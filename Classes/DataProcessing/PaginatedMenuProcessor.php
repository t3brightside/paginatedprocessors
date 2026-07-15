<?php

declare(strict_types=1);

namespace Brightside\Paginatedprocessors\DataProcessing;

use Brightside\Paginatedprocessors\Processing\DataToPaginatedData;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\DataProcessing\MenuProcessor;

final class PaginatedMenuProcessor implements DataProcessorInterface
{
    /**
     * @param ContentObjectRenderer $cObj
     * @param array<string, mixed> $contentObjectConfiguration
     * @param array<string, mixed> $processorConfiguration
     * @param array<string, mixed> $processedData
     * @return array<string, mixed>
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        // 1. Grab your pagination settings FIRST
        $paginationSettings = $processorConfiguration['pagination.'] ?? [];
        
        // 2. Clean the configuration array for the core processor
        $coreProcessorConfiguration = $processorConfiguration;
        
        unset($coreProcessorConfiguration['pagination.'], $coreProcessorConfiguration['pagination']);

        // 3. Instantiate the core MenuProcessor
        $menuProcessor = GeneralUtility::makeInstance(MenuProcessor::class);

        // 4. Let the core processor build the menu using the CLEANED configuration
        $allProcessedData = $menuProcessor->process(
            $cObj,
            $contentObjectConfiguration,
            $coreProcessorConfiguration,
            $processedData
        );
        
        // 5. Apply custom pagination logic to the built menu
        if ((int)$cObj->stdWrapValue('isActive', $paginationSettings) !== 0) {
            $paginatedData = new DataToPaginatedData();
            
            // Adding null-coalescing fallbacks for array keys prevents PHP 8.2 warnings 
            // if the user forgot to configure the 'as' property in TypoScript
            $asKey = $processorConfiguration['as'] ?? 'menu';
            
            $allProcessedData = $paginatedData->getPaginatedData(
                $cObj,
                $contentObjectConfiguration,
                $processorConfiguration, 
                $allProcessedData,
                $allProcessedData[$asKey] ?? [],
                $asKey
            );
        }

        return $allProcessedData;
    }
}