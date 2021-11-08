<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['PaginatedprocessorsContentMapper'] = \Brightside\Paginatedprocessors\Routing\Aspect\PaginatedprocessorsContentMapper::class;
