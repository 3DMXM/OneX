<?php
namespace App\Controllers;
use App\Models\seoModel;
use CodeIgniter\I18n\Time;

class SEO extends BaseController{

    public function AddSEO(){
        $data = array(
            'seo_parent' => $this->request->getPost('seo_parent'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_keywords' => $this->request->getPost('seo_keywords'),
            'seo_description' => $this->request->getPost('seo_description'),
            'seo_time' => new Time('now','Asia/Shanghai')
        );

        if (empty($data['seo_parent']) || empty($data['seo_title'])){
            echo json_encode(['code'=>'99','msg'=>'缺少必备参数！']);
            return;
        }

        $checking = seoModel::GetSEO($data['seo_parent']);
        if (!empty($checking)){
            // 如果存在则编辑
            seoModel::SetSEO($data['seo_parent'], $data);
            echo json_encode(['code'=>'00','msg'=>'更新成功']);
            return;
        }

        seoModel::AddSEO($data);

        echo json_encode(['code'=>'00','msg'=>'添加成功']);
    }

    public function GetSEO(){

        $parent = $this->request->getPost('parent');
        $seo = seoModel::GetSEO($parent);

        if (!empty($seo)){
            echo json_encode(['code'=>'00','data'=>$seo]);
        }else{
            echo json_encode(['code'=>'99','msg'=>'获取数据失败']);
        }
    }
}