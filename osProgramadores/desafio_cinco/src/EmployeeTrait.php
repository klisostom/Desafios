<?php

use Illuminate\Support\Collection;

/**
 * Get employees
 */
trait EmployeeTrait
{
    protected function getEmployeesFromJson(): array
    {
        $pathJson = __ROOT__ . "../../funcionarios.json";
        return json_decode(file_get_contents($pathJson), true);
    }

    public function employees(): Collection
    {
        return collect($this->getEmployeesFromJson()['funcionarios']);
    }

    public function calculateSalary(Collection $employees): Collection
    {
        return $employees
            ->map(function ($employee) {
                return array_merge(
                    ['nome' => $employee['nome']],
                    ['sobrenome' => $employee['sobrenome']],
                    ['salario' => $employee['salario']],
                    ['area' => $employee['area']],
                );
            });
    }
}

