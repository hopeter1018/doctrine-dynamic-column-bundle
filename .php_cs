<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('var')
    ->exclude('vendor')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'ordered_class_elements' => true,
        'no_short_echo_tag' => true,
    ])
    ->setFinder($finder)
;
