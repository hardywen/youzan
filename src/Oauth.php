<?php

namespace Hardywen\Youzan;


use Exception;
use Illuminate\Support\Facades\Session;

class Oauth
{
    protected $baseUrl = 'https://open.koudaitong.com/oauth';

    function __construct($config)
    {

        if (!$config['client_id']) {
            throw new Exception('缺少client_id', 422);
        }

        $this->config = $config;

    }

    public function authorize()
    {

        $state = str_random(32);
        Session::put('youzan.state', $state);

        $params = [
            'client_id'     => $this->config['client_id'],
            'response_type' => 'code',
            'state'         => $state,
            'redirect_uri'  => request()->url(),
        ];

        $query = http_build_query($params);

        $url = $this->baseUrl . '/authorize?' . $query;
        return redirect($url);


    }


    public function token()
    {

        if (request('state') !== session('youzan.state')) {
            throw new Exception('state不匹配,服务器的值为:' . session('youzan.state') . ',返回值为:' . request('state'));
        }

        $params = [
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'grant_type'    => 'authorization_code',
            'code'          => request('code'),
            'redirect_uri'  => request()->url()
        ];


        $curl = curl_init($this->baseUrl . '/token');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $responseText = curl_exec($curl);

        curl_close($curl);

        return json_decode($responseText);

    }

}