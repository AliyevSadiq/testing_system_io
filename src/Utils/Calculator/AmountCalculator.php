<?php


namespace App\Utils\Calculator;


use App\Entity\Product;
use App\Repository\ProductRepository;

class AmountCalculator implements CalculatorInterface
{

    private ?string $couponCode = null;
    private string $taxNumber;
    private Product|null $product;

    public function __construct(
        private TaxesCalculator $taxesHandler,
        private CouponCalculator $couponHandler,
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

    public function calculation():float
    {
        $price = $this->product->getPrice();

        $discount = $this->couponCode ? $this->couponHandler->setCouponByCode($this->couponCode)
            ->setPrice($price)
            ->calculation() : 0;

        $discountedProductPrice = $this->product->getPrice() - $discount;

        $taxes = $this->taxesHandler->setTaxNumber($this->taxNumber)
            ->setPrice($price)
            ->calculation();
        return $discountedProductPrice + $taxes;
    }
}