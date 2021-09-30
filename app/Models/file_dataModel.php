<?php

namespace App\Models;

class file_dataModel extends \CodeIgniter\Model
{
    protected $table = 'file_data';
    public function GetFileDataForPath($file_path = false)
    {
        if ($file_path === false)
        {
                return $this->findAll();
        }

        return $this->asArray()->where([
            'file_path' => $file_path
        ])->first();
    }

    static function SetFileData($file_path, $data = array()){
        $db = db_connect();
        $builder = $db->table('file_data');
        $builder->where([
           'file_path' => $file_path 
        ]);
        $builder->update($data);
        $db->close();
    }

    static function AddFileData($data = array()){
        $db = db_connect();
        $builder = $db->table('file_data');
        $builder->insert($data);
        $db->close();
    }
}