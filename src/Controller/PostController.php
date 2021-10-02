<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/{slug}", name="post")
     */
    public function showOne(Post $post, Request $request): Response
    {
        // updates the views if is viewed first time this session
        $this->updateSessionViews($post, $request);

        //
        $randomPosts = $this->getDoctrine()->getRepository(Post::class)->findLast($post->getId(), 5);

        // show the template
        return $this->render('post/index.html.twig', [
            'post' => $post,
            'randomPosts' => $randomPosts
        ]);

    }

    private function updateSessionViews(Post $post, Request $request)
    {
        $viewed = $request->getSession()->get('viewed');
        if (!is_array($viewed))
        {
            $viewed = [];
        }
        if (!in_array($post->getId(), $viewed))
        {
            $viewed[] = $post->getId();
            $request->getSession()->set('viewed', $viewed);

            $post->setViews( $post->getViews() + 1 );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        }
    }
}
