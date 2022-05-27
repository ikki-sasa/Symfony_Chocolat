<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_name', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'attr' => [
                    'maxLength' => 250,
                    'placeholder' => 'Exemple: Assortiment de pâtes de fruits 100g'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                    'maxLength' => 70000,
                    'placeholder' => 'Exemple: Assortiment de nos pâtes de fruits: Framboise, mangue/passion...'
                ]

            ])
            ->add('statutes', TextType::class, [
                'required' => true,
                'label' => 'État/Statut',
                'attr' => [
                    'maxLength' => 50,
                    'placeholder' => 'État du produit en cours'
                ]

            ])

            ->add('price', IntegerType::class, [
                'required' => true,
                'label' => 'Prix',
                'attr' => [
                    'min' => 0,
                    'max' => 5000
                ]
            ])

            ->add('img', FileType::class, [
                'required' => true,
                'label' => 'Première photo du produit',
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '15M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Maximum autorisé : {{ limit }} Mo. ',
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
                    ])
                ]
            ])
            ->add('img2', FileType::class, [
                'required' => true,
                'label' => 'Second photo du produit',
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '15M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Maximum autorisé : {{ limit }} Mo. ',
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
                    ])
                ]
            ])
            ->add('category_id', EntityType::class, [
                'required' => true,
                'label' => 'Catégorie',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $categoryRepository) {
                    return $categoryRepository->getProductCategories();
                },
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
