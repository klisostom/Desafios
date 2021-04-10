<?php

namespace App;

class Salary implements SalaryInterface
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

    public function average(): float
    {
        $result = $this->employees()->avg('salario');
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
        ->map(function ($employees) {
            return "global_max|{$employees['nome']}|" . number_format($employees['salario'], 2, '.', '');
        });
    }

    private function printSmallers()
    {
        return function ($biggers) {
            $smallers = collect($this->smaller())
                ->map(function ($employees) {
                    return "global_min|{$employees['nome']}|" . number_format($employees['salario'], 2, '.', '');
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
