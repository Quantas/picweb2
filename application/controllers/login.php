<?php
class Login extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$vars['content_view'] = 'login_form';
		$vars['title'] = 'Login';
		$this->load->view('template', $vars);
	}

	public function submit()
	{

		if ($this->_submit_validate() === FALSE)
		{
			$this->index();
			return;
		}
		// user has been logged in
		$this->session->set_userdata('logged_in', TRUE);
		// redirect user to previously requested URL
		$this->bannermessage->setBanner('info', 'Successfully logged in as ' . Current_User::user()->username);
		redirect($this->session->userdata('redirect_url'));
	}

	private function _submit_validate()
	{

		$this->form_validation->set_rules('username', 'Username',
			'trim|required|callback_authenticate');

		$this->form_validation->set_rules('password', 'Password',
			'trim|required');

		$this->form_validation->set_message('authenticate','Invalid login. Please try again.');

		return $this->form_validation->run();

	}

	public function authenticate()
	{
		return Current_User::login($this->input->post('username'),
		$this->input->post('password'));
	}
}
