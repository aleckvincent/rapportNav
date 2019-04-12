<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NavireRepository")
 */
class Navire {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 6)
     */
    private $immatriculation_fr;

    /**
     * Identifiant du référentiel Floteurs
     * @ORM\Column(type="integer")
     */
    private $id_nav_floteur;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 45)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $longueurHorsTout;

    public function getId(): ?int {
        return $this->id;
    }

    public function getImmatriculationFr(): ?string {
        return $this->immatriculation_fr;
    }

    public function setImmatriculationFr(string $immatriculation_fr): self {
        $this->immatriculation_fr = $immatriculation_fr;

        return $this;
    }

    public function getIdNavFloteur(): ?int {
        return $this->id_nav_floteur;
    }

    public function setIdNavFloteur(int $id_nav_floteur): self {
        $this->id_nav_floteur = $id_nav_floteur;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getLongueurHorsTout(): ?float {
        return $this->longueurHorsTout;
    }

    public function setLongueurHorsTout(float $longueurHorsTout): self {
        $this->longueurHorsTout = $longueurHorsTout;

        return $this;
    }
}