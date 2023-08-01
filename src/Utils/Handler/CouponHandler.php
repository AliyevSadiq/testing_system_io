<?php


namespace App\Utils\Handler;


use App\Entity\Coupon;
use App\Enums\DiscountType;
use App\Repository\CouponRepository;

class CouponHandler
{

    private Coupon $coupon;

    public function __construct(private CouponRepository $couponRepository)
    {
    }

    public function setCouponByCode(?string $code=null):self
    {
            $this->coupon = $this->couponRepository->activeCoupon($code);
        return $this;
    }

    public function calcDiscount(float $product_price): float
    {
        $coupon=$this->coupon;
        $discount = 0;

        if ($coupon) {
            $discount= $coupon->getDiscountType() == DiscountType::PERCENTAGE
                ? ($product_price*$coupon->getDiscountValue()) / 100
                : $coupon->getDiscountValue();
        }
        return $discount;
    }

}