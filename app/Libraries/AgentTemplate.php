<?php 

namespace App\Libraries;

class AgentTemplate
{
    public function render($view, $data = [])
    {
        echo view('includes/agent_header.php',['data'=>$data]);
        echo view($view,['data'=>$data]);
        echo view('includes/agent_footer.php',['data'=>$data]);

    }
}