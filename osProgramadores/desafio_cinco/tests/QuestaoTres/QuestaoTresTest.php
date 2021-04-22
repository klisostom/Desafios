<?php declare(strict_types=1);

namespace App;

use Help;
use App\SalaryArea;
use PHPUnit\Framework\TestCase;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '../../vendor/autoload.php';
require_once __ROOT__ . '../Help.php';
require_once __ROOT__ . '../../src/SalaryArea.php';

class QuestaoTresTest extends TestCase
{
    use Help;

    protected function setUp(): void
    {
        $this->salary = new SalaryArea();
    }

    public function test_least_employees_by_area(): void
    {
        $numEmployees = $salaries = $this->salary->print_questao_tres();

        $this->assertIsString($numEmployees);
    }
}

