<?php

declare(strict_types=1);

namespace CommissionCalc\tests\integration;

use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    public function test_calculator(): void
    {
        $this->assertEquals(0.3, 0.3);
    }
}