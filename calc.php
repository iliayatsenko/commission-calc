<?php

declare(strict_types=1);

use CommissionCalc\Calculator\CorrectAmountsCalculator;
use CommissionCalc\Calculator\Exceptions\InfrastructureException;
use CommissionCalc\Calculator\Exceptions\UnexpectedInputException;
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

try {
    $correctedAmounts = $calculator->calculateCorrectedAmounts();
} catch (UnexpectedInputException $e) {
    echo 'Invalid input: ' . $e->getMessage() . "\n";
    exit(1);
} catch (InfrastructureException $e) {
    echo 'Infrastructure error: ' . $e->getMessage() . "\n";
    exit(1);
}

echo implode("\n", $correctedAmounts) . "\n";
