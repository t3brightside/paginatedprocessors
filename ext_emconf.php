<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Paginated Processors',
    'description' => 'Paginated data processors',
    'category' => 'fe',
    'author' => 'Tanel Põld',
    'author_email' => 'tanel@brightside.ee',
    'author_company' => 'Brightside OÜ / t3brightside.com',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '1.2.0',
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
