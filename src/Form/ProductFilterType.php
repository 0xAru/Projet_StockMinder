<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // pour utiliser le type de champs EntityType
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // pour utiliser le type de champs ChoiceType (champs avec ou sans alcool)
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // pour utiliser le type de champs TextType (champs de recherche)
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupérer les options uniques pour le champ "style" et supprimer les doublons
        $styleChoices = array_values(array_unique($options['style_choices']));
        $originChoices = array_values(array_unique($options['origin_choices']));
        $brandChoices = array_values(array_unique($options['brand_choices']));
        $capacityChoices = array_values(array_unique($options['capacity_choices']));

        $builder
            ->add('style', ChoiceType::class, [
                'choices' => array_combine($styleChoices, $styleChoices),
                'required' => false,
                'placeholder' => 'Style',
                'label' => false,
                'attr' => [
                    'class' => 'text-red-500',
                    ],
            ])
            ->add('origin', ChoiceType::class, [
                'choices' => array_combine($originChoices, $originChoices),
                'required' => false,
                'placeholder' => 'Provenance',
                'label' => false,
            ])
            ->add('brand', ChoiceType::class, [
                'choices' => array_combine($brandChoices, $brandChoices),
                'required' => false,
                'placeholder' => 'Marque',
                'label' => false,
            ])
            ->add('capacity', ChoiceType::class, [
                'choices' => array_combine($capacityChoices, $capacityChoices),
                'required' => false,
                'placeholder' => 'Contenance',
                'label' => false,
            ])
            ->add('degre_of_alcohol', ChoiceType::class, [
                'choices' => [
                    'Avec' => 'with',
                    'Sans' => 'without',
                ],
                'required' => false,
                'label' => false,
                'placeholder' => 'Avec ou sans alcool', //il faut faire une logique afin de déterminer s'il y a de l'alcool ou non (alcool>0°= with, else = without)
            ])
            //->add('search', TextType::class, [
               // 'required' => false,
                //'attr' => ['placeholder' => 'Recherche par nom'],
            //])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer', // activer le bouton submit uniquement lorsque le champs de recherche est renseigner
            ]);
    }
// Ne pouvoir filtrer que sur un seul champs
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'style_choices' => [],
            'origin_choices' => [],
            'brand_choices' => [],
            'capacity_choices' => [],
        ]);
    }
}
