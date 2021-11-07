<?php
declare(strict_types = 1);

namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

/**
 * Adds pagination API to the DatabaseQueryProcessor
 */

class PaginatedDatabaseQueryProcessor extends DatabaseQueryProcessor
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
      debug($processedData);
        $allProcessedData = parent::process($cObj, $contentObjectConfiguration, $processorConfiguration, $processedData);
        $paginationSettings = $processorConfiguration['pagination.'];
        $paginationIsActive = (int)($cObj->stdWrapValue('isActive', $paginationSettings ?? []));

        if ($paginationIsActive) {
          $paginationElementIdKey = (int)$cObj->getRequest()->getQueryParams()['paginationElementId'] ? : 1;
          $paginationElementId = $processedData['data']['uid'];
          if($paginationElementIdKey == $paginationElementId) {
            $currentPage = (int)$cObj->getRequest()->getQueryParams()['paginationPage'] ? : 1;
          } else {
            $currentPage = 1;
          }
          $itemsToPaginate = $allProcessedData[$processorConfiguration['as']];
          $itemsPerPage = (int)($cObj->stdWrapValue('itemsPerPage', $paginationSettings ?? [])) ? : 10;
          $paginator = new ArrayPaginator($itemsToPaginate, $currentPage, $itemsPerPage);
          $pagination = new SimplePagination($paginator);
          $allProcessedData = array_diff_key($allProcessedData, array_flip([$processorConfiguration['as']]));
          $paginatedData = array(
            $processorConfiguration['as'] => $paginator->getPaginatedItems(),
            'pagination' => array(
              'numberOfPages' => $paginator->getNumberOfPages(),
              'currentPageNumber' => $paginator->getCurrentPageNumber(),
              'allPageNumbers' => $pagination->getAllPageNumbers(),
              'previousPageNumber' => $pagination->getPreviousPageNumber(),
              'nextPageNumber' => $pagination->getNextPageNumber()
            )
          );
          $allProcessedData = array_merge($allProcessedData, $paginatedData);
          return $allProcessedData;
        } else {
          return $allProcessedData;
        }
    }
}
