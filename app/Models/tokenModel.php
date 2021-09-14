<?php

    namespace App\Models;

    class tokenModel extends \CodeIgniter\Model
    {
            protected $table = 'token';

            // 获取Token
            public function GetToken($id = false)
            {
                if ($id === false)
                {
                        return $this->findAll();
                }

                return $this->asArray()->where(['id' => $id])->first();
            }

            // 设置 TOken
            public function SetToken($id, $TokenData=array())
            {

                $db = db_connect();

                $builder = $db->table('token');

                $builder->where('id',$id);
                $builder->update($TokenData);

                
                // $db = $this->update($id, $TokenData)->set();


                $db->close();

            }
    }