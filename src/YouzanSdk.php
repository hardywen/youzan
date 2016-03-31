<?php

namespace Hardywen\Youzan;


use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;

class YouzanSdk
{
    public $oauth;

    public $api;

    protected $access_token;

    function __construct($config)
    {
        if (empty($config)) {
            throw new Exception('配置不能为空', 422);
        }

        $this->config = $config;

        $this->oauth = new Oauth($this->config);

        $this->api = new Api($this->config);

    }

    public function authorize()
    {
        if (!request('code')) {
            $accessToken = Session::get('youzan.access_token');
            if (!$accessToken || (isset($accessToken->expires_at) && $accessToken->expires_at < Carbon::now())) {
                return $this->oauth->authorize();
            }
        } else {
            $accessToken = $this->oauth->token();
        }

        if (isset($accessToken->error)) {
            throw new Exception($accessToken->error_description);
        }

        $accessToken->expires_at = Carbon::now()->addSeconds($accessToken->expires_in);

        Session::put('youzan.access_token', $accessToken);

        return true;
    }

    public function getAccessToken()
    {
        $accessToken = Session::get('youzan.access_token');
        return $accessToken;
    }


    public function get($method, $params = [])
    {
        return $this->api('get', $method, $params);
    }

    public function post($method, $params = [])
    {
        return $this->api('post', $method, $params);

    }

    protected function api($requestMethod, $method, $params)
    {
        $accessToken = Session::get('youzan.access_token');

        $params = array_merge($params, ['method' => $method, 'access_token' => $accessToken->access_token]);

        $result = $this->api->$requestMethod($params);

        if (isset($result->error_response)) {
            throw new Exception('[' . $result->error_response->code . ']' . $result->error_response->msg);
        }

        return $result->response;
    }

    public function sessionClear()
    {
        Session::forget('youzan.access_token');
        Session::forget('youzan.state');
    }

}