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
     * @Route("/p/{slug}", name="post")
     */
    public function showOne(Post $_post, Request $request): Response
    {
        // updates the views if is viewed first time this session
        $this->updateSessionViews($_post, $request);

        // last 5 posts - without including the current post
        $lastPosts = $this->getDoctrine()->getRepository(Post::class)->findLast($_post->getId(), 5);

        // cast the post to the correct entity
        $post = $_post->cast();

        // show the template
        return $this->render('post/index.html.twig', [
            'post' => $post,
            'lastPosts' => $lastPosts
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
