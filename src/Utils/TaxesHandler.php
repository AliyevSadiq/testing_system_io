<?php


namespace App\Utils;


use App\Enums\Taxes;

class TaxesHandler
{

    private string $country;

    public function taxNumberIsValid(string $taxNumber): bool
    {
        return $this->getCountryByFormula($taxNumber);
    }

    public function getPercentageByCountry():int
    {
        return Taxes::percentageByCountry()[$this->country];
    }


    private function getCountryByFormula(string $taxNumber): string|bool
    {
        $formulas = Taxes::formulasByCountry();

        foreach ($formulas as $country => $formula) {
            if (preg_match($formula, $taxNumber) === 1) {
                $this->country = $country;
                return true;
            }
        }
        return false;
    }
}