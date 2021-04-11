<?php

namespace App;

require_once('EmployeeTrait.php');

use EmployeeTrait;

class Employee
{
    use EmployeeTrait;

    public function getEmployees()
    {
        return $this->employees();
    }
}
