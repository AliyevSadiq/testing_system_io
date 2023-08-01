<?php


namespace App\Utils\Handler;


use App\Enums\Taxes;

class TaxesHandler
{

    private string $country;
    private string $taxNumber;

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;
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

    public function calculationTax($productPrice)
    {
        $taxPercentage = $this->getPercentageByCountry();
        return ($productPrice * $taxPercentage) / 100;
    }
}