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
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="taxonomies")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
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
        for ($n = 1; $n <= 20; $n++) {
            if ($this->term == 'quest_level_' . $n) return $n . ". Level";
            if ($this->term == 'quest_requirement_' . $n) return $n . ". Requirement";
            if ($this->term == 'quest_reward_' . $n) return $n . ". Reward";
            if ($this->term == 'quest_cooldown_' . $n) return $n . ". Cooldown";
        }
        switch ($this->term) 
        {
            // items
            case 'vnum': return 'VNUM';
            case 'job': return 'Classes';
            case 'sockets': return 'Sockets';
            case 'model3d': return '3D Model';
            case 'drop_stone': return 'Drop Stone';
            case 'drop_monster': return 'Drop Monster';
            case 'drop_chest': return 'Drop Chest';
            // chests
            case 'chest_level': return 'Level';
            case 'chest_origin': return 'Origin';
            case 'chest_drop': return 'Drop';
            // maps
            case 'image': return 'Image';
            case 'entry_requirement': return 'Entry Requirement';
            case 'spawn_monster': return 'Spawn Monster';
            case 'spawn_stone': return 'Spawn Stone';
            case 'spawn_ore': return 'Spawn Ore Vein';
            // mobs
            case 'mob_image': return 'Image';
            case 'mob_level': return 'Level';
            case 'mob_hp': return 'HP';
            case 'mob_spawn': return 'Spawn';
            case 'mob_drop': return 'Drop';
            case 'mob_weakness': return 'Weakness';
        }

        return $this->term;
    }
}
