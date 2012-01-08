<?php

function check_login()
{
	// Get CodeIgniter Object
	$CI =& get_instance();

	// Load Session Library
	$CI->load->library('session');

	// Load URL Helper
	$CI->load->helper('url');

	// Location of the login screen
	$login_url = 'login';

	// Session variable to check if user is logged in
	$user_session_var = 'logged_in';

	if($CI->uri->uri_string() != $login_url)
	{
		if( ! $CI->session->userdata($user_session_var))
		{
			// user is not logged in
			$CI->session->set_userdata('redirect_url', $CI->uri->uri_string());
			redirect($login_url);
		}
		else
		{
			// User logged in
			$CI->session->unset_userdata('redirect_url');
		}
	}
}

/* End of file account_helper.php */
/* Location: ./application/helpers/account_helper.php */