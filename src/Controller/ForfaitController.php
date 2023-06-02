<?php

namespace App\Controller;

use App\Entity\Forfait;
use App\Repository\ForfaitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForfaitController extends AbstractController
{
    #[Route('/forfait', name: 'app_forfait')]
    public function index(ForfaitRepository $forfaitRepository): Response
    {
        return $this->render('forfait/index.html.twig', [
            'forfaits' => $forfaitRepository->findAll(),
        ]);
    }

    // #[Route('/{id}', name: 'app_forfait_show', methods: ['GET'])]
    // public function show(Forfait $forfait): Response
    // {
    //     return $this->render('forfait/show.html.twig', [
    //         'forfait' => $forfait,
    //     ]);
    // }
}
