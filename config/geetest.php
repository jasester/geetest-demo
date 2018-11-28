<?php

return [
    'captcha_id' => '', //geetest id
    'captcha_key' => '', // geetest key
    'start_captcha_servle_url' => '', // 调用验证码路由
    'client_type' => 'web', //#web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
    'cache_minutes' => 15, //缓存时间默认15分钟
];