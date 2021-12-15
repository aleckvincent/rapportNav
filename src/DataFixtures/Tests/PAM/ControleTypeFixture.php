<?php

namespace App\DataFixtures\Tests\PAM;

use App\Entity\PAM\PamControleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ControleTypeFixture extends Fixture implements FixtureGroupInterface {

    public static function getGroups(): array {
        return ['test', 'pam'];
    }

    public function load(ObjectManager $manager) {
        $labels = [
            'Contrôle en mer de navires  de pêche professionnelle',
            'Contrôle en mer de navires de plaisance professionnelle',
            'Contrôle en mer des navires de plaisance de loisir',
            'Contrôles à terre navires de pêche professionnels',
            'Contrôles à terre navires de plaisance professionnelle',
            'Contrôles à terre navires de plaisance de loisir',
            'Autres missions'
        ];

        foreach($labels as $key => $label) {
            $type = new PamControleType();
            $type->setLabel($label);
            $type->setId($key+1);
            $manager->persist($type);
        }
        $manager->flush();
    }
}
