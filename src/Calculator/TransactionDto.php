<?php

declare(strict_types=1);

namespace CommissionCalc\Calculator;

final readonly class TransactionDto
{
    public function __construct(
        public string $bin,
        public float $amount,
        public string $currency,
    ) {}
}