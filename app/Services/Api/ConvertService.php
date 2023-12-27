<?php

namespace App\Services\Api;

class ConvertService
{
    const COMISSION_PERCENT = 0.02;

    public function convert($data)
    {
        if ($data['currency_from'] != 'BTC' && $data['currency_to'] != 'BTC') {
            return null;
        }

        $currencies = json_decode(file_get_contents('https://blockchain.info/ticker'), true);
        $rate = 0;
        $converted_value = 0;

        if ($data['currency_from'] == 'BTC')
        {
            if (!in_array($data['currency_to'], array_keys($currencies))) {
                return null;
            }
            
            $rate = $currencies[$data['currency_to']]['last'];
            $result = $data['value'] * $rate;
            $converted_value = round($result - ($result * self::COMISSION_PERCENT), 2);
        }
        else
        {
            if (!in_array($data['currency_from'], array_keys($currencies))) {
                return null;
            }

            $rate = $currencies[$data['currency_from']]['last'];
            $result = fdiv($data['value'], $rate);
            $converted_value = round($result - ($result * self::COMISSION_PERCENT), 10);
        }

        return [
            'currency_from' => $data['currency_from'],
            'currency_to' => $data['currency_to'],
            'value' => $data['value'],
            'converted_value' => $converted_value,
            'rate' => $rate,
        ];
    }
}