<?php

namespace App\Contracts\Manager;

use App\Entity\Article;
use App\Entity\Tag;
use App\ViewModel\ArticleVm;
use Doctrine\Common\Collections\Collection;

interface ArticleManagerInterface
{
    /**
     * @param Article $article
     * @param bool $flush
     * @return void
     */
    public function createOrUpdate(Article $article, bool $flush = true): void;

    /**
     * @return Collection
     */
    public function getAllShortArticlesVms(): Collection;

    /**
     * @return Collection
     */
    public function getAllArticlesVms(): Collection;

    /**
     * @param string $slug
     * @return ArticleVm|null
     */
    public function getArticleVmBySlug(string $slug): ?ArticleVm;

    /**
     * @param Tag $tag
     * @return Collection
     */
    public function getArticlesByTag(Tag $tag): Collection;
}
