<?php

declare(strict_types=1);

namespace CommissionCalc;

use JsonException;

/**
 * @throws JsonException
 */
function jsonDecode(string $json): array
{
    return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
}

function roundMoney(float $value): float
{
    return ceil($value * pow(10, 2)) / pow(10, 2);
}