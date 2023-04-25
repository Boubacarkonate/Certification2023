<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                // 'label' => "Choisissez votre espace :",         //ne fonctionne pas
                'choices' => [
                    'Recruteur' => 'ROLE_USER_RECRUTEUR',
                    'Candidat' => 'ROLE_USER_CANDIDAT'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôle'

            ]) 
            ->add('password')
            ->add('isVerified')
            ->add('Name')
            ->add('first_name')
            ->add('company')
            ->add('phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
