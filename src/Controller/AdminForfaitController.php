<?php

namespace App\Controller;

use App\Entity\Forfait;
use App\Form\ForfaitType;
use App\Repository\ForfaitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin/forfait')]
class AdminForfaitController extends AbstractController
{
    #[Route('/', name: 'app_admin_forfait_index', methods: ['GET'])]
    public function index(ForfaitRepository $forfaitRepository): Response
    {
        return $this->render('admin_forfait/index.html.twig', [
            'forfaits' => $forfaitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_forfait_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ForfaitRepository $forfaitRepository): Response
    {
        $forfait = new Forfait();
        $form = $this->createForm(ForfaitType::class, $forfait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $forfaitRepository->save($forfait, true);

            return $this->redirectToRoute('app_admin_forfait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_forfait/new.html.twig', [
            'forfait' => $forfait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_forfait_show', methods: ['GET'])]
    public function show(Forfait $forfait): Response
    {
        return $this->render('admin_forfait/show.html.twig', [
            'forfait' => $forfait,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_forfait_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forfait $forfait, ForfaitRepository $forfaitRepository): Response
    {
        $form = $this->createForm(ForfaitType::class, $forfait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $forfaitRepository->save($forfait, true);

            return $this->redirectToRoute('app_admin_forfait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_forfait/edit.html.twig', [
            'forfait' => $forfait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_forfait_delete', methods: ['POST'])]
    public function delete(Request $request, Forfait $forfait, ForfaitRepository $forfaitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forfait->getId(), $request->request->get('_token'))) {
            $forfaitRepository->remove($forfait, true);
        }

        return $this->redirectToRoute('app_admin_forfait_index', [], Response::HTTP_SEE_OTHER);
    }
}
