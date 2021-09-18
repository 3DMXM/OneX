<?php
use App\Models\filelistModel;
use App\Models\site_infoModel;
use App\ThirdParty\onedrive;

function GetAllFile($path = "/Games"){
    set_time_limit(0);
    echo "123";

    // $path = $request->getPost("path");
    // $site_infoModel = new site_infoModel();
    // $site_info = $site_infoModel->GetSiteInfo(1);  
    // $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5

    $filelistModel = new filelistModel();
    
    $filelistModel->SetFileDaa($path);

    echo "写入目录完毕!";
}


array_shift($argv);
if($argc==0)
	  echo "here is no args";
  else
	  echo $argc;
  
  print_r($argv);

GetAllFile();