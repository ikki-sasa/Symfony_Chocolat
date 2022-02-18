<?php

namespace App\Form;

use App\Entity\Category;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom Produit',
                'attr' => [
                    'maxLenght' => 255,
                    'placeholder' => 'Exemple: L\'Amoureux Noir'
                ]
            ])

            ->add('slug', TextType::class, [
                'required' => true,
            ])

            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description produit',
                'attr' => [
                    'maxLength' => 80000,
                    'placeholder' => 'Exemple: Voici le nouveau venu dans la famille des ganaches.... '
                ]
            ])

            ->add('img', FileType::class, [
                'required' => true,
                'label' => 'Image produit',
                'mapped' => false,
                'help' => 'jpeg, png, gif, svg, eps, psd, tiff, jp2 ou webp - 3 Mo maximum ',
                'constraints' => [
                    'maxSize' => '3M',
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
                ]
            ])

            ->add('parentCategory', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'Choix des catégories'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
