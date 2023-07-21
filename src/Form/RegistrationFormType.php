<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
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
            //champs pour l'utilisateur
            ->add('director_firstname', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom du directeur",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('director_lastname', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Prénom du directeur",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "E-mail",
                    'class' => 'rounded-full md:my-3'
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
                        'class' => 'password-field rounded-full md:my-3'
                    ],
                ],
                'second_options' => [
                    'label' => ' ',
                    'attr' => [
                        'placeholder' => 'Confirmez le mot de passe',
                        'class' => 'password-field rounded-full md:my-3'
                    ],
                ],
                'mapped' => false, // Vous pouvez retirer cette option si vous n'en avez pas besoin
                'constraints' => [ // Vous pouvez conserver les contraintes de validation pour le premier champ de mot de passe
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
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('siret_number', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Numéro SIRET",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Adresse",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Code postal",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Ville",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'md:px-28 btn rounded-full '
                ],
                'row_attr' => [
                    'class' => 'flex justify-center md:my-3'
                ]
            ])

            // Ajouter la classe à la div qui englobe tous les champs
            ->setAttributes([
                'class' => 'flex flex-col items-center',
            ]);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
