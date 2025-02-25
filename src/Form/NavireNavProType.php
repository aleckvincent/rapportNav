<?php

namespace App\Form;

use App\Entity\CategorieUsageNavire;
use App\Entity\Navire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NavireNavProType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('immatriculation', TextType::class, [
        'attr' => [
          'class' => "immatriculation fr-input fr-mb-2w",
          'placeholder' => '6 chiffres',
          'maxlength' => 6,
          'minlength' => 6
        ],
        'label' => "Immatriculation du navire",
        'required' => true,
      ])
      ->add('pavillon', CountryType::class, [
        'required' => true,
        'label' => "Pavillon du navire",
        'attr' => [
          'class' => 'fr-input fr-mb-2w'
        ],
        'preferred_choices' => ['FR', 'ES', 'GB', 'PT', 'COM', 'LC', 'DM', 'MU']
      ])
      ->add('nom', TextType::class, [
        'required' => true,
        'label' => "Nom du navire",
        'attr' => [
          'class' => 'fr-input fr-mb-2w'
        ]
      ]
      )
      ->add('categorieUsageNavire', EntityType::class, [
        'required' => true,
        'class' => CategorieUsageNavire::class,
        'multiple' => false,
        'expanded' => false,
        'placeholder' => "Sélectionnez une catégorie",
        'choice_label' => "nom",
        'label' => "Catégorie du navire contrôlé",
        'attr' => [
          'class' => 'fr-select fr-mb-2w'
        ]
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'data_class' => Navire::class,
    ]);
  }

}
