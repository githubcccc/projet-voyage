<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class VoyageController extends Controller {
    /**
     * @Route("/voyage/gestion/ajout")
     * @param Request $request
     * @return Response
     */
    public function add(Request/*Type*/ $request , UserInterface $user):Response
    {
        //récuperation du formulaire
        $voyage = new Voyage(); //contient un objet vide
        $form = $this->createForm(VoyageType::class,$voyage);

        //vérification du formulaire
        $form->handleRequest($request);
        //si le formulaire est valide => on ajoute la catégorie en BDD
        if($form->isSubmitted() && $form->isValid()){
            $voyage=$form->getData();
            $voyage->setUser($user);
            $manager =$this->getDoctrine()->getManager();
            $manager->persist($voyage);
            //dump($voyage);
            //dump($user);
            //die("stop");
            $manager->flush();
            return $this ->redirectToRoute('app_home_homepage');
        }

        //sinon on revoie une vue avec la formulaire
        return $this->render("voyage/ajoutevoyage.html.twig",[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}")
     * @param Request $request
     * @return Response
     */

    public function show(int $id):Response
    {
        $voyage=$this->getDoctrine()->getRepository(Voyage::class)->findOneWithCategory($id);

        return $this->render("voyage/showvoyage.html.twig",[
            "voyage"=>$voyage
        ]);



    }

    public function edit()
    {

    }

    public function delete()
    {

    }






}