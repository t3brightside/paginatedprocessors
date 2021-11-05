<?php
declare(strict_types = 1);

namespace Brightside\Paginatedprocessors\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\MenuProcessor;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

/**
 * Adds pagination API to the DatabaseQueryProcessor
 */

class PaginatedMenuProcessor extends MenuProcessor
{
  /**
   * Allowed configuration keys for menu generation, other keys
   * will throw an exception to prevent configuration errors.
   *
   * @var array
   */
  public $allowedConfigurationKeys = [
      'cache_period',
      'entryLevel',
      'entryLevel.',
      'special',
      'special.',
      'minItems',
      'minItems.',
      'maxItems',
      'maxItems.',
      'begin',
      'begin.',
      'alternativeSortingField',
      'alternativeSortingField.',
      'showAccessRestrictedPages',
      'showAccessRestrictedPages.',
      'excludeUidList',
      'excludeUidList.',
      'excludeDoktypes',
      'includeNotInMenu',
      'includeNotInMenu.',
      'alwaysActivePIDlist',
      'alwaysActivePIDlist.',
      'protectLvar',
      'addQueryString',
      'addQueryString.',
      'if',
      'if.',
      'levels',
      'levels.',
      'expandAll',
      'expandAll.',
      'includeSpacer',
      'includeSpacer.',
      'as',
      'titleField',
      'titleField.',
      'dataProcessing',
      'dataProcessing.',
      'pagination.',
  ];
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
          return $combinedData;
        } else {
          return $allProcessedData;
        }
    }
}
