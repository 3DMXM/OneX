<?php
namespace App\Models;
use App\ThirdParty\onedrive;
use App\ThirdParty\oneindex;
use App\ThirdParty\fetch;
use CodeIgniter\I18n\Time;

class seoModel extends \CodeIgniter\Model{
    protected $table = 'seo';

    /**
     * 获取SEO
     * @param false $slug 目录
     * @return array|object|null
     */
    static function GetSEO($slug = false){
        $seoModel = new seoModel();
        if ($slug === false)
        {
            return $seoModel->findAll();
        }

        return $seoModel->asArray()->where(['seo_parent' => $slug])->first();
    }

    /**
     * 设置DEO
     * @param $seo_parent
     * @param $data
     */
    static function SetSEO($seo_parent, $data){
        $db = db_connect();
        $builder = $db->table('seo');
        $builder->where('seo_parent',$seo_parent);
        $builder->update($data);
        $db->close();
    }

    /**
     * 添加SEO
     * @param $data
     */
    static function AddSEO($data){
        $db = db_connect();
        $builder = $db->table('seo');
        $builder->insert($data);
        $db->close();
    }

    /**
     * 添加游览量
     * seo_click_cnt
     */
    static function AddSEOClickCnt($seo_parent){
        $seoModel = new seoModel();
        $old = $seoModel->GetSEO($seo_parent);
        $click = $old['seo_click_cnt'] + 1;

        $db = db_connect();
        $builder = $db->table('seo');
        $builder->where('seo_parent',$seo_parent);
        $builder->set("seo_click_cnt",$click);
        $builder->update();
        $db->close();
    }



}