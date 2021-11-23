<?php

namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor;

// Use DataToPaginatedData class
use Brightside\Paginatedprocessors\Processing\DataToPaginatedData;

class PaginatedDatabaseQueryProcessor extends DatabaseQueryProcessor
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $allProcessedData = parent::process($cObj, $contentObjectConfiguration, $processorConfiguration, $processedData);

        // Get pagination settings from TypoScript
        $paginationSettings = $processorConfiguration['pagination.'];

        // If pagination activated
        if ((int)($cObj->stdWrapValue('isActive', $paginationSettings ?? []))) {
            $paginatedData = new DataToPaginatedData();
            $allProcessedData = $paginatedData->getPaginatedData(
                $cObj,
                $contentObjectConfiguration,
                $processorConfiguration,
                $allProcessedData,
                $allProcessedData[$processorConfiguration['as']],  // Data to paginate
                $processorConfiguration['as'] // Array key for the paginated data
            );
            return $allProcessedData;
        } else {
            return $allProcessedData;
        }
    }
}
