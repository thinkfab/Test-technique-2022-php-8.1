<?php

namespace App\Contracts\Service;

interface ArticleServiceInterface
{
    /**
     * @param string $content
     * @return string
     */
    public function generateBionicContent(string $content): string;
}
