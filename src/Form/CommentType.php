<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('articles_id')
            ->add('user_id');
        //  ->add('content', TextType::class, [
        //     'required' => true
        // ])
        // ->add('articles_id', EntityType::class, [
        //     'required' => true,
        //     'label' => 'Événement',
        //     'class' => Category::class,
        //     'choice_label' => 'title'
        // ])
        // ->add('user_id');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
