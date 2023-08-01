<?php


namespace App\Utils\Calculator;


use App\Enums\Taxes;

class TaxesCalculator implements CalculatorInterface
{

    private string $country;
    private string $taxNumber;
    private float $price;

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }


    public function taxNumberIsValid(): bool
    {
        return $this->setCountryByFormula($this->taxNumber);
    }

    public function getPercentageByCountry(): int
    {
        if ($this->setCountryByFormula($this->taxNumber)) {
            return Taxes::percentageByCountry()[$this->country];
        }
        return 0; // Default percentage when country is not found.
    }


    private function setCountryByFormula(string $taxNumber): bool
    {
        $formulas = Taxes::formulasByCountry();

        foreach ($formulas as $country => $formula) {
            if (preg_match($formula, $taxNumber) === 1) {
                $this->country = $country;
                return true;
            }
        }

        $this->country = '';
        return false;
    }

    public function calculation(): float
    {
        $taxPercentage = $this->getPercentageByCountry();
        return ($this->price * $taxPercentage) / 100;
    }
}