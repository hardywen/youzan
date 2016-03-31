<?php

namespace Hardywen\Youzan;


class Api
{

    protected $baseUrl = 'https://open.koudaitong.com/api/oauthentry';

    public function get($params)
    {
        $curl = curl_init($this->baseUrl . '?' . http_build_query($params));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $responseText = curl_exec($curl);

        curl_close($curl);

        return json_decode($responseText);
    }


    public function post($params)
    {
        $curl = curl_init($this->baseUrl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $responseText = curl_exec($curl);

        curl_close($curl);

        return json_decode($responseText);
    }

}