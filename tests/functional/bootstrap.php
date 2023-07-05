<?php

use VCR\VCR;

require_once __DIR__ . '/../../bootstrap.php';

$withReal3rdPartyApis = (bool)($_ENV['WITH_REAL_3RD_PARTY_APIS'] ?? false);

if (!$withReal3rdPartyApis) {
    VCR::configure()
        ->setCassettePath('tests/functional/vcr_cassettes')
        ->setMode('none') // disable any real HTTP requests, always use recorded responses
        ->enableLibraryHooks(['stream_wrapper']);

    VCR::turnOn();
    VCR::insertCassette('commissions-calc');
}