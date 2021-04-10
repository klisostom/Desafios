<?php

namespace App;

class Employee
{
    public function __construct(
    ) { }

    protected function getEmployeesFromJson(): array
    {
        $pathJson = __ROOT__ . "../../funcionarios.json";
        return json_decode(file_get_contents($pathJson), true);
    }

    public function getEmployees()
    {
        $employees = $this->getEmployeesFromJson();
        return collect($employees['funcionarios'])->all();
    }
}
