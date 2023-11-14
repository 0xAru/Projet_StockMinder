<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupération des options uniques pour le champ "style" et suppression des doublons. Routourne un tableau indexé à partir de 0 avec le options uniques.
        $styleChoices = array_values(array_unique($options['style_choices']));
        $originChoices = array_values(array_unique($options['origin_choices']));
        $brandChoices = array_values(array_unique($options['brand_choices']));
        $capacityChoices = array_values(array_unique($options['capacity_choices']));
        $builder

            ->add('style', ChoiceType::class, [
                'choices' => array_combine($styleChoices, $styleChoices), //Creates an array by using the values from the keys array as keys and the values from the values array as the corresponding values.
                //les options et les valeurs soumises sont identiques (nom du style et pas 0,1,2...)
                'required' => false,
                'placeholder' => 'Style',
                'label' => false,
                'attr' => [
                    'class' => 'focus:font-bold focus:ring-0 bg-transparent border-0 w-40',
                ],
                'row_attr' => [
                    'class' => 'my-filter-fields',
                ],

            ])

            ->add('origin', ChoiceType::class, [
                'choices' => array_combine($originChoices, $originChoices),
                'required' => false,
                'placeholder' => 'Provenance',
                'label' => false,
                'attr' => [
                    'class' => 'focus:font-bold focus:ring-0 bg-transparent border-0 w-40 ',
                ],
                'row_attr' => [
                    'class' => 'my-filter-fields',
                ],
            ])
            ->add('brand', ChoiceType::class, [
                'choices' => array_combine($brandChoices, $brandChoices),
                'required' => false,
                'placeholder' => 'Marque',
                'label' => false,
                'attr' => [
                    'class' => 'focus:font-bold focus:ring-0 bg-transparent border-0 w-40',
                ],
                'row_attr' => [
                    'class' => 'my-filter-fields',
                ],
            ])
            ->add('capacity', ChoiceType::class, [
                'choices' => array_combine($capacityChoices, $capacityChoices),
                'required' => false,
                'placeholder' => 'Contenance',
                'label' => false,
                'attr' => [
                    'class' => 'focus:font-bold focus:ring-0 bg-transparent border-0 w-40 ',
                ],
                'row_attr' => [
                    'class' => 'my-filter-fields',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class' => 'my-button w-28 rounded-full p-1 focus:font-bold focus:ring-0 border-0 ',
                ],
            ])

            ->add('button', ButtonType::class, [
                'label' => 'Effacer',
                'attr' => [
                    'onclick' => 'resetFilters()',
                    'class' => 'my-button w-28 rounded-full p-1 focus:font-bold focus:ring-0 border-0'
                ],
            ]);

    }
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
