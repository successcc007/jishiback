<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/14
 * Time: 6:55
 */

namespace app\index\controller;
include_once "CurlMethod.php";


class Autopublish
{

    /*
     * 登录
     * 传递用户名,密码
     * */
    public function LoginIn(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {

            $data_login = array(
                'loginAttempt' => 'true',
                'lang' => 'en-us',
                'return' => '',
                'site' => '',
                'ad' => '',
          //    'rememberMe' => 'remember',
                'email' => 'bp1@biteveryday.com',
                'password' => 'Ped.,_eo123'
            );
            $cookie = dirname(__FILE__) . "/" . 'cookie.txt'; //设置cookie保存的路径

            $url_login = "https://my.backpage.com/classifieds/central/index";
            $rs_login = $curl->login_post($url_login, $cookie, $data_login);
            if (!$rs_login) {
                echo 'login fail';
            } else {
                echo 'login succeed';
            }
            echo '<br>';
        }
    }


}