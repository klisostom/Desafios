<?php

use App\Employee;

trait Help
{
    protected function getEmployees()
    {
        return (new Employee())->getEmployees();
    }
}
