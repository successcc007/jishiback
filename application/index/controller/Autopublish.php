<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/14
 * Time: 6:55
 */

namespace app\index\controller;
include_once "CurlMethod.php";


class AutoPublish
{

    /*
     * 登录
     * 参数：用户名,密码
     * */
    public function LoginIn(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {

            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $data_login = array(
                'loginAttempt' => 'true',
                'lang' => 'en-us',
                'return' => '',
                'site' => '',
                'ad' => '',
                //'rememberMe' => 'remember',
                //'email' => 'bp1@biteveryday.com',
                //'password' => 'Ped.,_eo123'
                'email' => $username,
                'password' => $password
            );
            $cookie = dirname(__FILE__) . "/" . 'cookieSave.txt'; //设置cookie保存的路径
            $url_login = "https://my.backpage.com/classifieds/central/index";
            $rs_login = $curl->login_post($url_login, $cookie, $data_login);
            if (!$rs_login) {
                $result = array(
                    "code" => "10001",
                    "msg" => "login fail"
                );
            } else {
                $result = array(
                    "code" => "10002",
                    "msg" => "login succeed"
                );
            }
            echo json_encode($result);
            die;
        }
    }

    /*
     * 城市选择
     * 参数：城市，cookie
     * $city = "Seattle"
     * $cookie = $_POST['cookie']
     * */
    public function  CitySelect(Request $request)
    {
        $curl = new CurlMethod();
        $url_allCity = "http://www.backpage.com/";
        if ($request->isPost()) {
            $city = $_POST['city'];
            $cookie = $_POST['cookie'];
            $content_allCity = $curl->get_content($url_allCity, $cookie);
            if (empty($content_allCity)) {
                $result = array(
                    "code" => "20001",
                    "msg" => "allcity fail"
                );
            } else {
                $pattern_City = "/<a href=\"(.*)?\">" . $city . "<\/a>/";
                preg_match_all($pattern_City, $content_allCity, $arr_City);
                $url_city = $arr_City[1][0];
                if (empty($url_city)) {
                    $result = array(
                        "code" => "21001",
                        "msg" => "city url fail"
                    );
                } else {
                    $result = array(
                        "code" => "21002",
                        "msg" => "city url success",
                        "data" => $url_city
                    );
                }
            }
        } else {
            $result = array(
                "code" => "20000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
     * ad
     *parameter：cookie，url_city
    */
    public function AdPost(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {
            $url_city = $_POST['url_city'];
            $cookie = $_POST['cookie'];
            $content_city = $curl->get_content($url_city, $cookie);
            if (empty($content_city)) {
                $result = array(
                    "code" => "30001",
                    "msg" => "city fail"
                );
            } else {
                $pattern_ad_url = "/<form name=\"formPost\" id=\"formPost\" action=\"(.*)?\" method=\"get\">/";
                $pattern_ad_u = "/<input type=\"hidden\" name=\"u\" value=\"(.*)?\">/";
                $pattern_ad_serverName = "/<input type=\"hidden\" name=\"serverName\" value=\"(.*)?\">/";
                preg_match_all($pattern_ad_url, $content_city, $arr_ad);
                preg_match_all($pattern_ad_u, $content_city, $arr_ad_u);
                preg_match_all($pattern_ad_serverName, $content_city, $arr_ad_serverName);
                $url_ad = $arr_ad[1][0];
                $data_u = $arr_ad_u[1][0];
                $data_serverName = $arr_ad_serverName[1][0];
                $data_ad = array(
                    'u' => $data_u,
                    'serverName' => $data_serverName
                );
                $data = array(
                    'url_ad' => $url_ad,
                    'data_ad' => $data_ad
                );
                $result = array(
                    "code" => "30002",
                    "msg" => "city succeed",
                    "data" => $data
                );
            }
        } else {
            $result = array(
                "code" => "20000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
     * dating
     * parameter:cookie,url_ad,data_ad,section
     * $section = 'dating';
     * */

    public function SectionSelect(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {
            $cookie = $_POST['cookie'];
            $section = $_POST['section'];
            $url_ad = $_POST['url_ad'];
            $data_ad = $_POST['data_ad'];
            $content_ad = $curl->get_content_post($url_ad, $cookie, $data_ad);
            if (empty($content_ad)) {
                $result = array(
                    "code" => "40001",
                    "msg" => "ad fail"
                );
            } else {
                $pattern_dating_url = "/<a href=\"(.*)?\" data-section=\"(.*)?\" data-name=\"" . $section . "\">" . $section . "<\/a>/";
                preg_match_all($pattern_dating_url, $content_ad, $arr_dating);
                $url_dating = substr($url_ad, 0, strpos($url_ad, '.com') + 4) . $arr_dating[1][0];
                $result = array(
                    "code" => "40002",
                    "msg" => "ad susccess",
                    "data" => $url_dating
                );
            }
        } else {
            $result = array(
                "code" => "40000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
     * Category
     * women man
     * parameter:category,cookie,url_dating,url_ad
     *$category = 'women seeking men';
    */
    public function CategorySelect(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {
            $cookie = $_POST['cookie'];
            $url_ad = $_POST['url_ad'];
            $category = $_POST['category'];
            $url_dating = $_POST['url_dating'];
            $content_dating = $curl->get_content($url_dating, $cookie);
            if (empty($content_dating)) {
                $result = array(
                    "code" => "50001",
                    "msg" => "dating fail"
                );
            } else {
                echo 'dating succeed<br>';
                $pattern_women_men_url = "/<a href=\"(.*)?\" data-category=\"(.*)?\" data-name=\"" . $category . "\" data-useRegions=\"yes\" data-disclaimer=\"yes\">" . $category . "<\/a>/";
                preg_match_all($pattern_women_men_url, $content_dating, $arr_women_men);
                $url_women_men = substr($url_ad, 0, strpos($url_ad, '.com') + 4) . $arr_women_men[1][0];
                $result = array(
                    "code" => "50002",
                    "msg" => "dating success",
                    "data" => $url_women_men
                );
            }
        } else {
            $result = array(
                "code" => "50000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
     * location
     * parameter:cookie,url_women_men,location,url_ad
     * $location = 'Bellingham';
    */
    public function LocationSelect(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {
            $cookie = $_POST['cookie'];
            $url_ad = $_POST['url_ad'];
            $location = $_POST['location'];
            $url_women_men = $_POST['url_women_men'];
            $content_women_men = $curl->get_content($url_women_men, $cookie);
            if (empty($content_women_men)) {
                $result = array(
                    "code" => "60001",
                    "msg" => "location fail "
                );
            } else {
                $pattern_location = "/<a href=\"(.*)?\" data-superRegion=\"" . $location . "\" data-multiple=\"no\">" . $location . "<\/a>/";
                preg_match_all($pattern_location, $content_women_men, $arr_location);
                $url_local = substr($url_ad, 0, strpos($url_ad, '.com') + 4) . $arr_location[1][0];
                $result = array(
                    "code" => "60002",
                    "msg" => "location success",
                    "data" => $url_local
                );
            }
        } else {
            $result = array(
                "code" => "60000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
     * continue_1
     * parameter:cookie,url_local
     * */
    public function continue_1(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {
            $cookie = $_POST['cookie'];
            $url_local = $_POST['url_local'];
            $content_local_1 = $curl->get_content($url_local, $cookie);
            if (empty($content_local_1)) {
                $result = array(
                    "code" => "70001",
                    "msg" => "local_1 fail"
                );
            } else {
                $pattern_continue_1_url = "/<a href=\"(.*)?\">here<\/a>/is";
                preg_match_all($pattern_continue_1_url, $content_local_1, $arr_continue_1);
                $url_continue_1 = $arr_continue_1[1][0];
                $result = array(
                    "code" => "70002",
                    "msg" => "local_1 success",
                    "data" => $url_continue_1
                );
            }
        } else {
            $result = array(
                "code" => "70000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
    * continue_1
    * parameter:cookie,url_continue_1
    * */
    public function continue_2(Request $request)
    {
        $curl = new CurlMethod();
        if ($request->isPost()) {
            $cookie = $_POST['cookie'];
            $url_continue_1 = $_POST['url_continue_1'];
            $content_local = $curl->get_content($url_continue_1, $cookie);
            if (empty($content_local)) {
                $result = array(
                    "code" => "80001",
                    "msg" => "local fail"
                );
            } else {
                $pattern_continue_url = "/<form name=\"formDisclaimer\" method=\"post\" action=\"(.*)?\">/";
                $pattern_continue_disc = "/<input type=\"hidden\" name=\"disc\" value=\"(.*)?\">/";
                $pattern_continue_category = "/<input type=\"hidden\" name=\"category\" value=\"(.*)?\">/";
                $pattern_continue_section = "/<input type=\"hidden\" name=\"section\" value=\"(.*)?\">/";
                $pattern_continue_serverName = "/ <input type=\"hidden\" name=\"serverName\" value=\"(.*)?\">/";
                $pattern_continue_superRegion = "/<input type=\"hidden\" name=\"superRegion\" value=\"(.*)?\">/";
                $pattern_continue_u = "/<input type=\"hidden\" name=\"u\" value=\"(.*)?\">/";
                preg_match_all($pattern_continue_url, $content_local, $arr_continue);
                preg_match_all($pattern_continue_disc, $content_local, $arr_disc);
                preg_match_all($pattern_continue_category, $content_local, $arr_category);
                preg_match_all($pattern_continue_section, $content_local, $arr_section);
                preg_match_all($pattern_continue_serverName, $content_local, $arr_serverName);
                preg_match_all($pattern_continue_superRegion, $content_local, $arr_superRegion);
                preg_match_all($pattern_continue_u, $content_local, $arr_u);
                $url_continue = $arr_continue[1][0];
                $data_disc = $arr_disc[1][0];
                $data_category = $arr_category[1][0];
                $data_section = $arr_section[1][0];
                $data_serverName = $arr_serverName[1][0];
                $data_superRegion = $arr_superRegion[1][0];
                $data_u = $arr_u[1][0];
                $data_continue = array(
                    'disc' => $data_disc,
                    'category' => $data_category,
                    'section' => $data_section,
                    'serverName' => $data_serverName,
                    'superRegion' => $data_superRegion,
                    'u' => $data_u
                );
                $data = array(
                    "url_continue" => $url_continue,
                    "data_continue" => $data_continue
                );
                $result = array(
                    "code" => "80002",
                    "msg" => "local success",
                    "data" => $data
                );
            }
        } else {
            $result = array(
                "code" => "80000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }

    /*
     * publish_1 todu
     * parameter:cookie,url_continue_1
     * */
    public function  publish_1(Request $request)
    {
        $curl = new CurlMethod();
        $url_allCity = "http://www.backpage.com/";
        if ($request->isPost()) {
            $city = $_POST['city'];
            $cookie = $_POST['cookie'];
            $content_allCity = $curl->get_content($url_allCity, $cookie);
            if (empty($content_allCity)) {
                $result = array(
                    "code" => "20001",
                    "msg" => "allcity fail"
                );
            } else {
                $pattern_City = "/<a href=\"(.*)?\">" . $city . "<\/a>/";
                preg_match_all($pattern_City, $content_allCity, $arr_City);
                $url_city = $arr_City[1][0];
                if (empty($url_city)) {
                    $result = array(
                        "code" => "21001",
                        "msg" => "city url fail"
                    );
                } else {
                    $result = array(
                        "code" => "21002",
                        "msg" => "city url success",
                        "data" => $url_city
                    );
                }
            }
        } else {
            $result = array(
                "code" => "20000",
                "msg" => "非post请求"
            );
        }
        echo json_encode($result);
        die;
    }
}