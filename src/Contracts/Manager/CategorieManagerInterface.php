<?php

namespace App\Contracts\Manager;

use Pagerfanta\Pagerfanta;

interface CategorieManagerInterface
{
    /**
     * @param int $limit
     * @param int $page
     * @return Pagerfanta
     */
    public function findAllCategories(int $limit = 10, int $page = 1): Pagerfanta;
}
