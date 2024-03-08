<?php

namespace App\Filters;

use Doctrine\Common\Collections\ArrayCollection;

class CowFilter
{
    private ?int $code = null;
    private ?string $milk = null;
    private ?float $portion = null;
    private ?float $weight = null;
    private ?string $live = null;
    private ?\DateTime $birth = null;
    private ?ArrayCollection $farms = null;

    public function getLive(): ?string
    {
        return $this->live;
    }

    public function setLive(?string $live): void
    {
        $this->live = $live;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    public function getMilk(): ?string
    {
        return $this->milk;
    }

    public function setMilk(?string $milk): void
    {
        $this->milk = $milk;
    }

    public function getPortion(): ?float
    {
        return $this->portion;
    }

    public function setPortion(?float $portion): void
    {
        $this->portion = $portion;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): void
    {
        $this->weight = $weight;
    }

    public function getBirth(): ?\DateTime
    {
        return $this->birth;
    }

    public function setBirth(?\DateTime $birth): void
    {
        $this->birth = $birth;
    }

    public function getFarms(): ?ArrayCollection
    {
        return $this->farms;
    }

    public function setFarms(?ArrayCollection $farms): void
    {
        $this->farms = $farms;
    }

}