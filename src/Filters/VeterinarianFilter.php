<?php

namespace App\Filters;

class VeterinarianFilter
{
    private ?string $nome = null;
    private ?int $crmv = null;

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