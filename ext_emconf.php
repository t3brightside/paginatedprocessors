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
    'version' => '1.7.3',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-14.9.99',
            'embedassets' => '1.3.0-1.99.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Brightside\\Paginatedprocessors\\' => 'Classes'
        ]
    ],
];
