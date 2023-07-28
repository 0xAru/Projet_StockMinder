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
               'label' => false,
               'required' => true,
               'attr' => [
                   'placeholder' => "Date de début",
                   'class' => 'rounded-full md:my-3 w-96'
               ]
            ])
           ->add("end_date", DateType::class, [
               'label' => false,
               'required' => true,
               'attr' => [
                   'placeholder' => "Date de fin",
                   'class' => 'rounded-full md:my-3 w-96'
               ]
           ])
           ->add("start_time", TimeType::class, [
               'label' => false,
               'required' => true,
               'attr' => [
                   'placeholder' => "Heure de début",
                   'class' => 'rounded-full md:my-3 w-96'
               ]
           ])
           ->add("end_time", TimeType::class, [
               'label' => false,
               'required' => true,
               'attr' => [
                   'placeholder' => "Heure de fin",
                   'class' => 'rounded-full md:my-3 w-96'
               ]
           ])
           ->add("image", FileType::class, [
               'label' => false,
               'required' => true,
               'attr' => [
                   'class' => 'rounded-full md:my-3 w-96'
               ]
           ])
           ->add("description", TextareaType::class, [
               'label' => false,
               'required' => true,
               'attr' => [
                   'placeholder' => "Description de l'évènement",
                   'class' =>'rounded-xl md:my-3 w-96'
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