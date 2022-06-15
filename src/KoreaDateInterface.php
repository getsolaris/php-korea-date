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

    /**
     * @param $day
     * @param $now
     * @return array
     */
    public static function calcFromInterval($day, $now = null): array;
}
