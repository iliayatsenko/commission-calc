<?php

declare(strict_types=1);

namespace CommissionCalc\Infrastructure;

use CommissionCalc\Calculator\CommissionValuesProviderInterface;

final class StaticCommissionValuesProvider implements CommissionValuesProviderInterface
{
    private const EU_COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function getCommissionValue(string $countryCode): float
    {
        // TODO: Assert country code is valid

        return $this->isEuCountry($countryCode) ? 0.01 : 0.02;
    }

    private function isEuCountry(string $countryCode): bool
    {
        return in_array($countryCode, self::EU_COUNTRIES, true);
    }
}