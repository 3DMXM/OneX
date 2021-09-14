<?php

namespace App\Controllers;
use App\Models\filelistModel;
use App\Models\tokenModel;
use App\Models\site_infoModel;
use App\ThirdParty\onedrive;

class Files extends BaseController {

    public function view()
    {        
        // $this->cachePage(600);

        // 引用文件相关类
        $filelistModel = new filelistModel();
         // 获取目录
        $path = $this->request->uri->getPath();

        // 站点属性
        $site_infoModel = new site_infoModel();
        $site_info = $site_infoModel->GetSiteInfo(1);  

        if($path != "/"){
            // "%20" => " "
            // 转义url中的特殊字符
            $path = rawurldecode($path);
            $path = "/{$path}";
            // 获取标题
            $title = $filelistModel->GetFileTitle($path);  
            if(!$filelistModel->CheckingFolder($path)){
                // 如果不是文件夹 而是文件
                // 直接下载文件去
                $this->DownloadFile($path);
                return false;
            }
            $path .= "/";
        }else{
            $title = $filelistModel->GetFileTitle($path);
        }
        $path = str_replace("//", "/", $path);
        // 获取当前目录中的文件
        $FileList = $filelistModel->GetFileDataByParent($path); 

        print_r($path);

        // 列表导航
        $navs = explode("/",$path);
        $navs = array_filter($navs); 
        // array_shift($navs);

        // readme
        $readme  = false;
        foreach($FileList as $i=>$val){
            if(in_array("README.md",$val)){
                $readme = $filelistModel->GetFileContent($val);
                unset($FileList[$i]);
            }
        }
               
        $data = [
            'files' => $FileList,
            'title' => $title,
            'site_info' => $site_info,
            'navs' => $navs,
            'readme' => $readme 
        ];

        echo view('Templates/Header', $data);

        echo view('Pages/list', $data);

        echo view('Templates/Footer');
    }


    public function DownloadFile($path)
    {
        $filelistModel = new filelistModel();
        $site_infoModel = new site_infoModel();
        $site_info = $site_infoModel->GetSiteInfo(1);  
        $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5

        $downloadUrl = $filelistModel->GetFileDownloadUrl($path);

        header('Location: '.$downloadUrl);
        exit();
    }


}