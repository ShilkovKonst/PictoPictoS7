<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Conjugation;
use App\Entity\Irregular;
use App\Entity\Phrase;
use App\Entity\Pictogram;
use App\Entity\Tag;
use App\Repository\PictogramRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PictogramFormType extends AbstractType
{
    public function __construct(
        private PictogramRepository $pictoRepo
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du pictogramme*:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre du pictogramme'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom du pictogramme est trop court. Il doit avoir au minimum 2 caractères.',
                        'maxMessage' => 'Le nom du pictogramme est trop long. Il doit avoir au maximum 50 caractères.',
                    ])
                ]
            ])
            ->add('illustration', FileType::class, [
                'label' => 'Illustration du pictogramme*: ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Illustration du pictogramme'
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/gif', 'image/png',
                        ],
                        'mimeTypesMessage' => "Veuillez insérer un fichier au format png ou gif.",
                    ])
                ],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie du nouveau pictogramme :',
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'title',
                'attr' => [
                    'placeholder' => 'Catégorie du nouveau pictogramme'
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' =>
                [null, 'verbe', 'nom', 'adjectif', 'adjectif', 'invariable', 'interrogatif', 'pronom_ou_determinant'],
                'choice_value' => function (?string $s) {
                    return $s ? $s : '';
                },
                'choice_label' => function (?string $s) {
                    return $s ? $s : 'Choisir type de la pictogramme';
                },
            ])
            ->add('irregular', EntityType::class, [
                'class' => Irregular::class,
                'choice_label' => 'id',
            ])
            ->add('conjugation', EntityType::class, [
                'mapped' => false,
                'class' => Conjugation::class,
                'choice_label' => 'id',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'id',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pictogram::class,
        ]);
    }
}
