<?php

namespace App\ViewModel;

use App\Entity\User;
use App\Helper\ArticleHelper;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;

final class ArticleVm
{
    private int $id;
    private string $slug;
    private string $titre;
    private DateTimeInterface $createdAt;
    private string $content;
    private Collection $tags;
    private string $auteur;
    private Collection $commentaires;

    public function __construct(
        int $id,
        bool $isShortContext,
        string $slug,
        string $titre,
        DateTimeInterface $createdAt,
        string $content,
        string $auteur,
    ) {
        $this->id = $id;
        $this->slug = $slug;
        $this->titre = $titre;
        $this->createdAt = $createdAt;
        $this->content = $isShortContext === false ? $content : $this->convertToShort($content);
        $this->auteur = $auteur;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getAuteur(): string
    {
        return $this->auteur;
    }

    /**
     * @param Collection $tags
     * @return ArticleVm
     */
    public function setTags(Collection $tags): ArticleVm
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param Collection $commentaires
     * @return ArticleVm
     */
    public function setCommentaires(Collection $commentaires): ArticleVm
    {
        $this->commentaires = $commentaires;
        return $this;
    }


    /**
     * @return Collection
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    /**
     * @param string $content
     * @return string
     */
    private function convertToShort(string $content): string
    {
        return ArticleHelper::convertToShort($content, 100);
    }
}
