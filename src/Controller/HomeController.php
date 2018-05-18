<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends Controller {

       /**
        * Page d'accueil : affiche la liste cliquable des voyage
        * @Route("/")
        * @return Response
        */
       public function homepage():Response
       {
           $repo = $this->getDoctrine()->getRepository(Category::class);
           $categories = $repo->findAll();

           return $this->render('partial/accueil.html.twig', [
               "categories" => $categories
           ]);
       }





   }