<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


	class TagController extends Controller
	{  
	
	    /**
		* @Route("/tags/ajout")
		* @param Request $request
		* @return Response
	    */
		public function add(Request/*Type*/ $request):Response
		{
			//récuperation du formulaire
			$tag = new Tag(); //contient un objet vide
			$form = $this->createForm(TagType::class,$tag);
	
			//vérification du formulaire
			$form->handleRequest($request);//recuperer tous les donnees pour met dans form
			//si le formulaire est valide => on ajoute la catégorie en BDD
			if($form->isSubmitted() && $form->isValid()){
			$tag=$form->getData();//selection les données correspon dans category
			$manager =$this->getDoctrine()->getManager();
			$manager->persist($tag);
			$manager->flush();
			return $this ->redirectToRoute('app_home_homepage');
			}
			
			//sinon on revoie une vue avec la formulaire
			return $this->render("tag/addtag.html.twig",[
			"form" => $form->createView()
			]);
		}
		

	}