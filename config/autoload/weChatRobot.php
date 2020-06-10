<?php

declare(strict_types=1);

return [
    //发送群消息请求地址  https://qyapi.weixin.qq.com/cgi-bin/webhook/send?
    'weChatUrl' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?',
    //默认机器人
    'default' => [
        //alpha 环境
        'alpha' => 'key=d9af7fb7-19d6-408e-a8ce-08c5da4270ac',
        //beta 环境
        'beta' => 'key=f907c83c-2093-4a0f-824d-14e1cf2e378d',
        //生产环境
        'production' => 'key=f5104baf-b593-40e5-817c-4ee6f371c559',
    ],
];

