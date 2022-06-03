<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Image;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom catégorie',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Exemple: L\'Amoureux Noir'
                ]
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
                'required' => false,
                'label' => 'Image produit',
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

            ->add('parentCategory', EntityType::class, [
                'required' => true,
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
