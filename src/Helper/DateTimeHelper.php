<?php

namespace App\Helper;

use DateTimeInterface;

final class DateTimeHelper
{
    /**
     * @param DateTimeInterface $dateTime
     * @return string
     */
    public static function formatDate(DateTimeInterface $dateTime): string
    {
        return $dateTime->format('d/m/Y');
    }
}
