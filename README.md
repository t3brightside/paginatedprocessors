# Paginatedprocessors
[![Packagist](https://img.shields.io/packagist/v/t3brightside/paginatedprocessors.svg?style=flat)](https://packagist.org/packages/t3brightside/paginatedprocessors)
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat)](LICENSE)
[![Brightside](https://img.shields.io/badge/by-t3brightside.com-orange.svg?style=flat)](https://t3brightside.com)

**TYPO3 CMS dataProcessors with pagination**

## System requirements

- TYPO3 v11.5

## Installation

 - **composer req t3brightside/paginatedprocessors** or from TER **paginatedprocessors**
 - include static template

## Usage
Paginated processors available:
- Brightside\Paginatedprocessors\DataProcessing\PaginatedDatabaseQueryProcessor
- Brightside\Paginatedprocessors\DataProcessing\PaginatedFilesProcessor
- Brightside\Paginatedprocessors\DataProcessing\PaginatedMenuProcessor

**TypoScript example**
```
10 = Brightside\Paginatedprocessors\DataProcessing\PaginatedDatabaseQueryProcessor
10 {
  pagination {
    isActive = 1
    itemsPerPage = 6

    # content element context, returns array 'pagination'
    uniqueId.field = uid
    uniquePaginatorName = 0

    # in page context, returns array 'pagination_mypaginator'
    uniqueId = mypaginator
    uniquePaginatorName = 1
  }
  ...
}

```
**Template**
```XML
<f:for each="{pages}" as="page" iteration="iterator">
  <f:render partial="List" arguments="{_all}" />
</f:for>
<!-- content element context -->
<f:if condition="{pagination.numberOfPages} > 1">
  <f:render partial="Pagination" arguments="{pagination:pagination}" />
</f:if>
<!-- page context -->
<f:if condition="{pagination_mypaginator.numberOfPages} > 1">
  <f:render partial="Pagination" arguments="{pagination:pagination_mypaginator}" />
</f:if>
```
**Route enhancers**
```
routeEnhancers:
  Paginatedprocessors:
    type: Simple
    routePath: '/page/{paginationPage}-{paginationElementId}'
    aspects:
      paginationPage:
        type: StaticRangeMapper
        start: '1'
        end: '999'
      paginationElementId:
        type: PersistedAliasMapper
        tableName: 'tt_content'
        routeFieldName: 'uid'

```

## Sources

-  [GitHub](https://github.com/t3brightside/paginatedprocessors)
-  [Packagist](https://packagist.org/packages/t3brightside/paginatedprocessors)
-  [TER](https://extensions.typo3.org/extension/paginatedprocessors/)

## Development and maintenance

[Brightside OÜ – TYPO3 development and hosting specialised web agency](https://t3brightside.com/ )
