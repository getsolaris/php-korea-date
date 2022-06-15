<?php

namespace Getsolaris\KoreaDate;

class GetIntervalResource
{
    /**
     * @param array $data
     * @return array
     */
    public static function toArray(array $data): array
    {
        return [
            'value' => $data['t'],
            'code' => $data['code'],
            'type' => $data['type'],
        ];
    }
}