<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('brand', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Marque',
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('degre_of_alcohol', TextType::class,[
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Degré d\'alcool',
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('category', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Catégorie',
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('style', TextType::class, [
                'label' => " ",
                'required' => true,
                'attr' => [
                    'placeholder' => 'Style',
                    'list' => "styleOptions",
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('price', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prix Unitaire',
                    'class' => 'rounded-full md:my-3'
                ]
            ])
            ->add('promotion', PercentType::class, [
                'label' => " ",
                'attr' => [
                    'placeholder' => 'Promotion',
                    'class' => 'rounded-full md:my-3'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}