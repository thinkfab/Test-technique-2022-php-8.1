<?php

namespace App\Contracts\Manager;

use App\Entity\Tag;

interface TagManagerInterface
{
    /**
     * @param string $slug
     * @return Tag
     */
    public function findOneBySlug(string $slug): Tag;
}
