<?php

use Getsolaris\KoreaDate\Exceptions\DateValidateException;
use Getsolaris\KoreaDate\KoreaDateEnum;
use PHPUnit\Framework\TestCase;
use Getsolaris\KoreaDate\KoreaDate;

class AgoDaysTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_n초전(): void
    {
        $randomSecond = random_int(1, 59);

        $now = new DateTime();
        $ago = date_create($randomSecond . ' seconds ago');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals($randomSecond . KoreaDateEnum::NUMBER_SECOND_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => $randomSecond,
            'code' => KoreaDateEnum::TYPE_SECOND,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_30분전(): void
    {
        $ago = new DateTime('2022-05-21 15:30:00');
        $now = new DateTime('2022-05-21 16:00:00');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals('30' . KoreaDateEnum::NUMBER_MINUTE_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => 30,
            'code' => KoreaDateEnum::TYPE_MINUTE,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_2시간전(): void
    {
        $ago = new DateTime('2022-05-21 15:00:00');
        $now = new DateTime('2022-05-21 17:00:00');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals('2' . KoreaDateEnum::NUMBER_HOUR_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => 2,
            'code' => KoreaDateEnum::TYPE_HOUR,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_어제(): void
    {
        $ago = new DateTime('2022-05-20');
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($ago, $now);

        $this->assertEquals(KoreaDateEnum::NUMBER_ONE_DAY_AGO, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_그제(): void
    {
        $ago = new DateTime('2022-05-19');
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($ago, $now);

        $this->assertEquals(KoreaDateEnum::NUMBER_TWO_DAY_AGO, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_엊그제(): void
    {
        $ago = new DateTime('2022-05-18');
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($ago, $now);

        $this->assertEquals(KoreaDateEnum::NUMBER_THREE_DAY_AGO, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_n일전(): void
    {
        $ago = new DateTime('2022-05-10'); // 11
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals('11' . KoreaDateEnum::NUMBER_DAY_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => 11,
            'code' => KoreaDateEnum::TYPE_DAY,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_랜덤_n일전(): void
    {
        $randomDay = random_int(4, 30);

        $now = new DateTime();
        $ago = date_create($randomDay . ' days ago');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals($randomDay . KoreaDateEnum::NUMBER_DAY_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => $randomDay,
            'code' => KoreaDateEnum::TYPE_DAY,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_1달전()
    {
        $ago = new DateTime('2022-04-16');
        $now = new DateTime('2022-05-18');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals('1' . KoreaDateEnum::NUMBER_MONTH_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => 1,
            'code' => KoreaDateEnum::TYPE_MONTH,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_랜덤_n달전()
    {
        $randomMonth = random_int(2, 11);

        $now = new DateTime();
        $ago = date_create($randomMonth . ' months ago');

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals($randomMonth . KoreaDateEnum::NUMBER_MONTH_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => $randomMonth,
            'code' => KoreaDateEnum::TYPE_MONTH,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_랜덤_n년전()
    {
        $randomYear = random_int(1, 50);

        $now = new DateTime('2022-06-15 12:31:10');
        $ago = date_create($randomYear . ' years ago');

        $randomYear--;

        $result = KoreaDate::calc($ago, $now);
        $this->assertEquals($randomYear . KoreaDateEnum::NUMBER_YEAR_AGO, $result);

        $result = KoreaDate::calcFromInterval($ago, $now);
        $this->assertEquals([
            'value' => $randomYear,
            'code' => KoreaDateEnum::TYPE_YEAR,
            'type' => KoreaDateEnum::INVERT_TYPE_AGO,
        ], $result);
    }
}
