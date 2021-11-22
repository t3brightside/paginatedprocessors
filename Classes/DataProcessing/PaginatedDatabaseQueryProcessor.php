<?php
namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor;
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
        $paginationSettings = $processorConfiguration['pagination.'];
        if ((int)($cObj->stdWrapValue('isActive', $paginationSettings ?? []))) {
          $paginatedData = new DataToPaginatedData();
          $allProcessedData = $paginatedData->getPaginateData($cObj,$contentObjectConfiguration,$processorConfiguration,$allProcessedData,$allProcessedData[$processorConfiguration['as']],$processorConfiguration['as']);
          return $allProcessedData;
        } else {
          return $allProcessedData;
        }
    }
}
