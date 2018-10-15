<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
 /**
 * @Route("/blog/{slug}")
 */
 public function show($slug){

   return $this->render('lucky/number.html.twig',['number' => $slug,]);

 }

}

?>
