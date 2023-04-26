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
    'version' => '1.5.1',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
            'embedassets' => '1.2.0-1.99.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Brightside\\Paginatedprocessors\\' => 'Classes'
        ]
    ],
];
