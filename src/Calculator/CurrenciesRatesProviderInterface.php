<?php

declare(strict_types=1);

namespace CommissionCalc\Calculator;

use RuntimeException;

interface CurrenciesRatesProviderInterface
{
    /**
     * @throws RuntimeException
     * @return array<string, float>
     */
    public function getCurrenciesRates(string $baseCurrencyCode): array;
}