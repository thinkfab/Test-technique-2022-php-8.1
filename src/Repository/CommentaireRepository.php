<?php

namespace App\Repository;

use App\Entity\Commentaire;
use App\Helper\DoctrineHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function add(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param QueryBuilder $query
     * @param int $articleId
     * @param string $comAlias
     * @return QueryBuilder
     */
    public static function addArticleIdConstraint(
        QueryBuilder $query,
        int $articleId,
        string $comAlias = DoctrineHelper::ALIAS_COMMENTAIRE
    ): QueryBuilder {
        return self::addArticleIdWhere($query, $articleId, $comAlias);
    }

    /**
     * @param QueryBuilder $query
     * @param int $articleId
     * @param string $comAlias
     * @return QueryBuilder
     */
    public static function addArticleIdWhere(
        QueryBuilder $query,
        int $articleId,
        string $comAlias = DoctrineHelper::ALIAS_COMMENTAIRE
    ): QueryBuilder {
        $query->andWhere("$comAlias.article = :id")
            ->setParameter('id', $articleId);
        return $query;
    }
}
