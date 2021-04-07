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

    public function bigger(): float
    {
        return $this->employees()
            ->map(fn($item) => $item['salario'])
            ->max();
    }

    public function smaller(): float
    {
        return $this->employees()
            ->map(fn($item) => $item['salario'])
            ->min();
    }

    public function smallerTest()
    {
        return $this->employees()
            ->groupBy('salario')
            ->map(fn ($item) => $item->pluck('salario')->min());
    }

    public function avgSalary(): float
    {
        $result = $this->employees()->avg('salario');
        return number_format($result, 2, '.', '');
    }
}
