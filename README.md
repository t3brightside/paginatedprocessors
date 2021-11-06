# Pagelist
[![Packagist](https://img.shields.io/packagist/v/t3brightside/paginatedprocessors.svg?style=flat)](https://packagist.org/packages/t3brightside/paginatedprocessors)
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat)](LICENSE)
[![Brightside](https://img.shields.io/badge/by-t3brightside.com-orange.svg?style=flat)](https://t3brightside.com)

**TYPO3 CMS dataProcessors with pagination**

## System requirements

- TYPO3

## Installation

 - **composer req t3brightside/paginatedprocessors** or from TER **paginatedprocessors**
 - include static template

## Usage
**TypoScript**
```
10 = Brightside\Paginatedprocessors\DataProcessing\PaginatedDatabaseQueryProcessor
10 {
  pagination {
    isActive = 1
    itemsPerPage = 6
  }
  ...
}

Brightside\Paginatedprocessors\DataProcessing\PaginatedFilesProcessor
...
Brightside\Paginatedprocessors\DataProcessing\PaginatedMenuProcessor
...
```
**Template**
```
<f:for each="{pagelist}" as="page" iteration="iterator">
  <f:render partial="Card" arguments="{_all}" />
</f:for>
<f:if condition="{pagination.numberOfPages} > 1">
  <f:render partial="Pagination" arguments="{_all}" />
</f:if>
```
**Route enhancers**
```
routeEnhancers:
  Pagelist:
    type: Simple
    routePath: '/page/{paginationElementId}-{paginationPage}'
    aspects:
      paginationElementId:
        type: PersistedAliasMapper
        tableName: 'tt_content'
        routeFieldName: 'uid'
        routeValueSuffix: '/'
      paginationPage:
        type: StaticRangeMapper
        start: '1'
        end: '999'
```

## Sources

-  [GitHub](https://github.com/t3brightside/paginatedprocessors)
-  [Packagist](https://packagist.org/packages/t3brightside/paginatedprocessors)
-  [TER](https://extensions.typo3.org/extension/paginatedprocessors/)

## Development and maintenance

[Brightside OÜ – TYPO3 development and hosting specialised web agency](https://t3brightside.com/ )
