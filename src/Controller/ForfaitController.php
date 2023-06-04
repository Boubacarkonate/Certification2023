<?php

namespace App\Controller;

use App\Entity\Forfait;
use App\Repository\ForfaitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[IsGranted("ROLE_USER_RECRUTEUR")]
#[Route('recruteur/forfait')]
class ForfaitController extends AbstractController
{
    #[Route('/', name: 'app_forfait')]
    public function index(ForfaitRepository $forfaitRepository): Response
    {
        return $this->render('forfait/index.html.twig', [
            'forfaits' => $forfaitRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_forfait_show', methods: ['GET'])]
    public function show(Forfait $forfait): Response
    {
        return $this->render('forfait/show.html.twig', [
            'forfait' => $forfait,
        ]);
    }
}
