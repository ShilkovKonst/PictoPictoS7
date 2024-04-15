<?php

namespace App\Form;

use App\Entity\Conjugation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConjugationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstPersonSingular', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-text h-6 z-10',
                    'placeholder' => "Je / J'"
                ],
            ])
            ->add('firstPersonPlurial', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-text h-6 z-10',
                    'placeholder' => "Tu"
                ],
            ])
            ->add('secondPersonSingular', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-text h-6 z-10',
                    'placeholder' => "Il / Elle / On"
                ],
            ])
            ->add('secondPersonPlurial', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-text h-6 z-10',
                    'placeholder' => "Nous"
                ],
            ])
            ->add('thirdPersonSingular', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-text h-6 z-10',
                    'placeholder' => "Vous"
                ],
            ])
            ->add('thirdPersonPlurial', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-text h-6 z-10',
                    'placeholder' => "Ils / Elles"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conjugation::class,
        ]);
    }
}
