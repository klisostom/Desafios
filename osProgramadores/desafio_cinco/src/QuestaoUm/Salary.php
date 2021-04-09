<?php

namespace App;

class Salary
{
    public function __construct(protected array $employees)
    {
        #
    }

    protected function employees()
    {
        return collect($this->employees);
    }

    protected function calculateSalary()
    {
        return $this->employees()
            ->map(function ($employee) {
                return array_merge(
                    ['nome' => $employee['nome']],
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

    public function avgSalary(): float
    {
        $result = $this->employees()->avg('salario');
        return number_format($result, 2, '.', '');
    }

    public function print_result(): string
    {
        # code...
    }
}
