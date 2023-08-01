<?php


namespace App\Form\DTO;

use App\Entity\Product;
use App\Enums\PaymentType;
use App\Validator\CouponCodeExists;
use App\Validator\EntityExist;
use App\Validator\TaxNumberValid;
use Symfony\Component\Validator\Constraints as Assert;

class PaymentDTO
{
    #[Assert\NotBlank(message:'Product is required')]
    #[EntityExist(className: Product::class)]
    public string $product;

    #[Assert\NotBlank(message:'Tax number is required')]
    #[TaxNumberValid]
    public string $taxNumber;

    #[CouponCodeExists]
    public string|null $couponCode;

    #[Assert\NotBlank(message:'Payment processor is required')]
    #[Assert\Choice(choices: ['paypal','stripe'])]
    public string $paymentProcessor;
}