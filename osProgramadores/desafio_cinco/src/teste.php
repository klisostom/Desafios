<?php

namespace App;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/vendor/autoload.php');




//========================
$names = collect(['Adam', 'Bryan', 'Jane', 'Dan', 'Kayla']);
$r = $names->groupBy(function ($name) {
    return strlen($name);
});
dump($r->toArray());
