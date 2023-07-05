<?php

declare(strict_types=1);

namespace CommissionCalc\Infrastructure;

use CommissionCalc\Calculator\CurrenciesRatesProviderInterface;
use CommissionCalc\Infrastructure\Exceptions\ThirdPartyInaccessibleException;
use CommissionCalc\Infrastructure\Exceptions\ThirdPartyUnexpectedResponseException;

use function CommissionCalc\jsonDecode;

final class ExchangeRatesCurrenciesRatesProvider implements CurrenciesRatesProviderInterface
{
    private const API_KEY = 'ed55beced187e20645e44ec656b7b144';

    /**
     * @inheritDoc
     * @throws ThirdPartyUnexpectedResponseException
     * @throws ThirdPartyInaccessibleException
     */
    public function getCurrenciesRates(string $baseCurrencyCode): array
    {
        // TODO: Assert currency code is valid

        // Maybe here I were supposed to use smth like Guzzle, but why to make things more complicated? :)
        $apiResponse = @file_get_contents(
            sprintf(
                'http://api.exchangeratesapi.io/latest?base=%s&access_key=%s',
                $baseCurrencyCode,
                self::API_KEY
            )
        );

        if ($apiResponse === false) {
            throw new ThirdPartyInaccessibleException(
                'Error while fetching data from exchangeratesapi.io'
            );
        }

        try {
            $ratesData = jsonDecode($apiResponse);
        } catch (\JsonException) {
            throw new ThirdPartyUnexpectedResponseException(
                'Error while decoding data from exchangeratesapi.io: ' . $apiResponse
            );
        }

        return $ratesData['rates']
            ?? throw new ThirdPartyUnexpectedResponseException(
                'Unexpected response from exchangeratesapi.io: ' . $apiResponse
            );
    }
}