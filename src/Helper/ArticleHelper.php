<?php

namespace App\Helper;

final class ArticleHelper
{
    /**
     * @param string $content
     * @return string
     */
    public static function convertToBionicReading(string $content): string
    {
        $wordsConverted = array();
        $words = explode(' ', $content);
        foreach ($words as $word) {
            $wordLen = strlen($word);
            switch ($wordLen) {
                case 8:
                case $wordLen > 8:
                    $letterBoldCount = 5;
                    break;
                case 7:
                case 6:
                    $letterBoldCount = 4;
                    break;
                case 5:
                    $letterBoldCount = 3;
                    break;
                case 4:
                    $letterBoldCount = 2;
                    break;
                case 3:
                case $wordLen < 3:
                default:
                    $letterBoldCount = 1;
                    break;
            }
            $wordArray = str_split($word, $letterBoldCount);
            $wordArray[0] = '<span class="bionic-reading-bold">' . $wordArray[0] . '</span>';
            $wordConvert = implode('', $wordArray);
            $wordsConverted[] = $wordConvert;
        }
        return implode(' ', $wordsConverted);
    }

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
        return self::convertToBionicReading($content);
    }
}
