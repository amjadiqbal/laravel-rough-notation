<?php

use AmjadIqbal\RoughNotation\NotationManager;

it('parses options to JSON', function () {
    $manager = new NotationManager();
    $json = $manager->toJsonOptions(['color' => 'red', 'strokeWidth' => 3, 'unknown' => 'x'], 'circle');
    expect($json)->toBe('{"color":"red","strokeWidth":3}');
});

it('normalizes bracket options', function () {
    $manager = new NotationManager();
    $json = $manager->toJsonOptions(['brackets' => 'left'], 'bracket');
    expect($json)->toBe('{"brackets":["left"]}');
});

it('builds opening tag with attributes', function () {
    $manager = new NotationManager();
    $html = $manager->openTag('circle', ['color' => 'red'], null, 'span');
    expect($html)->toContain('data-rough-type="circle"');
    expect($html)->toContain('data-rough-options=\'{"color":"red"}\'');
});
