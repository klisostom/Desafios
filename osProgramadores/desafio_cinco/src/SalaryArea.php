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
                return $this->groupingBySalaries($area);
            })->toArray();
    }

    protected function groupingBySalaries($area)
    {
        return $area->groupBy('salario')
            ->sortKeysDesc()
            ->last()
            ->pipe(function ($collection) {
                return $this->printSmallers($collection);
            });
    }

    protected function printSmallers($groupedBySalaries)
    {
        return $groupedBySalaries->map(function ($employee) {
            $area = $this->areas()->firstWhere('codigo', $employee['area']);

            return "area_min|{$area['nome']}|{$employee['nome']} {$employee['sobrenome']}|" .
                number_format($employee['salario'], 2, '.', '');
        });
    }

    public function average(): array|float
    {
        return $this->calculateSalary($this->employees)
            ->groupBy('area')
            ->map(function ($area, $key) {
                $salaryAverage = $area->avg('salario');
                $area = $this->areas()->firstWhere('codigo', $key);

                return "area_avg|{$area['nome']}|" .
                    number_format($salaryAverage, 2, '.', '');

            })->toArray();
    }

    public function highestsSalariesByArea(): mixed
    {
        return $this->bigger();
    }

    public function smallestsSalariesByArea(): mixed
    {
        return $this->smaller();
    }

    public function print_questao_dois(): string
    {
        $result = [];

        array_push($result, $this->bigger());
        array_push($result, $this->smaller());
        array_push($result, $this->average());

        $result = collect($result)->flatten()->toJson(JSON_PRETTY_PRINT);

        return preg_replace(array('/[\"\r\[\],]/'), '', $result);
    }

    public function resultLeastByArea(): mixed
    {
        return $this->employees()
            ->groupBy('area')
            ->map(function ($collection) {
                return $collection->count();
            });
    }

    protected function countEmployeesByArea($result)
    {
        return array_diff_assoc($result->all(), array_unique($result->all()));
    }

    public function print_questao_tres()
    {
        $result = $this->resultLeastByArea();

        $isRepeated = $this->countEmployeesByArea($result);

        if (!empty($isRepeated))
        {
            return collect(array_values($isRepeated))
                ->map(function ($item) use ($result) {
                    return $result->filter(function ($x) use ($item) {
                        return $x == $item;
                    });
                })->flatMap(function ($collection) {
                    return $collection->map(function ($count, $key) {
                        $area = $this->areas()->firstWhere('codigo', $key);

                        return "least_employees|{$area['nome']}|" . $count;
                    });
                })->flatten()->toJson(JSON_PRETTY_PRINT);
        }

        $keys = array_keys($result->sort()->toArray());
        $key = $keys[0];
        $value = $result[$key];

        $area = $this->areas()->firstWhere('codigo', $key);
        return "least_employees|{$area['nome']}|" . $value;
    }
}

