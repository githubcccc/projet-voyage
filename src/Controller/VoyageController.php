<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





class VoyageController extends Controller {
    /**
     * @Route("/voyage/ajout")
     * @param Request $request
     * @return Response
     */
    public function add(Request/*Type*/ $request):Response
    {
        //récuperation du formulaire
        $voyage = new Voyage(); //contient un objet vide
        $form = $this->createForm(VoyageType::class,$voyage);

        //vérification du formulaire
        $form->handleRequest($request);//recuperer tous les donnees pour met dans form
        //si le formulaire est valide => on ajoute la catégorie en BDD
        if($form->isSubmitted() && $form->isValid()){
            $voyage=$form->getData();//selection les données correspon dans product
            $manager =$this->getDoctrine()->getManager();
            $manager->persist($voyage);
            $manager->flush();
            return $this ->redirectToRoute('app_homepage');
        }

        //sinon on revoie une vue avec la formulaire
        return $this->render("voyage/ajoutevoyage.html.twig",[
            "form" => $form->createView()
        ]);
    }








}