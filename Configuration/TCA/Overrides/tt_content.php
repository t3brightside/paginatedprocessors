<?php

defined('TYPO3_MODE') || die('Access denied.');

$tempColumnsPaginatedprocessors = array(
    'tx_paginatedprocessors_paginationenabled' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:paginatedprocessors/Resources/Private/Language/locallang_tca.xlf:tx_paginatedprocessors_paginationenabled',
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
        'label' => 'LLL:EXT:paginatedprocessors/Resources/Private/Language/locallang_tca.xlf:tx_paginatedprocessors_itemsperpage',
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
        'label' => 'LLL:EXT:paginatedprocessors/Resources/Private/Language/locallang_tca.xlf:tx_paginatedprocessors_pagelinksshown',
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
        'label' => 'LLL:EXT:paginatedprocessors/Resources/Private/Language/locallang_tca.xlf:tx_paginatedprocessors_urlsegment',
        'config' => [
            'type' => 'input',
            'eval' => 'uniqueInPid,nospace,lower,trim',
            'size' => '1',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
    'tx_paginatedprocessors_anchor' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:paginatedprocessors/Resources/Private/Language/locallang_tca.xlf:tx_paginatedprocessors_anchor',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 0,
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
    'tx_paginatedprocessors_anchorid' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:paginatedprocessors/Resources/Private/Language/locallang_tca.xlf:tx_paginatedprocessors_anchorid',
        'config' => [
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tt_content',
            'default' => 0,
            'size' => 1,
            'autoSizeMax' => 1,
            'maxitems' => 1,
            'multiple' => 0,
        ],
    ],
);

// Use in your custom content element '--palette--;Pagination;paginatedprocessors,'
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumnsPaginatedprocessors);
$GLOBALS['TCA']['tt_content']['palettes']['paginatedprocessors']['showitem'] = '
    tx_paginatedprocessors_paginationenabled,
    tx_paginatedprocessors_itemsperpage,
    tx_paginatedprocessors_pagelinksshown,
    tx_paginatedprocessors_urlsegment,
    --linebreak--,
    tx_paginatedprocessors_anchor,
    tx_paginatedprocessors_anchorid,
';
