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
 * Adds pagination interface to the FilesProcessor
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
        if ($paginationIsActive) {
          $uniquePaginatorId = $cObj->stdWrapValue('uniqueId', $paginationSettings ?? []);
          $uniquePaginatorIdKey = $cObj->getRequest()->getQueryParams()['paginatorId'];
          if($uniquePaginatorId == $uniquePaginatorIdKey) {
            $currentPage = (int)$cObj->getRequest()->getQueryParams()['paginationPage'] ? : 1;
          } else {
            $currentPage = 1;
          }
          $uniquePaginatorName = $cObj->stdWrapValue('uniquePaginatorName', $paginationSettings ?? []);
          if ($uniquePaginatorName) {
            $paginationArray = 'pagination_' . $uniquePaginatorId;
          } else {
            $paginationArray = 'pagination';
          }
          $itemsToPaginate = $allProcessedData[$processorConfiguration['as']];
          $itemsPerPage = (int)($cObj->stdWrapValue('itemsPerPage', $paginationSettings ?? [])) ? : 10;
          $pageLinksShown = (int)($cObj->stdWrapValue('pageLinksShown', $paginationSettings ?? [])) ? : 0;
          $paginator = new ArrayPaginator($itemsToPaginate, $currentPage, $itemsPerPage);
          $pagination = new SimplePagination($paginator);
          $allProcessedData = array_diff_key($allProcessedData, array_flip([$processorConfiguration['as']]));
          $paginatedData = array(
            $processorConfiguration['as'] => $paginator->getPaginatedItems(),
            $paginationArray => array(
              'uniqueId' => $uniquePaginatorId,
              'numberOfPages' => $paginator->getNumberOfPages(),
              'currentPageNumber' => $paginator->getCurrentPageNumber(),
              'keyOfFirstPaginatedItem' => $paginator->getKeyOfFirstPaginatedItem(),
              'keyOfLastPaginatedItem' => $paginator->getKeyOfLastPaginatedItem(),
              'allPageNumbers' => $pagination->getAllPageNumbers(),
              'previousPageNumber' => $pagination->getPreviousPageNumber(),
              'nextPageNumber' => $pagination->getNextPageNumber(),
              'uniquePaginatorName' => $uniquePaginatorName,
              'pageLinksShown' => $pageLinksShown
            )
          );
          $allProcessedData = array_merge($allProcessedData, $paginatedData);
          return $allProcessedData;
        } else {
          return $allProcessedData;
        }
    }
}
