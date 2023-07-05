<?php

declare(strict_types=1);

namespace CommissionCalcTests\Functional;

use CommissionCalc\Calculator;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    public function test_outputs_list_of_numeric_values(): void
    {
        // arrange
        $calculator = new Calculator();

        // act
        ob_start();
        $calculator->calculateFromFile(ROOT . '/tests/data/transactions.txt');
        $result = ob_get_clean();

        $numbers = explode("\n", trim($result));

        // assert
        $this->assertNotEmpty($numbers);

        // do not assert against certain numbers because they may differ when running functional tests with real 3rd-party APIs
        foreach ($numbers as $number) {
            $this->assertIsNumeric($number);
        }
    }
}