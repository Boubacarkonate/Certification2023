<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[IsGranted("ROLE_USER_RECRUTEUR")]
class PresentationMetiersExpertiseController extends AbstractController
{
    #[Route('/presentation/metiers/expertise', name: 'app_presentation_metiers_expertise')]
    public function index(): Response
    {
        return $this->render('presentation_metiers_expertise/index.html.twig', [
            'controller_name' => 'PresentationMetiersExpertiseController',
        ]);
    }
}
