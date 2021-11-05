<?php
defined('TYPO3') or die();

call_user_func(function()
{
   /**
    * Default TypoScript
    */
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
      'paginatedprocessors',
      'Configuration/TypoScript',
      'Paginate Processors'
   );
});
