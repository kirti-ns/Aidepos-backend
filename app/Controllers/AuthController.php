<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\EmployeeModel;
use App\Models\AgentModel;
use App\Models\StoreModel;
use App\Models\TerminalsModel;
use App\Models\CommonModel;
use DateTime;
use DateTimeZone;

class AuthController extends BaseController
{
    public function Login()
    {
        $session = session();
        $session_set_value = $session->get('remember_me');
       
        if (isset($session) && session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        } else {
            $data = [];
            $data['title'] = 'Login'; 
            return view('pages/auth/login',['data'=>$data]);
        }
    }

    public function PostLogin()
    {
        if ($this->request->getMethod() == "post") {

                $post = $this->request->getVar();
                $email = $post['email'];
                $password = $post['password'];

                if($post['role'] == "2") {
                    $rememberme = isset($post['remember_me'])?$post['remember_me']:"";

                    $agentModel = new AgentModel();
                    $data = $agentModel->where('email', $email)->first();
                    if($data) {
                        $pass = $data['password'];
                        $authenticatePassword = password_verify($password, $pass);
                        
                        if($authenticatePassword){

                            $ses_data = [
                                'id' => $data['id'],
                                'name' => $data['agent_name'],
                                'email' => $data['email'],
                                'isLoggedIn' => TRUE
                            ];
                            $session = session();
                            $session->set($ses_data);
                             if($rememberme==1){
                                $session->set('remember_me', TRUE);
                                setcookie('login_email',$email,time()+60*60*24*100);
                                setcookie('login_pass',$password,time()+60*60*24*100);
                             }
                             else{
                                // delete_cookie('login_email',$email,100);
                                // delete_cookie('login_pass',$password,100);
                             }
                           
                             return json_encode([
                                "status" => "true",
                                "message" => "Login successfully",
                                "role_type"=>"2"
                            ]);
                        
                        }else{
                             return json_encode([
                                "status" => "false",
                                "message" => "Password is incorrect.",
                            ]);

                        }
                    } else {
                        return json_encode([
                            "status" => "false",
                            "message" => "Email does not exist.",
                        ]);
                    }
                } else {
                    $employeeModel = new EmployeeModel();
                    $rememberme = isset($post['remember_me'])?$post['remember_me']:"";
                    
                    $data = $employeeModel->where('primary_email', $email)->first();

                    if($data){
                        $db = db_connect();
                        $commonModel = new CommonModel($db);
                        $uData = ['timezone'=>$post['timezone']];
                        $commonModel->UpdateData('employees',$data['id'],$uData);
                        
                        $pass = $data['password'];
                        $authenticatePassword = password_verify($password, $pass);
                        
                        if($authenticatePassword){
                            $roleModel = new RoleModel();
                            $role = $roleModel->where('id',$data['role_id'])->first();
                            $roleId = "";
                            $roleName = "";
                            if(isset($role) && !empty($role)) {
                                $roleId = $role['id'];
                                $roleName = $role['role_name'];
                            }

                            $ses_data = [
                                'id' => $data['id'],
                                'name' => $data['first_name'].' '.$data['last_name'],
                                'email' => $data['primary_email'],
                                'role_name' => $roleName,
                                'profile' => $data['profile'],
                                'pos_id' => $data['pos_id'],
                                'is_super_user' => $data['is_super_user'] == 1 ? true : false,
                                'is_back_office' => $role['back_office'],
                                'permissions' => json_decode($role['back_office_permission']),
                                'isLoggedIn' => TRUE
                            ];
                            $session = session();
                            $session->set($ses_data);
                             if($rememberme==1){
                                 $session->set('remember_me', TRUE);
                                 setcookie('login_email',$email,time()+60*60*24*100);
                                setcookie('login_pass',$password,time()+60*60*24*100);
                             }
                             else{
                                // delete_cookie('login_email',$email,100);
                                // delete_cookie('login_pass',$password,100);
                             }
                           
                             return json_encode([
                                "status" => "true",
                                "message" => "Login successfully",
                                "role_type" => "1",
                                "role" => $roleName,
                                "store_assigned" => $data['store_id'] != "" ? true : false
                            ]);
                        
                        }else{
                             return json_encode([
                                "status" => "false",
                                "message" => "Password is incorrect.",
                            ]);

                        }
                    }else{
                        return json_encode([
                            "status" => "false",
                            "message" => "Email does not exist.",
                        ]);

                    }   
                }
        }

    }

    public function askStore()
    {
        $data = [];
        $data['title'] = 'Store PopUp';
        $data['modal-title'] = 'Please select Store';
        $session = session();
        $emp_id = $session->get('id');
        $is_super_user = $session->get('is_super_user');
        $empModel = new EmployeeModel();
        $getEmpData = $empModel->select('store_id, terminal_id')->where('id',$emp_id)->first();

        $empStore = json_decode($getEmpData['store_id']);
        $empTerminal = json_decode($getEmpData['terminal_id']);

        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->select('id, store_name')->whereIn('id',$empStore)->findAll();

        $terminalModel = new TerminalsModel();
        if($is_super_user) {
            $data['modal-title'] .= ' '.'and Terminal';
            $data['terminals'] = $terminalModel->select('id, terminal_name')->where('pos_id',$session->get('pos_id'))->findAll();
        } else {
            if(!empty($empTerminal)) {
                $data['modal-title'] .= ' '.'and Terminal';
                $data['terminals'] = $terminalModel->select('id, terminal_name')->whereIn('id',$empTerminal)->findAll();
            }
        }
        $data['modal-title'] .= ' '.'to continue';
        return view('store-popup',['data'=>$data]);
    }

    public function postEmpStore()
    {
        if ($this->request->getMethod() == "post") {
            $post = $this->request->getVar();
            $storeDt = "";
            $terminalDt = "";
            if(!empty($post['store'])) {
                $store = new StoreModel();
                $storeDt = $store->select('store_name')->where('id',$post['store'])->first();

            }
            if(!empty($post['terminal'])){
                $terminal = new TerminalsModel();
                $terminalDt = $terminal->select('terminal_name')->where('id',$post['terminal'])->first();
            }
            $ses_data = [
                'store_id' => $post['store'],
                'terminal_id' => isset($post['terminal'])?$post['terminal']:"",
                'store_name' => $storeDt != "" ? $storeDt['store_name'] : '',
                'terminal_name' => $terminalDt != "" ? $terminalDt['terminal_name'] : ''
            ];
            $session = session();
            $session->set($ses_data);

            return json_encode([
                "status" => "true",
                "message" => "Store set successfully"
            ]);
        }
    }

    public function Logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }

    public function ForgotPassword()
    {
        $data = [];
        $data['title'] = 'Forgot Password'; 
        return view('pages/auth/forgot_password',['data'=>$data]);
    }

    public function PostForgotPassword()
    {
        $post = $this->request->getVar();
        $employeeModel = new EmployeeModel();
        $email = $post['email'];

        $emp = $employeeModel->where('primary_email', $email)->first();
        if($emp){

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 20;
            $token = '';
            for ($i = 0; $i < $length; $i++) {
                $token .= $characters[rand(0, $charactersLength - 1)];
            }  

            $data = [
              'forgot_password_token' => $token,
           ];
           
           $id = $emp['id'];

           $employeeModel->update($id,$data);

            $mail = \Config\Services::email();
            $mail->setTo('k.kirtisharma1838@gmail.com');
            $mail->setFrom('kirtisharma.bluepixel@gmail.com', 'Aidepos');
            
            $eData = [
                'name'=>$emp['first_name'].' '.$emp['last_name'],
                'token'=>$token
            ];
            $mail->setSubject('Reset Password');
            $mail->setMessage(view('pages/mail/reset_password_mail',$eData));

            if ($mail->send()) 
            {
                return json_encode([
                    "status" => "true",
                    "message" => "We have sent a link to the given email ID for reset password. Please check your mail.",
                ]);
            } 
            /*else 
            {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }*/
            
        }else{
            return json_encode([
                "status" => "false",
                "message" => "Email does not exist.",
            ]);
        }
    }
    public function ResetPassword($token){
        $data = [];
        $data['title'] = 'Reset Password'; 
        $data['token'] = $token;
        $employeeModel = new EmployeeModel();
             
        $emp_data = $employeeModel->where('forgot_password_token', $token)->first();
        if(empty($emp_data)){
            return redirect()->to(base_url('login'));
        }
        return view('pages/auth/reset_password',['data'=>$data]);
    }
    public function PostResetPassword()
    {
        $post = $this->request->getVar();
        $employeeModel = new EmployeeModel();
        $emp_data = $employeeModel->where('forgot_password_token', $post['token'])->first();
        if($emp_data)
        {
              $data = [
              'forgot_password_token' => "",
              'password' => password_hash($post["new_password"],PASSWORD_DEFAULT),
           ];
           
        $id = $emp_data['id'];
        $employeeModel->update($id,$data);
             return json_encode([
                    "status" => "true",
                    "message" => "Your password reset successfully.",
                    ]);
        }else{
             return json_encode([
                    "status" => "false",
                    "message" => "Something went wrong.",
                    ]);
        }
    }
}
