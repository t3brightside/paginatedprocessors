<?php
namespace Brightside\Paginatedprocessors\Processing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

class DataToPaginatedData {
    public function getPaginatedData (
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $allProcessedData,
        array $dataToPaginate,
        string $paginatedDataArrayKey
    ) {
        $paginationSettings = $processorConfiguration['pagination.'];
        $uniquePaginatorId = $cObj->stdWrapValue('uniqueId', $paginationSettings ?? []);
        $uniquePaginatorIdKey = $cObj->getRequest()->getQueryParams()['paginatorId'] ?? null;
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
        $itemsToPaginate = $dataToPaginate;
        $itemsPerPage = (int)($cObj->stdWrapValue('itemsPerPage', $paginationSettings ?? [])) ? : 10;
        $pageLinksShown = (int)($cObj->stdWrapValue('pageLinksShown', $paginationSettings ?? [])) ? : 0;
        $anchorActive = (int)($cObj->stdWrapValue('anchorActive', $paginationSettings ?? [])) ? : 0;
        $anchorId = (int)($cObj->stdWrapValue('anchorId', $paginationSettings ?? [])) ? : 0;
        $paginator = new ArrayPaginator($itemsToPaginate, $currentPage, $itemsPerPage);
        $pagination = new SimplePagination($paginator);
        $allProcessedData = array_diff_key($allProcessedData, array_flip([$paginatedDataArrayKey]));
        $paginatedData = array(
            $paginatedDataArrayKey => $paginator->getPaginatedItems(),
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
                'pageLinksShown' => $pageLinksShown,
                'anchorActive' => $anchorActive,
                'anchorId' => $anchorId,
                'totalPageCount' => count($itemsToPaginate)
            )
        );
        $allProcessedData = array_merge($allProcessedData, $paginatedData);
        return $allProcessedData;
    }
}
