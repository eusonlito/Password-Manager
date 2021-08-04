<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules(['native_constant_invocation' => true, 'native_function_invocation' => true])
    ->setFinder(Finder::create()->exclude(['guzzlehttp', 'phpunit', 'php-parallel-lint', 'tests'])->in('vendor'));
