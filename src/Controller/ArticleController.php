<?php

namespace App\Controller;

use App\Form\CrudType;
use App\Entity\Article;
use App\Entity\Matieres;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class ArticleController extends AbstractController
    {
        /**
         * @Route("/articles", name="app_articles")
         */
        public function index(Request $request, ArticleRepository $repo): Response
        {
            $data= $repo-> findAll();
            return $this->render('article/index.html.twig', [
                'controller_name' => 'ArticleController',
                'data'=>$data,
            ]);
        }
        /**
         * @Route("/articles/create", name="create", methods={"GET","POST"})
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
            return $this->redirectToRoute("app_article");
        }
            #permet retour a la page d'accueil directement suite a la soumission#
            #rendu de la page de creation#
            return $this->render('accueil/createForm.html.twig', [
                'controller_name' => 'ArticleController',
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
            return $this->redirectToRoute("app_article");
        }
            #permet retour a la page d'accueil directement suite a la soumission#
            #rendu de la page de creation#
            return $this->render('accueil/update.html.twig', [
                'controller_name' => 'ArticleController',
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
            return $this->redirectToRoute("app_main");
        }
        
        /**
         * @Route("/matières", name="app_matieres", methods={"GET","POST"})
         */
        public function load(ObjectManager $manager): void
        {
            
            $matieres = [];
            
            $matiere = new Matieres();
            $matiere->setTitre("Mathématiques")
                    ->setDescription("Découvrez nos articles et exercices corrigés pour tout niveau de mathématique")
                    ->setPicture("https://www.savoie-news.fr/uploads/11664-629a0a557b70b-fond-tableau-mathematique-realiste-23-2148154055-1-jpg.jpg");
            $manager -> persist($matiere);
            $matieres[]= $matiere;

            $matiere = new Matieres();
            $matiere->setTitre("Physique&Chimie")
                    ->setDescription("Découvrez la Physique en toute alCHIMIE pour tous niveaux")
                    ->setPicture("https://www.neozone.org/blog/wp-content/uploads/2021/12/loi-physique-780x470.jpg");
            $manager-> persist($matiere);
            $matieres[]= $matiere;

            $matiere = new Matieres();
            $matiere->setTitre("Français")
                    ->setDescription("Molière et Consorts")
                    ->setPicture("https://medias.lumni.fr/WN3IaiKkx-Tuzsd9KwVlp9cG9jw/236x162/filters:focal(583740x-399230:583739x0):quality(95):max_bytes(120000)/61976aae821a2a4f265834a4");
            $manager->persist($matiere); 
            $matieres[]= $matiere;
        }
    }