<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresentationMetiersEducationanimationController extends AbstractController
{
    #[Route('/presentation/metiers/education_animation', name: 'app_presentation_metiers_education_animation')]
    public function index(): Response
    {
        return $this->render('presentation_metiers_educationanimation/index.html.twig', [
            'controller_name' => 'PresentationMetiersEducationanimationController',
        ]);
    }
}
