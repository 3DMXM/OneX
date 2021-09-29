<?php

namespace App\Controllers;
use App\Models\filelistModel;
use App\Models\site_infoModel;
use App\ThirdParty\onedrive;
use CodeIgniter\Model;

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

        $type = 'other';

        if($path != "/"){
            // "%20" => " "
            // 转义url中的特殊字符
            $path = rawurldecode($path);
            $path = "/{$path}";
            // 获取标题
            $SEO = $filelistModel->GetFileTitle($path);
            $type = $filelistModel->CheckingFolder($path);
            $path .= "/";
        }else{
            $SEO = $filelistModel->GetFileTitle($path);
            $type = 'folder';
        }

        // 如果有下载指令
        if ($d = $this->request->getGet('d') == 'true'){
            $this->DownloadFile($path);
            return;
        }


        $path = str_replace("//", "/", $path);
        // 获取当前目录中的文件
        $FileList = $filelistModel->GetFileDataByParent($path); 

        // print_r($path);

        // 列表导航
        $navs = explode("/",$path);
        $navs = array_filter($navs); 
        // array_shift($navs);

        // readme
        $readme  = false;
        $audio = false;
        foreach($FileList as $i=>$val){
            if(in_array("README.md",$val)){
                $readme = $filelistModel->GetFileContent($val);
                unset($FileList[$i]);
            }
            if (site_infoModel::GetFileType($val['file_type']) == 'audio'){
                $audio[] = $val;
            }
        }
               
        $data = [
            'path' => $path,
            'files' => $FileList,
            'SEO' => $SEO,
            'site_info' => $site_info,
            'navs' => $navs,
            'readme' => $readme,
            'audio' => $audio,
        ];

        echo view('Templates/Header', $data);

        $path = substr($path, 0, -1);
        switch ($type){
            case "folder": echo view('Pages/list', $data); break;
            case "image":
                $data['imgUrl'] = $filelistModel->GetFileDownloadUrl($path, false);
                echo view('Pages/show/image', $data);
                break;

            case "video":
                $site_info = site_infoModel::GetSiteInfo(1);

                $data['thumb'] = onedrive::thumbnail($site_info['onedrive_root'].$path);
                $data['url'] = $filelistModel->GetFileDownloadUrl($path, false);
                echo view('Pages/show/video', $data);
                break;

            case "audio":
                $data['url'] = $filelistModel->GetFileDownloadUrl($path, false);
                echo view('Pages/show/audio', $data);
                break;

            case "code":

                echo view('Pages/show/code', $data);
                break;

            default:
                $this->DownloadFile($path);
                break;

        }

        echo view('Templates/Footer');
    }


    public function DownloadFile($path)
    {
        $filelistModel = new filelistModel();
        $site_info = site_infoModel::GetSiteInfo(1);
        $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5

        $downloadUrl = $filelistModel->GetFileDownloadUrl($path);

        header('Location: '.$downloadUrl);
        exit();
    }


}