<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


	class CategoryController extends Controller
	{  
	
	    /**
		* @Route("/categories/ajout")
		* @param Request $request
		* @return Response
	    */
		public function add(Request/*Type*/ $request):Response
		{
			//récuperation du formulaire
			$category = new Category(); //contient un objet vide
			$form = $this->createForm(CategoryType::class,$category);
	
			//vérification du formulaire
			$form->handleRequest($request);//recuperer tous les donnees pour met dans form
			//si le formulaire est valide => on ajoute la catégorie en BDD
			if($form->isSubmitted() && $form->isValid()){
			$category=$form->getData();//selection les données correspon dans category
			$manager =$this->getDoctrine()->getManager();
			$manager->persist($category);
			$manager->flush();
			return $this ->redirectToRoute('app_home_homepage');
			}
			
			//sinon on revoie une vue avec la formulaire
			return $this->render("category/addcategory.html.twig",[
			"form" => $form->createView()
			]);
		}






		

	}