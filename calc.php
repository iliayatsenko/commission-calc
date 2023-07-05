<?php

use CommissionCalc\Calculator;

require 'bootstrap.php';

$calculator = new Calculator();

$calculator->calculateFromFile($argv[1]);
