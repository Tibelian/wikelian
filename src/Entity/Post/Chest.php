<?php

namespace App\Entity\Post;

use App\Repository\PostRepository;
use App\Entity\Post;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class, readOnly=true)
 * @ORM\Table(name="post")
 */
class Chest extends Post
{

    public function __construct()
    {
        parent::__construct();
        $this->setType("chest");
    }

}