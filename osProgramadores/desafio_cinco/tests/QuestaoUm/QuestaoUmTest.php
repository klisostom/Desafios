<?php declare(strict_types=1);

namespace App;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '../../vendor/autoload.php';

require_once __ROOT__ . '../../src/Employee.php';
require_once __ROOT__ . '../../src/Salary.php';

use PHPUnit\Framework\TestCase;

class QuestaoUmTest extends TestCase
{
    protected function getEmployees()
    {
        return (new Employee())->getEmployees();
    }

    protected function getEmployeesFactory(): array
    {
        return [
            ["salario" => 3200.00, "nome" => "Marcelo", "sobrenome" => "Fresno", "area" => "UT"],
            ["salario" => 1240.00, "nome" => "Ciclano", "sobrenome" => "Arrocha", "area" => "JK"],
            ["salario" => 1000.00, "nome" => "Beltano", "sobrenome" => "Cisco", "area" => "MV"],
            ["salario" => 1000.00, "nome" => "Chico", "sobrenome" => "Tripa", "area" => "MV"],
        ];
    }

    public function test_get_employees(): void
    {
        $employees = $this->getEmployees()->toArray();

        $this->assertIsArray($employees);
        $this->assertNotEmpty($employees);
    }

    public function test_print_result(): void
    {
        $employees = $this->getEmployeesFactory();
        $salary = new Salary($employees);

$result =
'
    global_max|Marcelo Fresno|3200.00
    global_min|Beltano Cisco|1000.00
    global_min|Chico Tripa|1000.00
    global_avg|1610.00
';
        $pattern = array('/[\"\r]/');
        $expected = preg_replace($pattern, '', $result);
        $atual = $salary->print_questao_um();

        $this->assertIsString($atual);
        $this->assertSame($expected, $atual);
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
            1610.00,
            $salary->average(),
            'Média salarial deveria ser 1766.66'
        );
    }
}
