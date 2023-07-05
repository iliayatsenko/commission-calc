<?php

declare(strict_types=1);

namespace CommissionCalc\Calculator;

interface CommissionValuesProviderInterface
{
    public function getCommissionValue(string $countryCode): float;
}