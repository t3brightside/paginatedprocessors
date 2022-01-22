<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Paginated Processors',
    'description' => 'Data processors with pagination',
    'category' => 'fe',
    'author' => 'Tanel Põld',
    'author_email' => 'tanel@brightside.ee',
    'author_company' => 'Brightside OÜ / t3brightside.com',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '1.3.3',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Brightside\\Paginatedprocessors\\' => 'Classes'
        ]
    ],
];
