<?php

declare(strict_types=1);

namespace CommissionCalcTests\Functional;

use CommissionCalc\Calculator\CorrectAmountsCalculator;
use CommissionCalc\Infrastructure\BinLookupBinInfoProvider;
use CommissionCalc\Infrastructure\ExchangeRatesCurrenciesRatesProvider;
use CommissionCalc\Infrastructure\FileTransactionsProvider;
use CommissionCalc\Infrastructure\StaticCommissionValuesProvider;
use PHPUnit\Framework\TestCase;

final class CorrectAmountsCalculatorTest extends TestCase
{
    public function test_returns_list_of_numeric_values(): void
    {
        // arrange
        $calculator = new CorrectAmountsCalculator(
            transactionsProvider: new FileTransactionsProvider(ROOT . '/tests/data/transactions.txt'),
            commissionValuesProvider: new StaticCommissionValuesProvider(),
            binInfoProvider: new BinLookupBinInfoProvider(),
            curRatesProvider: new ExchangeRatesCurrenciesRatesProvider()
        );

        $correctedAmounts = $calculator->calculateCorrectedAmounts();

        // assert
        $this->assertEquals(
            [1, 0.47, 1.28, 2.4, 46.78],
            $correctedAmounts
        );
    }
}