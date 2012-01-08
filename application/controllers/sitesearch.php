<?php
class Sitesearch extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model('Search_model');
	}


	function search_form()
	{
		$vars['content_view'] = 'search';
		$vars['title'] = 'Search';
		$this->load->view('template',$vars);
	}

	function do_search()
	{
		if($this->input->post('search_string') != '' && $this->input->post('search_string') != null && strlen($this->input->post('search_string')) > 2)
		{
			$vars['searchString'] = $this->input->post('search_string');
			$vars['using_ie'] = using_ie();

			$vars['is_mine'] = FALSE;

			//collect results
			$vars['pictures'] = $this->Search_model->search($this->input->post('search_string'),'Picture', 'name');
			$vars['users'] = $this->Search_model->search($this->input->post('search_string'),'User', 'username');
			$vars['albums'] = $this->Search_model->search($this->input->post('search_string'),'Album', 'name');

			$vars['nsfw_pref'] = Current_User::user()->show_nsfw;

			$vars['content_view'] = 'results';
			$vars['title'] = 'Search Results';
			$this->load->view('template',$vars);
		}
		else
		{
			if (strlen($this->input->post('search_string')) <= 2)
			{
				$this->bannermessage->setBanner('error', 'Search was too short.');
			}
			redirect('sitesearch/search_form');
		}
	}

}
?>