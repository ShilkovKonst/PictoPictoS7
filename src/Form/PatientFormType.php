<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom du patient',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom du patient'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom du patient',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du patient'
                ],
            ])
            ->add('grade', TextType::class, [
                'label' => 'Education du patient',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Education du patient'
                ],
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Choisir sèxe du patient',
                'required' => true,
                'mapped' => false,
                'choices' =>
                ['homme', 'femme'],
                'choice_value' => function (?string $s) {
                    return $s ? $s : '';
                },
                'choice_label' => function (?string $s) {
                    return $s ? $s : 'Choisir sèxe du patient';
                },
                'choice_attr' => [
                    'class' => 'input-text'
                ],
                'attr' => [
                    'class' => 'input-text',
                ],
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('noteComment', TextareaType::class, [
                'label' => 'Décrire la situation initiale',
                'required' => true,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Décrire la situation du patient'
                ],
            ])
            ;
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
