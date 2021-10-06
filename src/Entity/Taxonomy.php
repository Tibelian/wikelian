<?php

namespace App\Entity;

use App\Repository\TaxonomyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxonomyRepository::class)
 */
class Taxonomy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $term;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="taxonomies", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function __toString(): string
    {

        for ($i = 0; $i <= 10; $i++) {
            if ($this->term == 'item_name_' . $i) return "Item Name +" . $i;
            if ($this->term == 'item_attribute_' . $i) return "Item Attribute +" . $i;
            if ($this->term == 'item_requirement_' . $i) return "Item Requirement +" . $i;
            if ($this->term == 'upgrade_requirement_' . $i) return "Item Upgrade Requirement +" . $i;
        }
        if ($this->term == 'vnum') return 'VNUM';
        if ($this->term == 'job') return 'Classes';
        if ($this->term == 'sockets') return 'Sockets';
        if ($this->term == 'model3d') return '3D Model';
        if ($this->term == 'drop_stone') return 'Drop Metin Stone';
        if ($this->term == 'drop_monster') return 'Drop Monster';
        if ($this->term == 'drop_chest') return 'Drop Chest';

        return $this->term;
    }
}
