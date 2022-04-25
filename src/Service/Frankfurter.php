<?php

namespace App\Service;

class Frankfurter
{
    private $url = 'https://api.frankfurter.app';

    // $date - todays date: Y-m-d, $base - base currency, $symbols - curency rates to base
    public function get($date, $base, ?array $symbols) :array
    {
        $url = $this->url.'/'.$date.'?base='.$base.'&symbols='.implode(',', $symbols);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $response = curl_exec($ch);

        $error = null;
        if (curl_errno($ch)) {
            $error = curl_error($ch);
        }

        curl_close($ch);

        if ($error) {
            return false;
        }

        return json_decode($response, true);
    }

}