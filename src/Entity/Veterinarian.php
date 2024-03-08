<?php

namespace App\Entity;

use App\Repository\VeterinarianRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(VeterinarianRepository::class)]
#[ORM\Table(name: 'veterinarians')]
class Veterinarian
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(unique: true)]
    private ?int $crmv = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCrmv(): ?int
    {
        return $this->crmv;
    }

    public function setCrmv(?int $crmv): void
    {
        $this->crmv = $crmv;
    }

}