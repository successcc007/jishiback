<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
use think\Route;

Route::rule('/api/v1/user/register','User/register');  //用户注册
Route::rule('/api/v1/user/login','User/login');//用户登录
Route::rule('/api/v1/user/loginout','User/loginout');//用户登出
Route::rule('/api/v1/user/loginstatus','User/login_status');//用户登陆状态（无法使用）
Route::rule('/api/v1/user/checkuser','User/check_user');//检查用户类型 （技师/客户）
Route::rule('/api/v1/index/getinfo','Index/select_js');//查询单个技师详情
Route::rule('/api/v1/index/getjsall','Index/select_all');//查询所有技师
Route::rule('/api/v1/index/getjs','Index/select_tj');//根据地区、价格、评分查询技师
Route::rule('/api/v1/order/createorder','Order/order');//生成订单
Route::rule('/api/v1/order/update/providertime','Order/update_provider_arrived_time');//更新技师到达时间
Route::rule('/api/v1/order/update/starttime','Order/update_provider_start_time');//更新技师出发时间
Route::rule('/api/v1/order/update/customertime','Order/update_customer_arrive_time');//更新客户到达时间
Route::rule('/api/v1/order/update/cancelorder','Order/cancel_order');//取消订单
Route::rule('/api/v1/order/update/orderstatus','Order/order_status');//订单状态
Route::rule('/api/v1/order/update/comfirmpay','Order/confirm_pay');//确认最终付款
Route::rule('/api/v1/order/select/orderall','Order/order_list');//查询用户的所有订单
Route::rule('/api/v1/order/select/orderprovider','Order/order_provider_list');//查询技师的所有订单
//Route::rule('/api/v1/order/insert/customercomment','Order/customer_comment');//客户对此次订单发表评论
Route::rule('/api/v1/index/select/country','Index/country_list');//查询所有国家
Route::rule('/api/v1/index/select/province','Index/province_list');//查询所有对应国家下的所有省份
Route::rule('/api/v1/index/select/city','Index/city_list');//查询所有对应省份下的所有城市
Route::rule('/api/v1/index/select/studio','Index/studio_list');//查询所有对应城市下的所有工作室
Route::rule('/api/v1/index/insert/comment','Index/comment');//发表评论
Route::rule('/api/v1/index/select/jscomments','Index/comment_list');//该技师收到的所有评论
Route::rule('/api/v1/index/update/customerscore','Order/customer_score');//技师给客户评分
Route::rule('/api/v1/index/update/providerscore','Order/provider_score');//客户给技师评分
Route::rule('/api/v1/index/select/imglist','Index/provider_img_list');//查询技师的详情图片

Route::rule('/api/v1/autoPublish/publish','AutoPublish/publish');//自动发帖
Route::rule('/api/v1/autoPublish/save','PushConfig/Save');//自动发帖





