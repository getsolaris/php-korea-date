<?php

namespace Getsolaris\KoreaDate;

interface KoreaDateInterface
{
    /**
     * @param $day
     * @param $now
     * @return string
     */
    public static function calc($day, $now = null): string;
}
