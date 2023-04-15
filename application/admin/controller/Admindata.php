<?php
namespace app\admin\controller;

use app\common\model\VyangAdminPush;
use think\Db;
use think\Request;
use think\Loader;

/**
 * 权限管理
 * Class Admindata
 * @package app\admin\controller
 */
class Admindata extends Common
{
    protected $pid;
    /**
     * 初始加载
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //加载是否选中
        $this->assign('active','22');
    }

    public function admindataindex()
    {
        // 查询用户数据 并且每页显示10条数据
        $map     = [];
        $order = 'id desc';

        $list = PageSeach('admin', $map,[], $order, '10', false, Request::instance()->param());

        if (!empty($list))
        {
            $listall = $list->all();//【重点】 将分页数据转成实际数据数组，否则不能修改
            $page = $list->render();
            $a1 = ['0' => '禁止登录','1' => '允许登录' ];

            foreach ($listall as $k => $v)
            {
                $listall[$k]['auth'] = $a1[$v['status']];
                $listall[$k]['addtime'] = replaceTime($v['addtime']);
                //查询权限名称
                $listall[$k]['role_id'] = Db::name('admin_role')->where(['id' => $v['role_id']])->value('role_name');
            }
            $listall = _xss($listall);
        }else{
            $listall = [];
            $page = '';
        }


        // 把分页数据赋值给模板变量list
        $this->assign('user', $listall);
        $this->assign('show', $page);

        return $this->fetch();
    }
    /**
     * 管理员编辑
     */
    public function admindata_dataedit()
    {
        $type = $this->request->get('type',0);
        $this->assign('type',$type);
        $res = Db::name('admin')->where(['id' => $type])->find();

        //查询角色列表
        $role_all = Db::name('admin_role')->where([])->select();

        $this->assign('res', _xss($res));
        $this->assign('role_all', _xss($role_all));

        return $this->fetch();
    }
    /**
     * 管理员编辑提交
     */
    public function admindata_dataeditsub(){

        $type = $this->request->post('type',0);
        $username = $this->request->post('username','');
        $password = $this->request->post('password','');
        $phone = $this->request->post('phone','');
        $email = $this->request->post('email','');
        $status = $this->request->post('status',1);
        $title = $this->request->post('title','');
        $role_id = $this->request->post('role_id',0);

        $upd = [];

        if (!empty($password))
        {
            $pwd = password_hash($password,PASSWORD_DEFAULT);
            $upd['password'] = $pwd;
            if(mb_strlen($password,'UTF8') < 8){
                ajaxError('密码至少8位字母\数字');
            }
        }

        if($username && mb_strlen($username,'UTF8') < 4){
            ajaxError('账号至少4位中文或英文');
        }

        if(in_array($username,['administrator','admin','chad',])){
            ajaxError('不可编辑！');
        }else{
            //$upd['username'] = $username;
            $upd['phone'] = $phone;
            $upd['email'] = $email;
            $upd['status'] = $status;
            $upd['title'] = $title;
            $upd['role_id'] = $role_id;
        }

        $res = Db::name('admin')->where('id', $type)->update($upd);

        if($res)
        {
            ajaxSuccess('操作成功');
        }else{
            ajaxError('操作失败！');
        }
    }

    /**
     * 管理员添加
     */
    public function admindata_dataadd(){
        //查询角色列表
        $role_all = Db::name('admin_role')->where([])->select();
        $this->assign('role_all', _xss($role_all));
        return $this->fetch();
    }

    /**
     * 管理员添加提交
     */
    public function admindata_dataaddsub(){

        $username = $this->request->post('username','');
        $password = $this->request->post('password','');
        $phone = $this->request->post('phone','');
        $email = $this->request->post('email','');
        $status = $this->request->post('status','');
        $role_id = $this->request->post('role_id','');
        $title = $this->request->post('title','');

        $pwd = password_hash($password,PASSWORD_DEFAULT);

        if (empty($username) || empty($password))
        {
            ajaxError('账号和密码不能为空！');
        }
        if (empty($role_id))
        {
            ajaxError('权限不能为空');
        }
        if($role_id == '1'){ajaxError('不可添加超级管理员');}

        if(mb_strlen($username,'UTF8') < 4 || mb_strlen($password,'UTF8') < 8){
            ajaxError('账号至少4位中文或英文，密码至少8位字母\数字');
        }

        //查询重名
        $cf = Db::name('admin')->where(['username' => ['eq',$username]])->value('username');
        if(!empty($cf))
        {
            ajaxError('用户名已存在！');
        }

        $upd = [
            'username' => $username,
            'title' => $title,
            'password' => $pwd,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
            'role_id' => $role_id,
            'addtime' => time()
        ];

        $res = Db::name('admin')->insert($upd);

        if($res)
        {
            ajaxSuccess('操作成功');
        }else{
            ajaxError('操作失败！');
        }
    }

}
