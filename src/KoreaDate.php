<?php

declare(strict_types=1);

namespace Getsolaris\KoreaDate;

use DateTime;
use Getsolaris\KoreaDate\Exceptions\DateValidateException;

class KoreaDate implements KoreaDateInterface
{
    /**
     * @param $day string|\DateTime|\Carbon
     * @param $now null|string|\DateTime|\Carbon
     * @return string
     * @throws DateValidateException
     * @throws \Exception
     */
    public static function calc($day, $now = null): string
    {
        $customDayEpoch = self::convertDateToEpochTimeStamp($day);
        $nowEpoch = self::convertDateToEpochTimeStamp($now ?? date('Y-m-d H:i:s'));
        $interval = self::epochDiff($customDayEpoch, $nowEpoch);

        return self::getIntervalToDay($interval);
    }

    /**
     * @param int $e1
     * @param int $e2
     * @return \DateInterval
     * @throws \Exception
     */
    protected static function epochDiff(int $e1, int $e2): \DateInterval
    {
        return date_diff(
            self::convertEpochToDatetime($e1),
            self::convertEpochToDatetime($e2)
        );
    }

    /**
     * @param int $epoch
     * @return DateTime
     * @throws \Exception
     */
    protected static function convertEpochToDatetime(int $epoch): DateTime
    {
        return new DateTime(date('Y-m-d H:i:s', $epoch));
    }

    /**
     * @param \DateInterval $interval
     * @return string
     * @throws DateValidateException
     */
    protected static function getIntervalToDay(\DateInterval $interval): string
    {
        $days = $interval->days;
        $invert = $interval->invert;

        $invertType = $invert ? KoreaDateEnum::INVERT_TYPE_LATER : KoreaDateEnum::INVERT_TYPE_AGO;
        $dateType = KoreaDateEnum::getDayOfType($interval);
        switch ($dateType) {
            case KoreaDateEnum::TYPE_TODAY:
                return KoreaDateEnum::TODAY;
            case KoreaDateEnum::TYPE_MINUTE:
                return $interval->i . self::getKoreaDateEnumNumberType(KoreaDateEnum::TYPE_MINUTE, $invertType);
            case KoreaDateEnum::TYPE_HOUR:
                return $interval->h . self::getKoreaDateEnumNumberType(KoreaDateEnum::TYPE_HOUR, $invertType);
            case KoreaDateEnum::TYPE_DAY:
                if ((($days > 0 ? $days : $days * -1) > KoreaDateEnum::getTypeOfDaysCount($invertType)) && $days < 32) {
                    return $days . self::getKoreaDateEnumNumberType(KoreaDateEnum::TYPE_DAY, $invertType);
                }

                return $invertType === KoreaDateEnum::INVERT_TYPE_AGO
                    ? KoreaDateEnum::DAYS_AGO[$days - 1] : KoreaDateEnum::DAYS_LATER[$days - 1];
            case KoreaDateEnum::TYPE_MONTH:
                return $interval->m . self::getKoreaDateEnumNumberType(KoreaDateEnum::TYPE_MONTH, $invertType);
            case KoreaDateEnum::TYPE_YEAR:
                return $interval->y . self::getKoreaDateEnumNumberType(KoreaDateEnum::TYPE_YEAR, $invertType);
            default:
                throw new DateValidateException();
        }
    }

    /**
     * @param string $dateType
     * @param string $invertType
     * @return string
     */
    protected static function getKoreaDateEnumNumberType(string $dateType, string $invertType): string
    {
        return constant(
            KoreaDateEnum::class . sprintf("::NUMBER_%s_%s", strtoupper($dateType), strtoupper($invertType))
        );
    }

    /**
     * Epoch 변환
     *
     * @param $date
     * @return int
     * @throws DateValidateException
     */
    protected static function convertDateToEpochTimeStamp($date): int
    {
        if ($date instanceof \DateTime) {
            return $date->getTimestamp();
        } elseif ($date instanceof \Carbon) {
            return $date->timestamp;
        } elseif (strtotime($date)) {
            return strtotime($date);
        } else {
            throw new DateValidateException();
        }
    }
}
