## PHP Korea Date Calc

<p align="center">
<a href="https://packagist.org/packages/getsolaris/korea-date"><img src="https://poser.pugx.org/getsolaris/korea-date/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/getsolaris/korea-date"><img src="https://poser.pugx.org/getsolaris/korea-date/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/getsolaris/korea-date"><img src="https://poser.pugx.org/getsolaris/korea-date/license.svg" alt="License"></a>
</p>


## 날짜 범위

- 1초 ~ 59초
  - 전: n초 전
  - 후: n초 후
- 1분 ~ 59분
  - 전: n분 전
  - 후: n분 후
- 1시간 ~ 23시간
  - 전: n시간 전
  - 후: n시간 후
- 1일 ~ 3일
  - 전: 어제 (1) / 그제 (2) / 엊그제 (3)
  - 후: 내일 (1) / 모레 (2) / 글피 (3)
- 4일 ~ 31일
  - 전: n일 전
  - 후: n일 후
- 32일 ~ 364일
  - 전: n달 전
  - 후: n달 후
- 365일 (1년) ~
  - 전: n년 전
  - 후: n년 후

## 설치

```bash
composer require getsolaris/korea-date
```

## 함수

### calc()
- 첫번째 파라미터: 변화 날짜 (과거, 현재, 미래)
  - strtotime
  - DateTime
  - Carbon
- 두번째 파라미터: 현재 (optional)
- 
### calcFromInterval()
- 첫번째 파라미터: 변화 날짜 (과거, 현재, 미래)
  - strtotime
  - DateTime
  - Carbon
- 두번째 파라미터: 현재 (optional)

```php 
<?php 

$agoDate = new DateTime('2022-02-20');
$diffMessage = KoreaDate::calc($agoDate, '2022-05-20');
$diffArray = KoreaDate::calcFromInterval($agoDate, '2022-05-20');

echo $diffMessage; // 3달 전

$diffArray = [
  'value' => 3,
  'code' => 'month',
  'type' => 'ago',
]
```

## 사용법

```php
<?php declare(strict_types=1);

// 과거
$agoDate = new DateTime('2022-05-20'); // 2022-05-20
$dateMessage = KoreaDate::calc($agoDate);

echo $dateMessage; // result: 어제

// ------------

// 현재 (오늘)
$now = new DateTime('2022-05-21'); // 2022-05-21
$dateMessage = KoreaDate::calc($now);

echo $dateMessage; // result: 오늘

// ------------

// 미래
$now = new DateTime(); // 2022-05-21
$laterDate = new DateTime('2022-05-22'); // 2022-05-22

$dateMessage = KoreaDate::calc($laterDate, $now);

echo $dateMessage; // result: 내일
```
