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

    #[ORM\Column]
    private ?float $PriceGram24k = null;

    #[ORM\Column]
    private ?float $PriceGram22k = null;

    #[ORM\Column]
    private ?float $PriceGram21k = null;

    #[ORM\Column]
    private ?float $PriceGram20k = null;

    #[ORM\Column]
    private ?float $PriceGram18k = null;

    #[ORM\Column]
    private ?float $PriceGram16k = null;

    #[ORM\Column]
    private ?float $PriceGram14k = null;

    #[ORM\Column]
    private ?float $PriceGram10k = null;

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

    public function getPriceGram24k(): ?float
    {
        return $this->PriceGram24k;
    }

    public function setPriceGram24k(float $PriceGram24k): static
    {
        $this->PriceGram24k = $PriceGram24k;

        return $this;
    }

    public function getPriceGram22k(): ?float
    {
        return $this->PriceGram22k;
    }

    public function setPriceGram22k(float $PriceGram22k): static
    {
        $this->PriceGram22k = $PriceGram22k;

        return $this;
    }

    public function getPriceGram21k(): ?float
    {
        return $this->PriceGram21k;
    }

    public function setPriceGram21k(float $PriceGram21k): static
    {
        $this->PriceGram21k = $PriceGram21k;

        return $this;
    }

    public function getPriceGram20k(): ?float
    {
        return $this->PriceGram20k;
    }

    public function setPriceGram20k(float $PriceGram20k): static
    {
        $this->PriceGram20k = $PriceGram20k;

        return $this;
    }

    public function getPriceGram18k(): ?float
    {
        return $this->PriceGram18k;
    }

    public function setPriceGram18k(float $PriceGram18k): static
    {
        $this->PriceGram18k = $PriceGram18k;

        return $this;
    }

    public function getPriceGram16k(): ?float
    {
        return $this->PriceGram16k;
    }

    public function setPriceGram16k(float $PriceGram16k): static
    {
        $this->PriceGram16k = $PriceGram16k;

        return $this;
    }

    public function getPriceGram14k(): ?float
    {
        return $this->PriceGram14k;
    }

    public function setPriceGram14k(float $PriceGram14k): static
    {
        $this->PriceGram14k = $PriceGram14k;

        return $this;
    }

    public function getPriceGram10k(): ?float
    {
        return $this->PriceGram10k;
    }

    public function setPriceGram10k(float $PriceGram10k): static
    {
        $this->PriceGram10k = $PriceGram10k;

        return $this;
    }
}
