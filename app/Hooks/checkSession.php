<?php

class checkSession{
	public static function isLoggedIn()
	{
		if (!session()->get('isLoggedIn'))
        {
             //header("Location: ".base_url('login'));
            $exp = explode('/',current_url());
            if((!in_array('login',$exp)) && (!in_array('post-login',$exp))) {
                header("Location: http://enterpro.net/login");exit;
            }
        	// echo "<pre>";print_r(session()->get());die;
        	// redirect(site_url('login'));
        }
	}
}