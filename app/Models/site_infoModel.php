<?php

namespace App\Models;

class site_infoModel extends \CodeIgniter\Model
{
    protected $table = 'site_info';

    /**
     * 获取文章信息
     * @param false $slug
     * @return array|object|null
     */
    static function GetSiteInfo($slug = false)
    {
        $site_infoModel = new site_infoModel();

        if ($slug === false)
        {
            return $site_infoModel->findAll();
        }

        return $site_infoModel->asArray()->where(['id' => $slug])->first();
    }

    /**
     * 设置网站信息
     * @param int $id
     * @param array $data
     */
    static function SetSiteInfo(int $id = 1, array $data = array()){
        $db = db_connect();
        $builder = $db->table('site_info');
        $builder->where(['id' => $id,]);
        $builder->update($data);
        $db->close();
    }

    /**
     * 通过文件后缀获取获取文件类型
     * @param string $type 文件类型
     * @return string
     */
    static function GetFileType(string $type): string
    {
        $info = site_infoModel::GetSiteInfo(1);

        $type = str_replace(".",'',$type);

        if ($type == 'folder'){
            return 'folder';
        }

        $show_image = explode(" ", $info['show_image']);
        if (in_array($type, $show_image)){
            return 'image';
        }

        $show_video = explode(" ", $info['show_video']);
        if (in_array($type, $show_video)){
            return 'video';
        }

        $show_audio = explode(" ", $info['show_audio']);
        if (in_array($type, $show_audio)){
            return 'audio';
        }

        $show_code = explode(" ", $info['show_code']);
        if (in_array($type, $show_code)){
            return 'code';
        }

        $show_code2 = explode(" ", $info['show_code2']);
        if (in_array($type, $show_code2)){
            return 'code2';
        }

        $show_doc = explode(" ", $info['show_doc']);
        if (in_array($type, $show_doc)){
            return 'doc';
        }

        return 'other';
    }
}