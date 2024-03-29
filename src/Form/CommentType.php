<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre de votre message',
                'attr' => [
                    'maxLength' => 155,
                    'placeholder' => 'Laissez le titre de votre commentaire ici....'

                ]
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'Commentez l\'article',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Laissez votre message ici....'

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
