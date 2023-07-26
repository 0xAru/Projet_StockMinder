<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Blonde' => 'Blonde',
                    'Brune' => 'Brune',
                    'Blanche' => 'Blanche',
                    'Ambrée' => 'Ambrée',
                    'Fruitée' => 'Fruitée',
                    'Sans alcool' => 'Sans alcool',
                    'Soft' => 'Soft'
                ]
            ])
        ;
    }
}