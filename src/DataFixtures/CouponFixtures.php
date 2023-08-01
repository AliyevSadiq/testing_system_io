<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Enums\DiscountType;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends BaseFixtures
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Coupon::class, 10, function (Coupon $coupon) use ($manager) {
            $coupon->setCode($this->generateCouponCode($this->faker->numberBetween(3, 7)))
                ->setDiscountValue($this->faker->numberBetween(1, 10))
                ->setDiscountType($this->faker->randomElement(DiscountType::converToArray()));

        });

        $manager->flush();
    }

    private function generateCouponCode($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $couponCode = '';

        for ($i = 0; $i < $length; $i++) {
            $couponCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $couponCode;
    }
}
