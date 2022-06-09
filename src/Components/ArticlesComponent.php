<?php

namespace App\Components;

use App\Contracts\Manager\ArticleManagerInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('articles')]
class ArticlesComponent
{
    public Collection $articles;

    public function __construct(
        private ArticleManagerInterface $articleManager
    ) {}

    public function getArticles() {
        return $this->articleManager->getAllShortArticlesVms();
    }
}
