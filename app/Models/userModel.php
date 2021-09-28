<?php
namespace App\Models;
use CodeIgniter\I18n\Time;

class userModel extends \CodeIgniter\Model
{
    protected $table = 'user';



    public function Login($username, $password)
    {
        $user = $this->asArray()->where([
            'user_name' => $username,
            'user_password' => MD5(MD5($password))  // 双重MD5加密
        ])->first();


        if(!empty($user)){
            // 登录成功 写入token
            // $token = MD5("{$username}{$time}{$username}");  
            $this->SetToken($user['id'], $username);

            return $user;
        }else{
            return false;
        }
    }

    // 写入Token
    public function SetToken($uid, $username){
        $time = new Time('now','Asia/Shanghai');
        $time = $time->toLocalizedString();

        $token =  MD5("{$username}{$time}{$username}");  

        helper('cookie');
        set_cookie("token", $token, 604800);   // 写入token 有效期7天

        echo "写入cookie";
        
        // 写入数据库
        $db = db_connect();
        $builder = $db->table('user');
        $builder->where(['id' => $uid,]);
        $builder->update([
            'user_token' => $token,
            'user_last_login_time' => $time
        ]);
        $db->close();
    }


    // 检查是否登录
    static function CheckingLogin()
    {
        helper('cookie');
        $token = get_cookie("token");

        if(empty($token)){
            // 如果没有token 直接返回false
            return false;
        }

        $userModel = new userModel();
        $user = $userModel->asArray()->where(['user_token' => $token])->first();

        if(!empty($user)){
            // 如果用户存在，返回用户信息
//            $userModel->SetToken($user['id'], $user['user_name']);
            return $user;
        }else{
            return false;
        }
    }

    /**
     * 更新用户密码
     * @param $id
     * @param $psd
     */
    static function UpUserPassword($id, $psd){
        $db = db_connect();
        $builder = $db->table('user');
        $builder->where('id',$id);
        $builder->set("user_password",$psd);
        $builder->update();
        $db->close();
    }



}