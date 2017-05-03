<?php

namespace Controller;

class VKController
{
    private $app_id;
    private $api_secret;
    private $ch;
    private $VK_options;

    const AUTHORIZE_URL = 'https://oauth.vk.com/authorize';
    const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';

    public function __construct()
    {
        $this->VK_options = require('../config/VKconfg.php');

        $this->app_id = $this->VK_options['app_id'];
        $this->api_secret = $this->VK_options['api_secret'];

        $this->ch = curl_init();

    }

     public function __destruct()
    {
        curl_close($this->ch);
    }

    //URL авторизаци
    public function getAuthorizeUrl()
    {
        $parameters = [
            'client_id' => $this->app_id,
            'scope' => $this->VK_options['api_settings'],
            'redirect_uri' => $this->VK_options['callback_url'],
            'response_type' => 'code'
        ];

        return $this->createUrl(self::AUTHORIZE_URL, $parameters);
    }

    //формирование URL
    private function createUrl($url, $parameters)
    {
        $url .= '?' . http_build_query($parameters);
        return $url;
    }

    //Доступ приложения VK
    public function getAccess($code)
    {
        $parameters = array(
            'client_id' => $this->app_id,
            'client_secret' => $this->api_secret,
            'code' => $code,
            'redirect_uri' => $this->VK_options['callback_url']
        );

        $rs = json_decode($this->request(
            $this->createUrl(self::ACCESS_TOKEN_URL, $parameters)), true);

        if (isset($rs['error'])) {
            return 'error';
        } else {
            return $rs;
        }
    }

    //Запрос данных
    private function request($url, $method = 'GET', $postfields = array())
    {
        curl_setopt_array($this->ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => ($method == 'POST'),
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_URL => $url
        ));

        return curl_exec($this->ch);
    }

//    Формирование URL запроса
    public function getApiUrl($method, $response_format = 'json')
    {
        return 'https://api.vk.com/method/' . $method . '.' . $response_format;
    }

//    запрос данных
    public function api($method, $parameters = array(), $format = 'array', $requestMethod = 'get')
    {
        $parameters['timestamp'] = time();
        $parameters['api_id'] = $this->app_id;
        $parameters['random'] = rand(0, 10000);

        ksort($parameters);

        $sig = '';
        foreach ($parameters as $key => $value) {
            $sig .= $key . '=' . $value;
        }
        $sig .= $this->api_secret;

        $parameters['sig'] = md5($sig);

        if ($method == 'execute' || $requestMethod == 'post') {
            $rs = $this->request(
                $this->getApiUrl($method, $format == 'array' ? 'json' : $format), "POST", $parameters);
        } else {
            $rs = $this->request($this->createUrl(
                $this->getApiUrl($method, $format == 'array' ? 'json' : $format), $parameters));
        }
        return $format == 'array' ? json_decode($rs, true) : $rs;
    }
};

