<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => "Votre Prénom*",
                'required' => true,
                'attr' => [
                    'maxLength' => 100
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => "Votre Nom*",
                'required' => true,
                'attr' => [
                    'maxLength' => 100
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Addresse mail*',
                'required' => true,
                'attr' => [
                    'maxLength' => 100
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => "Votre Téléphone*",
                'required' => true,
                'attr' => [
                    'maxLength' => 14
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'maxLength' => 100
                ]
            ])
            ->add('captcha', ReCaptchaType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
