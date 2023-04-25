<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('roles', ChoiceType::class, [
               'label' => "Choisissez votre espace :",         //  ne fonctionne pas
                'choices' => [
                    'Recruteur' => 'ROLE_USER_RECRUTEUR',
                    'Candidat' => 'ROLE_USER_CANDIDAT'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôle'

            ]) 
            ->add('name', TextType::class)
            ->add('first_name', TextType::class)
            ->add('company', TextType::class, [
                'required'=>false])
            ->add('phone', TextType::class, [
                'required'=>false])
            // ->add('file', FileType::class, [
            //         'label' => 'Télécharger votre PDF',
    
            //         // unmapped means that this field is not associated to any entity property
            //         'mapped' => true,
    
            //         // make it optional so you don't have to re-upload the PDF file
            //         // every time you edit the Product details
            //         'required' => true,
    
                    // unmapped fields can't define their validation using annotations
                    // in the associated entity, so you can use the PHP constraint classes
                    // 'constraints' => [
                    //     new File([
                    //         'maxSize' => '1024k',
                    //         'mimeTypes' => [
                    //             'application/pdf',
                    //             'application/x-pdf',
                    //                                                           //telecharger doc pdf
                    //         ],
                    //         'mimeTypesMessage' => 'Please upload a valid PDF document',
                    //     ])
                    // ],
                // ])
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{14,}$/',
                    "Doit contenir au minimum 14 caractères, dont 1 majuscule, 1 minuscule, 1 chiffre & 1 caractère spécial (@$!%*?&)")  //je ne vois pas le message
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
