<?php

namespace  App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DashboardEmployeeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("firstname", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => " Prénom de l'employé",
                    'class' => 'rounded-full md:my-3 h-6 md:h-11 md:w-96 text-xs md:text-base'
                ]
            ])
            ->add("lastname", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de l'employé",
                    'class' => 'rounded-full md:my-3 h-6 md:h-11 md:w-96 text-xs md:text-base'
                ]
            ])
            ->add("employee_number", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Matricule",
                    'class' => 'rounded-full md:my-3 h-6 md:h-11 md:w-96 text-xs md:text-base',
                    'title' => 'entrez un matricule entre 2 et 99 pour le ROLE_CHEF et superieur ou égal à 100 pour le ROLE_SERVEUR'
                ],
                'mapped' => false
            ])

            ->add("Envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn rounded-full px-10 py-2'
                ],
                'row_attr' => [
                    'class' => 'flex justify-center md:my-3 md:w-96'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}