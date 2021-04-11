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

    protected function calculateSalary()
    {
        return $this->employees
            ->map(function ($employee) {
                return array_merge(
                    ['nome' => $employee['nome']],
                    ['sobrenome' => $employee['sobrenome']],
                    ['salario' => $employee['salario']]
                );
            })
            ->groupBy('salario')
            ->sortKeysDesc();
    }

    public function bigger(): array
    {
        return $this->calculateSalary()
            ->first()
            ->all();
    }

    public function smaller(): array
    {
        return $this->calculateSalary()
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
