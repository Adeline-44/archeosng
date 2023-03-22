<?php

namespace App\Entity;

use App\Repository\ProfessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionRepository::class)]
class Profession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $cadreEmploi;

    #[ORM\Column(type: 'string', length: 1)]
    private $categorie;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $intitule;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;


    public function __construct()
    {

    }

    public function __tostring(): string
    {
        return $this->getIntitule();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCadreEmploi(): ?int
    {
        return $this->cadreEmploi;
    }

    public function setCadreEmploi(int $cadreEmploi): self
    {
        $this->cadreEmploi = $cadreEmploi;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

}
