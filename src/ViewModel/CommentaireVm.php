<?php

namespace App\ViewModel;

use DateTimeInterface;

final class CommentaireVm
{
    private string $username;
    private string $content;
    private DateTimeInterface $createdAt;

    public function __construct(
        string $username,
        string $content,
        DateTimeInterface$createdAt
    ) {
        $this->username = $username;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
