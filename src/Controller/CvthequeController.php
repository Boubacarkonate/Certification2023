<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Repository\CvRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CvthequeController extends AbstractController
{
    #[Route('/cvtheque', name: 'app_cvtheque')]
    public function index(CvRepository $cvRepository): Response
    {
        
        return $this->render('cvtheque/index.html.twig', [
            'cvs' => $cvRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_admin_cv_show', methods: ['GET'])]
    public function show(Cv $cv): Response
    {
        return $this->render('admin_cv/show.html.twig', [
            'cv' => $cv,
        ]);
    }
}
