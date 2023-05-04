<?php

namespace App\Entity;

use App\Repository\CvRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CvRepository::class)]
class Cv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'cv', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'cvs')]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $cv_candidat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCvCandidat(): ?string
    {
        return $this->cv_candidat;
    }

    public function setCvCandidat(string $cv_candidat): self
    {
        $this->cv_candidat = $cv_candidat;

        return $this;
    }

    public function __toString()
    {
        return $this->cv_candidat;            //peut etre changé firts_name, name, email = string, non null
    }
}
