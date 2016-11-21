<?php

$phpCSConfig = function () {
    $output = [];

    #exec('git diff dev..HEAD --name-status --diff-filter=ACM', $output);
    exec('git diff --cached --name-status --diff-filter=ACM', $output);

    $files = array_filter(
        array_map(function ($str) {
            return new SplFileInfo(trim(substr($str, 1)));
        }, $output), function (SplFileInfo $file) {
        return $file->getExtension() == 'php';
    }
    );

    $fixers = [
        '-psr0',
        '-concat_without_spaces',
        '-phpdoc_inline_tag',
        '-phpdoc_no_empty_return',
        '-phpdoc_to_comment',
        '-phpdoc_params',
        '-phpdoc_var_without_name',
        '-multiline_array_trailing_comma'
    ];

    return Symfony\CS\Config::create()
        ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
        ->fixers($fixers)
        ->finder(new ArrayIterator($files));
};

return $phpCSConfig();
