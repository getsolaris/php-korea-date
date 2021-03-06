<?php

use Getsolaris\KoreaDate\Exceptions\DateValidateException;
use Getsolaris\KoreaDate\KoreaDateEnum;
use PHPUnit\Framework\TestCase;
use Getsolaris\KoreaDate\KoreaDate;

class LaterDaysTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_n초후(): void
    {
        $randomSecond = random_int(1, 59);

        $later = new DateTime();
        $ago = date_create($randomSecond . ' seconds');

        $result = KoreaDate::calc($ago, $later);

        $this->assertEquals($randomSecond . KoreaDateEnum::NUMBER_SECOND_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_30분후(): void
    {
        $later = new DateTime('2022-05-21 16:30:00');
        $now = new DateTime('2022-05-21 16:00:00');

        $result = KoreaDate::calc($later, $now);

        $this->assertEquals('30' . KoreaDateEnum::NUMBER_MINUTE_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_2시간후(): void
    {
        $later = new DateTime('2022-05-21 19:00:00');
        $now = new DateTime('2022-05-21 17:00:00');

        $result = KoreaDate::calc($later, $now);

        $this->assertEquals('2' . KoreaDateEnum::NUMBER_HOUR_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_내일(): void
    {
        $later = new DateTime('2022-05-22');
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($later, $now);

        $this->assertEquals(KoreaDateEnum::NUMBER_ONE_DAY_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_모레(): void
    {
        $later = new DateTime('2022-05-23');
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($later, $now);

        $this->assertEquals(KoreaDateEnum::NUMBER_TWO_DAY_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_글피(): void
    {
        $later = new DateTime('2022-05-24');
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($later, $now);

        $this->assertEquals(KoreaDateEnum::NUMBER_THREE_DAY_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_n일후(): void
    {
        $later = new DateTime('2022-05-30'); // 11
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($later, $now);
        $this->assertEquals('9' . KoreaDateEnum::NUMBER_DAY_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_랜덤_n일후(): void
    {
        $randomDay = random_int(4, 30);

        $now = new DateTime();
        $later = date_create($randomDay . ' days');

        $result = KoreaDate::calc($later, $now);
        $this->assertEquals($randomDay . KoreaDateEnum::NUMBER_DAY_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_랜덤_n달후(): void
    {
        $randomMonth = random_int(2, 11);

        $now = new DateTime();
        $later = date_create($randomMonth . ' months');

        $result = KoreaDate::calc($later, $now);
        $this->assertEquals($randomMonth . KoreaDateEnum::NUMBER_MONTH_LATER, $result);
    }

    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_랜덤_n년후(): void
    {
        $randomYear = random_int(1, 50);

        $now = new DateTime();
        $later = date_create($randomYear . ' years');

        $result = KoreaDate::calc($later, $now);
        $this->assertEquals($randomYear . KoreaDateEnum::NUMBER_YEAR_LATER, $result);
    }
}
