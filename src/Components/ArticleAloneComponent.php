<?php

namespace App\Components;

use App\Contracts\Manager\TagManagerInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('article_alone')]
class ArticleAloneComponent
{
    public int $id;
    public string $slug;
    public string $titre;
    public string $content;
    public DateTimeInterface $createdAt;
    public string $auteur;
    public Collection $tags;
    public Collection $commentaires;
    public ?string $tagSlug;
}
