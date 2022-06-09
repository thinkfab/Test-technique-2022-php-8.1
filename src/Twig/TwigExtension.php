<?php

namespace App\Twig;

use App\Helper\DateTimeHelper;
use DateTimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TwigExtension extends AbstractExtension
{

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('render_date', array($this, 'renderDate')),
            new TwigFunction('convert_slug_to_string', array($this, 'convertSlugToString'))
        );
    }

    /**
     * @param DateTimeInterface|null $date
     * @param null|string $displayEmpty
     * @return string
     */
    public function renderDate(?DateTimeInterface $date, ?string $displayEmpty = null): string
    {
        if ($date === null) {
            if ($displayEmpty !== null) {
                return $displayEmpty;
            }
            return '';
        }
        return DateTimeHelper::formatDate($date);
    }

    /**
     * @param string $string
     * @return string
     */
    public function convertSlugToString(string $string): string
    {
        return implode(' ', explode('-', $string));
    }
}
