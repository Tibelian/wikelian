<?php

namespace App\Entity\Post;

use App\Repository\PostRepository;
use App\Entity\Post;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\Table(name="post")
 */
class Map extends Post
{

    public function __construct()
    {
        parent::__construct();
        $this->setType("map");
    }

}