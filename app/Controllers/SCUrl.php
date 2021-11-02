<?php
namespace App\Controllers;
use App\Models\short_chainModel;
use CodeIgniter\Model;

class SCUrl extends BaseController{

    public function index($string)
    {
//        print_r($string);

        $url = short_chainModel::GetSCUrl($string);


        if ($url['sc_string']){
            short_chainModel::AddSCUrlClickCnt($string);    // 添加点击次数

            header('Location: '.$url['sc_url']);
            exit();
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }



    }

    public function AddSCUrl(){
        $data = array(
            'sc_string' =>$this->request->getPost('sc_string'),
            'sc_url'=>$this->request->getPost('sc_url'),
        );

        if (empty($data['sc_string']) || empty($data['sc_url'])){
            echo json_encode(['code'=>'99','msg'=>'缺少必备参数！']);
            return;
        }

        if (!empty(short_chainModel::GetSCUrl($data['sc_string']))){
            // $data['sc_string']
            echo json_encode(['code'=>'99','msg'=>"错误，已有{$data['sc_string']}，请重新随机"]);

            return;
        }


        short_chainModel::AddSCUrl($data);

        echo json_encode(['code'=>'00','msg'=>'添加成功']);
    }


    /**
     * 获取唯一字符串
     */
    public function GetStr($randomString = null){

        $randomString = $this->GetRandomStr($randomString);

        echo json_encode(['code'=>'00','str'=>$randomString]);
    }

    private function GetRandomStr($randomString = null){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $n = 10; // 长度为10位
        $randomString = "";
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        // 检查是否存在，存在则重新生成
        if (!empty(short_chainModel::GetSCUrl($randomString))){
            $randomString = $this->GetRandomStr($randomString);
        }
        return $randomString;
    }


}