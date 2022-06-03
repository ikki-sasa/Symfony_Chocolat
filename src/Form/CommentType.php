<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxLength' => 255
                ]
            ])
            // ->add('articles_id', EntityType::class, [
            //     'class' => Article::class,
            //     'label' => 'Selection de l\'article a commenter',
            //     'choice_label' => 'title',
            // ])
            // ->add('comment_id', IntegerType::class, [
            //     'required' => true,
            //     'label' => 'Nom de l\'Article id',
            //     'class' => Category::class,
            //     'query_builder' => function (CategoryRepository $categoryRepository) {
            //         return $categoryRepository->getBlogCategories();
            //     },
            //     'choice_label' => 'name'
            // ])
            // ->add('comment_id', IntegerType::class, [
            //     'class' => Comment::class,
            //     'label' => 'identifiant | id',
            //     'choice_label' => 'title',
            // ])

            // ->add('comment_id', EntityType::class, [
            //     'required' => true,
            //     'label' => 'L\'auteur du commentaire',
            //     'class' => User::class,
            //     'query_builder' => function (UserRepository $userRepository) {
            //         return $userRepository->getId();
            //     },
            // 'choice_label' => 'name'
            // ])
        ;

        // ->add('user_id');
        //  ->add('content', TextType::class, [
        //     'required' => true
        // ])
        // ->add('articles_id', EntityType::class, [
        //     'required' => true,
        //     'label' => 'Événement',
        //     'class' => Category::class,
        //     'choice_label' => 'title'
        // ]);
        // ->add('user_id');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
