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
            return $this->oauth->authorize();
        } else {
            $accessToken = $this->oauth->token();
        }

        if (isset($accessToken->error)) {
            throw new Exception($accessToken->error_description);
        }

        return true;
    }


    public function setToken($token)
    {
        $this->access_token = $token;

        return $this;
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
        $params = array_merge($params, ['method' => $method, 'access_token' => $this->access_token]);

        $result = $this->api->$requestMethod($params);

        if (isset($result->error_response)) {
            throw new Exception('[' . $result->error_response->code . ']' . $result->error_response->msg);
        }

        return $result->response;
    }

    public function sessionClear()
    {
        Session::forget('youzan.access_token');
    }

}