<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Tag;
use App\Entity\User;
use App\Helper\DoctrineHelper;
use App\ViewModel\ArticleVm;
use App\ViewModel\CommentaireVm;
use App\ViewModel\TagVm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param Article $entity
     * @param bool $flush
     * @return void
     */
    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Article $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param bool $isShortContext
     * @return Collection
     */
    public function getAllArticlesVms(bool $isShortContext = false): Collection
    {
        $aAlias = DoctrineHelper::ALIAS_ARTICLE;
        $query = $this->_em->createQueryBuilder()
            ->from(Article::class, $aAlias);
        self::addArticleVMSelect($query, $aAlias, $isShortContext);
        self::addDefaultConstraint($query, false, $aAlias);
        return new ArrayCollection($query->getQuery()->getResult());
    }

    /**
     * @param string $slug
     * @return ArticleVm|null
     * @throws NonUniqueResultException
     */
    public function getArticleVmBySlug(string $slug): ?ArticleVm
    {
        $aAlias = DoctrineHelper::ALIAS_ARTICLE;
        $query = $this->_em->createQueryBuilder()
            ->from(Article::class, $aAlias);
        self::addArticleVMSelect($query, $aAlias);
        self::addDefaultConstraint($query, true, $aAlias);
        self::addSlugConstraint($query, $slug, $aAlias);
        $query->setMaxResults(1);
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @param QueryBuilder $query
     * @param string $tAlias
     * @param string $joinType
     * @return QueryBuilder
     */
    public static function addTagJoin(
        QueryBuilder $query,
        string $tAlias = DoctrineHelper::ALIAS_TAG,
        string $joinType = Join::LEFT_JOIN
    ): QueryBuilder {
        $joinType = $joinType === Join::LEFT_JOIN ? 'leftjoin' : 'innerjoin';
        $query->$joinType(Tag::class, $tAlias);
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param string $slug
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addSlugConstraint(
        QueryBuilder $query,
        string $slug,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE
    ): QueryBuilder {
        return self::addSlugWhere($query, $slug, $aAlias);
    }

    /**
     * @param QueryBuilder $query
     * @param string $slug
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addSlugWhere(
        QueryBuilder $query,
        string $slug,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE
    ): QueryBuilder {
        $query->andWhere("$aAlias.slug = :slug")
            ->setParameter('slug', $slug);
        return $query;
    }

    /**
     * @param int $articleId
     * @return ArrayCollection
     */
    public function findAllTagsByArticleId(int $articleId)
    {
        $tAlias = DoctrineHelper::ALIAS_TAG;
        $vm = TagVm::class;
        $query = $this->_em->createQueryBuilder();
        $query->select("NEW $vm(" .
            "$tAlias.slug, " .
            "$tAlias.intitule, " .
            "$tAlias.color" .
            ")")
            ->from(Tag::class, $tAlias);
        TagRepository::addArticleIdConstraint($query, $articleId, $tAlias);
        return new ArrayCollection($query->getQuery()->getResult());
    }

    /**
     * @param int $articleId
     * @return ArrayCollection
     */
    public function findAllCommentairesByArticleId(int $articleId)
    {
        $comAlias = DoctrineHelper::ALIAS_COMMENTAIRE;
        $vm = CommentaireVm::class;
        $query = $this->_em->createQueryBuilder();
        $query->select("NEW $vm(" .
            "$comAlias.username, " .
            "$comAlias.content, " .
            "$comAlias.createdAt " .
            ")")
            ->from(Commentaire::class, $comAlias);
        CommentaireRepository::addArticleIdConstraint($query, $articleId, $comAlias);
        return new ArrayCollection($query->getQuery()->getResult());
    }

    /**
     * @param QueryBuilder $query
     * @param User|null $user
     * @param string $aAlias
     * @param string $userAlias
     * @return QueryBuilder
     */
    public static function addUserConstraint(
        QueryBuilder $query,
        User $user = null,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE,
        string $userAlias = DoctrineHelper::ALIAS_USER
    ): QueryBuilder {
        if (!DoctrineHelper::hasAlias($query, $userAlias)) {
            self::addUserJoin($query, $aAlias, $userAlias, Join::INNER_JOIN);
        }
        if ($user !== null) {
            self::addUserWhere($query, $user, $aAlias);
        }
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param string $aAlias
     * @param string $userAlias
     * @param string $joinType
     * @return QueryBuilder
     */
    public static function addUserJoin(
        QueryBuilder $query,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE,
        string $userAlias = DoctrineHelper::ALIAS_USER,
        string $joinType = Join::LEFT_JOIN
    ): QueryBuilder {
        $relation = "$aAlias.user";
        $joinType = $joinType === Join::LEFT_JOIN ? 'leftjoin' : 'innerjoin';
        $query->$joinType($relation, $userAlias);
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param User $user
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addUserWhere(
        QueryBuilder $query,
        User $user,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE,
    ): QueryBuilder {
        $query->andWhere("$aAlias.user = :user")
            ->setParameter('user', $user);
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param bool $isSingleArticleContext
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addDefaultConstraint(
        QueryBuilder $query,
        bool $isSingleArticleContext = false,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE
    ):QueryBuilder {
        self::addIsPublishedWhere($query, true, $aAlias);
        if ($isSingleArticleContext === false) {
            self::addOrderWhere($query);
        }
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param bool $isPublished
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addIsPublishedWhere(
        QueryBuilder $query,
        bool $isPublished = true,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE
    ):QueryBuilder {
        $query->andWhere("$aAlias.isPublished = " . (int)$isPublished);
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param string $field
     * @param string $order
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addOrderWhere(
        QueryBuilder $query,
        string $field = "createdAt",
        string $order = DoctrineHelper::ORDER_DESC,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE
    ):QueryBuilder {
        $query->addOrderBy("$aAlias.$field", $order);
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param int $articleId
     * @param string $aAlias
     * @return QueryBuilder
     */
    public static function addArticleIdWhere(
        QueryBuilder $query,
        int $articleId,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE
    ): QueryBuilder {
        $query->andWhere("$aAlias.id = :id")
            ->setParameter('id', $articleId);
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param string $aAlias
     * @param bool $isShortContext
     * @return QueryBuilder
     */
    private static function addArticleVMSelect(
        QueryBuilder $query,
        string $aAlias = DoctrineHelper::ALIAS_ARTICLE,
        bool $isShortContext = false
    ): QueryBuilder {
        $userAlias = DoctrineHelper::ALIAS_USER;
        $vm = ArticleVm::class;
        $query->select("NEW $vm(" .
            "$aAlias.id, " .
            "(" . (int)$isShortContext . "), " .
            "$aAlias.slug, " .
            "$aAlias.titre, " .
            "$aAlias.createdAt, " .
            "$aAlias.content, " .
            "$userAlias.displayName" .
            ")");
        self::addUserConstraint($query, null, $aAlias, $userAlias);
        return $query;
    }

}
