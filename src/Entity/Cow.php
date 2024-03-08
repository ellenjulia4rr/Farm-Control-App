<?php

namespace App\Entity;

use App\Repository\CowRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\True_;

#[ORM\Entity(CowRepository::class)]
#[ORM\Table(name: 'cows')]
class Cow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    private ?int $code = null;

    #[ORM\Column]
    private float $milk;

    #[ORM\Column]
    private float $portion;

    #[ORM\Column]
    private float $weight;

    #[ORM\Column]
    private bool $live;

    #[ORM\Column]
    private ?\DateTime $birth;

    #[ORM\ManyToOne(targetEntity: Farm::class, inversedBy: 'cows')]
    private Farm $farm;

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    public function getMilk(): float
    {
        return $this->milk;
    }

    public function setMilk(float $milk): void
    {
        $this->milk = $milk;
    }

    public function getPortion(): float
    {
        return $this->portion;
    }

    public function setPortion(float $portion): void
    {
        $this->portion = $portion;
    }

    public function isLive(): bool
    {
        return $this->live;
    }

    public function setLive(bool $live): void
    {
        $this->live = $live;
    }

    public function getBirth(): ?\DateTime
    {
        return $this->birth;
    }

    public function setBirth(?\DateTime $birth): void
    {
        $this->birth = $birth;
    }

    public function getFarm(): Farm
    {
        return $this->farm;
    }

    public function setFarm(Farm $farm): void
    {
        $this->farm = $farm;
    }

    public function checksCattleForSlaughter()
    {
       $birth = new \DateTime('-5 years');
       if(
           ($this->milk < 40 || $this->weight > 270 || $this->birth < $birth ||
           ($this->milk < 70 and $this->portion > 350)) and $this->live = true)
           return true;

       return false;
    }
}