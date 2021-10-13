<?php

namespace App\Entity;

use App\Entity\Post\Article;
use App\Entity\Post\Chest;
use App\Entity\Post\Item;
use App\Entity\Post\Map;
use App\Entity\Post\Mission;
use App\Entity\Post\Mob;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\MappedSuperclass
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @Vich\Uploadable()
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $thumbnail;

    /**
     * @Vich\UploadableField(mapping="thumbnails", fileNameProperty="thumbnail")
     */
    protected $thumbnailFile;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer")
     */
    protected $views;

    /**
     * @ORM\OneToMany(targetEntity=Taxonomy::class, mappedBy="post", orphanRemoval=true)
     */
    protected $taxonomies;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $type = 'article';

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

    public function cast(): object
    {
        switch ($this->type) {
            case 'article': $newObj = new Article(); break;
            case 'chest': $newObj = new Chest(); break;
            case 'item': $newObj = new Item(); break;
            case 'map': $newObj = new Map(); break;
            case 'mission': $newObj = new Mission(); break;
            case 'mob': $newObj = new Mob(); break;
            default: $newObj = new Post(); break;
        }
        $newObj->cloneThis($this, $newObj, $this->id);
        return $newObj;
    }

    private function cloneThis($fromObj, &$toObj, $id = null): void
    {
        $toObj->id = $id; // protected - but i am the parent
        $toObj->setTitle( $fromObj->getTitle() );
        $toObj->setContent( $fromObj->getContent() );
        $toObj->setCategory( $fromObj->getCategory() );
        $toObj->setThumbnail( $fromObj->getThumbnail() );
        $toObj->setThumbnailFile( $fromObj->getThumbnailFile() );
        $toObj->setSlug( $fromObj->getSlug() );
        $toObj->setDescription( $fromObj->getDescription() );
        $toObj->setType( $fromObj->getType() );
        $toObj->setViews( $fromObj->getViews() );
        $toObj->setUpdatedAt( $fromObj->getUpdatedAt() );
        foreach ($fromObj->getTaxonomies() as $fromTaxonomy)
        {
            $toObj->addTaxonomy($fromTaxonomy);
        }
    }


    // easyadmin

    public function __toString()
    {
        return $this->title;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    
}
