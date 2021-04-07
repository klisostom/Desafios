<?php

namespace App;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '../../vendor/autoload.php';

require_once __ROOT__ . '../../src/QuestaoUm/Employee.php';
require_once __ROOT__ . '../../src/QuestaoUm/Salary.php';

use PHPUnit\Framework\TestCase;

class QuestaoUmTest extends TestCase
{
    protected function getEmployees(): array
    {
        $employee = new Employee();

        return $employee->getEmployees();
    }

    protected function getEmployeesFactory(): array
    {
        return [
            ["salario" => 3200.00],
            ["salario" => 1240.00],
            ["salario" => 1000.00],
        ];
    }

    public function test_get_employees(): void
    {
        $employees = $this->getEmployees();

        $this->assertIsArray($employees);
        $this->assertNotEmpty($employees);
    }

    public function test_highest_salary_is_float(): void
    {
        $employees = $this->getEmployees();

        $salary = new Salary($employees);

        $this->assertIsFloat($salary->bigger());
    }

    public function test_get_the_highest_salary(): void
    {
        $employees = $this->getEmployeesFactory();

        $salary = new Salary($employees);

        $this->assertEquals(
            3200.00,
            $salary->bigger(),
            'Maior salário deveria ser 3200.00'
        );
    }

    public function test_get_smaller_salary(): void
    {
        $employees = $this->getEmployeesFactory();

        $salary = new Salary($employees);

        $this->assertEquals(
            1000.00,
            $salary->smaller(),
            'Menor salário deveria ser 1000.00'
        );
    }

    public function test_get_the_avg_salary(): void
    {
        $employees = $this->getEmployeesFactory();

        $salary = new Salary($employees);

        $this->assertEquals(
            1813.33,
            $salary->avgSalary(),
            'Média salarial deveria ser 1766.66'
        );
    }

    public function test_print_result(): void
    {
        $salary = new Salary($this->getEmployees());

        dump($salary->smallerTest());
    }
}
