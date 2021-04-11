<?php

namespace App;

require_once('SalaryInterface.php');
require_once('EmployeeTrait.php');

use EmployeeTrait;
use App\SalaryInterface;

class Salary implements SalaryInterface
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
            ->groupBy('salario')
            ->sortKeysDesc()
            ->first()
            ->all();
    }

    public function smaller(): array
    {
        return $this->calculateSalary($this->employees)
            ->groupBy('salario')
            ->sortKeysDesc()
            ->last()
            ->all();
    }

    public function average(): float
    {
        $result = $this->employees->avg('salario');
        return number_format($result, 2, '.', '');
    }

    public function print_questao_um()
    {
        $result = $this->printBiggers()
            ->pipe($this->printSmallers())
            ->pipe($this->printAvg())
            ->toJson(JSON_PRETTY_PRINT);

        return preg_replace(array('/[\"\r\[\],]/'), '', $result);
    }

    private function printBiggers()
    {
        return collect($this->bigger())
            ->map(function ($employee) {
                return "global_max|{$employee['nome']} {$employee['sobrenome']}|" .
                    number_format($employee['salario'], 2, '.', '');
            });
    }

    private function printSmallers()
    {
        return function ($biggers) {
            $smallers = collect($this->smaller())
                ->map(function ($employee) {
                    return "global_min|{$employee['nome']} {$employee['sobrenome']}|" .
                        number_format($employee['salario'], 2, '.', '');
                });

            return collect(array_merge($biggers->toArray(), $smallers->toArray()));
        };
    }

    private function printAvg()
    {
        return function ($collection) {
            $avg = "global_avg|" . number_format($this->average(), 2, '.', '');
            return collect(array_merge($collection->toArray(), [$avg]));
        };
    }
}
