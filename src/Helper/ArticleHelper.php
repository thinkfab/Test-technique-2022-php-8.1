<?php

namespace App\Helper;

final class ArticleHelper
{
    /**
     * @param string $content
     * @param int $maxChar
     * @return string
     */
    public static function convertToShort(string $content, int $maxChar): string
    {
        $content = strip_tags($content);
        $content = substr($content, 0, $maxChar);
        $content .= '...';
        return $content;
    }
}
