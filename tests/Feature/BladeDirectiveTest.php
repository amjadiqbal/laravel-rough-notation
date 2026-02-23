<?php

it('renders annotate directive with attributes', function () {
    $blade = "@annotate('circle', ['color' => 'red'])Hello@endannotate";
    $compiled = app('blade.compiler')->compileString($blade);
    ob_start();
    eval('?>' . $compiled);
    $output = ob_get_clean();
    expect($output)->toContain('data-rough-type="circle"');
    expect($output)->toContain('Hello');
});

it('outputs roughNotationScripts module', function () {
    $blade = "@roughNotationScripts";
    $compiled = app('blade.compiler')->compileString($blade);
    ob_start();
    eval('?>' . $compiled);
    $output = ob_get_clean();
    expect($output)->toContain('type="module"');
    expect($output)->toContain('annotationGroup');
});
