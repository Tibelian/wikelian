<?php

namespace App\Controller;

use App\Entity\Category;
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

        return $this->render('homepage/index.html.twig', [
            'categories' => $categories,
        ]);
        
    }
}
