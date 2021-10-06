<?php

namespace App\Entity;

use App\Repository\PostRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @Vich\Uploadable();
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @Vich\UploadableField(mapping="thumbnails", fileNameProperty="thumbnail")
     */
    private $thumbnailFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\OneToMany(targetEntity=Taxonomy::class, mappedBy="post", cascade={"persist", "remove"})
     */
    private $taxonomies;

    public function __construct()
    {
        $this->taxonomies = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile($thumbnailFile): self
    {
        $this->thumbnailFile = $thumbnailFile;

        if ($thumbnailFile) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Taxonomy[]
     */
    public function getTaxonomies(): Collection
    {
        return $this->taxonomies;
    }

    public function addTaxonomy(Taxonomy $taxonomy): self
    {
        if (!$this->taxonomies->contains($taxonomy)) {
            $this->taxonomies[] = $taxonomy;
            $taxonomy->setPost($this);
        }

        return $this;
    }

    public function removeTaxonomy(Taxonomy $taxonomy): self
    {
        if ($this->taxonomies->removeElement($taxonomy)) {
            // set the owning side to null (unless already changed)
            if ($taxonomy->getPost() === $this) {
                $taxonomy->setPost(null);
            }
        }

        return $this;
    }

    public function getUpgrades(): array
    {
        $upgrades = [];

        // max upgrade example: sword +0 to sword +10
        for ($i = 0; $i < 10; $i++)
        {
            $upgrades[$i] = [
                'name' => '',
                'requirements_wear' => [],
                'requirements' => [],
                'attributes' => []
            ];
            foreach ($this->taxonomies as $tx)
            {
                switch($tx->getTerm())
                {
                    case 'item_name_' . $i:
                        $upgrades[$i]['name'] = $tx->getValue();
                    break;
                    case 'item_requirement_' . $i:
                        $upgrades[$i]['requirements_wear'][] = $tx->getValue();
                    break;
                    case 'upgrade_requirement_' . $i:
                        $upgrades[$i]['requirements'][] = $tx->getValue();
                    break;
                    case 'item_attribute_' . $i:
                        $upgrades[$i]['attributes'][] = $tx->getValue();
                    break;
                }
            }
        }

        $k = 0;
        foreach ($upgrades as &$upgrade) {
            if (empty($upgrade['name'])) {
                unset($upgrades[$k]);
            }
            $k++;
        }

        return $upgrades;
    }

    


    // easyadmin

    public function __toString()
    {
        return $this->title;
    }
}
