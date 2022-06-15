<?php

declare(strict_types=1);

namespace Getsolaris\KoreaDate;

use DateTime;
use Getsolaris\KoreaDate\Exceptions\DateValidateException;

class KoreaDate implements KoreaDateInterface
{
    /**
     * @var string $invertType
     */
    protected static string $invertType;

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
     * @param $day string|\DateTime|\Carbon
     * @param $now null|string|\DateTime|\Carbon
     * @return array
     * @throws DateValidateException
     * @throws \Exception
     */
    public static function calcFromInterval($day, $now = null): array
    {
        $customDayEpoch = self::convertDateToEpochTimeStamp($day);
        $nowEpoch = self::convertDateToEpochTimeStamp($now ?? date('Y-m-d H:i:s'));
        $interval = self::epochDiff($customDayEpoch, $nowEpoch);

        return self::getInterval($interval);
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
     * @return array|GetIntervalResource
     * @throws DateValidateException
     */
    protected static function getInterval(\DateInterval $interval)
    {
        $days = $interval->days;
        $invert = $interval->invert;

        $invertType = $invert ? KoreaDateEnum::INVERT_TYPE_LATER : KoreaDateEnum::INVERT_TYPE_AGO;
        self::setInvertType($invertType);

        $dateType = KoreaDateEnum::getDayOfType($interval);
        switch ($dateType) {
            case KoreaDateEnum::TYPE_SECOND:
                $dateInterval = [
                    't' => $interval->s,
                    'code' => KoreaDateEnum::TYPE_SECOND,
                ];
                break;
            case KoreaDateEnum::TYPE_MINUTE:
                $dateInterval = [
                    't' => $interval->i,
                    'code' => KoreaDateEnum::TYPE_MINUTE,
                ];
                break;
            case KoreaDateEnum::TYPE_HOUR:
                $dateInterval = [
                    't' => $interval->h,
                    'code' => KoreaDateEnum::TYPE_HOUR,
                ];
                break;
            case KoreaDateEnum::TYPE_DAY:
                if ((($days > 0 ? $days : $days * -1) > KoreaDateEnum::getTypeOfDaysCount($invertType)) && $days < 32) {
                    $dateInterval = [
                        't' => $days,
                        'code' => KoreaDateEnum::TYPE_DAY,
                    ];
                    break;
                }

                $dateInterval = [
                    't' => $days - 1,
                    'code' => KoreaDateEnum::TYPE_DAYS[$days - 1],
                ];
                break;
            case KoreaDateEnum::TYPE_MONTH:
                $dateInterval = [
                    't' => $interval->m,
                    'code' => KoreaDateEnum::TYPE_MONTH,
                ];
                break;
            case KoreaDateEnum::TYPE_YEAR:
                $dateInterval = [
                    't' => $interval->y,
                    'code' => KoreaDateEnum::TYPE_YEAR,
                ];
                break;
            default:
                throw new DateValidateException();
        }

        $dateInterval['type'] = self::$invertType;
        return GetIntervalResource::toArray($dateInterval);
    }

    /**
     * @param \DateInterval $interval
     * @return string
     * @throws DateValidateException
     */
    protected static function getIntervalToDay(\DateInterval $interval): string
    {
        $interval = self::getInterval($interval);

        return (in_array(
                $interval['code'],
                KoreaDateEnum::TYPE_DAYS,
                true
            ) ? '' : $interval['value']) . self::getEnumNumberType($interval['code']);
    }

    /**
     * @param string $dateType
     * @return string
     */
    protected static function getEnumNumberType(string $dateType): string
    {
        $invertType = self::getInvertType();
        return constant(
            KoreaDateEnum::class . sprintf("::NUMBER_%s_%s", strtoupper($dateType), strtoupper($invertType))
        );
    }

    /**
     * @param string $invertType
     * @return void
     */
    protected static function setInvertType(string $invertType): void
    {
        self::$invertType = $invertType;
    }

    /**
     * @return string
     */
    protected static function getInvertType(): string
    {
        return self::$invertType;
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
