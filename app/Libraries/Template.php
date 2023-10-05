<?php 

namespace App\Libraries;

class Template
{
    public function render($view, $data = [])
    {
        echo view('includes/header.php',['data'=>$data]);
        echo view($view,['data'=>$data]);
        echo view('includes/footer.php',['data'=>$data]);

    }
}