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
 - Enable default CSS from constant editor or set:<br /> **paginatedprocessors.enableDefaultStyles = 1**


## Usage
```
Brightside\Paginatedprocessors\DataProcessing\PaginatedDatabaseQueryProcessor
Brightside\Paginatedprocessors\DataProcessing\PaginatedFilesProcessor
Brightside\Paginatedprocessors\DataProcessing\PaginatedMenuProcessor
```
**TypoScript example**
```
10 = Brightside\Paginatedprocessors\DataProcessing\PaginatedDatabaseQueryProcessor
10 {
  pagination {
    isActive = 1
    itemsPerPage = 10

    ## uniqueId is mandatory
    ## returns array 'pagination'
    ## URL example /21/2
    uniqueId.field = uid
    uniquePaginatorName = 0

    ## returns array 'pagination'
    ## URL example /gallery/2
    ## need to map uniqueId in routeEnhancers
    # uniqueId = gallery
    # uniquePaginatorName = 0

    ## returns array 'pagination_gallery'
    ## URL example /gallery/2
    ## need to map uniqueId in routeEnhancers
    # uniqueId = gallery
    # uniquePaginatorName = 1
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
<f:if condition="{pagination_gallery.numberOfPages} > 1">
  <f:render partial="Pagination" arguments="{pagination:pagination_gallery}" />
</f:if>
```
**Route enhancers**
```
routeEnhancers:
  UidPaginatedprocessors:
    type: Simple
    routePath: '/{paginatorId}/{paginationPage}'
    aspects:
      paginatorId:
        type: PersistedAliasMapper
        tableName: 'tt_content'
        routeFieldName: 'uid'
      paginationPage:
        type: StaticRangeMapper
        start: '0'
        end: '999'
  NamePaginatedprocessors:
    type: Simple
    routePath: '/{paginatorName}/{paginationPage}'
    aspects:
      paginatorName:
        type: StaticValueMapper
        map:
          gallery: 'gallery'
      paginationPage:
        type: StaticRangeMapper
        start: '0'
        end: '900'
```

## Sources

-  [GitHub](https://github.com/t3brightside/paginatedprocessors)
-  [Packagist](https://packagist.org/packages/t3brightside/paginatedprocessors)
-  [TER](https://extensions.typo3.org/extension/paginatedprocessors/)

## Development and maintenance

[Brightside OÜ – TYPO3 development and hosting specialised web agency](https://t3brightside.com/ )
