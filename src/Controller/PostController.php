<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Post;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {

       $entityManager = $this->getDoctrine()->getManager();

       $post = new Post();
       $post->setContent('This is content.');

       $entityManager->persist($post);
       $entityManager->flush();

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
    * @Route("post/{id}", name="post_show")
    */
    public function show($id)
    {
      $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

      if(!$post){
        throw $this->createNotFoundException(
          'No product found for id ' . $id
        );
      }
      return new Response('Post with id ' . $id .' content: ' . $post->getContent());

    }
}
