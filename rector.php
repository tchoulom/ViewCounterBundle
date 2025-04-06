<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
//        __DIR__ . '/assets',
//        __DIR__ . '/config',
//        __DIR__ . '/public',
        __DIR__ . '/src',
//        __DIR__ . '/src/Command',
        __DIR__ . '/Tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpVersion(Rector\ValueObject\PhpVersion::PHP_84)
    ->withRules([
//        Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector::class,
    ])
    ->withPhpSets(php84: true)
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
