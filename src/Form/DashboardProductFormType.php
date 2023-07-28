<?php

namespace App\Form;

use App\Entity\Product;

use Symfony\Component\Form\AbstractType;
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
        $builder
            ->add('name', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du produit',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('brand', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Marque',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('degre_of_alcohol', TextType::class,[
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Degré d\'alcool',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('category', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Catégorie',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('style', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Style',
                    'list' => "styleOptions",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('price', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prix Unitaire',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('promotion', TextType::class, [
                'label' => " ",
                'attr' => [
                    'placeholder' => 'Promotion',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('capacity', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Contenance',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('stock', IntegerType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Stock',
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('threshold', IntegerType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Seuil de réapprovisionnement",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add('customer_description', TextareaType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description client',
                    'class' => 'rounded-xl md:my-3 w-96'
                ]
            ])
            ->add('employee_description', TextareaType::class, [
                'label' => ' ',
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
            'data_class' => Product::class
        ]);
    }
}