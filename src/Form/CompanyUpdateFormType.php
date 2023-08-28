<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Dénomination Sociale: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Dénomination Sociale",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add('director_firstname', TextType::class, [
                'label' => "Prénom du directeur: ",
                'required' => true,
                'attr' => [
                    'placeholder' => "Prénom du directeur",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add('director_lastname', TextType::class, [
                'label' => 'Nom du directeur: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom du directeur",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add('siret', TextType::class, [
                'label' => 'Numéro SIRET: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Numéro SIRET",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Adresse",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Code postal",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Ville",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'row_attr' => [
                    'class' => "flex flex-col text-center"
                ]
            ])
            ->add("logo", FileType::class, [
                'label' => "Modifier le logo",
                'label_attr' => [
                    'class' => 'block text-wine text-sm font-bold cursor-pointer text-center hover:text-persian-orange hover:bg-wine shadow appearance-none border border-wine rounded w-full py-2 px-3 focus:outline-none focus:shadow-outline'
                ],
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'hidden',
                    'onchange' => 'previewPicture(this)'
                ],
                'row_attr' => [
                    'class' => 'flex justify-center md:my-3'
                ],
                'mapped' =>false
            ])
            ->add("Envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn rounded-full px-10 py-2'
                ],
                'row_attr' => [
                    'class' => 'flex justify-center md:my-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class
        ]);
    }
}