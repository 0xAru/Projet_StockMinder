<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Renseignez votre email",
                    'class' => 'rounded-full my-3'
                ]
            ])
            ->add("Envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn rounded-full px-10 py-2'
                ],
                'row_attr' => [
                    'class' => 'flex justify-center my-3'
                ]
            ]);
    }
}
