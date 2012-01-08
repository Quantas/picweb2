<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class BannerMessage
{
	function setBanner($type, $message)
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$CI->session->set_flashdata('message_exists', 'true');
		$CI->session->set_flashdata('type', $type);
		$CI->session->set_flashdata('message', $message);
	}
}
?>