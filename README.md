# Pagelist
[![Packagist](https://img.shields.io/packagist/v/t3brightside/paginatedprocessors.svg?style=flat)](https://packagist.org/packages/t3brightside/paginatedprocessors)
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat)](LICENSE)
[![Brightside](https://img.shields.io/badge/by-t3brightside.com-orange.svg?style=flat)](https://t3brightside.com)

**TYPO3 CMS extension for paginated dataProcessors.**

## System requirements

- TYPO3 11.5 LTS

## Installation

 - **composer req t3brightside/paginatedprocessors** or from TER **paginatedprocessors**
 - include static template

## Usage

- Brightside\Paginatedprocessors\DataProcessing\PaginatedDatabaseQueryProcessor
- Brightside\Paginatedprocessors\DataProcessing\PaginatedFilesProcessor
- Brightside\Paginatedprocessors\DataProcessing\PaginatedMenuProcessor

**Route enhancers**
```json
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

-  [GitHub][a47ab545]
-  [Packagist][40819ab1]
-  [TER][15e0f507]

  [a47ab545]: https://github.com/t3brightside/paginatedprocessors "GitHub"
  [40819ab1]: https://packagist.org/packages/t3brightside/paginatedprocessors "Packagist"
  [15e0f507]: https://extensions.typo3.org/extension/paginatedprocessors/ "Typo3 Extension Repository"

Development and maintenance
---------------------------

[Brightside OÜ – TYPO3 development and hosting specialised web agency][ab26eed2]

  [ab26eed2]: https://t3brightside.com/ "TYPO3 development and hosting specialised web agency"
