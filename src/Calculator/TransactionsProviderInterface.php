<?php

declare(strict_types=1);

namespace CommissionCalc\Calculator;

interface TransactionsProviderInterface
{
    /**
     * @return TransactionDto[]
     */
    public function getTransactions(): iterable;
}