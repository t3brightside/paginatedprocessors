<?php
namespace Brightside\Paginatedprocessors\Routing\Aspect;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Routing\Aspect\StaticMappableAspectInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PaginatedprocessorsContentMapper implements StaticMappableAspectInterface
{
    public function generate(string $value): ?string
    {
        if ($this->isValidContentElementUid($value)) {
            return $value;
        }
        return null;
    }

    public function resolve(string $value): ?string
    {
        if ($this->isValidContentElementUid($value)) {
            return $value;
        }
        return null;
    }

    /**
     * Validate, if $value is a valid uid in tt_content
     *
     * @param mixed $uid
     * @return bool
     */
    protected function isValidContentElementUid($value): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $data = (bool)$queryBuilder
            ->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($value)),
                $queryBuilder->expr()->eq('tx_paginatedprocessors_paginationenabled', $queryBuilder->createNamedParameter(true))
            )
            ->execute()
            ->rowCount();
            return $data;
    }
}
