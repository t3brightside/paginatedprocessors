<?php
namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\MenuProcessor;
use Brightside\Paginatedprocessors\Processing\DataToPaginatedData;

class PaginatedMenuProcessor extends MenuProcessor
{
    /**
     * This method overrides the parent and injects your custom keys.
     * By doing it here instead of a class property, we avoid the 
     * Fatal Error: "Type must be array (as in class MenuProcessor)"
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        // We manually define the keys here to ensure compatibility across TYPO3 versions
        $this->allowedConfigurationKeys = [
            'cache_period',
            'entryLevel',
            'entryLevel.',
            'special',
            'special.',
            'minItems',
            'minItems.',
            'maxItems',
            'maxItems.',
            'begin',
            'begin.',
            'alternativeSortingField',
            'alternativeSortingField.',
            'showAccessRestrictedPages',
            'showAccessRestrictedPages.',
            'excludeUidList',
            'excludeUidList.',
            'excludeDoktypes',
            'includeNotInMenu',
            'includeNotInMenu.',
            'alwaysActivePIDlist',
            'alwaysActivePIDlist.',
            'protectLvar',
            'addQueryString',
            'addQueryString.',
            'if',
            'if.',
            'levels',
            'levels.',
            'expandAll',
            'expandAll.',
            'includeSpacer',
            'includeSpacer.',
            'as',
            'titleField',
            'titleField.',
            'dataProcessing',
            'dataProcessing.',
            'pagination.', // Your custom key
        ];

        $allProcessedData = parent::process($cObj, $contentObjectConfiguration, $processorConfiguration, $processedData);
        
        $paginationSettings = $processorConfiguration['pagination.'] ?? [];
        
        if ((int)($cObj->stdWrapValue('isActive', $paginationSettings))) {
            $paginatedData = new DataToPaginatedData();
            $allProcessedData = $paginatedData->getPaginatedData(
                $cObj,
                $contentObjectConfiguration,
                $processorConfiguration,
                $allProcessedData,
                $allProcessedData[$processorConfiguration['as']],
                $processorConfiguration['as']
            );
            return $allProcessedData;
        }

        return $allProcessedData;
    }
}