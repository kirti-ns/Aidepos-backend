<?php

class checkSession{
	public static function isLoggedIn()
	{
        $exp = explode('/',current_url());
		if (!session()->get('isLoggedIn') && !in_array('forgot_password',$exp) && !in_array('post-forgot_password',$exp))
        {
             //header("Location: ".base_url('login'));
            if((!in_array('login',$exp)) && (!in_array('post-login',$exp))) {
                header("Location: http://localhost/enterprolive/login");exit;
            }
        	// echo "<pre>";print_r(session()->get());die;
        	// redirect(site_url('login'));
        }
	}
}