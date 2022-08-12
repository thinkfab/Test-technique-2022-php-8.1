<?php

namespace App\Manager;

use App\Contracts\Manager\CategorieManagerInterface;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;

class CategorieManager implements CategorieManagerInterface
{
    private CategorieRepository $categorieRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $categorieRepository = $entityManager->getRepository(Categorie::class);
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @inheritDoc
     */
    public function findAllCategories(int $limit = 10, int $page = 1): Pagerfanta
    {
        return $this->categorieRepository->findAllCategories($limit, $page);
    }
}
