<?php

namespace App\Entity\PAM;

use App\Repository\PAM\CategoryPamIndicateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryPamIndicateurRepository::class)
 */
class CategoryPamIndicateur
{
    /**
     * @Groups({"view", "draft", "save_rapport"})
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"view", "draft", "save_rapport"})
     * @ORM\Column(type="string", length=124)
     */
    private $nom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
