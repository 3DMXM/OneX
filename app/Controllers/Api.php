<?php
namespace App\Controllers;
use App\Models\filelistModel;
use App\Models\site_infoModel;
use App\ThirdParty\onedrive;

class Api extends BaseController {
    public function GetAllFile($path = "/"){
        // set_time_limit(0);

        // // $path = $request->getPost("path");
        // $site_infoModel = new site_infoModel();
        // $site_info = $site_infoModel->GetSiteInfo(1);  
        // $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5

        $filelistModel = new filelistModel();
        
        $filelistModel->GetFileDataByParent($path);

        echo "写入目录完毕!";
    }

    public function ShowFile(){

        $filelistModel = new filelistModel();
        $list = $filelistModel->GetFileDataByParent();

        print_r($list);
    }

}


