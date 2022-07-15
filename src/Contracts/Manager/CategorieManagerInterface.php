<?php

namespace App\Contracts\Manager;

use App\Entity\Categorie;
use Pagerfanta\Pagerfanta;

interface CategorieManagerInterface
{
    /**
     * @param Categorie $Categorie
     * @param bool $flush
     * @return void
     */
    public function createOrUpdate(Categorie $Categorie, bool $flush = true): void;

    /**
     * @param int $limit
     * @param int $page
     * @return Pagerfanta
     */
    public function getAllCategories(int $limit = 10, int $page = 1): Pagerfanta;

}
