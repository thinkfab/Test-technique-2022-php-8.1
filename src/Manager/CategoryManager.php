<?php

namespace App\Manager;

use App\Contracts\Manager\CategorieManagerInterface;
use App\Entity\Categorie;
use Pagerfanta\Pagerfanta;
use InvalidArgumentException;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;

final class CategorieManager implements CategorieManagerInterface
{
    private CategorieRepository $categorieRepo;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Categorie::class);
        if (!$repo instanceof CategorieRepository) {
            throw new InvalidArgumentException(sprintf(
                'The repository class for "%s" must be "%s" and given "%s"! ' .
                'Maybe look the "repositoryClass" declaration on %s ?',
                Categorie::class,
                EntityManagerInterface::class,
                get_class($repo),
                Categorie::class
            ));
        }
        $this->categorieRepo = $repo;
    }

    /**
     * @inheritDoc
     */
    public function createOrUpdate(Categorie $categorie, bool $flush = true): void
    {
        /** @var int|null $id */
        $id = $categorie->getId();
        if ($id === null) {
            $this->entityManager->persist($categorie);
        }
        if ($flush === true) {
            $this->entityManager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function getAllCategories(int $limit = 10, int $page = 1): Pagerfanta
    {
        return $this->categorieRepo->getAllCategories($limit, $page);
    }

}
