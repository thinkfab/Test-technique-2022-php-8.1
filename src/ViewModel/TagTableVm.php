<?php

namespace App\ViewModel;

final class TagTableVm
{
    public function __construct(
        private string $intitule,
        private int $nombreArticle,
        private int $id
    ) {}

    /**
     * @return string
     */
    public function getIntitule(): string
    {
        return $this->intitule;
    }

    /**
     * @return int
     */
    public function getNombreArticle(): int
    {
        return $this->nombreArticle;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
