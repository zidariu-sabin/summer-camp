<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
$faker=Faker\Factory::create();
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
