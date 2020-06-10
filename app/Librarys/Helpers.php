<?php

use Hyperf\Guzzle\ClientFactory;

if (!function_exists('chJsonEncode')) {
    /**
     * 处理json 中文问题
     * @param array $data 要处理的数据
     * @return false|string
     */
    function chJsonEncode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('createUuid')) {
    /**
     * uuid生成
     * @param int $type
     * @return string
     */
    function createUuid($type = 1)
    {
        list($t1, $t2) = explode(' ', microtime());
        $microTime = sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
        $rand = mt_rand(1001, 9999);
        return $microTime . $type . $rand;
    }
}

if (!function_exists('curlRequest')) {
    /**
     * 发送http 请求
     * @param string $url 请求地址
     * @param array $data 请求数据
     * @param string $type 请求的数据类型
     * @param string $method 请求类型  POST GET PUT DELETE
     * @param array $headers 请求头
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function curlRequest($url, $data = [], $type = 'json', $method = "POST", $headers = [])
    {
        $clientFactory = make(ClientFactory::class);
        // $options 等同于 GuzzleHttp\Client 构造函数的 $config 参数
        $options = [];
        // $client 为协程化的 GuzzleHttp\Client 对象
        $client = $clientFactory->create($options);
        $requestData = [
            'timeout' => 30,
            'verify' => false,
            'headers' => $headers,
            'http_errors' => true,
        ];
        //判断发送的请求数据
        switch ($type) {
            case 'zhJson':
                $requestData['headers'] = ['content-type' => 'application/json'];
                $requestData['body'] = ch_json_encode($data);
                break;
            case 'json':
                $requestData['json'] = $data;
                break;
            case 'formParams':
                $requestData['form_params'] = $data;
                break;
            case 'multipart':
                $requestData['multipart'] = $data;
                break;
        }
        try {
            //发送请求
            $response = $client->request($method, $url, $requestData);
            $code = $response->getStatusCode();
            $data = (string)$response->getBody()->getContents();
        } catch (Exception $e) {
            return ['status' => 500, 'message' => $e->getMessage()];
        }
        $responseData = json_decode($data, true);
        //判断是否为json
        if (is_null($responseData)) {
            return ['status' => $code, 'message' => $data];
        } else {
            if (is_array($responseData)) {
                return array_merge($responseData, ['status' => $code]);
            } else {
                return ['status' => $code, 'message' => $data];
            }
        }
    }
}

if (!function_exists('lockString')) {
    /**
     * 字符串加密函数
     * @param $txt
     * @param $key
     * @return string
     */
    function lockString($txt, $key)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $nh = rand(0, 64);
        $ch = $chars[$nh];
        $mdKey = substr(md5($key . $ch), $nh % 8, $nh % 8 + 7);
        $txt = base64_encode($txt);
        $tmp = '';
        $i = 0;
        $j = 0;
        $k = 0;
        for ($i = 0; $i < strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = ($nh + strpos($chars, $txt[$i]) + ord($mdKey[$k++])) % 64;
            $tmp .= $chars[$j];
        }
        return urlencode($ch . $tmp);
    }
}

if (!function_exists('unlockString')) {
    /**
     * 字符串解密函数
     * @param $txt
     * @param $key
     * @return bool|string
     */
    function unlockString($txt, $key)
    {
        $txt = urldecode($txt);
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $ch = $txt[0];
        $nh = strpos($chars, $ch);
        $mdKey = substr(md5($key . $ch), $nh % 8, $nh % 8 + 7);
        $txt = substr($txt, 1);
        $tmp = '';
        $i = 0;
        $j = 0;
        $k = 0;
        for ($i = 0; $i < strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = strpos($chars, $txt[$i]) - $nh - ord($mdKey[$k++]);
            while ($j < 0) {
                $j += 64;
            }
            $tmp .= $chars[$j];
        }
        return base64_decode($tmp);
    }
}

if (!function_exists('getWeChatXML')) {
    /**
     * 解析微信返回的xml
     * @param $data
     * @return mixed
     */
    function getWeChatXML($data)
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
}

if (!function_exists('appAuth')) {
    /**
     * 平台加权
     * @param string $sub 用户id
     * @param array $scopes 有效作用域
     * @param array $others 其他参数
     * @param string $aud
     * @param string $expires 有效时间
     * @return array
     */
    function appJwtAuth($sub, $scopes = [], $others = [], $aud = '0', $expires = '7200')
    {
        $privateKey = file_get_contents(BASE_PATH . '/runtime/cert/private.pem');

        $time = time();
        $exp = $time + $expires;

        $token = array(
            "aud" => $aud,//接收jwt的一方
            "jti" => md5(uniqid(mt_rand(), true)),//jwt的唯一身份标识
            "iat" => $time,// jwt的签发时间
            "nbf" => '1577808000',//定义在什么时间之前，该jwt都是不可用的.
            "exp" => $exp,//jwt的过期时间，这个过期时间必须要大于签发时间
            "sub" => $sub,//jwt所面向的用户
            "scopes" => $scopes,//作用域
        );
        //合并加密参数
        $token = array_merge($token, $others);

        $jwt = JWT::encode($token, $privateKey, 'RS256');

        return [
            'accessToken' => $jwt,
            'expires' => $expires,
            'iat' => $exp,
        ];
    }
}

