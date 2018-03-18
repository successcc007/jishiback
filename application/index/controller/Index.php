<?php
namespace app\index\controller;

use think\Db;
use think\Request;

class Index
{
    /*
     * 查询单个技师信息
     * @id  技师id
     * return  json  技师信息
     */
    public function select_js(Request $request)
    {
        if ($request->isGet()) {
            $id = isset($_GET['jid']) ? $_GET['jid'] : '';
            if (empty($id)) {  //判断是否传技师id
                $result = array(
                    "code" => "30013",
                    "msg" => "缺少参数"
                );
                echo json_encode($result);
                die;
            }
            $js_info = Db::table('tbl_c_provider')->where("i_id", "=", $id)->find();
            if (empty($js_info)) {
                $result = array(
                    "code" => "10009",
                    "msg" => "没有对应的技师信息"
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    "code" => "20003",
                    "msg" => "查询成功",
                    "info" => $js_info
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $msg = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($msg);
            die;
        }
    }

    /*按城市获取技师列表*/
    public function select_js_bycity(Request $request)
    {
        if ($request->isPost()) {
            $idCity = $_POST['city'];
            $idStudio = Db::table('tbl_c_studio')->where(array('i_city_id' => $idCity))->select();
            if (count($idStudio)>0) {
                $len = count($idStudio);
                $servers=array();
                for ($i = 0; $i < $len; $i++) {
                    $servers[]=Db::table('tbl_c_provider')->where(array('i_studio_id'=>$idStudio[$i]['i_id']))->select();
                }

                if(count($servers)>0){
                    $result=array(
                        "code"=>"10006",
                        "msg"=>"查询成功",
                        "data"=>$servers
                    );
                    echo json_encode($result);die;
                }else{
                    $result=array(
                        "code"=>"10006",
                        "msg"=>"查询技师失败"
                    );
                    echo json_encode($result);die;
                }

            }else{
                $result=array(
                    "code"=>"10006",
                    "msg"=>"查询工作室失败"
                );
                echo json_encode($result);die;
            }
        }else{
            $result=array(
                "code"=>"10006",
                "msg"=>"非POST方法"
            );
            echo json_encode($result);die;
        }

    }

    /*
     * @request     请求对象
     * @country     国家
     * @province    省份
     * @city        城市
     * @studio      工作室
     * return       返回json （二维数组转换）
     * function     通过地区筛选技师
     */
    public function select_tj(Request $request)
    {
        if ($request->isGet()) {
//            $country=isset($_GET['country'])?$_GET['country']:'Japan';
//            $province=isset($_GET['province'])?$_GET['province']:'';
//            $city=isset($_GET['city'])?$_GET['city']:'';
            $studio = isset($_GET['studio']) ? $_GET['studio'] : '';
            $price = isset($_GET['price']) ? $_GET['price'] : '';
            $score = isset($_GET['score']) ? $_GET['score'] : '';
            $type = isset($_GET['type']) ? $_GET['type'] : '';//服务类型（in/out）
            if (!empty($price) && $price == 1) {
                $p_sort = "i_price desc";
            } else if (!empty($price) && $price == 2) {
                $p_sort = "i_price asc";
            } else {
                $p_sort = "";
            }
            if (!empty($score) && $score == 1) {
                $s_sort = "i_score desc";
            } else if (!empty($score) && $score == 2) {
                $s_sort = "i_score asc";
            } else {
                $s_sort = "";
            }
            if (!empty($p_sort) && !empty($s_sort)) {
                $sort = "  order BY " . $p_sort . ',' . $s_sort;
            } else if (!empty($p_sort) && empty($s_sort)) {
                $sort = "  order BY " . $p_sort;
            } else if (empty($p_sort) && !empty($s_sort)) {
                $sort = "  order BY " . $s_sort;
            } else {
                $sort = "";
            }

            if (!empty($studio)) {
//                $sql="SELECT g.* FROM tbl_c_provider AS g LEFT JOIN (SELECT e.* FROM tbl_c_studio AS e LEFT JOIN (select d.* from tbl_c_city AS d LEFT  JOIN  (select b.* from tbl_c_country AS  a LEFT JOIN tbl_c_province AS b ON a.i_id=b.i_country_id) AS c
// ON d.i_province_id=c.i_id) AS f ON e.i_city_id=f.i_id) AS f ON g.i_studio_id=f.i_id WHERE g.i_studio_id=$studio and g.i_type='$type' and
// g.s_nation='$country' ORDER  BY".$sort;
                if (empty($type)) {
                    $type = "";
                } else {
                    $type = " and i_type='$type'";
                }
                $sql = "select * from tbl_c_provider where i_studio_id=$studio" . $type . $sort;
                $js_info = Db::query($sql);
                if (!empty($js_info)) {
                    $result = array(
                        "code" => "20004",
                        "msg" => "查询成功",
                        "info" => $js_info
                    );
                    echo json_encode($result);
                    die;
                } else {
                    $result = array(
                        "code" => "10009",
                        "msg" => "没有对应的信息"
                    );
                    echo json_encode($result);
                    die;
                }
            } else {
                $result = array(
                    "code" => "10080",
                    "msg" => "参数不能为空"
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $msg = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($msg);
            die;
        }
    }

    /*
     * @request  请求对象
     * function  查询所有技师
     */
    public function select_all(Request $request)
    {
        if ($request->isGet()) {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            if (empty($type)) {
                $result = array(
                    "code" => "30014",
                    "msg" => "缺少参数"
                );
                echo json_encode($result);
                die;
            }
            if ($type == 1) {
                $js_list = Db::table('tbl_c_provider')->order('i_score desc')->limit(10)->select();
            } else {
                $js_list = Db::table('tbl_c_provider')->order('i_score asc')->limit(10)->select();
            }
            if (empty($js_list)) {
                $result = array(
                    "code" => "30015",
                    "msg" => "暂时还没有技师，请联系管理员"
                );
                echo json_encode($result);
                die;
            } else {
                $result['code'] = 40003;
                $result['msg'] = "查询成功";
                $result['info'] = $js_list;
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     * @request  请求对象
     * function  查询所有国家
     * return   json
     */
    public function country_list(Request $request)
    {
        if ($request->isGet()) {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            if ($type == 'country') {
                $clist = Db::table('tbl_c_country')->select();
                if (empty($clist)) {
                    $result = array(
                        "code" => "30016",
                        "msg" => "暂时没有数据"
                    );
                    echo json_encode($result);
                    die;
                } else {
                    $result = array(
                        "code" => "40004",
                        "msg" => "查询成功",
                        "info" => $clist
                    );
                    echo json_encode($result);
                    die;
                }
            } else {
                $result = array(
                    "code" => "40070",
                    "msg" => "参数有误"
                );
                echo json_encode($result);
                die;
            }

        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     * @request  请求对象
     * function  查询所有省份
     * return   json
     */
    public function province_list(Request $request)
    {
        if ($request->isGet()) {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $province_id = isset($_GET['province_id']) ? $_GET['province_id'] : '';//获取省份id
            if ($type == 'province') {
                $clist = Db::table('tbl_c_province')->where(array('i_country_id' => $province_id))->select();//查询该国家下的所有城市
                if (empty($clist)) {
                    $result = array(
                        "code" => "30016",
                        "msg" => "暂时没有数据"
                    );
                    echo json_encode($result);
                    die;
                } else {
                    $result = array(
                        "code" => "40005",
                        "msg" => "查询成功",
                        "info" => $clist
                    );
                    echo json_encode($result);
                    die;
                }
            } else {
                $result = array(
                    "code" => "40070",
                    "msg" => "参数有误"
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     * @request  请求对象
     * function  查询所有城市
     * return   json
     */
    public function city_list(Request $request)
    {
        if ($request->isGet()) {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $city_id = isset($_GET['city']) ? $_GET['city'] : '';//获取城市id
            if ($type == 'city') {
                $clist = Db::table('tbl_c_city')->where(array('i_province_id' => $city_id))->select();//查询该国家下的所有城市
                if (empty($clist)) {
                    $result = array(
                        "code" => "30016",
                        "msg" => "暂时没有数据"
                    );
                    echo json_encode($result);
                    die;
                } else {
                    $result = array(
                        "code" => "40006",
                        "msg" => "查询成功",
                        "info" => $clist
                    );
                    echo json_encode($result);
                    die;
                }
            } else {
                $result = array(
                    "code" => "40070",
                    "msg" => "参数有误"
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     * @request  请求对象
     * function  查询所有工作室
     * return   json
     */
    public function studio_list(Request $request)
    {
        if ($request->isGet()) {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $studio_id = isset($_GET['studio_id']) ? $_GET['studio_id'] : '';//获取工作室id
            if ($type == 'studio') {
                $clist = Db::table('tbl_c_studio')->where(array('i_city_id' => $studio_id))->select();//查询该城市下所有的工作室
                if (empty($clist)) {
                    $result = array(
                        "code" => "30016",
                        "msg" => "暂时没有数据"
                    );
                    echo json_encode($result);
                    die;
                } else {
                    $result = array(
                        "code" => "40007",
                        "msg" => "查询成功",
                        "info" => $clist
                    );
                    echo json_encode($result);
                    die;
                }
            } else {
                $result = array(
                    "code" => "40070",
                    "msg" => "参数有误"
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     * @request  请求对象
     * function  发表对技师的评论
     * return   json
     */
    public function comment(Request $request)
    {
        if ($request->isPost()) {
            $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';//客户id
            $provider_id = isset($_POST['provider_id']) ? $_POST['provider_id'] : '';//技师id
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $create_time = time();
            if (empty($customer_id)) {
                $result = array(
                    "code" => "30019",
                    "msg" => "缺少参数"
                );
                echo json_encode($result);
                die;
            }
            if (empty($provider_id)) {
                $result = array(
                    "code" => "30020",
                    "msg" => "缺少参数"
                );
                echo json_encode($result);
                die;
            }
            if (empty($content)) {
                $result = array(
                    "code" => "30021",
                    "msg" => "请填写评论内容"
                );
                echo json_encode($result);
                die;
            }
            $res = Db::table("tbl_comment")->where(array('provider_id' => $provider_id))->insert(['customer_id' => $customer_id, 'provider_id' => $provider_id, 'content' => $content, 'create_time' => $create_time]);
            if ($res) {
                $result = array(
                    "code" => "40009",
                    "msg" => "发表成功"
                );
                json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     *@request 请求对象
     * @provider_id  技师id
     * function  查询技师所有的评论
     * return json
     */
    public function comment_list(Request $request)
    {
        if ($request->isGet()) {
            $provider_id = isset($_GET['pid']) ? $_GET['pid'] : '';
            if (empty($provider_id)) {
                $result = array(
                    "code" => "30017",
                    "msg" => "缺少参数"
                );
                echo json_encode($result);
                die;
            }
            $com_list = Db::table('tbl_comment')->where(array("provider_id" => $provider_id))->select();
            if (empty($com_list)) {
                $result = array(
                    "code" => "30018",
                    "msg" => "该技师暂时还没有收到评论",
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    "code" => "40008",
                    "msg" => "查询成功",
                    "info" => $com_list
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }
    }

    /*
     * @request 请求对象
     * @provider_id 技师ID
     * function 查询技师的详情图片
     */
    public function provider_img_list(Request $request)
    {
        if ($request->isGet()) {
            $provider_id = isset($_GET['provider_id']) ? $_GET['provider_id'] : '';
            if (empty($provider_id) || !is_numeric($provider_id)) {
                $result = array(
                    "code" => "20080",
                    "msg" => "参数为空或类型有误"
                );
                echo json_encode($result);
                die;
            }
            $imgs = Db::table('tbl_c_provider_img')->where(array('provider_id' => $provider_id))->select();//查询技师的所有详情图片
            if (empty($imgs)) {
                $result = array(
                    "code" => "20081",
                    "msg" => "该技师暂时未上传图片"
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    "code" => "20082",
                    "msg" => "查询成功",
                    "info" => $imgs
                );
                echo json_encode($result);
                die;
            }
        } else {
            $method = $request->method();
            $result = array(
                "code" => "10005",
                "msg" => "不支持" . $method . "请求"
            );
            echo json_encode($result);
            die;
        }

    }

}
