<?php
declare(strict_types = 1);

namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use TYPO3\CMS\Frontend\DataProcessing\FilesProcessor;

use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

/**
 * Adds pagination API to the DatabaseQueryProcessor
 */

class PaginatedFilesProcessor extends FilesProcessor
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $allProcessedData = parent::process($cObj, $contentObjectConfiguration, $processorConfiguration, $processedData);
        $paginationSettings = $processorConfiguration['pagination.'];
        $paginationIsActive = (int)($cObj->stdWrapValue('isActive', $paginationSettings ?? []));
        $paginationElementIdKey = (int)$cObj->getRequest()->getQueryParams()['paginationElementId'] ? : 1;
        $paginationElementId = $processedData['data']['uid'];

        if ($paginationIsActive) {
          if($paginationElementIdKey == $paginationElementId) {
            $currentPage = (int)$cObj->getRequest()->getQueryParams()['paginationPage'] ? : 1;
          } else {
            $currentPage = 1;
          }
          $itemsToPaginate = $allProcessedData[$processorConfiguration['as']];
          $itemsPerPage = (int)($cObj->stdWrapValue('itemsPerPage', $paginationSettings ?? []));
          $paginator = new ArrayPaginator($itemsToPaginate, $currentPage, $itemsPerPage);
          $pagination = new SimplePagination($paginator);
          $combinedData = array(
            'settings' => $contentObjectConfiguration['settings.'],
            'variables' => $contentObjectConfiguration['variables.'],
            'data' => $allProcessedData['data'],
            $processorConfiguration['as'] => $paginator->getPaginatedItems(),
            'pagination' => array(
              'numberOfPages' => $paginator->getNumberOfPages(),
              'current' => $paginator->getCurrentPageNumber(),
              'paginationPages' => $pagination->getAllPageNumbers(),
              'previousPage' => $pagination->getPreviousPageNumber(),
              'nextPage' => $pagination->getNextPageNumber()
            )
          );
          debug($combinedData);

          return $combinedData;
        } else {
          debug($allProcessedData);

          return $allProcessedData;
        }
    }
}
