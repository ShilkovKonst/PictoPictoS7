<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Patient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estimation', ChoiceType::class, [
                'label' => 'Estimer une situation',
                'required' => true,
                'mapped' => false,
                'choices' =>
                [null, 'progress', 'regress', 'stable'],
                'choice_value' => function (?string $s) {
                    return $s ? $s : '';
                },
                'choice_label' => function (?string $s) {
                    return $s ? $s : 'Estimer une situation';
                },
                'choice_attr' => [
                    'class' => 'input-text'
                ],
                'attr' => [
                    'class' => 'input-text',
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Décrire la situation initiale',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Décrire la situation du patient'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
