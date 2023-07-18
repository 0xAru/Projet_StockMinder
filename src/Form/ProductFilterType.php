<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // pour utiliser le type de champs EntityType
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // pour utiliser le type de champs ChoiceType (champs avec ou sans alcool)
use Symfony\Component\Form\Extension\Core\Type\TextType; // pour utiliser le type de champs TextType (champs de recherche)
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('style', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'style',
                'group_by' => 'style', // Cette option regroupe les styles de produits identiques dans le champ select
                'required' => false,
                'placeholder' => 'Style'
            ])
            ->add('origin', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'origin',
                'group_by' => 'origin',
                'required' => false,
                'placeholder' => 'Provenance',
            ])
            ->add('brand', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'brand',
                'group_by' => 'brand',
                'required' => false,
                'placeholder' => 'Marque',
            ])
            ->add('capacity', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'capacity',
                'group_by' => 'capacity',
                'required' => false,
                'placeholder' => 'Contenance',
            ])
            ->add('degre_of_alcohol', ChoiceType::class, [
                'choices' => [
                    'Avec' => 'with',
                    'Sans' => 'without',
                ],
                'required' => false,
                'placeholder' => 'Avec ou sans alcool', //il faut faire une logique afin de déterminer s'il y a de l'alcool ou non (alcool>0°= with, else = without)
            ])
            ->add('search', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Recherche par nom'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer', // activer le bouton submit uniquement lorsque le champs de recherche est renseigner
            ]);
    }
// Ne pouvoir filtrer que sur un seul champs
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
