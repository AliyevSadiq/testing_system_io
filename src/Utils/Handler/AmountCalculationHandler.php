<?php


namespace App\Utils\Handler;


use App\Entity\Product;
use App\Repository\ProductRepository;

class AmountCalculationHandler
{

    private ?string $couponCode = null;
    private string $taxNumber;
    private Product|null $product;

    public function __construct(
        private TaxesHandler $taxesHandler,
        private CouponHandler $couponHandler,
        private ProductRepository $productRepository
    )
    {
    }

    public function setCouponCode(?string $couponCode = null): self
    {
        $this->couponCode = $couponCode;
        return $this;
    }

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    public function setProduct(int $product_id): self
    {
        $this->product = $this->productRepository->find($product_id);
        return $this;
    }

    public function calculation()
    {
        $discount =$this->couponCode ? $this->couponHandler->setCouponByCode($this->couponCode)
            ->calcDiscount($this->product->getPrice()) : 0;

        $discountedProductPrice = $this->product->getPrice() - $discount;

        $taxes = $this->taxesHandler->setTaxNumber($this->taxNumber)
            ->calculationTax($discountedProductPrice);
        return $discountedProductPrice + $taxes;
    }
}