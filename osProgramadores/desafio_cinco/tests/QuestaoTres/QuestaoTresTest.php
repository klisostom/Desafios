<?php declare(strict_types=1);

namespace App;

use Help;
use PHPUnit\Framework\TestCase;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '../Help.php';

class QuestaoTresTest extends TestCase
{
    use Help;

    public function test_test(): void
    {
        $this->assertTrue(true);
    }
}

