<?php
defined('TYPO3') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['PaginatedprocessorsContentMapper'] =
\Brightside\Paginatedprocessors\Routing\Aspect\PaginatedprocessorsContentMapper::class;
