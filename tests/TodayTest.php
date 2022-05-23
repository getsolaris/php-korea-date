<?php

use Getsolaris\KoreaDate\Exceptions\DateValidateException;
use Getsolaris\KoreaDate\KoreaDateEnum;
use PHPUnit\Framework\TestCase;
use Getsolaris\KoreaDate\KoreaDate;

class TodayTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws DateValidateException
     */
    public function test_오늘(): void
    {
        $now = new DateTime('2022-05-21');

        $result = KoreaDate::calc($now, $now);

        $this->assertEquals(KoreaDateEnum::TODAY, $result);
    }
}
