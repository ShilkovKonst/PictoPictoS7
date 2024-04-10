<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TherapistUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstName', TextType::class, [
            'label' => 'Votre Prénom',
            'required' => true,
            'attr' => [
                'placeholder' => 'Votre Prénom'
            ],
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Votre Nom',
            'required' => true,
            'attr' => [
                'placeholder' => 'Votre Nom'
            ],
        ])
        ->add('job', TextType::class, [
            'label' => 'Votre Fonction',
            'required' => true,
            'attr' => [
                'placeholder' => 'Votre Fonction'
            ],
        ])
        ->add('phoneNumber', TextType::class, [
            'label' => 'Votre numéro de téléphone',
            'required' => true,
            'attr' => [
                'placeholder' => 'Votre numéro de téléphone'
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
