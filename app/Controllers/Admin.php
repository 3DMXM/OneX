<?php
namespace App\Controllers;
use App\Models\filelistModel;
use App\Models\seoModel;
use App\Models\tokenModel;
use App\Models\site_infoModel;
use App\Models\userModel;
use App\ThirdParty\onedrive;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController{

    public function index($page = "index")
    {
        if(!userModel::CheckingLogin()){
            // 如果未登录 跳转到登录页面
            header('Location: /~admin/login');
            exit();
        }

        if ($page == "index"){
            $page = "install";
        }
        if (!file_exists(APPPATH.'Views/Admin/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            throw PageNotFoundException::forPageNotFound("{$page}页面不存在");
        }
        $site_infoModel = new site_infoModel();


        $data = array(
            'title' => '后台首页',
            'page' => $page,
        );

        switch ($page){
            case 'install':
                // 基础设置
                $site_name = $this->request->getPost("site_name");
                $onedrive_root = $this->request->getPost("onedrive_root");
                $cache_expire_time = $this->request->getPost("cache_expire_time");
                $password = $this->request->getPost('password');
                if(!empty($site_name) && !empty($onedrive_root) && !empty($cache_expire_time)){
                    // 如果都不为空
                    // 更新数据
                    $updata = array(
                        'site_name' => $site_name,
                        'onedrive_root' => $onedrive_root,
                        'cache_expire_time' => $cache_expire_time,
                    );
                    if(!empty($password)){
                        $password = MD5(MD5($password));
                        $nowUser = userModel::CheckingLogin();
                        userModel::UpUserPassword($nowUser['id'], $password);

                    }
                    $site_infoModel->SetSiteInfo(1,$updata);
                    $data['msg'] = "保存成功";
                }
                $data['site_info'] = $site_infoModel->GetSiteInfo(1);

                break;

            case 'cache':
                // 目录缓存
                $filelistModel = new filelistModel();
                $parent = $this->request->getPost("cache_path");
                if(!empty($parent)){
                    $parent .= '/';
                    // 如果目录不为空
                    // 更新指定目录的缓存                   
                    $CacheType = $filelistModel->CacheList($parent);
                    if($CacheType){
                        $data['msg'] = "缓存更新成功";
                    }else{
                        $data['msg'] = "缓存更新失败";
                    }
                }
                break;
            case 'show':
                // 显示设置

                $updata = array(
                    'show_image' => $this->request->getPost('show_image'),
                    'show_video' => $this->request->getPost('show_video'),
                    'show_audio' => $this->request->getPost('show_audio'),
                    'show_code' => $this->request->getPost('show_code'),
                    'show_code2' => $this->request->getPost('show_code2'),
                    'show_doc' => $this->request->getPost('show_doc'),
                );
                if (!empty($updata['show_image'])){
                    // 如果不为空
                    // 更新数据
                    $site_infoModel->SetSiteInfo(1,$updata);
                    $data['msg'] = "保存成功";
                }


                $data['site_info'] = $site_infoModel->GetSiteInfo(1);

                break;
            case 'SEO':
                // 路径SEO
                $seoModel = new seoModel();
                $data['list'] = $seoModel->GetSEO();

                break;
        }
        

        // 渲染页面
        echo view("/Admin/base/header.php",$data);
        echo view("/Admin/index", $data);
        echo view("/Admin/base/footer.php", $data);

    }

    public function login(){
        if(!empty(userModel::CheckingLogin())){
            // 如果已登录，直接跳转到后台
            header('Location: /~admin');
        }

        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        $data = array(
            'title' => ' 登录'
        );

        if(!empty($username) && !empty($password)){
            $userModel = new userModel();
            if($userModel->Login($username, $password)){
                // 登录成功
                header('Location: /~admin/index');
            }else{
                $data['msg'] = "用户名或密码错误";
                $data['username'] = $username;
            }
        }
        echo view("/Admin/base/header.php",$data);
        echo view('Admin/Login', $data);
        echo view("/Admin/base/footer.php", $data);

    }


}

