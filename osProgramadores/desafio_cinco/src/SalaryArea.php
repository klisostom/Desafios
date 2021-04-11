<?php

namespace App;

require_once('SalaryInterface.php');

use App\SalaryInterface;

class SalaryArea implements SalaryInterface
{
    public function bigger(): array
    {
        return [];
    }
    public function smaller(): array
    {
        return [];
    }
    public function average(): array|float
    {
        return [];
    }

    public function highestsSalariesByArea(): array
    {
        return [1];
    }

    public function highestsSalariesPrintedByArea(): string
    {
        return '';
    }
}

