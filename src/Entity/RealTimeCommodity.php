<?php

namespace App\Entity;

use App\Repository\RealTimeCommodityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealTimeCommodityRepository::class)]
class RealTimeCommodity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $Metal = null;

    #[ORM\Column(length: 3)]
    private ?string $Currency = null;

    #[ORM\Column(length: 8)]
    private ?string $Exchange = null;

    #[ORM\Column(length: 20)]
    private ?string $Symbol = null;

    #[ORM\Column]
    private ?float $Price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    public function setCurrency(string $Currency): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getExchange(): ?string
    {
        return $this->Exchange;
    }

    public function setExchange(string $Exchange): static
    {
        $this->Exchange = $Exchange;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->Symbol;
    }

    public function setSymbol(string $Symbol): static
    {
        $this->Symbol = $Symbol;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
