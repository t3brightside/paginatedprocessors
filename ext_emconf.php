<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Paginated Processors',
    'description' => 'Paginated data processors',
    'category' => 'fe',
    'author' => 'Tanel Põld',
    'author_email' => 'tanel@brightside.ee',
    'state' => 'alpha',
    'clearCacheOnLoad' => true,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'classmap' => ['Classes'],
    ],
];
