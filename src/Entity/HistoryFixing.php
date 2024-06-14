<?php

namespace App\Entity;

use App\Repository\HistoryFixingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryFixingRepository::class)]
class HistoryFixing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $OpenPrice = null;

    #[ORM\Column(length: 3)]
    private ?string $Metal = null;

    #[ORM\Column]
    private ?int $OpenTime = null;

    #[ORM\Column(length: 3)]
    private ?string $Currency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpenPrice(): ?float
    {
        return $this->OpenPrice;
    }

    public function setOpenPrice(float $OpenPrice): static
    {
        $this->OpenPrice = $OpenPrice;

        return $this;
    }

    public function getMetal(): ?string
    {
        return $this->Metal;
    }

    public function setMetal(string $Metal): static
    {
        $this->Metal = $Metal;

        return $this;
    }

    public function getOpenTime(): ?int
    {
        return $this->OpenTime;
    }

    public function setOpenTime(int $OpenTime): static
    {
        $this->OpenTime = $OpenTime;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    public function setCurrency(string $Currency): static
    {
        $this->Currency = $Currency;

        return $this;
    }
}
