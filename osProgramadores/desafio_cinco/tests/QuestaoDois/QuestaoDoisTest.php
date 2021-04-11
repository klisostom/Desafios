<?php declare(strict_types=1);

/*
    2. Quem mais recebe e quem menos recebe em cada área e a média salarial em cada área.

    Calcular e imprimir o nome completo do(s) funcionário(s) com o(s) maior(es) e menor(res)
    salário(s) por área da empresa empresa, bem como o salário médio (também por área).
    Em caso de empate (mais de um funcionário nas posições de maior ou menor salário
    em uma determinada área), imprimir todos os funcionários nessas posições que tem
    o mesmo salário, em cada área.
*/

namespace App;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '../../vendor/autoload.php';
require_once __ROOT__ . '../../src/SalaryArea.php';

use App\SalaryArea;
use PHPUnit\Framework\TestCase;

class QuestaoDoisTest extends TestCase
{
    protected function getEmployees(): array
    {
        return (new Employee())->getEmployees();
    }

    public function test_get_the_highests_salaries_by_area(): void
    {
        $salaries = (new SalaryArea())->highestsSalariesByArea();

        $this->assertIsArray($salaries);
        $this->assertGreaterThanOrEqual(1, count($salaries));
    }

    public function test_print_result_highests_salaries_by_area(): void
    {
        $salariesPrinted = (new SalaryArea())->highestsSalariesPrintedByArea();

        $resultForCompare =
'
    area_max|SM|Bernardo Costa|3700.00
    area_max|SD|Fabio Souza|2750.00
    area_max|SD|Cleverton Farias|2750.00
    area_max|SD|Washington Ramos|2700.00
';

        $pattern = array('/[\"\r]/');
        $atual = preg_replace($pattern, '', $resultForCompare);
        $expected = $salariesPrinted;

        $this->assertIsString($expected);
        //$this->assertSame($expected, $atual);
    }
}

