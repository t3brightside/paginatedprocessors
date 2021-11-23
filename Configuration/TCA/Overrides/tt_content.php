<?php

defined('TYPO3_MODE') || die('Access denied.');

$tempColumnsPaginatedprocessors = array(
    'tx_paginatedprocessors_paginationenabled' => [
        'exclude' => 1,
        'label' => 'Enabled',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => '',
                    1 => '',
                ]
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
    'tx_paginatedprocessors_itemsperpage' => [
        'exclude' => 1,
        'label' => 'Items per page',
        'config' => [
            'type' => 'input',
            'eval' => 'num',
            'size' => '1',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
    'tx_paginatedprocessors_pagelinksshown' => [
        'exclude' => 1,
        'label' => 'Number of links',
        'config' => [
            'type' => 'input',
            'eval' => 'num',
            'size' => '1',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
    'tx_paginatedprocessors_urlsegment' => [
        'exclude' => 1,
        'label' => 'URL Segment',
        'config' => [
            'type' => 'input',
            'eval' => 'uniqueInPid,nospace,lower,trim',
            'size' => '1',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ]
);

// Use in your custom content element '--palette--;Pagination;paginatedprocessors,'
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumnsPaginatedprocessors);
$GLOBALS['TCA']['tt_content']['palettes']['paginatedprocessors']['showitem'] = '
    tx_paginatedprocessors_paginationenabled,
    tx_paginatedprocessors_itemsperpage,
    tx_paginatedprocessors_pagelinksshown,
    tx_paginatedprocessors_urlsegment,
';
