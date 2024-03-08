<?php

namespace App\Filters;

use Doctrine\Common\Collections\ArrayCollection;

class FarmFilter
{
    private ?string $nome = null;
    private ?float $tamanho = null;
    private ?string $responsavel = null;
    private ?ArrayCollection $veterinarios = null;

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getTamanho(): ?float
    {
        return $this->tamanho;
    }

    public function setTamanho(?float $tamanho): void
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

    public function getVeterinarios(): ?ArrayCollection
    {
        return $this->veterinarios;
    }

    public function setVeterinarios(?ArrayCollection $veterinarios): void
    {
        $this->veterinarios = $veterinarios;
    }


}