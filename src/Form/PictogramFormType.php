<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Pictogram;
use App\Repository\PictogramRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PictogramFormType extends AbstractType
{
    public function __construct(
        private PictogramRepository $pictoRepo
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $pictogram = null;
        $tags = [];
        $conjugationPresent = null;
        $conjugationFutur = null;

        if (array_key_exists('data', $options)) {
            $pictogram = $options['data'];

            foreach ($pictogram->getTags() as $t) {
                array_push($tags, $t->getTitle());
            }
            if ($pictogram->getType() == 'verbe' && $pictogram->getIrregular() != null) {
                foreach ($pictogram->getIrregular()->getConjugations() as $c) {
                    if ($c->getTense() == 'present') {
                        $conjugationPresent = $c;
                    }
                    if ($c->getTense() == 'futur') {
                        $conjugationFutur = $c;
                    }
                }
            }
        }
// dd($pictogram && $pictogram->getFilename());
        $builder
            ->add('title', TextType::class, [
                'row_attr' => [
                    'class' => 'border-b',
                ],
                'label' => 'Titre du pictogramme',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
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
                'mapped' => false,
                'row_attr' => [
                    'class' => 'flex flex-col justify-between border-b'
                ],
                'label' => 'Illustration du pictogramme',
                'label_attr' => [
                    'class' => 'block ms-2 mb-2 text-sm font-medium text-gray-900'
                ],
                'attr' => [
                    'placeholder' => 'Illustration du pictogramme',
                ],
                'required' => $pictogram && $pictogram->getFilename() ? false : true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/gif', 'image/png',
                        ],
                        'mimeTypesMessage' => "Veuillez insérer un fichier au format png ou gif.",
                    ]),
                    new Callback([$this, 'validateFilename'])
                ],
            ])
            ->add('category', EntityType::class, [
                'row_attr' => [
                    'class' => 'border-b',
                ],
                'label' => 'Catégorie du pictogramme',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => true,
                'class' => Category::class,
                'choice_label' => function (Category $category): string {
                    return $category->getTitle();
                },
                'attr' => [
                    'placeholder' => 'Catégorie du pictogramme'
                ],
            ])
            ->add('type', ChoiceType::class, [
                'row_attr' => [
                    'class' => 'border-b',
                ],
                'mapped' => true,
                'label' => 'Choisir type du pictogramme',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => true,
                'choices' => [
                    null, 'verbe', 'nom', 'adjectif',
                    'invariable', 'interrogatif', 'pronom_ou_determinant'
                ],
                'choice_value' => function (?string $s) {
                    return $s ? $s : '';
                },
                'choice_label' => function (?string $s) {
                    return $s ? $s : 'Choisir type du pictogramme';
                },
            ])
            ->add('verbe', ChoiceType::class, [
                'mapped' => false,
                'label' => false,
                'placeholder' => false,
                'required' => false,
                'choices' => [
                    'auxiliaire_avoir' => 'auxiliaire_avoir',
                    'auxiliaire_etre' => 'auxiliaire_etre'
                ],
                'expanded' => true,
                'data' => $pictogram && in_array('auxiliaire_avoir', $tags) ? 'auxiliaire_avoir' : (in_array('auxiliaire_etre', $tags) ? 'auxiliaire_etre' : ''),
                'constraints' => [
                    new Callback([$this, 'validateVerbe'])
                ]
            ])
            ->add('nom_pronom', ChoiceType::class, [
                'mapped' => false,
                'label' => false,
                'placeholder' => false,
                'required' => false,
                'empty_data' => '',
                'choices' => [
                    'masculin' => 'masculin',
                    'feminin' => 'feminin'
                ],
                'expanded' => true,
                'data' => $pictogram && in_array('masculin', $tags) ? 'masculin' : (in_array('feminin', $tags) ? 'feminin' : ''),
                'constraints' => [
                    new Callback([$this, 'validateNomPronom'])
                ]
            ])
            ->add('pronom', ChoiceType::class, [
                'mapped' => false,
                'label' => false,
                'placeholder' => false,
                'required' => false,
                'choices' => [
                    'singulier' => 'singulier',
                    'pluriel' => 'pluriel'
                ],
                'choice_value' => function (?string $s) {
                    return $s ? $s : '';
                },
                'choice_label' => function (?string $s) {
                    return $s ? $s : 'Choisir sèxe du patient';
                },
                'expanded' => true,
                'data' => $pictogram && in_array('singulier', $tags) ? 'singulier' : (in_array('pluriel', $tags) ? 'pluriel' : ''),
                'constraints' => [
                    new Callback([$this, 'validatePronom'])
                ]
            ])
            ->add('irregular', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => [
                    'class' => 'flex flex-row items-center justify-start w-full z-10 mt-2 text-sm tracking-[0.15px]',
                ],
                'label' => 'Est-ce que le mot est irregulier?',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => false,
                'data' => $pictogram && in_array('irregulier', $tags) ? true : false,
            ])
            ->add('participe_passe', TextType::class, [
                'mapped' => false,
                'label' => 'Définir participe passe',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Définir participe passe'
                ],
                'data' => $pictogram && $pictogram->getIrregular() && $pictogram->getIrregular()->getPastParticiple() != null ? $pictogram->getIrregular()->getPastParticiple() : '',
            ])
            ->add('pluriel', TextType::class, [
                'mapped' => false,
                'row_attr' => [
                    'class' => 'border-b',
                ],
                'label' => 'Définir pluriel',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Définir pluriel'
                ],
                'data' => $pictogram && $pictogram->getIrregular() && $pictogram->getIrregular()->getPlurial() != null ? $pictogram->getIrregular()->getPlurial() : '',
            ])
            ->add('feminin', TextType::class, [
                'mapped' => false,
                'label' => 'Définir feminin',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Définir feminin'
                ],
                'data' => $pictogram && $pictogram->getIrregular() && $pictogram->getIrregular()->getFeminin() != null ? $pictogram->getIrregular()->getFeminin() : '',
            ])
            ->add('present', ConjugationFormType::class, [
                'mapped' => false,
                'label' => 'Présent',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => false,
                'data' => $conjugationPresent ? $conjugationPresent : null,
            ])
            ->add('futur', ConjugationFormType::class, [
                'mapped' => false,
                'label' => 'Futur',
                'label_attr' => [
                    'class' => 'ms-2 text-sm font-medium text-gray-900'
                ],
                'required' => false,
                'data' => $conjugationFutur ? $conjugationFutur : null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pictogram::class,
        ]);
    }

    public function validateFilename($value, ExecutionContextInterface $context, ?Pictogram $pictogram)
    {
        if ($pictogram && !$pictogram->getFilename()) {
            $context->buildViolation('This field is required because filename is not set.')
                ->atPath('illustration') // Замените на имя вашего поля
                ->addViolation();
        }
    }

    public function validateVerbe($value, ExecutionContextInterface $context, ?Pictogram $pictogram)
    {
        if ($pictogram && $pictogram->getType() === 'verbe') {
            $context->buildViolation('This field is required because filename is not set.')
                ->atPath('verbe') // Замените на имя вашего поля
                ->addViolation();
        }
    }

    public function validateNomPronom($value, ExecutionContextInterface $context, ?Pictogram $pictogram)
    {
        if ($pictogram && ($pictogram->getType() === 'nom' || $pictogram->getType() === 'pronom_ou_determinant')) {
            $context->buildViolation('This field is required because filename is not set.')
                ->atPath('nom_pronom') // Замените на имя вашего поля
                ->addViolation();
        }
    }

    public function validatePronom($value, ExecutionContextInterface $context, ?Pictogram $pictogram)
    {
        if ($pictogram && $pictogram->getType() === 'pronom_ou_determinant') {
            $context->buildViolation('This field is required because filename is not set.')
                ->atPath('pronom') // Замените на имя вашего поля
                ->addViolation();
        }
    }
}
