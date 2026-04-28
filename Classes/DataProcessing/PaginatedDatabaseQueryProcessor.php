<?php

namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface; // Fixed!
use TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Brightside\Paginatedprocessors\Processing\DataToPaginatedData;

// 1. Implement the interface instead of extending the core class. 
class PaginatedDatabaseQueryProcessor implements DataProcessorInterface
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        // 2. Instantiate the core DatabaseQueryProcessor manually
        $databaseProcessor = GeneralUtility::makeInstance(DatabaseQueryProcessor::class);

        // 3. Let the core processor do the heavy lifting first
        $allProcessedData = $databaseProcessor->process(
            $cObj, 
            $contentObjectConfiguration, 
            $processorConfiguration, 
            $processedData
        );

        // Get pagination settings from TypoScript (added null coalescing for safety)
        $paginationSettings = $processorConfiguration['pagination.'] ?? [];

        // 4. Run your custom pagination logic on the result
        if ((int)($cObj->stdWrapValue('isActive', $paginationSettings))) {
            $paginatedData = new DataToPaginatedData();
            $allProcessedData = $paginatedData->getPaginatedData(
                $cObj,
                $contentObjectConfiguration,
                $processorConfiguration,
                $allProcessedData,
                $allProcessedData[$processorConfiguration['as']],  // Data to paginate
                $processorConfiguration['as'] // Array key for the paginated data
            );
        }
        
        return $allProcessedData;
    }
}