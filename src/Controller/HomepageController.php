<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {

        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy([
            "parent" => null
        ]);

        $popularPosts = $this->getDoctrine()->getRepository(Post::class)->findBy([], [
            'views' => 'DESC'
        ], 12);

        return $this->render('homepage/index.html.twig', [
            'categories' => $categories,
            'popularPosts' => $popularPosts,
        ]);
        
    }
}
