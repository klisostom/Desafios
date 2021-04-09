<?php declare(strict_types=1);

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
            ["salario" => 3200.00, "nome" => "Marcelo"],
            ["salario" => 1240.00, "nome" => "Ciclano"],
            ["salario" => 1000.00, "nome" => "Beltano"],
        ];
    }

    public function test_get_employees(): void
    {
        $employees = $this->getEmployees();

        $this->assertIsArray($employees);
        $this->assertNotEmpty($employees);
    }

    public function test_get_the_highest_salary(): void
    {
        $employees = $this->getEmployeesFactory();

        $salary = new Salary($employees);
        $biggersSalaries = $salary->bigger();

        $this->assertIsArray($biggersSalaries);
        $this->assertGreaterThanOrEqual(1, count($biggersSalaries));
    }

    public function test_get_smaller_salary(): void
    {
        $employees = $this->getEmployeesFactory();

        $salary = new Salary($employees);
        $smallersSalaries = $salary->smaller();

        $this->assertIsArray($smallersSalaries);
        $this->assertGreaterThanOrEqual(1, count($smallersSalaries));
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
        # code...
    }
}
