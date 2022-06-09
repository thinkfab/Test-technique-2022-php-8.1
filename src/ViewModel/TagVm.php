<?php

namespace App\ViewModel;

final class TagVm
{
    private int $id;
    private string $intitule;
    private string $colorHexa;

    public function __construct(
        string $slug,
        string $intitule,
        string $colorHexa
    ) {
        $this->slug = $slug;
        $this->intitule = $intitule;
        $this->colorHexa = $colorHexa;
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
    public function getIntitule(): string
    {
        return $this->intitule;
    }

    /**
     * @return string
     */
    public function getColorHexa(): string
    {
        return $this->colorHexa;
    }
}
