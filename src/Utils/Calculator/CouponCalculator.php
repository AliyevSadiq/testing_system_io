<?php


namespace App\Utils\Calculator;


use App\Entity\Coupon;
use App\Enums\DiscountType;
use App\Repository\CouponRepository;

class CouponCalculator implements CalculatorInterface
{

    private Coupon $coupon;
    private float $price;

    public function __construct(private CouponRepository $couponRepository)
    {
    }

    public function setCouponByCode(?string $code = null): self
    {
        $this->coupon = $this->couponRepository->activeCoupon($code);
        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function calculation():float
    {
        $coupon = $this->coupon;
        $discount = 0.0;

        if ($coupon) {
            $discount = $coupon->getDiscountType() == DiscountType::PERCENTAGE
                ? ($this->price * $coupon->getDiscountValue()) / 100
                : $coupon->getDiscountValue();
        }
        return $discount;
    }

}