<?php

namespace App\Models;
use App\ThirdParty\onedrive;
use App\ThirdParty\oneindex;
use App\ThirdParty\fetch;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class filelistModel extends \CodeIgniter\Model
{
    protected $table = 'filelist';

    public function getFileData($slug = false)
    {
        if ($slug === false)
        {
                return $this->findAll();
        }

        return $this->asArray()->where(['id' => $slug])->first();
    }

    // 前台 通过 父级目录获取 子集
    public function GetFileDataByParent($path = "/"){
        $site_infoModel = new site_infoModel();
        $site_info = $site_infoModel->GetSiteInfo(1);  
        $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5

        $FileList = $this->asArray()->where(['file_parent' => $path])->orderBy('file_type','DESC')->distinct('file_name')->findAll();

        if(empty($FileList)){
            // 如果数据库未找到数据
            // 调用API 寻找数据
            $newList = onedrive::dir($path);
            $this->AddFileDataList($newList, $path);
        }else{
            // 如果有，检查是否过期
            if($this->CheckingTime($FileList[0]['file_up_time'])){
//                echo "过期，尝试重新获取";
                // 如果过期则重新获取
                $newList = onedrive::dir($path);
                if(!empty($newList)){
                    // 如果获取成功
                    // 删除旧数据
                    $db = db_connect();
                    $builder = $db->table('filelist');
                    $builder->where(['file_parent'=> $path]);
                    $builder->delete();
                    $db->close();

                    $this->AddFileDataList($newList, $path);
                }else{
//                    print_r($newList);
                }
            }
        }
       
        return $this->asArray()->where(['file_parent' => $path])
            ->orderBy('file_type','DESC')->orderBy('file_name','ASC')
            ->distinct('file_name')->findAll();
    }

    // 获取标题目录标题
    public function GetFileTitle($path){
        $site_infoModel = new site_infoModel();
        $site_info = $site_infoModel->GetSiteInfo(1);
//        if($path == "/"){
//            return $site_info['site_name'];
//        }
//        $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5
//
//        $name = substr(strrchr($path, '/'), 1);         // 文件或文件夹名
//        $file_parent = str_replace($name, "", $path);   // 父级目录
//
//        $data = $this->asArray()->where([
//            'file_parent' => $file_parent,
//            'file_name' => $name
//        ])->first();
        $SEO = seoModel::GetSEO($path);

        if (!empty($SEO)){
            seoModel::AddSEOClickCnt($path);    // 如果有,添加一次访问量
        }


        $SEO['seo_title'] = !empty($SEO['seo_title'])?"{$SEO['seo_title']} - {$site_info['site_name']}":"{$path} - {$site_info['site_name']}";
        $SEO['seo_keywords'] = empty($SEO['seo_keywords']) ?"":$SEO['seo_keywords'];
        $SEO['seo_description'] = empty($SEO['seo_description']) ?"":$SEO['seo_description'];

        return $SEO;

//        return !empty($data['file_title'])?"{$data['file_title']} - {$site_info['site_name']}":"{$path} - {$site_info['site_name']}";

    }

    // 清空目录
    public function EmptyFileList($file_parent){
        if(empty($file_parent)){
            // 参数为空，不执行操作
            return;
        }

        $db = db_connect();
        $builder = $db->table('filelist');

        $FileList = $this->GetFileDataByParent($file_parent);

        foreach($FileList as $val){            
            $builder->where(['file_parent'=> $val['file_parent']]);
            $builder->delete();
            if($val['file_type'] == "folder"){
                $this->EmptyFileList("{$file_parent}/{$val['file_name']}");
            }
        }
        $db->close();
    }

    // 写入新的文件
    public function AddFileData($data = array()){
        $db = db_connect();
        $builder = $db->table('filelist');
        $builder->insert($data);
        $db->close();
    }

    // 写入列表文件
    public function AddFileDataList($List = array(), $path="")
    {
        foreach($List as $val){
            $time = new Time('now','Asia/Shanghai');
            $data = array(
                'file_parent' => $path,
                'file_name' => $val['name'],
                'file_type' => $val['type'],
                'file_size' => $val['size'],
                'file_path' => $path.$val['name'],
                'file_time' => $val['lastModifiedDateTime'],
                'file_downloadUrl' => $val['downloadUrl'],
                'file_up_time' => $time->toLocalizedString()
            );
            $this->AddFileData($data);
        }
    }

    // 通过父级目录更新目录内容
    public function SetFileDaa($file_parent, $data = array()){
        $db = db_connect();
        $builder = $db->table('filelist');

        $checking = $this->GetFileDataByParent($file_parent);
        if(!empty($checking)){
            // 如果目录不为空，清空目录相关内容，重新写入
            $this->EmptyFileList($file_parent);
        }

        // 通过API 获取目录内容
        $onedrive = new onedrive();
        $FileList = $onedrive->dir($file_parent);
        foreach($FileList as $val){
            $data = array(
                'file_parent' => $file_parent,
                'file_name' => $val['name'],
                'file_type' => $val['type'],
                'file_size' => $val['size'],
                'file_path' => $file_parent.$val['name'],
                'file_time' => $val['lastModifiedDateTime'],
                'file_downloadUrl' => $val['downloadUrl'],
                'file_up_time' => new Time('now','Asia/Shanghai'),
            );
            $this->AddFileData($data);

            echo "{$file_parent}{$val['name']}/";

            if($val['type'] == "folder"){
                // 如果是目录，递归写入
                $this->SetFileDaa("{$file_parent}{$val['name']}/");

            }
        }
        $db->close();
    }

    // 获取文件内容
    public function GetFileContent($file){

        $file_dataModel = new file_dataModel();

        $path = "";
        $isMd = false;
        if (!empty($file['file_parent'])){
            // 判断文件是否大于10MB
            if($file['file_size'] > 10485760){
                return false;
            }
            $isMd = true;
            // 如果传递的是文件数组
            $path = $file['file_parent'].$file['file_name'];
        }else{
            $path = $file;
        }

        $SqlData = $file_dataModel->GetFileDataForPath($path);

        if(!empty($SqlData)){
            // 如果数据库中存在
            if($this->CheckingTime($SqlData['file_time'])){
                // 如果数据已过期
                // 重新获取
                $DownloadUrl = $this->GetFileDownloadUrl($path, $isMd);
                $resp = fetch::get($DownloadUrl);
                if($resp->http_code == 200){
                    // 如果获取成功 更新数据库
                    $content = $resp->content;
                    if($content != ""){
                        $data = array(
                            'file_data' => $content,
                            'file_time' =>  new Time('now','Asia/Shanghai'),
                            'file_download_url' => $DownloadUrl
                        );
                        $file_dataModel->SetFileData($path, $data);
                    }
                    return $content;
                }else{
                    // 如果获取失败，返回旧的数据
                    return $SqlData['file_data'];
                }
            }
            $content = $SqlData['file_data'];
            return $content;
        }else{
            $DownloadUrl = $this->GetFileDownloadUrl($path, $isMd);
            $resp = fetch::get($DownloadUrl);
            if($resp->http_code == 200){
                $content = $resp->content;
                if($content != ""){
                    $data = array(
                        'file_path' => $path,
                        'file_data' => $content,
                        'file_time' =>  new Time('now','Asia/Shanghai'),
                        'file_download_url' => $DownloadUrl
                    );
                    $file_dataModel->AddFileData($data);
                }
                return $content;
            }else{
                // 获取失败，返回空
                return "";
            }
        }
    }

    // 获取文件下载地址
    public function GetFileDownloadUrl($file, $isroot = true){
        // 虽然有缓存下载地址
        // 但通过下载地址下载文件也会调用API
        // 导致依然会出现调用频繁的问题

        if (!$isroot){
            $site_info = site_infoModel::GetSiteInfo(1);
            $file = $site_info['onedrive_root'].$file;  // 如 /GTA5 则是 /Games/GTA5
        }

        $fileData = $this->asArray()->where(['file_path' => $file])->first();
        if (!empty($fileData['file_downloadUrl'])){
            // 优先获取 filelist 里面的下载地址
            if ($this->CheckingTime($fileData['file_up_time'])){
                // 如果缓存过期，重新获取
                // 注：OneDrive的下载地址过期时间为1小时，
                $downloadUrl = oneindex::download_url($file);
                if(!empty($downloadUrl)){
                    // 如果获取成功
                    $data = array(
                        'file_download_url' => $downloadUrl,
                        'file_up_time' => new Time('now','Asia/Shanghai')
                    );
                    downloadurlModel::SetData($file, $data);

                    return $downloadUrl;
                }else{
                    // 如果获取失败
                    // 返回旧的地址
                    return $fileData['file_downloadUrl'];
                }
            }
            // 没有则返回最新的
            return  $fileData['file_downloadUrl'];
        }


        $downloadurlModel = new downloadurlModel();
        $fileData = $downloadurlModel->GetDataForPath($file);

        if(!empty($fileData)){
            // 如果有缓存
            if($this->CheckingTime($fileData['file_up_time'])){
                // 如果缓存过期 重新获取
                // 注：OneDrive的下载地址过期时间为1小时，
                $downloadUrl = oneindex::download_url($file);
                if(!empty($downloadUrl)){
                    // 如果获取成功
                    $data = array(
                        'file_download_url' => $downloadUrl,
                        'file_up_time' => new Time('now','Asia/Shanghai')
                    );
                    downloadurlModel::SetData($file, $data);
                   
                    return $downloadUrl;
                }else{
                    // 如果获取失败
                    // 返回旧的地址
                    return $fileData['file_download_url'];
                }                
            }
            // 如果没过期 则直接返回缓存
            return $fileData['file_download_url'];
        }
        
        $downloadUrl = oneindex::download_url($file);
        if(!empty($downloadUrl)){
            $data = array(
                'file_path' => $file,
                'file_download_url' => $downloadUrl,
                'file_up_time' => new Time('now','Asia/Shanghai')
            );            
            $downloadurlModel->AddData($data);
            return $downloadUrl;
        }else{
            echo "下载地址获取失败,请稍后再试！";
        }
    }

    // 判断是否是文件夹
    public function CheckingFolder($path){
        if($path == "/"){
            return true;
        }

        $site_info = site_infoModel::GetSiteInfo(1);
        $path = $site_info['onedrive_root'].$path;  // 如 /GTA5 则是 /Games/GTA5

        $name = substr(strrchr($path, '/'), 1);         // 文件或文件夹名
        $file_parent = str_replace($name, "", $path);   // 父级目录

        $data = $this->asArray()->where([
            'file_parent' => $file_parent,
            'file_name' => $name
        ])->first();

        if(empty($data)){
            // 如果为空 返回404
            // http_response_code(404);
            return 'folder';
        }

        return site_infoModel::GetFileType($data['file_type']);

//        if($data['file_type'] != "folder"){
//            return false;
//        }else{
//            return true;
//        }
    }

    // 检查是否过期
    public function CheckingTime($time = 0){
        $site_infoModel = new site_infoModel();
        $info = $site_infoModel->GetSiteInfo(1);
        $expireTime = $info['cache_expire_time'];

        $nowTime = new Time('now','Asia/Shanghai');
        $nowTime = strtotime($nowTime);
        $time = strtotime($time);
        $t0 = $nowTime - $time;

        if($t0 >= $expireTime){
            return true;
        }else{
            return false;
        }

        // echo "{$nowTime}\n{$time}\n{$t0}";
    }

    // 获取缓存目录列表
    public function CacheList($parent){
        $site_infoModel = new site_infoModel();
        $site_info = $site_infoModel->GetSiteInfo(1);
        $parent = $site_info['onedrive_root'].$parent;  // 如 /GTA5 则是 /Games/GTA5
        // file_parent
        $newList = onedrive::dir($parent);

        if(!empty($newList)){
            // 获取成功
            // 删除旧数据
            $db = db_connect();
            $builder = $db->table('filelist');
            $builder->where(['file_parent'=> $parent]);
            $builder->delete();
            $db->close();

            $this->AddFileDataList($newList, $parent);

            return true;
        }else{
            // 获取失败
            return false;
        }

        
    }

}
