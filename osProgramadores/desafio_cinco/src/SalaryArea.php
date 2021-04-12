<?php

namespace App;

require_once('SalaryInterface.php');
require_once('EmployeeTrait.php');

use EmployeeTrait;
use App\SalaryInterface;

class SalaryArea implements SalaryInterface
{
    use EmployeeTrait;

    public function __construct(protected mixed $employees = [])
    {
        $this->employees = (count($employees) === 0) ?
            $this->employees() :
            collect($employees);
    }

    public function bigger(): array
    {
        return $this->calculateSalary($this->employees)
            ->groupBy('area')
            ->map(function ($area) {
                return $area->groupBy('salario')
                        ->sortKeysDesc()
                        ->first()
                        ->map(function ($employee) {
                            $area = $this->areas()->firstWhere('codigo', $employee['area']);

                            return "area_max|{$area['nome']}|{$employee['nome']} {$employee['sobrenome']}|" .
                                number_format($employee['salario'], 2, '.', '');
                        });
            })->toArray();
    }

    public function smaller(): array
    {
        return $this->calculateSalary($this->employees)
            ->groupBy('area')
            ->map(function ($area) {
                return $area->groupBy('salario')
                        ->sortKeysDesc()
                        ->last()
                        ->map(function ($employee) {
                            $area = $this->areas()->firstWhere('codigo', $employee['area']);

                            return "area_min|{$area['nome']}|{$employee['nome']} {$employee['sobrenome']}|" .
                                number_format($employee['salario'], 2, '.', '');
                        });
            })->toArray();
    }

    public function average(): array|float
    {
        return [];
    }

    public function highestsSalariesByArea(): mixed
    {
        return $this->bigger();
    }

    public function smallestsSalariesByArea(): mixed
    {
        return $this->smaller();
    }
}

