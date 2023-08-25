<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champs pour l'utilisateur
            ->add('director_firstname', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Prénom du directeur",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add('director_lastname', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom du directeur",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "E-mail",
                    'class' => 'w-full rounded-full my-3'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'required' => true,
                'first_options' => [
                    'label' => ' ',
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'class' => 'password-field rounded-full my-3'
                    ],
                ],
                'second_options' => [
                    'label' => ' ',
                    'attr' => [
                        'placeholder' => 'Confirmez le mot de passe',
                        'class' => 'password-field rounded-full my-3'
                    ],
                ],
                'mapped' => false,
                // contraintes de validation pour le premier champ de mot de passe
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être composé d\'au moins 6 caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            //champs pour la société
            ->add('company_name', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Dénomination Sociale",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add('siret_number', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Numéro SIRET",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Adresse",
                    'class' => 'w-full rounded-full my-3'
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Code postal",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Ville",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add('employee_password', PasswordType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Mot de passe employés',
                    'class' => 'w-full rounded-full my-3'
                ]
            ])
            ->add("logo", FileType::class, [
                'label' => "Sélectionner un logo",
                'label_attr' => [
                    'class' => 'block text-wine text-sm font-bold cursor-pointer text-center hover:text-persian-orange hover:bg-wine shadow appearance-none border border-wine rounded w-full py-2 px-3 focus:outline-none focus:shadow-outline'
                ],
                'required' => false,
                'attr' => [
                    'class' => 'hidden',
                    'onchange' => 'previewPicture(this)'
                ]
            ])
            ->add("Envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn rounded-full px-10 py-2 font-semibold'
                ],
                'row_attr' => [
                    'class' => 'flex justify-center my-3'
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
