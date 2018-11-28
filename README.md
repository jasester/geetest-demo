# geetest-tool for laravel

geetest 验证

## Installing

```shell
$ composer require hnndy/geetest-tool
```

```shell
php artisan vendor:publish --provider="Hnndy\GeetestTool\GeetestToolServiceProvider "
```

## Usage

##1.填写配置
文件发布到config -> geetest.php
```php
'captcha_id' => '', //geetest id
'captcha_key' => '', // geetest key
'start_captcha_servle_url' => 'http://***.test/***', // 调用验证码路由, 此处许要执行注册一个路由
'client_type' => 'web', //#web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
```
##1.开始使用
显示验证码视图
```php
@include('vendor/captcha/captcha') //在页面中引用验证码视图
```
获取验证码
```php
app('geetest')->StartCaptchaServlet();
```
验证
```php
$param = [
    'geetest_challenge' => '',
    'geetest_validate' => '',
    'geetest_seccode' => 
];
app('geetest')->VerifyCaptchaServlet($param); //返回bool型
```
## Example
视图
```html
<form action="{{ route('login') }}" method="post">
    @csrf
    <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        @include('vendor/captcha/captcha')
    </div>
    <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Remember Me
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
    </div>
</form>
```
获取验证码
```php
Route::get('/getCaptcha', function () {
    $param = [
        'user_id' => '', //用户id 如果不填写 则会 使用str_random(10) 随机10位字符串
        'ip_address' => '' //用户请求验证时所携带的IP
    ];
   echo app('geetest')->StartCaptchaServlet($param);
});
```
验证
```php
dd(app('geetest')->VerifyCaptchaServlet());
```

## License

MIT