<?php

namespace App;

interface SalaryInterface
{
    public function bigger(): array;
    public function smaller(): array;
    public function average(): array|float;
}
