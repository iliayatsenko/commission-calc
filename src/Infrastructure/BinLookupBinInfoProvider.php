<?php

declare(strict_types=1);

namespace CommissionCalc\Infrastructure;

use CommissionCalc\Calculator\BinInfoProviderInterface;
use CommissionCalc\Infrastructure\Exceptions\ThirdPartyInaccessibleException;
use CommissionCalc\Infrastructure\Exceptions\ThirdPartyUnexpectedResponseException;

use function CommissionCalc\jsonDecode;

final class BinLookupBinInfoProvider implements BinInfoProviderInterface
{
    /**
     * @throws ThirdPartyInaccessibleException
     * @throws ThirdPartyUnexpectedResponseException
     */
    public function getCountryCodeOfBin(string $bin): string
    {
        // TODO: Assert bin is valid

        // Maybe here I were supposed to use smth like Guzzle, but why to make things more complicated? :)
        $apiResponse = @file_get_contents(
            sprintf(
                'https://lookup.binlist.net/%s',
                $bin
            )
        );

        if ($apiResponse === false) {
            throw new ThirdPartyInaccessibleException(
                'Error while fetching data from binlist.net'
            );
        }

        try {
            $binData = jsonDecode($apiResponse);
        } catch (\JsonException) {
            throw new ThirdPartyUnexpectedResponseException(
                'Error while decoding data from binlist.net: ' . $apiResponse
            );
        }

        return $binData['country']['alpha2']
            ?? throw new ThirdPartyUnexpectedResponseException(
                'Unexpected response from binlist.net: ' . $apiResponse
            );
    }
}