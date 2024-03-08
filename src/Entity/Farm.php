<?php

namespace App\Entity;
use App\Repository\FarmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(FarmRepository::class)]
#[ORM\Table(name: 'farms')]
class Farm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?float $tamanho = null;

    #[ORM\Column(length: 255)]
    private ?string $responsavel = null;

    #[ORM\ManyToMany(targetEntity: Veterinarian::class, inversedBy: 'farm')]
    #[ORM\JoinTable(name: 'veterinarios_fazendas')]
    private ArrayCollection | PersistentCollection | null $veterinarios;

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

    public function getTamanho(): ?int
    {
        return $this->tamanho;
    }

    public function setTamanho(?int $tamanho): void
    {
        $this->tamanho = $tamanho;
    }

    public function getResponsavel(): ?string
    {
        return $this->responsavel;
    }

    public function setResponsavel(?string $responsavel): void
    {
        $this->responsavel = $responsavel;
    }

    public function getVeterinarios(): ArrayCollection|PersistentCollection|null
    {
        return $this->veterinarios;
    }

    public function setVeterinarios(ArrayCollection|PersistentCollection|null $veterinarios): void
    {
        $this->veterinarios = $veterinarios;
    }

}