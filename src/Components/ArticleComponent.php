<?php

namespace App\Components;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('article')]
class ArticleComponent
{
    public int $id;
    public string $slug;
    public string $titre;
    public string $content;
    public DateTimeInterface $createdAt;
    public string $auteur;
    public Collection $tags;
    public Collection $commentaires;
    public bool $shortContent = false;
    public ?string $tagSlug;
}
