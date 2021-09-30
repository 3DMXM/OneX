<?php
namespace App\Models;
class downloadurlModel extends \CodeIgniter\Model
{
    protected $table = 'downloadurl';
    public function GetDataForPath($path = false)
    {
        if ($path === false)
        {
            return $this->findAll();
        }

        return $this->asArray()->where([
            'file_path' => $path
        ])->first();
    }

    // 添加下载地址
    static function AddData($data = array())
    {
        $db = db_connect();
        $builder = $db->table('downloadurl');
        $builder->insert($data);
        $db->close();
    }

    // 更新下载地址
    static function SetData($path = "", $data = array())
    {
        $db = db_connect();
        $builder = $db->table('downloadurl');
        $builder->where([
           'file_path' => $path 
        ]);
        $builder->update($data);
        $db->close();
    }

}