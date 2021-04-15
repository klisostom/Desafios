<?php declare(strict_types=1);

namespace App;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '../../vendor/autoload.php';
require_once __ROOT__ . '../../src/SalaryArea.php';
require_once __ROOT__ . '../Help.php';

use Help;
use App\SalaryArea;
use PHPUnit\Framework\TestCase;

class QuestaoDoisTest extends TestCase
{
    use Help;

    protected SalaryArea $salary;

    protected function setUp(): void
    {
        $this->salary = new SalaryArea();
    }

    public function test_get_the_highests_salaries_by_area(): void
    {
        $salaries = $this->salary->highestsSalariesByArea();

        $this->assertIsArray($salaries);
        $this->assertGreaterThanOrEqual(1, count($salaries));
    }

    public function test_result_highests_salaries_by_area(): void
    {
        $salariesPrinted = $this->salary->highestsSalariesByArea();

        $salariesPrinted = collect($salariesPrinted)->flatten(1);

        $this->assertContains('area_max|Gerenciamento de Software|Bernardo Costa|3700.00', $salariesPrinted);
        $this->assertContains('area_max|Designer de UI/UX|Washington Ramos|2700.00', $salariesPrinted);
        $this->assertContains('area_max|Desenvolvimento de Software|Cleverton Farias|2750.00', $salariesPrinted);
        $this->assertContains('area_max|Desenvolvimento de Software|Fabio Souza|2750.00', $salariesPrinted);
    }

    public function test_result_smallers_salaries_by_area(): void
    {
        $salariesPrinted = $this->salary->smallestsSalariesByArea();

        $salariesPrinted = collect($salariesPrinted)->flatten(1);

        $this->assertContains('area_min|Gerenciamento de Software|Marcelo Silva|3200.00', $salariesPrinted);
        $this->assertContains('area_min|Designer de UI/UX|Letícia Farias|2450.00', $salariesPrinted);
        $this->assertContains('area_min|Desenvolvimento de Software|Sergio Pinheiro|2450.00', $salariesPrinted);
        $this->assertContains('area_min|Desenvolvimento de Software|Fernando Ramos|2450.00', $salariesPrinted);
    }

    public function test_result_average_by_area(): void
    {
        $average = $this->salary->average();

        $this->assertContains(
            'area_avg|Gerenciamento de Software|3450.00',
            $average
        );

        $this->assertContains(
            'area_avg|Designer de UI/UX|2566.67',
            $average
        );

        $this->assertContains(
            'area_avg|Desenvolvimento de Software|2575.00',
            $average
        );
    }

    public function test_print_result(): void
    {
        $atual = $this->salary->test_print_questao_dois();

        $result =
'
    area_max|Gerenciamento de Software|Bernardo Costa|3700.00
    area_max|Designer de UI\/UX|Washington Ramos|2700.00
    area_max|Desenvolvimento de Software|Cleverton Farias|2750.00
    area_max|Desenvolvimento de Software|Fabio Souza|2750.00
    area_min|Gerenciamento de Software|Marcelo Silva|3200.00
    area_min|Designer de UI\/UX|Let\u00edcia Farias|2450.00
    area_min|Desenvolvimento de Software|Sergio Pinheiro|2450.00
    area_min|Desenvolvimento de Software|Fernando Ramos|2450.00
    area_avg|Gerenciamento de Software|3450.00
    area_avg|Designer de UI\/UX|2566.67
    area_avg|Desenvolvimento de Software|2575.00
';

        $pattern = array('/[\"\r]/');
        $expected = preg_replace($pattern, '', $result);

        $this->assertIsString($atual);
        $this->assertSame($expected, $atual);
    }

    // ===============================================

    protected function tearDown(): void
    {
        unset($this->salary);
    }

}

