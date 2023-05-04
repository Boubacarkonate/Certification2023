<?php

namespace App\Controller;

use index;
use App\Entity\Categorie;
use App\Repository\CvRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_admin_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_detail_categorie')]
    public function show(CvRepository $cvRepository, Categorie $categorie): Response
    {
        $cv_categorie=$cvRepository->findBy([                      //pour voir cv par categorie (video loom crud personnalisé du 21/03 a 18h58)
            'categorie' => $categorie]);
    
            return $this->render('categorie/detailCategorie.html.twig', [
                'cv_categorie' => $cv_categorie,
            ]);
        }
}
