<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(EmailService $emailService, Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
            $email_form = $data['Votre_email'];
            $message_form = $data['Votre_message'];

            $emailService->envoyer(
                $email_form,
                $data['Votre_message']);


            return $this->renderForm('contact/traitement.html.twig', [
                'form' => $form,
            ]);


        }
    
       
        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
