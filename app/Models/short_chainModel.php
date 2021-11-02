<?php


namespace App\Models;


class short_chainModel extends \CodeIgniter\Model
{
    protected $table = 'short_chain';

    /**
     * 通过短链获取跳转地址
     * @param null $string
     * @return array|object|null
     */
    static function GetSCUrl($string = null){
        $short_chainModel = new short_chainModel();

        if ($string === false){
            return $short_chainModel->findAll();
        }

        return $short_chainModel->asArray()->where(['sc_string' => $string])->first();

    }

    /**
     * 通过短链设置地址
     * @param $string
     * @param $data
     */
    static function SetSCUrl($string, $data){
        $db = db_connect();
        $builder = $db->table('short_chain');
        $builder->where(['sc_string' => $string,]);
        $builder->update($data);
        $db->close();
    }

    /**
     * 添加短链
     * @param $data
     */
    static function AddSCUrl($data){
        $db = db_connect();
        $builder = $db->table('short_chain');
        $builder->insert($data);
        $db->close();
    }

    /**
     * 短链添加点击量
     * @param $string
     */
    static function AddSCUrlClickCnt($string){
        $old = short_chainModel::GetSCUrl($string);
        $click = $old['sc_click_cnt'] + 1;

        $db = db_connect();
        $builder = $db->table('short_chain');
        $builder->where('sc_string',$string);
        $builder->set("sc_click_cnt",$click);
        $builder->update();
        $db->close();
    }

}