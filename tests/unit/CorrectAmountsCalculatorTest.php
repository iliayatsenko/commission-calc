<?php

declare(strict_types=1);


use CommissionCalc\Calculator\BinInfoProviderInterface;
use CommissionCalc\Calculator\CorrectAmountsCalculator;
use CommissionCalc\Calculator\CurrenciesRatesProviderInterface;
use CommissionCalc\Calculator\TransactionDto;
use CommissionCalc\Calculator\TransactionsProviderInterface;
use CommissionCalc\Infrastructure\StaticCommissionValuesProvider;
use PHPUnit\Framework\TestCase;

final class CorrectAmountsCalculatorTest extends TestCase
{
    private const LT_BIN = '12345678';
    private const US_BIN = '87654321';

    public function test_calculates_correct_amounts(): void
    {
        // arrange
        $transactions = [
            new TransactionDto(bin: self::LT_BIN, amount: 123.45, currency: 'EUR'),
            new TransactionDto(bin: self::LT_BIN, amount: 987.65, currency: 'USD'),
            new TransactionDto(bin: self::US_BIN, amount: 678.90, currency: 'EUR'),
            new TransactionDto(bin: self::US_BIN, amount: 543.21, currency: 'USD'),
        ];

        $calculator = new CorrectAmountsCalculator(
            transactionsProvider: $this->makeTransactionProviderStub($transactions),
            commissionValuesProvider: new StaticCommissionValuesProvider(),
            binInfoProvider: $this->makeBinProviderStub(),
            curRatesProvider: $this->makeCurrenciesRatesProviderStub()
        );

        // act
        $correctedAmounts = $calculator->calculateCorrectedAmounts();

        // assert
        $this->assertEquals(
            [1.24, 8.24, 13.58, 9.06],
            $correctedAmounts
        );
    }

    private function makeTransactionProviderStub(array $transactions): TransactionsProviderInterface
    {
        $stub = $this->createStub(TransactionsProviderInterface::class);

        $stub
            ->method('getTransactions')
            ->willReturn($transactions);

        return $stub;
    }

    private function makeBinProviderStub(): BinInfoProviderInterface
    {
        $stub = $this->createStub(BinInfoProviderInterface::class);

        $stub
            ->method('getCountryCodeOfBin')
            ->willReturnMap([
                [self::LT_BIN, 'LT'],
                [self::US_BIN, 'US'],
            ]);

        return $stub;
    }

    private function makeCurrenciesRatesProviderStub(): CurrenciesRatesProviderInterface
    {
        $stub = $this->createStub(CurrenciesRatesProviderInterface::class);

        $stub
            ->method('getCurrenciesRates')
            ->willReturnMap([
                ['EUR', ['USD' => 1.2]],
                ['USD', ['EUR' => 0.8]],
            ]);

        return $stub;
    }
}