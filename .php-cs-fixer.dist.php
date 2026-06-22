<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->ignoreVCSIgnored(true)
    ->notName('bundles.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS'                                => true,
        'binary_operator_spaces'                 => [
            'operators' => [
                '=>'  => 'align',
                '='   => 'align',
                '+='  => 'align',
                '-='  => 'align',
                '*='  => 'align',
                '/='  => 'align',
                '%='  => 'align',
                '.='  => 'align',
                '&='  => 'align',
                '|='  => 'align',
                '^='  => 'align',
                '<<=' => 'align',
                '>>=' => 'align',
            ],
        ],
        'phpdoc_align'                           => true,
        'concat_space'                           => [
            'spacing' => 'one',
        ],
        'array_syntax'                           => [
            'syntax' => 'short',
        ],
        'no_unused_imports'                      => true,
        'no_trailing_whitespace'                 => true,
        'braces'                                 => false,
        'simplified_null_return'                 => false,
        'short_scalar_cast'                      => true,
        'phpdoc_scalar'                          => true,
        'no_leading_import_slash'                => false,
        'phpdoc_summary'                         => false,
        'phpdoc_separation'                      => false,
        'no_blank_lines_after_phpdoc'            => true,
        'no_blank_lines_after_class_opening'     => true,
        'no_whitespace_in_blank_line'            => true,
        'no_whitespace_before_comma_in_array'    => true,
        'no_trailing_comma_in_singleline_array'  => true,
        'no_leading_namespace_whitespace'        => true,
        'no_empty_comment'                       => true,
        'no_empty_statement'                     => true,
        'declare_equal_normalize'                => true,
        'blank_line_before_statement'            => true,
        'unary_operator_spaces'                  => true,
        'ordered_imports'                        => false,
        'phpdoc_add_missing_param_annotation'    => ['only_untyped' => true],
        'class_definition'                       => [
            'multi_line_extends_each_single_line' => true,
        ],
        'linebreak_after_opening_tag'            => true,
        'declare_strict_types'                   => false,
        'method_argument_space'                  => ['on_multiline' => 'ensure_fully_multiline'],
        'native_constant_invocation'             => false,
        'native_function_casing'                 => false,
        'no_php4_constructor'                    => true,
        'no_unreachable_default_argument_value'  => true,
        'no_useless_else'                        => true,
        'no_useless_return'                      => true,
        'php_unit_strict'                        => true,
        'semicolon_after_instruction'            => true,
        'strict_comparison'                      => false,
        'visibility_required'                    => ['elements' => ['property', 'method', 'const']],
        'phpdoc_to_comment'                      => [
            'ignored_tags' => ['todo', 'var'],
        ],
        'trailing_comma_in_multiline'            => ['elements' => ['arrays', 'arguments', 'parameters']],
        'global_namespace_import'                => ['import_classes' => false, 'import_constants' => false, 'import_functions' => false],
    ])
    ->setFinder($finder);
