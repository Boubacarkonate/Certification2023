<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class EmailService {
    private $mailer;

    public function __construct(MailerInterface $monmailer)
    {
        // stocker dans la propriété $mailer un
        // Mailerinterface
        $this->mailer=$monmailer;
    }

      public function sendEmail(
        $from = '',
        $to = 'admin@gmail.com',
        $subject = 'This is the Mail subject !',
        $content = '',
        $text = ''
    ): void{
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}

    // public function envoyer(
    //     $email,
    //     $message){

    //     $email = (new Email())
    //     ->from($email)          
    //     ->to($email)  //->to(admin@gmail.com)    le user envoie un mail à l'admin
    //     //->cc('cc@example.com')
    //     //->bcc('bcc@example.com')
    //     //->replyTo('fabien@example.com')
    //     //->priority(Email::PRIORITY_HIGH)
    //     ->subject('Time for Symfony Mailer!')
    //     ->text($message)
    //     ->html($message);

    //     $this->mailer->send($email);
       
 
    // }
// }