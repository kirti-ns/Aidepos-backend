<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\EmployeeModel;
use App\Models\StoreModel;
use App\Models\TerminalsModel;
use App\Models\CommonModel;

class AuthController extends BaseController
{
    public function Login()
    {
        $session = session();
        $session_set_value = $session->get('remember_me');
       
        if (isset($session_set_value) && $session_set_value == 1) {
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
                $employeeModel = new EmployeeModel();
                $email = $post['email'];
                $password = $post['password'];
                $role_id = $post['role_id'];
                $rememberme = isset($post['remember_me'])?$post['remember_me']:"";
                
                $data = $employeeModel->where('primary_email', $email)->first();

                
                if($data){
                    $db = db_connect();
                    $commonModel = new CommonModel($db);
                    $uData = ['timezone'=>$post['timezone']];
                    $commonModel->UpdateData('employees',$data['id'],$uData);
                    
                    $pass = $data['password'];
                    $authenticatePassword = password_verify($password, $pass);
                    $roleModel = new RoleModel();
                    $role = $roleModel->where('id',$data['role_id'])->first();
                    
                    if($authenticatePassword){
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
                            'role_name' => "Manager",
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

    public function askStore()
    {
        $data = [];
        $data['title'] = 'Store PopUp';
        $data['modal-title'] = 'Please select store';
        $session = session();
        $emp_id = $session->get('id');
        $empModel = new EmployeeModel();
        $getEmpData = $empModel->select('store_id, terminal_id')->where('id',$emp_id)->first();

        $empStore = json_decode($getEmpData['store_id']);
        $empTerminal = json_decode($getEmpData['terminal_id']);

        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->select('id, store_name')->whereIn('id',$empStore)->findAll();

        if(!empty($empTerminal)) {
            $data['modal-title'] .= ' '.'and Terminal';
            $terminalModel = new TerminalsModel();
            $data['terminals'] = $terminalModel->select('id, terminal_name')->whereIn('id',$empTerminal)->findAll();
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

                $h = date('H');
                $d = date('d');
                $m = date('m');
                $pin = (int)$h * (int)$d + (int)$m;

                $db = db_connect();
                $commonModel = new CommonModel($db);
                $uData = ['pin'=>$pin];
                $commonModel->UpdateData('stores',$post['store'],$uData);
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $length = 20;
                $token = '';
                for ($i = 0; $i < $length; $i++) {
                    $token .= $characters[rand(0, $charactersLength - 1)];
                }       
        $emp_data = $employeeModel->where('primary_email', $email)->first();
        if($emp_data){
              $data = [
              'forgot_password_token' => $token,
           ];
           
           $id = $emp_data['id'];

           ## Update record
           $employeeModel->update($id,$data);
             return json_encode([
                    "status" => "true",
                    "message" => "Please check you email.",
                    ]);
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
