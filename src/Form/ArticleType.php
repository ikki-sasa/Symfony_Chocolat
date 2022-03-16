<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'article',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Exemple: La Saint Valentin'
                ]
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'Description article',
                'attr' => [
                    'maxLength' => 80000,
                    'placeholder' => 'Exemple: Voici l\'évenment tant attendu cette année....'
                ]
            ])
            ->add('featured_img', FileType::class, [
                'required' => true,
                'label' => 'Image article',
                'mapped' => false,
                'help' => 'jpeg, png, gif, svg, eps, psd, tiff, jp2 ou webp - 8 Mo maximum ',
                'constraints' => [
                    new Image([
                        'maxSize' => '8M',
                        'maxSizeMessage' => 'Votre fichier est trop volumineux ({{ size }} Mo). Taille maximum autorisée.',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/svg',
                            'image/eps',
                            'image/psd',
                            'image/tiff',
                            'image/jp2',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci d\'utiliser un des formats suivant jpeg, png, gif, svg, eps, psd, tiff, jp2 ou webp. '
                    ])
                ]
            ])
            ->add('category_id', EntityType::class, [
                'required' => true,
                'label' => 'Catégorie article',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $categoryRepository) {
                    return $categoryRepository->getBlogCategories();
                },
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
