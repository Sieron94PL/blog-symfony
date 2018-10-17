<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Post;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
       $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', array(
          'posts' => $posts,
        ));
    }

    /**
    * @Route("post/new", name="post_new")
    */
    public function new(Request $request)
    {
      $post = new Post();
      $post->setContent('Write a post content');

      $form = $this->createFormBuilder($post)
        ->add('content', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Create Post'))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $post = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
      }

        return $this->render('post/new.html.twig', array(
          'form' => $form->createView(),
        ));
    }

    /**
    * @Route("/admin")
    */
    public function admin()
    {
      return new Response('<html><body>Admin page!</body></html>');
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
