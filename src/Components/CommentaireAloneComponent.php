<?php

namespace App\Components;

use DateTimeInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('commentaire_alone')]
class CommentaireAloneComponent
{
    public string $username;
    public string $content;
    public string $class;
    public DateTimeInterface $createdAt;
}
