<?php

declare(strict_types=1);

namespace CommissionCalc\Calculator;

use RuntimeException;

use function CommissionCalc\roundMoney;

final readonly class CorrectAmountsCalculator
{
    public function __construct(
        private TransactionsProviderInterface $transactionsProvider,
        private CommissionValuesProviderInterface $commissionValuesProvider,
        private BinInfoProviderInterface $binInfoProvider,
        private CurrenciesRatesProviderInterface $curRatesProvider
    ) {}

    /**
     * @throws RuntimeException
     * @return float[]
     */
    public function calculateCorrectedAmounts(): array
    {
        $baseCurrencyCode = 'EUR';
        $currenciesRates = $this->curRatesProvider->getCurrenciesRates($baseCurrencyCode);
        $correctedAmounts = [];

        foreach ($this->transactionsProvider->getTransactions() as $transactionDto) {
            $transactionCountry = $this->binInfoProvider->getCountryCodeOfBin($transactionDto->bin);
            $transactionCommission = $this->commissionValuesProvider->getCommissionValue($transactionCountry);

            if ($transactionDto->currency == $baseCurrencyCode) {
                $transactionAmountCorrected = $transactionDto->amount;
            } else {
                $transactionCurrencyRate = $currenciesRates[$transactionDto->currency]
                    ?? throw new RuntimeException(
                        sprintf('Currency rate for currency %s not found', $transactionDto->currency)
                    );

                $transactionAmountCorrected = $transactionDto->amount / $transactionCurrencyRate;
            }

            $transactionAmountCorrected = roundMoney($transactionAmountCorrected * $transactionCommission);
            $correctedAmounts[] = $transactionAmountCorrected;
        }

        return $correctedAmounts;
    }
}



