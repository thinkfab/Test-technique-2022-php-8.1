<?php

namespace App\Helper;

use Doctrine\ORM\QueryBuilder;

final class DoctrineHelper
{
    public const ALIAS_ARTICLE = 'article_';
    public const ALIAS_TAG = 'tag_';
    public const ALIAS_COMMENTAIRE = 'commentaire_';
    public const ALIAS_USER = 'user_';

    public const ORDER_DESC = 'DESC';
    public const ORDER_ASC = 'ASC';

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $alias
     * @return bool
     */
    public static function hasAlias(QueryBuilder $queryBuilder, string $alias): bool
    {
        return in_array($alias, $queryBuilder->getAllAliases(), true);
    }
}
