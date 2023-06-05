<?php

namespace App\Controller;

use App\Entity\Cv;
use DateTimeImmutable;
use App\Entity\Categorie;
use App\Repository\CvRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CvthequeController extends AbstractController
{
    #[Route('/cvtheque', name: 'app_cvtheque')]
    public function index(CvRepository $cvRepository, CategorieRepository $categorieRepository, CommandesRepository $commandesRepository, $id): Response
    {   
        $user = $this->getUser();
        if ($user) {
            # code...
        }
        $finAbonnement = new \DateTimeImmutable();              // création d'une variable $finAbonnement contenant la date actuelle
       
       $commandes_encours = $commandesRepository->find($id) ;   //id de la commande affiché enfermé dans la variable $commandes_encours
    // dd ($commandes_encours->getExpireAt() )  ;                   // récupération du champ ExpireAt avec le get 


        if ($commandes_encours->getExpireAt()  > $finAbonnement) {          //si commandes_encours est supérieur à $finAbonnement(date actuelle) alors retourne
            
        // return $this->render('cvtheque/index.html.twig', [
        //     'cvs' => $cvRepository->findAll(),
        // ]);
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);

    } else {
        return $this->redirectToRoute('app_home');
    }
    }


    #[Route('/detailcategorie/{id}', name: 'app_detail_categorie')]
    public function show(CvRepository $cvRepository, Categorie $categorie): Response
    {
        $cv_categorie=$cvRepository->findBy([                      //pour voir cv par categorie (video loom crud personnalisé du 21/03 a 18h58)
            'categorie' => $categorie]);
    
            return $this->render('categorie/detailCategorie.html.twig', [
                'cv_categorie' => $cv_categorie,
            ]);
        }

}
