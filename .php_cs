<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

if (!\file_exists(__DIR__ . '/var')) {
    \mkdir(__DIR__ . '/var');
}

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__.'/var/.php_cs.cache')
    ->setRules([
        '@PSR2' => true,
        'psr4' => true,
        'strict_param' => true,
        'ordered_imports' => true,
        'blank_line_before_statement' => true,
        'trailing_comma_in_multiline_array' => true,
        'return_type_declaration' => ['space_before' => 'one'],
        'class_attributes_separation' => ['elements' => ['const', 'property', 'method']],
        'no_unused_imports' => true,
        'declare_strict_types' => true,
        'blank_line_after_opening_tag' => true
    ])
    ->setFinder($finder);