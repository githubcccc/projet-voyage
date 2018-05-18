<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class VoyageController extends Controller {

    /**
     * @Route("/voyages")
     */
    public function list(Request $request): Response
    {

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT v FROM App:Voyage v";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('voyage/list.html.twig', [
            "pagination" => $pagination
        ]);
    }

    /**
     * @Route("/voyage/category/{id}")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function listByCategory(Request $request, int $id): Response
    {
        $query = $this->getDoctrine()
            ->getRepository(Voyage::class)
            ->findByCategory($id)
        ;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render("voyage/list-by-categories.html.twig", [
            "pagination" => $pagination
        ]);
    }



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

    /**
     * @Route("/voyage/edition/{id}")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id): Response
    {
        // Récupération du formulaire
        $voyage =  $this->getDoctrine()
            ->getRepository(Voyage::class)
            ->find($id)
        ;
        $form = $this->createForm(VoyageType::class, $voyage);
        // Vérication du formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est valide :
            // => on ajoute la catégorie en BDD
            $voyage = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirectToRoute('app_home_homepage');
        }
        // Sinon on renvoit une vue avec le formulaire
        return $this->render("voyage/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/voyage/suppression/{id}")
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function delete(int $id): Response
    {
        $voyage = $this->getDoctrine()
            ->getRepository(Voyage::class)
            ->find($id)
        ;

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($voyage);
        $manager->flush();

        return $this->redirectToRoute('app_home_homepage');
    }

}