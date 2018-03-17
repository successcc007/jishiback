<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/17
 * Time: 16:36
 */

namespace app\index\controller;


class PushConfig
{
    /*save config
    *parameter:country,province,city,startTimeHour,startTimeMinute,endTimeHour,endTimeMinute,interval
    */
    public function Save(Request $request)
    {
        if ($request->post()) {
            $country = $_POST['country'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $startTimeHour = $_POST['startTimeHour'];
            $startTimeMinute = $_POST['startTimeMinute'];
            $endTimeHour = $_POST['endTimeHour'];
            $endTimeMinute = $_POST['endTimeMinute'];
            $interval = $_POST['interval'];
            $push = Db::table('tbl_push')->where("city", "=", "$city")->find();
            if (!empty($push) && $push['country'] = $country && $push['province'] = $province) {
                $id = $push['id'];
                $rst = Db::table('tbl_push')->where(array('id' => $id))->update(['$startTimeHour' => $startTimeHour, 'startTimeMinute' => $startTimeMinute, 'endTimeHour' => $endTimeHour, 'endTimeMinute' => $endTimeMinute, 'intervalMinutes' => $interval]);
                if ($rst) {
                    $msg = array(
                        "code" => "10001",
                        "msg" => "更新成功"
                    );
                    echo json_encode($msg);
                    die;
                }
            } else {
                $new['country'] = $country;
                $new['province'] = $province;
                $new['city'] = $city;
                $new['startTimeHour'] = $startTimeHour;
                $new['startTimeMinute'] = $startTimeMinute;
                $new['endTimeHour'] = $endTimeHour;
                $new['endTimeMinute'] = $endTimeMinute;
                $new['interval'] = $interval;
                $new['intervalMinutes'] = $interval;
                $res = Db::table('tbl_push')->insert($new);
                if ($res) {
                    $msg = array(
                        "code" => "10001",
                        "msg" => "设置成功"
                    );
                    echo json_encode($msg);
                    die;
                }
            }
        }
    }
}