<?php

namespace App\Form;

use App\Entity\Institution;
use App\Entity\Therapist;
use App\Repository\InstitutionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    private InstitutionRepository $iRepo;

    public function __construct(InstitutionRepository $iRepo)
    {
        $this->iRepo = $iRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Email'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                        'match' => true,
                        'message' => 'Saisir votre adresse email dans un bon format',
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Prénom'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Nom'
                ],
            ])
            ->add('job', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Fonction'
                ],
            ])
            ->add('codeInstitution', TextType::class, [
                'label' => false,
                'required' => true,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Code de votre Institut'
                ],
            ])
            ->add('institution', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'mapped' => false,
                'choices' =>
                array_merge([null], $this->iRepo->findAll()),
                'choice_value' => function (?Institution $i) {
                    return $i ? $i->getCode() : '';
                },
                'choice_label' => function (?Institution $i) {
                    return $i ? $i->getName() : 'Choisir votre Institut';
                },
                'choice_attr' => [
                    'class' => 'input-text'
                ],
                'attr' => [
                    'class' => 'input-text',
                ],
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'label' => '',
            //     'required' => true,
            //     'attr' => [
            //     ],
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'options' => [
                    'attr' => []
                ],
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Verifier mot de passe'
                    ],
                ],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Mot de passe'
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*!@$%&?_+\-=|]).{8,}$/',
                        'match' => true,
                        'message' => 'Le mot de passe doit contenir au moins: une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial ( *!@$%&?_+\-=| )',
                    ]),
                    new NotBlank([
                        'message' => 'Saisir Mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            // ->add('checkPassword', PasswordType::class, [
            //     'label' => false,
            //     'required' => true,
            //     'mapped' => false,
            //     'attr' => [
            //         'placeholder' => 'Verifier mot de passe'
            //     ],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please verify a password',
            //         ]),
            //         new Length([
            //             'min' => 8,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Therapist::class,
        ]);
    }
}
