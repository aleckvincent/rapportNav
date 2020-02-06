<?php

namespace App\Form;

use App\Entity\ControleNavireSansPv;
use App\Entity\RapportNavireControle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControleNavireSansPvType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nombreControle', IntegerType::class, [
                'required' => false,
                'label' => "Nombre de navires non professionnels contrôlés sans PV"
            ])
            ->add('nombreControleAireProtegee', IntegerType::class, [
                'required' => false,
                'label' => "dont en aire marine protégée"
            ])
            ->add('controles', EntityType::class, [
                'class' => RapportNavireControle::class,
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => "Contrôles réalisés sur chacun de ces navires"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ControleNavireSansPv::class,
        ]);
    }
}