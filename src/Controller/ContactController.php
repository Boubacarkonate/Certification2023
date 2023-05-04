<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact')]
    public function index(Request $request, EmailService $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $from = $contactFormData['email'];
            $subject = 'Demande de contact sur votre site de ' . $contactFormData['email'];
             $content = $contactFormData['name'] . ' vous a envoyé le message suivant: ' . $contactFormData['message'] . ' nom du service : ' . $contactFormData['services'];//. 'service choisi : ' .$contactFormData['services'] ;
            $mailer->sendEmail(from: $from , subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a été envoyé');
          
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}


