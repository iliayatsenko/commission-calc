<?php

use VCR\VCR;

require_once __DIR__ . '/../../bootstrap.php';

$useRecorded3rdPartyResponses = (bool) ($_ENV['USE_RECORDED_3RD_PARTY_RESPONSES'] ?? false);

if ($useRecorded3rdPartyResponses) {
    VCR::configure()
        ->setCassettePath('tests/functional/vcr_cassettes')
        ->setMode('once') // allow to make real request to 3rd party API only first time, then recorded responses should be reused
        ->enableLibraryHooks(['stream_wrapper']);

    VCR::turnOn();
    VCR::insertCassette('commissions-calc');
}