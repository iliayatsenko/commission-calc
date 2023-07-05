<?php

declare(strict_types=1);

namespace CommissionCalc\Infrastructure;

use CommissionCalc\Calculator\TransactionDto;
use CommissionCalc\Calculator\TransactionsProviderInterface;
use CommissionCalc\Infrastructure\Exceptions\FileNotReadableException;
use CommissionCalc\Infrastructure\Exceptions\UnexpectedFileFormatException;

use function CommissionCalc\jsonDecode;

final readonly class FileTransactionsProvider implements TransactionsProviderInterface
{
    public function __construct(
        private string $filePath
    ) {}

    /**
     * @inheritDoc
     */
    public function getTransactions(): iterable
    {
        $fileHandle = fopen($this->filePath, 'r');

        if ($fileHandle === false) {
            throw new FileNotReadableException('Cannot open file with transactions.');
        }

        while(($row = fgets($fileHandle)) !== false) {
            if (trim($row) === '') {
                continue;
            }

            try {
                $rawData = jsonDecode($row);
            } catch (\JsonException) {
                throw new UnexpectedFileFormatException('Row is not valid JSON: ' . $row);
            }

            yield new TransactionDto(
                bin: $rawData['bin'] ?? throw new UnexpectedFileFormatException('Row does not contain "bin" field'),
                amount: isset($rawData['amount'])
                    ? (float) $rawData['amount']
                    : throw new UnexpectedFileFormatException('Row does not contain "amount" field'),
                currency: $rawData['currency'] ?? throw new UnexpectedFileFormatException('Row does not contain "currency" field'),
            );
        }
    }
}