<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

#-----------------------------------------404页面---------------------------------------------
Route::rule('not_find','index/Notfind/index');
#-----------------------------------------404页面结束-----------------------------------------




#-----------------------------------------前台地址--------------------------------------------
Route::rule('/','index/Index/index');
Route::rule('/test','index/Index/test');
Route::rule('/agreement_user','index/Index/user');
Route::rule('/agreement_privacy','index/Index/privacy');
Route::rule('/cash_explain','index/Index/cash_explain');
Route::rule('/reg','index/Index/register');
Route::rule('/down','index/Index/down');
Route::rule('/my_info','index/Index/my_info');
//Route::rule('/yyshuahao','index/Index/shua');
Route::rule('/bug','index/Index/bug');
Route::rule('/chongzhi_transaction_yes_day','index/Index/chongzhi_transaction_yes_day');
Route::rule('/quxiao_danzi','index/Index/quxiao_danzi');
Route::rule('/meitianzidongfenhong','index/Index/meitianzidongfenhong');
Route::rule('/zuori_fenhong_num','index/Index/zuori_fenhong_num');
//Route::rule('/shua22','index/Index/shua22');
Route::rule('/genxinjiage','index/Index/genxinjiage');
Route::rule('/yangyang','index/Index/yangyang');
Route::rule('/push','index/Index/push');
#-----------------------------------------前台地址结束--------------------------------------------





#-----------------------------------------接口地址--------------------------------------------
Route::rule('api/common/code','api/Common/code');

//开通会员
//Route::rule('api/push','api/Push/push');

#-----------------------------------------接口地址结束--------------------------------------------





#-----------------------------------------后台地址--------------------------------------------
/**
 * 默认
 */
Route::rule('sun_admin','admin/Index/index');
Route::rule('sun_admin/test','admin/Index/test');
Route::rule('sun_admin/login','admin/Login/index');
Route::rule('sun_admin/checkLogin','admin/Login/checkLogin');
Route::rule('sun_admin/out','admin/Login/out');
Route::rule('sun_admin/self_page','admin/Index/self_page');
Route::rule('sun_admin/self_edit','admin/Index/self_edit');
Route::rule('sun_admin/asdasdasda','admin/Set/asdasdasda');
Route::rule('sun_admin/get_notice_add','admin/Set/get_notice_add');
Route::rule('sun_admin/get_help_add','admin/Set/get_help_add');
Route::rule('sun_admin/asdasd','admin/User/asdasd');
Route::rule('sun_admin/shua','admin/Index/shua');
Route::rule('sun_admin/shua2','admin/Index/shua2');
Route::rule('sun_admin/jinyan','admin/Index/jinyan');


/**
 * 配置
 */
Route::rule('sun_admin/xieyi','admin/Set/xieyi');
Route::rule('sun_admin/set','admin/Set/index');
Route::rule('sun_admin/set_edit_add','admin/Set/edit_add');
Route::rule('sun_admin/add_set','admin/Set/add');
Route::rule('sun_admin/set_edit_all','admin/Set/edit_all');
Route::rule('sun_admin/set_youxiang','admin/Set/set_youxiang');
Route::rule('sun_admin/set_robot_cont','admin/Set/set_robot_cont');
Route::rule('sun_admin/set_robot_ci','admin/Set/set_robot_ci');


/**
 * 上传图片
 */
Route::rule('sun_admin/upload','admin/Index/upload');
Route::rule('sun_admin/upload_alioos','admin/Index/upload_alioos');
Route::rule('sun_admin/upload_qiniu_ht','admin/Index/upload_qiniu_ht');//七牛云富文本
Route::rule('sun_admin/upload_qiniu_pt_ht','admin/Index/upload_qiniu_pt_ht');//七牛云普通
Route::rule('sun_admin/shopgoods_pho_upl','admin/Index/shopgoods_pho_upl');//七牛云 上传多图
Route::rule('sun_admin/shopgoods_pho_ali_upl','admin/Index/shopgoods_pho_ali_upl');//阿里 上传多图
Route::rule('sun_admin/upload_aliyun_ht_fwb','admin/Index/upload_aliyun_ht_fwb');//阿里云富文本

/**
 * 提现管理
 */
Route::rule('sun_admin/cash','admin/Cash/cash');
Route::rule('sun_admin/cash_edit','admin/Cash/edit');
Route::rule('sun_admin/cash_listEdit','admin/Cash/listEdit');
Route::rule('sun_admin/cash_export','admin/Cash/export');
Route::rule('sun_admin/cash_edit_shiming','admin/Cash/edit_shiming');
Route::rule('sun_admin/cash_edit_shibai','admin/Cash/edit_shibai');

Route::rule('sun_admin/orderxsexcel_out','admin/Cash/orderxsexcel_out');//提现首页
Route::rule('sun_admin/shopbkorderplfh_index','admin/Cash/shopbkorderplfh_index');//批量显示
Route::rule('sun_admin/shopbkorderplfh_upload','admin/Cash/shopbkorderplfh_upload');//批量 提交

/**
 * 用户管理
 */
Route::rule('sun_admin/user','admin/User/user');
Route::rule('sun_admin/user_online','admin/User/user_online');
Route::rule('sun_admin/get_user_info','admin/User/get_user_info');
Route::rule('sun_admin/user_login_status','admin/User/user_login_status');
Route::rule('sun_admin/user_team_login','admin/User/user_team_login');
Route::rule('sun_admin/user_zhi_login','admin/User/user_zhi_login');
Route::rule('sun_admin/user_jian_login','admin/User/user_jian_login');
Route::rule('sun_admin/user_jinri_login','admin/User/user_jinri_login');

Route::rule('sun_admin/daoruzhuce','admin/User/daoruzhuce');
Route::rule('sun_admin/daoruzhuce_upload','admin/User/daoruzhuce_upload');

Route::rule('sun_admin/get_user_logs','admin/User/get_user_logs');
Route::rule('sun_admin/user_all_add','admin/User/user_all_add');
Route::rule('sun_admin/user_all_add_edit','admin/User/user_all_add_edit');

Route::rule('sun_admin/user_all_del','admin/User/user_all_del');
Route::rule('sun_admin/user_all_del_edit','admin/User/user_all_del_edit');
Route::rule('sun_admin/user_pay_vip','admin/User/user_pay_vip');
Route::rule('sun_admin/user_del_vip','admin/User/user_del_vip');
Route::rule('sun_admin/user_del_vip_edit','admin/User/user_del_vip_edit');
Route::rule('sun_admin/user_pay_vip_edit','admin/User/user_pay_vip_edit');
Route::rule('sun_admin/user_song_ci','admin/User/user_song_ci');
Route::rule('sun_admin/user_song_ci_edit','admin/User/user_song_ci_edit');


Route::rule('sun_admin/get_user_wallet','admin/User/get_user_wallet');
Route::rule('sun_admin/user_huifu','admin/User/user_huifu');
Route::rule('sun_admin/user_gaihaoma','admin/User/user_gaihaoma');
Route::rule('sun_admin/user_add_jubao','admin/User/user_add_jubao');
Route::rule('sun_admin/user_cha_pid','admin/User/user_cha_pid');
Route::rule('sun_admin/user_edit','admin/User/user_edit');
Route::rule('sun_admin/user_edit_all','admin/User/user_edit_all');
Route::rule('sun_admin/user_huoyuedu','admin/User/user_huoyuedu');
Route::rule('sun_admin/add_dian','admin/User/add_dian');
Route::rule('sun_admin/user_add_receive_num','admin/User/add_receive_num');
Route::rule('sun_admin/user_shengji_daren','admin/User/user_shengji_daren');
Route::rule('sun_admin/user_shengji_plus','admin/User/user_shengji_plus');
Route::rule('sun_admin/user_set_shouma','admin/User/set_shouma');
Route::rule('sun_admin/user_set_paiming','admin/User/set_paiming');
Route::rule('sun_admin/user_set_paiming2','admin/User/set_paiming2');
Route::rule('sun_admin/user_set_daren','admin/User/set_daren');
Route::rule('sun_admin/user_set_guanfang','admin/User/set_guanfang');
Route::rule('sun_admin/user_set_shiming','admin/User/set_shiming');
Route::rule('sun_admin/user_set_shiming_edit','admin/User/set_shiming_edit');
Route::rule('sun_admin/user_set_guanliyuan','admin/User/set_guanliyuan');
Route::rule('sun_admin/user_auth','admin/User/shiming');
Route::rule('sun_admin/user_vip','admin/User/open_vip');
Route::rule('sun_admin/update_daren','admin/User/update_daren');
Route::rule('sun_admin/doudi','admin/User/doudi');
Route::rule('sun_admin/doudi_edit','admin/User/doudi_edit');
Route::rule('sun_admin/user_qingchu','admin/User/user_qingchu');
Route::rule('sun_admin/user_qingchu_edit','admin/User/user_qingchu_edit');
Route::rule('sun_admin/user_chazhi','admin/User/user_chazhi');
Route::rule('sun_admin/chadaquweima','admin/User/chadaquweima');
Route::rule('sun_admin/chadaquweima_edit','admin/User/chadaquweima_edit');
Route::rule('sun_admin/daoxu','admin/User/daoxu');
Route::rule('sun_admin/paixian','admin/User/paixian');
Route::rule('sun_admin/get_pay_info','admin/User/get_pay_info');
Route::rule('sun_admin/update_daren_di','admin/User/update_daren_di');
Route::rule('sun_admin/user_yc_set','admin/User/user_yc_set');
Route::rule('sun_admin/cha_login_ip','admin/User/cha_login_ip');
Route::rule('sun_admin/user_beizhu','admin/User/user_beizhu');//备注
Route::rule('sun_admin/login_ip','admin/User/login_ip');//一键封禁IP所注册的所有用户
Route::rule('sun_admin/get_bao','admin/User/get_bao');
Route::rule('sun_admin/chaxun_ip','admin/User/chaxun_ip');

/**
 * 分红
 */
Route::rule('sun_admin/fenhong','admin/Fenhong/index');
Route::rule('sun_admin/fenhong_edit','admin/Fenhong/edit');
Route::rule('sun_admin/fenhong_fen','admin/Fenhong/fenhong');
Route::rule('sun_admin/fenhong_log','admin/Fenhong/fenhong_log');
Route::rule('sun_admin/fenhong_listEdit','admin/Fenhong/fenhong_listEdit');
Route::rule('sun_admin/fenhong_edit22','admin/Fenhong/fenhong_edit');
Route::rule('sun_admin/fenhong_edit_hhr','admin/Fenhong/fenhong_edit_hhr');


/**
 * 包管理
 */
Route::rule('sun_admin/task_bao','admin/TaskBao/index');
Route::rule('sun_admin/task_bao_add','admin/TaskBao/task_bao_add');
Route::rule('sun_admin/task_bao_add_edit','admin/TaskBao/task_bao_add_edit');
Route::rule('sun_admin/task_bao_zd_edit','admin/TaskBao/task_bao_zd_edit');
Route::rule('sun_admin/beel_duihuan_log','admin/TaskBao/beel_duihuan_log');
Route::rule('sun_admin/bao_edit','admin/TaskBao/bao_edit');
Route::rule('sun_admin/bao_listEdit','admin/TaskBao/bao_listEdit');
Route::rule('sun_admin/bao_export','admin/TaskBao/bao_export');

/**
 * 价格管理
 */
Route::rule('sun_admin/price','admin/Price/index');
Route::rule('sun_admin/price_zd_edit','admin/Price/price_zd_edit');
Route::rule('sun_admin/price_add','admin/Price/price_add');
Route::rule('sun_admin/price_add_edit','admin/Price/price_add_edit');




/**
 * 订单管理
 */
Route::rule('sun_admin/order','admin/Order/order');
Route::rule('sun_admin/order_edit','admin/Order/order_edit');
Route::rule('sun_admin/order_quxiao','admin/Order/order_quxiao');
Route::rule('sun_admin/order_kan','admin/Order/kan');
Route::rule('sun_admin/order_kan_edit','admin/Order/kan_edit');
Route::rule('sun_admin/orderzongxsexcel_out','admin/Order/orderzongxsexcel_out');


/**
 * 藏品-系列
 */
Route::rule('sun_admin/cp_xl','admin/CangPin/xl');
Route::rule('sun_admin/cp_xl_edit','admin/CangPin/xl_edit');
Route::rule('sun_admin/cp_xl_add','admin/CangPin/xl_add');
Route::rule('sun_admin/cp_xl_add_edit','admin/CangPin/xl_add_edit');


Route::rule('sun_admin/cp_bq','admin/CangPin/bq');
Route::rule('sun_admin/cp_bq_edit','admin/CangPin/bq_edit');
Route::rule('sun_admin/cp_bq_add','admin/CangPin/bq_add');
Route::rule('sun_admin/cp_bq_add_sub','admin/CangPin/cp_bq_add_sub');
Route::rule('sun_admin/bq_edit_xs','admin/CangPin/bq_edit_xs');//编辑标显示
Route::rule('sun_admin/bq_edit_sub','admin/CangPin/bq_edit_sub');//编辑标签提交

Route::rule('sun_admin/cp_czz','admin/CangPin/czz');
Route::rule('sun_admin/add_czz','admin/CangPin/add_czz');//添加创作者显示
Route::rule('sun_admin/add_czz_sub','admin/CangPin/add_czz_sub');//添加创作者提交
Route::rule('sun_admin/czz_edit','admin/CangPin/czz_edit');//创作者编辑显示
Route::rule('sun_admin/czz_edit_sub','admin/CangPin/czz_edit_sub');//创作者编辑提交
Route::rule('sun_admin/czz_del','admin/CangPin/czz_del');//创作者删除


Route::rule('sun_admin/cp_fxf','admin/CangPin/fxf');
Route::rule('sun_admin/fxf_add','admin/CangPin/fxf_add');//添加发行方显示
Route::rule('sun_admin/fxf_add_sub','admin/CangPin/fxf_add_sub');//添加发行方提交
Route::rule('sun_admin/fxf_edit','admin/CangPin/fxf_edit');//发行方编辑显示
Route::rule('sun_admin/fxf_edit_sub','admin/CangPin/fxf_edit_sub');//发行方编辑提交
Route::rule('sun_admin/fxf_del','admin/CangPin/fxf_del');//发行方删除

Route::rule('sun_admin/cp_zz','admin/CangPin/zz');//铸造列表
Route::rule('sun_admin/zz_add','admin/CangPin/zz_add');//添加铸造显示
Route::rule('sun_admin/zz_add_sub','admin/CangPin/zz_add_sub');//添加铸造提交
Route::rule('sun_admin/zz_edit','admin/CangPin/zz_edit');//铸造编辑显示
Route::rule('sun_admin/zz_edit_sub','admin/CangPin/zz_edit_sub');//铸造编辑提交
Route::rule('sun_admin/zz_del','admin/CangPin/zz_del');//铸造删除
Route::rule('sun_admin/zz_selectnum','admin/CangPin/zz_selectnum');//铸造查看编号列表

/**
 * 转账管理
 */
Route::rule('sun_admin/zhuan','admin/JiaoYi/zhuan');



Route::rule('sun_admin/jiaoyi_tz','admin/JiaoYi/jiaoyi_tz');
Route::rule('sun_admin/jiaoyi_quxiao','admin/JiaoYi/jiaoyi_quxiao');

Route::rule('sun_admin/jiaoyi_pm','admin/JiaoYi/jiaoyi_pm');


//商品管理
Route::rule('sun_admin/shop_goods_label','admin/Shop/shop_goods_label');//商品标签列表
Route::rule('sun_admin/shop_goods_label_add','admin/Shop/shop_goods_label_add');//商品标签添加显示
Route::rule('sun_admin/shop_goods_label_add_sub','admin/Shop/shop_goods_label_add_sub');//商品标签添加提交
Route::rule('sun_admin/shop_goods_label_edit_sub','admin/Shop/shop_goods_label_edit_sub');//商品标签修改提交
Route::rule('sun_admin/shop_goods_label_edit_sub_yc','admin/Shop/shop_goods_label_edit_sub_yc');//商品标签修改隐藏提交

Route::rule('sun_admin/shop_goods','admin/Shop/shop_goods');//商品列表
Route::rule('sun_admin/shop_goods_add','admin/Shop/shop_goods_add');//添加商品显示
Route::rule('sun_admin/shop_goods_add_sub','admin/Shop/shop_goods_add_sub');//添加商品提交
Route::rule('sun_admin/shop_goods_edit','admin/Shop/shop_goods_edit');//商品编辑显示
Route::rule('sun_admin/shop_goods_edit_sub','admin/Shop/shop_goods_edit_sub');//商品编辑提交
Route::rule('sun_admin/shop_goods_del','admin/Shop/shop_goods_del');//商品删除

//抽签
Route::rule('sun_admin/shop_goodscq_add','admin/Shop/shop_goodscq_add');//添加商品显示

//订单列表
Route::rule('sun_admin/shop_order_list','admin/Shop/shop_order_list');//订单列表

//日志
Route::rule('sun_admin/log','admin/Log/log');

//日志
Route::rule('sun_admin/chazhitui','admin/User/chazhitui');
Route::rule('sun_admin/chaxunjinrizhitui','admin/User/chaxunjinrizhitui');


//装修管理

Route::rule('/upload_alioos','admin/Index/upload_ali_ht');//后台上传单图阿里云oss务器

Route::rule('sun_admin/gonggaolist','admin/Zhuangxiu/gonggaolist');//公告列表
Route::rule('sun_admin/gonggao_edit','admin/Zhuangxiu/gonggao_edit');//编辑公告提交
Route::rule('sun_admin/gonggao_insert','admin/Zhuangxiu/gonggao_insert');//添加公告显示
Route::rule('sun_admin/gonggao_insert_sub','admin/Zhuangxiu/gonggao_insert_sub');//添加公告提交
Route::rule('sun_admin/del_notice','admin/Zhuangxiu/del_notice');//删除公告
Route::rule('sun_admin/edit_neirogn','admin/Zhuangxiu/edit_neirogn');//编辑公告内容显示
Route::rule('sun_admin/edit_neirogn_sub','admin/Zhuangxiu/edit_neirogn_sub');//编辑公告内容提交

Route::rule('sun_admin/zx_index','admin/Zhuangxiu/zx_index');//轮播图
Route::rule('sun_admin/zx_lbt_sub','admin/Zhuangxiu/zx_lbt_sub');//轮播图提交
Route::rule('sun_admin/zx_lbt_sub_data','admin/Zhuangxiu/zx_lbt_sub_data');//轮播图提交

/**
 * 话费
 */

Route::rule('sun_admin/phone','admin/Phone/index');
Route::rule('sun_admin/phone_ok','admin/Phone/phone_ok');
Route::rule('sun_admin/phone_err','admin/Phone/phone_err');

//转盘管理
Route::rule('sun_admin/zhuanpan_list','admin/Zhuanpan/zhuanpan_list');//转盘列表
Route::rule('sun_admin/zhuanpan_edit','admin/Zhuanpan/zhuanpan_edit');//转盘编辑显示
Route::rule('sun_admin/zhuanpan_edit_sub','admin/Zhuanpan/zhuanpan_edit_sub');//转盘编辑提交
Route::rule('sun_admin/zhuanpan_add','admin/Zhuanpan/zhuanpan_add');//转盘添加显示
Route::rule('sun_admin/zhuanpan_add_sub','admin/Zhuanpan/zhuanpan_add_sub');//转盘添加提交
Route::rule('sun_admin/zhuanpan_delete_sub','admin/Zhuanpan/zhuanpan_delete_sub');//删除抽奖商品

//扑满管理
Route::rule('sun_admin/puman_address_list','admin/Puman/puman_address_list');//扑满-地址管理
Route::rule('sun_admin/puman_address_add','admin/Puman/puman_address_add');//扑满-地址添加-显示
Route::rule('sun_admin/puman_address_add_sub','admin/Puman/puman_address_add_sub');//扑满-地址添加-提交
Route::rule('sun_admin/puman_address_zt_sub2','admin/Puman/puman_address_zt_sub2');//扑满-状态修改-提交
Route::rule('sun_admin/puman_address_del','admin/Puman/puman_address_del');//删除
Route::rule('sun_admin/puman_hash_list','admin/Puman/puman_hash_list');//扑满-hash
Route::rule('sun_admin/puman_hash_add','admin/Puman/puman_hash_add');//扑满-地址添加-显示
Route::rule('sun_admin/puman_hash_add_sub','admin/Puman/puman_hash_add_sub');//扑满-地址添加-提交
Route::rule('sun_admin/puman_hash_del','admin/Puman/puman_hash_del');//删除
Route::rule('sun_admin/puman_hash_edit','admin/Puman/puman_hash_edit');//删除
Route::rule('sun_admin/puman_shuhui_list','admin/Puman/puman_shuhui_list');//扑满赎回列表
Route::rule('sun_admin/puman_shuhui_sub','admin/Puman/puman_shuhui_sub');//扑满赎回编辑提交
Route::rule('sun_admin/out_sh_list','admin/Puman/out_sh_list');//扑满赎回导出
Route::rule('sun_admin/out_cb_list','admin/Puman/out_cb_list');//扑满储备导出


//通证回收
Route::rule('sun_admin/tz_huishou_list','admin/Tongzheng/tz_huishou_list');//通证回收列表
Route::rule('sun_admin/tz_huishou_sub','admin/Tongzheng/tz_huishou_sub');//通证回收编辑提交
Route::rule('sun_admin/out_tz_hs_list','admin/Tongzheng/out_tz_hs_list');//导出


//商家管理
Route::rule('sun_admin/offline_list','admin/Offline/offline_list');
Route::rule('sun_admin/offline_data','admin/Offline/offline_data');
Route::rule('sun_admin/offline_data_sub','admin/Offline/offline_data_sub');
Route::rule('sun_admin/offline_xiaxian_sub','admin/Offline/offline_xiaxian_sub');//强制下线
Route::rule('sun_admin/bangbang_list','admin/Offline/bangbang_list');//帮帮列表
Route::rule('sun_admin/bangbang_delete','admin/Offline/bangbang_delete');
Route::rule('sun_admin/add_bangbang','admin/Offline/add_bangbang');
Route::rule('sun_admin/add_bangbang_sub','admin/Offline/add_bangbang_sub');
Route::rule('sun_admin/editdata','admin/Offline/editdata');//修改承兑

//IM管理
Route::rule('sun_admin/redwrap_list','admin/Redwrap/redwrap_list');//红包列表
Route::rule('sun_admin/redwrap_edit','admin/Redwrap/redwrap_edit');//红包处理


Route::rule('sun_admin/huafei_order_list','admin/Huafei/huafei_order_list');//话费订单
Route::rule('sun_admin/dianying_order_list','admin/Dianying/dianying_order_list');//电影订单
Route::rule('sun_admin/huafei_sub','admin/Huafei/huafei_sub');//话费-强制退款


//重置人脸次数
Route::rule('sun_admin/auth_shibai_do','admin/User/auth_shibai_do');
//清理环信token用户表
Route::rule('sun_admin/del_hunaxin_token','admin/User/del_hunaxin_token');

Route::rule('sun_admin/out_dianying_list','admin/Dianying/out_dianying_list');//导出电影
Route::rule('sun_admin/out_huafei_list','admin/Huafei/out_huafei_list');//导出话费


/**
 * 权限管理
 */
Route::rule('sun_admin/admindata','admin/Admindata/admindataindex');//管理员列表
Route::rule('sun_admin/adminrole','admin/Adminrole/adminroleindex');//角色列表
Route::rule('sun_admin/adminnode','admin/Adminnode/adminnodeindex');//节点列表
//角色
Route::rule('sun_admin/adminrole_roleedit','admin/Adminrole/adminrole_roleedit');//角色的权限节点分配页面
Route::rule('sun_admin/adminrole_roleeditsub','admin/Adminrole/adminrole_roleeditsub');//角色的权限节点分配页面提交
Route::rule('sun_admin/adminrole_roleadd','admin/Adminrole/adminrole_roleadd');//添加角色页面
Route::rule('sun_admin/adminrole_roleaddsub','admin/Adminrole/adminrole_roleaddsub');//添加角色提交
Route::rule('sun_admin/adminrole_roleeditdata','admin/Adminrole/adminrole_roleeditdata');//编辑角色页面
Route::rule('sun_admin/adminrole_roleeditdatasub','admin/Adminrole/adminrole_roleeditdatasub');//编辑角色页面提交
Route::rule('sun_admin/adminrole_roledel','admin/Adminrole/adminrole_roledel');//角色删除
//节点
Route::rule('sun_admin/adminnode_nodeedit','admin/Adminnode/adminnode_nodeedit');//编辑节点页面
Route::rule('sun_admin/adminnode_nodeeditsub','admin/Adminnode/adminnode_nodeeditsub');//编辑节点提交
Route::rule('sun_admin/adminnode_nodeadd','admin/Adminnode/adminnode_nodeadd');//添加节点页面
Route::rule('sun_admin/adminnode_nodeaddsub','admin/Adminnode/adminnode_nodeaddsub');//添加节点页面提交
Route::rule('sun_admin/adminnode_nodedel','admin/Adminnode/adminnode_nodedel');//节点删除
Route::rule('sun_admin/admin_node_xiaji','admin/Adminnode/admin_node_xiaji');//下级节点列表
//管理员
Route::rule('sun_admin/admindata_dataedit','admin/Admindata/admindata_dataedit');//管理员编辑
Route::rule('sun_admin/admindata_dataeditsub','admin/Admindata/admindata_dataeditsub');//管理员编辑 //管理员编辑提交
Route::rule('sun_admin/admindata_dataadd','admin/Admindata/admindata_dataadd');//添加管理员
Route::rule('sun_admin/admindata_dataaddsub','admin/Admindata/admindata_dataaddsub');//添加管理员提交
#-----------------------------------------后台地址结束--------------------------------------------










