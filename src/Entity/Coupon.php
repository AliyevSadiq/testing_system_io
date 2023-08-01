<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[ORM\Column(length: 20)]
    private ?string $discount_type = null;

    #[ORM\Column]
    private ?int $discount_value = null;

    #[ORM\Column(options: ['default'=>false])]
    private ?bool $is_used = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscountType(): ?string
    {
        return $this->discount_type;
    }

    public function setDiscountType(string $discount_type): static
    {
        $this->discount_type = $discount_type;

        return $this;
    }

    public function getDiscountValue(): ?int
    {
        return $this->discount_value;
    }

    public function setDiscountValue(int $discount_value): static
    {
        $this->discount_value = $discount_value;

        return $this;
    }

    public function isIsUsed(): ?bool
    {
        return $this->is_used;
    }

    public function setIsUsed(bool $is_used): static
    {
        $this->is_used = $is_used;

        return $this;
    }
}
