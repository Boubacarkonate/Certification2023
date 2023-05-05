<?php

namespace App\Controller;


use App\Entity\Cv;
use App\Entity\User;
use App\Form\CvType;
use App\Form\UserProfileType;
use App\Service\FileUploader;
use App\Repository\CvRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_index', methods: ['GET'])]
    public function index(): Response
    {
        
        $monprofil=$this->getUser();
        // dd($monuser);


        // $moncv = $userRepository->find($id);   2 solution pour récupérer toutes les données d'un profil
        // dd($moncv);                              attention {{ user.cv}} pour accéder au cv et  {{user.cv.categorie}} pour acceder a la categorie
     
        return $this->render('profile/index.html.twig', [
          
            'user' => $monprofil,
        ]);
    }

    #[Route('/new', name: 'app_profile_cv_new', methods: ['GET', 'POST'])]
    public function new(FileUploader $fileUploader, Request $request, CvRepository $cvRepository): Response
    {
        $cv = new Cv();
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cvChampForm = $form->get('cv_candidat')->getData();

            if ($cvChampForm) {
                
                $cvTelecharge = $fileUploader->upload($cvChampForm);

                $cv->setCvCandidat($cvTelecharge);
          
            }

            $cvRepository->save($cv, true);

            return $this->redirectToRoute('app_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cv/new.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    // #[Route('/new', name: 'app_profile_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, UserRepository $userRepository): Response
    // {
    //     $user = new User();
    //     $form = $this->createForm(UserProfileType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userRepository->save($user, true);

    //         return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('profile/new.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_profile_show', methods: ['GET'])]
    // public function show(User $user): Response
    // {
    //     return $this->render('profile/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    #[Route('/edit/{id}', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    }
 }
