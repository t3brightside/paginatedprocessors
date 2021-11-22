# Paginatedprocessors
[![License](https://poser.pugx.org/t3brightside/paginatedprocessors/license)](LICENSE.txt)
[![Packagist](https://img.shields.io/packagist/v/t3brightside/paginatedprocessors.svg?style=flat)](https://packagist.org/packages/t3brightside/paginatedprocessors)
[![Downloads](https://poser.pugx.org/t3brightside/paginatedprocessors/downloads)](https://packagist.org/packages/t3brightside/paginatedprocessors)
[![Brightside](https://img.shields.io/badge/by-t3brightside.com-orange.svg?style=flat)](https://t3brightside.com)

**TYPO3 CMS dataProcessors with pagination**

## System requirements
- TYPO3 v11.5

## Features
- PaginatedDatabaseQueryProcessor
- PaginatedFilesProcessor
- PaginatedMenuProcessor
- Pagination on/off
- Number of items per page
- Number of pagination links
- URL Segment from content element or TypoScript

## Installation & Updates
- **composer req t3brightside/paginatedprocessors** or from TYPO3 extension repository **[paginatedprocessors](https://extensions.typo3.org/extension/paginatedprocessors/)**
- Include static template
- Enable default CSS from constant editor: **paginatedprocessors.enableDefaultStyles = 1**
- See the [ChangeLog](ChangeLog) for updates and breaking changes

## Usage
**Available DataProcessors**
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
    # isActive.field = tx_paginatedprocessors_paginationenabled

    itemsPerPage = 10
    itemsPerPage.override.field = tx_paginatedprocessors_itemsperpage

    pageLinksShown = 7
    pageLinksShown.override.field = tx_paginatedprocessors_pagelinksshown

    ## uniqueId is mandatory
    ## returns array 'pagination'
    ## URL example /21/2
    uniqueId.field = uid
    uniquePaginatorName = 0

    ## returns array 'pagination'
    ## URL example /gallery/2
    ## need to map in routeEnhancers, see PaginatedprocessorsByUnigueIdInTs
    # uniqueId = gallery

    ## returns array 'pagination_gallery'
    ## URL example /gallery/2
    ## need to map in routeEnhancers, see PaginatedprocessorsByUnigueIdInTs
    # uniqueId = gallery
    # uniquePaginatorName = 1
  }
  ...
}
```
**Pagination link control examples**
```
pageLinksShown = 1
[<<][<][-4/12-][>][>>]

pageLinksShown = 0 or is bigger than amount of pages + 2
[<][1][2][-3-][4][5][>]

pageLinksShown = 5
[<][1]…[5][6][-7-][8][9]…[60][>]
```
**Template**
```XML
<f:for each="{pages}" as="page" iteration="iterator">
  <f:render partial="List" arguments="{_all}" />
</f:for>
<f:if condition="{pagination.numberOfPages} > 1">
  <f:render partial="Pagination" arguments="{pagination:pagination}" />
</f:if>
<!-- with uniquePaginatorName turned on -->
<f:if condition="{pagination_gallery.numberOfPages} > 1">
  <f:render partial="Pagination" arguments="{pagination:pagination_gallery}" />
</f:if>
```
**Route enhancers**
```
routeEnhancers:
  PaginatedprocessorsByContentId:
    type: Simple
    routePath: '/{paginatorId}/{paginationPage}'
    aspects:
      paginatorId:
        type: PaginatedprocessorsContentMapper
      paginationPage:
        type: StaticRangeMapper
        start: '0'
        end: '999'
  PaginatedprocessorsByUnigueIdInTs:
    type: Simple
    routePath: '/{paginatorId}/{paginationPage}'
    aspects:
      paginatorId:
        type: StaticValueMapper
        map:
          files: files
          gallery: gallery
      paginationPage:
        type: StaticRangeMapper
        start: '0'
        end: '999'
```
## In your own extensions
Use Classes/Processing/DataToPaginatedData in your own custom dataProcessors.
And there's TCA for 'tt_content' to add Paginatedprocessors to your own content elements. See: [tt_content.php](Configuration/Overrides/tt_content.php)
## Sources
-  [GitHub](https://github.com/t3brightside/paginatedprocessors)
-  [Packagist](https://packagist.org/packages/t3brightside/paginatedprocessors)
-  [TER](https://extensions.typo3.org/extension/paginatedprocessors/)

## Development and maintenance
[Brightside OÜ – TYPO3 development and hosting specialised web agency](https://t3brightside.com/ )
