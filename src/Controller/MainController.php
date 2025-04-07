<?php

namespace App\Controller;

use App\Form\CrudType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/articles", name="app_articles")
     */
    public function index(Request $request, ArticleRepository $repo): Response
    {
        $data= $repo-> findAll();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'MainController',
            'data'=>$data,
        ]);
    }
    /**
     * @Route("articles/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $crud = new Article();#article correspond au nom du fichier en entity#
        $form=$this->createForm( CrudType :: class , $crud); #creation de formulaire avec le type d'entité#
        $form -> handleRequest($request); #gestion des données entrées dans le formulaire#
        if ($form->isSubmitted() && $form->isValid()){

        $sendDatabase = $this->getDoctrine()->getManager();
        $sendDatabase->persist($crud); #ajout de l'objet crud à la base de donnée#
        $sendDatabase->flush();  
        
        $this->addFlash('notice', 'Soumission Réussi !!');
        #notice va creer un composant qui va contenir plusieurs valeurs (3)#
        return $this->redirectToRoute("app_articles");
    }
        #permet retour a la page d'accueil directement suite a la soumission#
        #rendu de la page de creation#
        return $this->render('article/create.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),    
            #le 'form' est rappelé dans le twig createform : celui entre paranthese (form) #  
        ]);
    }
    /**
     * @Route("/update/{id}", name="update", methods={"GET","POST"})
     */
    public function update(Request $request, $id): Response
    {
        $crud = $this->getDoctrine()->getRepository( Article :: class )->find($id);  
        #recupère les informations de l'objet id de la table article#
        $form=$this->createForm( CrudType :: class , $crud); #creation de formulaire avec le type d'entité#
        $form -> handleRequest($request); #gestion des données entrées dans le formulaire#
        if ($form->isSubmitted() && $form->isValid()){
        $sendDatabase = $this->getDoctrine()->getManager();
        $sendDatabase->persist($crud); #ajout de l'objet crud à la base de donnée#
        $sendDatabase->flush();  
        
        $this->addFlash('notice', 'Soumission Réussi !!');
        #notice va creer un composant qui va contenir plusieurs valeurs (3)#
        return $this->redirectToRoute("app_articles");
    }
        #permet retour a la page d'accueil directement suite a la soumission#
        #rendu de la page de creation#
        return $this->render('article/update.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),    
            #le 'form' est rappelé dans le twig createform : celui entre paranthese (form) #  
        ]);
    }
    
    /**
     * @Route("/delete/{id}", name="delete", methods={"GET","POST"})
     */
    public function remove($id): Response
    {
        $crud = $this->getDoctrine()->getRepository( Article :: class )->find($id);  
        #recupère les informations de l'objet id de la table article#
        $sendDatabase = $this->getDoctrine()->getManager();
        $sendDatabase->remove($crud); #suppression de l'objet crud à la base de donnée#
        $sendDatabase->flush();  
        
        $this->addFlash('notice', 'Soumission Réussi !!');
        #notice va creer un composant qui va contenir plusieurs valeurs (3)#
        return $this->redirectToRoute("app_articles");
    }
    }
