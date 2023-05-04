<?php

namespace App\Controller;

use App\Form\MessageType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function sendEmail(MailerInterface $mailer, Request  $request): Response
    {

        
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $from = $contactFormData['email'];
            $subject = 'Demande de contact sur votre site de ' .$contactFormData['email'];
            $name = $contactFormData['name'] ;
            $message = $contactFormData['message'];
            $service = $contactFormData['services'];
            
       
            $email = (new TemplatedEmail())
        ->from($from)
        ->to('admin@gmail.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject($subject)
        ->text('Sending emails is fun again!')
        ->htmlTemplate('message/email.html.twig')
        ->context([
            'expiration_date' => new \DateTime('+7 days'),
            'from' => $from,
            'subject' => $subject,
            'name' => $name,
            'message' => $message,
            'services' => $service
        ]);

    $mailer->send($email);


        }

        return $this->render('message/index.html.twig', [
            'form' => $form->createView(),
        ]);
   
    }

}
//     public function sendEmail(SendMailService $mailer, Request  $request): Response
//     {

        
//         $form = $this->createForm(MessageType::class);
//         $form->handleRequest($request);
//         if($form->isSubmitted() && $form->isValid()) {
//             $data = $form->getData();

          
//     $mailer->send(
//         $data['email'],
//         'admin@gmail',
//         'reparation',
//         'message/email.html.twig',
//         ['name' => $data['name'],
//         'services' => $data['services'],
//         'message' => $data['message'],
        
//         ]

        
//     );


//         }

//         return $this->render('message/index.html.twig', [
//             'form' => $form->createView(),
//         ]);
   
// }
// }