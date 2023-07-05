<?php

declare(strict_types=1);

use CommissionCalc\Calculator\CorrectAmountsCalculator;
use CommissionCalc\Infrastructure\BinLookupBinInfoProvider;
use CommissionCalc\Infrastructure\ExchangeRatesCurrenciesRatesProvider;
use CommissionCalc\Infrastructure\FileTransactionsProvider;
use CommissionCalc\Infrastructure\StaticCommissionValuesProvider;

require 'bootstrap.php';

$calculator = new CorrectAmountsCalculator(
    transactionsProvider: new FileTransactionsProvider($argv[1]),
    commissionValuesProvider: new StaticCommissionValuesProvider(),
    binInfoProvider: new BinLookupBinInfoProvider(),
    curRatesProvider: new ExchangeRatesCurrenciesRatesProvider()
);

$correctedAmounts = $calculator->calculateCorrectedAmounts();

echo implode("\n", $correctedAmounts) . "\n";
