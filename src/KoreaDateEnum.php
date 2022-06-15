<?php

namespace Getsolaris\KoreaDate;

use Getsolaris\KoreaDate\Exceptions\DateValidateException;

abstract class KoreaDateEnum
{
    public const INVERT_TYPE_AGO = 'ago';
    public const INVERT_TYPE_LATER = 'later';

    public const INVERT_TYPES = [
        self::INVERT_TYPE_AGO,
        self::INVERT_TYPE_LATER,
    ];

    public const TYPE_SECOND = 'second';
    public const TYPE_MINUTE = 'minute';
    public const TYPE_HOUR = 'hour';
    public const TYPE_DAY = 'day';
    public const TYPE_MONTH = 'month';
    public const TYPE_YEAR = 'year';

    public const TYPES = [
        self::TYPE_MINUTE,
        self::TYPE_HOUR,
        self::TYPE_DAY,
        self::TYPE_MONTH,
        self::TYPE_YEAR,
    ];

    public const NUMBER_ONE_DAY_AGO = '어제';
    public const NUMBER_TWO_DAY_AGO = '그제';
    public const NUMBER_THREE_DAY_AGO = '엊그제';

    public const NUMBER_SECOND_AGO = '초 전';
    public const NUMBER_SECOND_LATER = '초 후';
    public const NUMBER_MINUTE_AGO = '분 전';
    public const NUMBER_MINUTE_LATER = '분 후';
    public const NUMBER_HOUR_AGO = '시간 전';
    public const NUMBER_HOUR_LATER = '시간 후';
    public const NUMBER_DAY_AGO = '일 전';
    public const NUMBER_DAY_LATER = '일 후';
    public const NUMBER_MONTH_AGO = '달 전';
    public const NUMBER_MONTH_LATER = '달 후';
    public const NUMBER_YEAR_AGO = '년 전';
    public const NUMBER_YEAR_LATER = '년 후';

    public const NUMBER_ONE_DAY_LATER = '내일';
    public const NUMBER_TWO_DAY_LATER = '모레';
    public const NUMBER_THREE_DAY_LATER = '글피';

    public const DAYS_AGO = [
        self::NUMBER_ONE_DAY_AGO,
        self::NUMBER_TWO_DAY_AGO,
        self::NUMBER_THREE_DAY_AGO,
    ];

    public const TYPE_DAYS = [
        'one_day',
        'two_day',
        'three_day',
    ];

    public const DAYS_LATER = [
        self::NUMBER_ONE_DAY_LATER,
        self::NUMBER_TWO_DAY_LATER,
        self::NUMBER_THREE_DAY_LATER,
    ];

    /**
     * @param string $type
     * @return int
     */
    public static function getTypeOfDaysCount(string $type = self::INVERT_TYPE_AGO): int
    {
        return count($type === self::INVERT_TYPE_AGO ? self::DAYS_AGO : self::DAYS_LATER);
    }

    /**
     * @param \DateInterval $interval
     * @return string
     */
    public static function getDayOfType(\DateInterval $interval): string
    {
        $days = $interval->days;
        if (! $days && $interval->s) {
            return self::TYPE_SECOND;
        } elseif (! $days && $interval->i && $interval->i >= 1 && $interval->i < 60) {
            return self::TYPE_MINUTE;
        } elseif (! $days && $interval->h && $interval->h >= 1 && $interval->h < 24) {
            return self::TYPE_HOUR;
        } elseif ($days && $interval->y) {
            return self::TYPE_YEAR;
        } elseif ($days && $days >= 32 && $days <= 364) {
            return self::TYPE_MONTH;
        } elseif ($days && $days < 32) {
            return self::TYPE_DAY;
        } elseif (! $days) {
            return self::TYPE_TODAY;
        }
    }
}
