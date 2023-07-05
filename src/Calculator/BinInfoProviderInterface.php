<?php

declare(strict_types=1);

namespace CommissionCalc\Calculator;

use RuntimeException;

interface BinInfoProviderInterface
{
    /**
     * @throws RuntimeException
     */
    public function getCountryCodeOfBin(string $bin): string;
}