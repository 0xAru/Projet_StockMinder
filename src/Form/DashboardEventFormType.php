<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class DashboardEventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de l'évènement",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add("theme", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Thème de l'évènement",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add("display_time_period", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Délai d'affichage",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add("start_date", DateType::class, [
                'label' => "Date de début <img src='/assets/img/date-limite.png' class='ml-4 w-8 h-auto'>",
                'label_html' => true,
                'label_attr' => ['class' => 'flex items-center'],
                'attr' => [
                    'placeholder' => "Date de début",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'required' => true,
                'format' => 'dd MMMM yyyy',
            ])
            ->add("end_date", DateType::class, [
                'label' => "Date de fin <img src='/assets/img/date-limite.png' class='ml-4 w-8 h-auto'>",
                'label_html' => true,
                'label_attr' => ['class' => 'flex items-center'],
                'required' => true,
                'attr' => [
                    'placeholder' => "Date de fin",
                    'class' => 'rounded-full md:my-3 w-96'
                ],
                'format' => 'dd MMMM yyyy'
            ])
            ->add("start_time", TimeType::class, [
                'label' => "Heure de début <img src='/assets/img/heure_event.png' class='ml-4 w-8 h-auto'>",
                'label_html' => true,
                'label_attr' => ['class' => 'flex items-center ml-2'],
                'required' => true,
                'attr' => [
                    'placeholder' => "Heure de début",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add("end_time", TimeType::class, [
                'label' => "Heure de fin <img src='/assets/img/heure_event.png' class='ml-4 w-8 h-auto'>",
                'label_html' => true,
                'label_attr' => ['class' => 'flex items-center ml-2'],
                'required' => true,
                'attr' => [
                    'placeholder' => "Heure de fin",
                    'class' => 'rounded-full md:my-3 w-96'
                ]
            ])
            ->add("image", FileType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'md:my-3 w-96'
                ],
                "mapped" => false
            ])
            ->add("description", TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Description de l'évènement",
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
}