<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class)
        ->add('email',EmailType::class)
        ->add('services', ChoiceType::class, [
            // 'label' => "Choisissez votre espace :",         //ne fonctionne pas
            'choices' => [
             'reseaux'   =>  'service 1',
              'formation'   =>'service 2' ,
              'depannage'   => 'service 3'
            ],
            // 'expanded' => true,
            // 'multiple' => true,
            // 'label' => 'service'

        ]) 
        ->add('message', TextareaType::class) 
      
        ->add('Envoyer', SubmitType::class)
            // ->add('Votre_email', TextType::class)
            // ->add('Votre_message', TextareaType::class)
            // ->add('Votre_nom', TextareaType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
