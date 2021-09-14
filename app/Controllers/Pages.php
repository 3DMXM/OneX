<?php

namespace App\Controllers;

class Pages extends BaseController {

    public function view($page = 'home')
    {
        if ( ! file_exists(APPPATH.'/Views/Pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            // 哎呀，我们没有那个页面！
            echo "未找到文件 {$page}";
            throw new \CodeIgniter\PageNotFoundException($page);
        }

        // echo "测试";
        $data['title'] = ucfirst($page); // Capitalize the first letter

        echo view('Templates/Header', $data);
        echo view('Pages/'.$page, $data);
        echo view('Templates/Footer', $data);

        // return view('Pages/'.$page);
    }
}