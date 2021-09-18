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
    public function GetSiteInfo($slug = false)
    {
        if ($slug === false)
        {
            return $this->findAll();
        }

        return $this->asArray()->where(['id' => $slug])->first();
    }

    /**
     * 设置网站信息
     * @param int $id
     * @param array $data
     */
    public function SetSiteInfo(int $id = 1, array $data = array()){
        $db = db_connect();
        $builder = $db->table('site_info');
        $builder->where(['id' => $id,]);
        $builder->update($data);
        $db->close();
    }
}