<?php

namespace App\Models;

class site_infoModel extends \CodeIgniter\Model
{
    protected $table = 'site_info';
    public function GetSiteInfo($slug = false)
    {
        if ($slug === false)
        {
                return $this->findAll();
        }

        return $this->asArray()->where(['id' => $slug])->first();
    }
}