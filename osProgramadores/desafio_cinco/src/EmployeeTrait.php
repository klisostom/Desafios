<?php

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

    public function employees()
    {
        return collect($this->getEmployeesFromJson());
    }
}

