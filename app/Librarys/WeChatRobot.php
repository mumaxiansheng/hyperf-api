<?php

namespace App\Librarys;

/**
 * 企业微信机器人报警
 * Class WeChatRobot
 * @package App\Librarys
 */
class WeChatRobot
{
    /**
     * 报警地址
     * @var string
     */
    private $_robotUrl;

    /**
     * @var
     */
    private static $_instance;

    /**
     * 环境
     * @var string
     */
    private $_env;

    /**
     * @param string $platform
     * @return mixed
     */
    public static function getInstance(string $platform = 'default')
    {
        if (!static::$_instance instanceof static) {
            static::$_instance = new static($platform);
        }
        return static::$_instance;
    }

    private function __clone()
    {

    }

    /**
     * WeChatRobot constructor.
     * @param string $platform 平台
     */
    private function __construct(string $platform = 'default')
    {
        $this->_env = env('APP_ENV', 'alpha');
        $config = config('weChatRobot');
        $host = $config['weChatUrl'];
        $this->_robotUrl = $host . $config[$platform][$this->_env];
    }

    /**
     * 发送消息
     * @param string $content 消息内容
     * @param string $messageType 消息列表
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $content, $messageType = 'markdown')
    {
        $data = [
            'msgtype' => $messageType,
        ];
        //判断是否为文本消息
        if ($messageType == 'text') {
            $data['text']['content'] = $content;
        }
        //判断是否为markdown
        if ($messageType == 'markdown') {
            $data['markdown']['content'] = $content;
        }
        return curlRequest($this->_robotUrl, $data);
    }
}