<?php
namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\DataProcessing\MenuProcessor;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Brightside\Paginatedprocessors\Processing\DataToPaginatedData;

class PaginatedMenuProcessor implements DataProcessorInterface
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        // 1. Instantiate the core MenuProcessor manually
        $menuProcessor = GeneralUtility::makeInstance(MenuProcessor::class);

        // 2. Let the core processor build the menu. 
        // It will safely ignore your custom "pagination." key.
        $allProcessedData = $menuProcessor->process(
            $cObj,
            $contentObjectConfiguration,
            $processorConfiguration,
            $processedData
        );
        
        // 3. Grab your pagination settings safely
        $paginationSettings = $processorConfiguration['pagination.'] ?? [];
        
        // 4. Apply your custom pagination logic to the built menu
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
        }

        return $allProcessedData;
    }
}