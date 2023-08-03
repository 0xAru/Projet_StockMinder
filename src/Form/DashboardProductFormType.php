<?php

namespace App\Form;

use App\Entity\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DashboardProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Récupération des différents styles et labels de l'entité Product
        $labelChoices = array_values(array_unique($options['label_choices']));
        $originChoices = array_values(array_unique($options['origin_choices']));

        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du produit',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('brand', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Marque',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('degree_of_alcohol', TextType::class,[
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Degré d\'alcool (%)',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('category', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Catégorie',
                    'list' => "categoryOptions",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('style', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Style',
                    'list' => "styleOptions",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('label', ChoiceType::class, [
                'choices' => array_combine($labelChoices, $labelChoices),
                'required' => false,
                'label' => false,
                'placeholder' => 'Choisissez un label si necessaire',
                'attr' => [
                    'class' => 'rounded-full md:my-3 w-96 text-gray-500',
                ],
                'data' => 'NULL',
            ])
            ->add('origin', ChoiceType::class, [
                'choices' => array_combine($originChoices, $originChoices),
                'required' => false,
                'placeholder' => 'Provenance',
                'label' => false,
                'attr' => [
                    'class' => 'rounded-full md:my-3 w-96 text-gray-500'
                ]
            ])
            ->add('price', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prix Unitaire (en centimes)',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('promotion', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Promotion (%)',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('capacity', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Contenance (cl)',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('stock', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Stock',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('threshold', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Seuil de réapprovisionnement",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('customer_description', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description client',
                    'class' => 'rounded-xl md:my-3 w-96'
                ]
            ])
            ->add('employee_description', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description serveur',
                    'class' => 'rounded-xl md:my-3 w-96'
                ]
            ])
            ->add("Envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn rounded-full px-10 py-2 font-semibold'
                ],
                'row_attr' => [
                    'class' => 'flex justify-center md:my-3 w-96'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'label_choices' => [],
            'origin_choices' => []
        ]);
    }
}