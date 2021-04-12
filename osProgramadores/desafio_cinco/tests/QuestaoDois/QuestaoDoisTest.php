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

    public function test_result_highests_salaries_by_area(): void
    {
        $salariesPrinted = (new SalaryArea())->highestsSalariesByArea();

        $salariesPrinted = collect($salariesPrinted)->flatten(1);

        $this->assertContains('area_max|Gerenciamento de Software|Bernardo Costa|3700.00', $salariesPrinted);
        $this->assertContains('area_max|Designer de UI/UX|Washington Ramos|2700.00', $salariesPrinted);
        $this->assertContains('area_max|Desenvolvimento de Software|Cleverton Farias|2750.00', $salariesPrinted);
        $this->assertContains('area_max|Desenvolvimento de Software|Fabio Souza|2750.00', $salariesPrinted);
    }

    public function test_result_smallers_salaries_by_area(): void
    {
        $salariesPrinted = (new SalaryArea())->smallestsSalariesByArea();

        $salariesPrinted = collect($salariesPrinted)->flatten(1);

        $this->assertContains('area_min|Gerenciamento de Software|Marcelo Silva|3200.00', $salariesPrinted);
        $this->assertContains('area_min|Designer de UI/UX|Letícia Farias|2450.00', $salariesPrinted);
        $this->assertContains('area_min|Desenvolvimento de Software|Sergio Pinheiro|2450.00', $salariesPrinted);
        $this->assertContains('area_min|Desenvolvimento de Software|Fernando Ramos|2450.00', $salariesPrinted);
    }
}

