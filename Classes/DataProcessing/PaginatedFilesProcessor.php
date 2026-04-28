<?php
namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\DataProcessing\FilesProcessor;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Brightside\Paginatedprocessors\Processing\DataToPaginatedData;

class PaginatedFilesProcessor implements DataProcessorInterface
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        // 1. Instantiate the core FilesProcessor manually
        $filesProcessor = GeneralUtility::makeInstance(FilesProcessor::class);

        // 2. Let the core processor fetch and process the files first
        $allProcessedData = $filesProcessor->process(
            $cObj, 
            $contentObjectConfiguration, 
            $processorConfiguration, 
            $processedData
        );

        // Get pagination settings safely
        $paginationSettings = $processorConfiguration['pagination.'] ?? [];

        // 3. Apply your custom pagination logic
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