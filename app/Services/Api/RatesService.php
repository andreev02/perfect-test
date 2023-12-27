<?php

namespace App\Services\Api;

class RatesService
{
    const COMISSION_PERCENT = 0.02;

    public function rates($data)
    {
        $currencies = json_decode(file_get_contents('https://blockchain.info/ticker'), true);

        if (isset($data['currency']))
        {
            $currency = explode(',', $data['currency']);
            
            foreach($currency as $value) {
                if (!in_array($value, array_keys($currencies))) {
                    return null;
                }
            }

            $currencies = array_filter($currencies, function ($value) use ($currency) {
                return in_array($value, $currency);
            }, ARRAY_FILTER_USE_KEY);
        }
        
        $result = [];
        foreach ($currencies as $key => $value)
        {
            $result += [
                $key => 
                [
                    'rate' => $value['last'] - ($value['last'] * self::COMISSION_PERCENT),
                ]
            ];
        }
            
        array_multisort($result, array_column($result, 'rate'), SORT_ASC);

        return $result;
    }
}