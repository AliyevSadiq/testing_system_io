<?php


namespace App\Enums;


final class Taxes
{

    public static function percentageByCountry(): array
    {
        return [
            Country::GERMANY => 19,
            Country::ITALY => 22,
            Country::FRANCE => 20,
            Country::GREECE => 24,
        ];
    }

    public static function formulasByCountry(): array
    {
        return [
            Country::GERMANY => '/^DE\d{9}$/',
            Country::ITALY => '/^IT\d{11}$/',
            Country::FRANCE => '/^FR[A-Z]{2}\d{9}$/',
            Country::GREECE => '/^GR\d{9}$/',
        ];
    }
}