<?php
namespace app\index\controller;

use think\Controller;
class Notfind extends Controller
{
    //404页面
    public function index()
    {
        return $this->fetch();
    }
}
