<?php

namespace Hnndy\GeetestTool;

session_start();
use Hnndy\GeetestTool\Lib\GeetestLib;

class GeetestTool
{
    protected $GtSdk;

    public function __construct()
    {
        $this->GtSdk = new GeetestLib(config('geetest.captcha_id'), config('geetest.captcha_key'));
    }

    /**
     * 生成
     * @param array $param
     */
    public function StartCaptchaServlet (array $param = [])
    {
        $data = [
            'user_id' => (array_key_exists('user_id', $param)) ? $param['user_id'] : str_random(10), # 网站用户id
            'client_type' => config('geetest.client_type'), #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            'ip_address' => (array_key_exists('ip_address', $param)) ? $param['ip_address'] : '127.0.0.1', # 请在此处传输用户请求验证时所携带的IP
        ];
        $status = $this->GtSdk->pre_process($data, 1);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $data['user_id'];
        echo $this->GtSdk->get_response_str();
    }

    /**
     * 验证
     * @return bool
     */
    public function VerifyCaptchaServlet ()
    {
        $data = array(
            "user_id" => $_SESSION['user_id'], # 网站用户id
            "client_type" => config('geetest.client_type'), #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $this->GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
            if ($result) {
                return true;
            } else{
                return false;
            }
        }else{  //服务器宕机,走failback模式
            if ($this->GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
                return true;
            }else{
                return false;
            }
        }
    }
}