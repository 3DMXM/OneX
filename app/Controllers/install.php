<?php
namespace App\Controllers;
use CodeIgniter\Model;


class install extends  BaseController{

    public function index(){

        $tab = $this->request->getGet('tab');

        if (empty($tab)){
            $tab = 1;
        }

        $title = "数据库配置";
        switch ($tab){
            case 1: $title = "数据库配置"; break;
            case 2: $title = "网站配置"; break;
            case 3: $title = "账号绑定"; break;
            case 4: $title = "其他杂项"; break;
        }

        $data = array(
            'tab' => $tab,
            'title' => $title
        );

        echo view('install/install', $data);
    }

}