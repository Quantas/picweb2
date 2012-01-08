<?php

class Signup extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{

		//date crap
		//Setup months
		$vars['months'] = array('FALSE' => 'Month',
                             '1'  => 'Jan',
                             '2'  => 'Feb',
                             '3'  => 'Mar',
                             '4'  => 'Apr',
                             '5'  => 'May',
                             '6'  => 'Jun',
                             '7'  => 'Jul',
                             '8'  => 'Aug',
                             '9'  => 'Sep',
                             '10' => 'Oct',
                             '11' => 'Nov',
                             '12' => 'Dec'
		);
		//Setup days
		$vars['days']['FALSE'] = 'Day';

		for($i=1;$i<=31;$i++){
			$vars['days'][$i] = $i;
		}

		//Setup years
		$start_year = date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")-100)); //Adjust 100 to however many year back you want
		$vars['years']['FALSE'] = 'Year';

		for ($i=$start_year;$i<=date("Y");++$i) {
			$vars['years'][$i] = $i;
		}


		$vars['content_view'] = 'signup_form';
		$vars['title'] = 'Signup';
		$vars['container_css'] = 'forums';
		$this->load->view('template', $vars);
	}

	public function tou()
	{
		if($this->config->item('registration'))
		{
			$vars['content_view'] = 'tou_register';
			$vars['title'] = 'Signup';
			$this->load->view('template', $vars);
		}
		else
		{
			$this->bannermessage->setBanner('error', 'Account Creation is currently Disabled!!');
			redirect('/');
		}
	}

	public function agecheck()
	{
		if($this->input->post('submit'))
		{
			redirect('/signup/');
		}
	}

	private function birthdate_check($bday)
	{
		$month = substr($bday,0,2);
		$day = substr($bday,3,2);
		$year = substr($bday,6,4);
		$birthstamp = mktime(0, 0, 0, $month, $day, $year);
		$diff = time() - $birthstamp;
		$age_years = floor($diff / 31556926);
		if($age_years>=13)
		{
			return false;
		}
		else
		{
			$this->bannermessage->setBanner('error', 'You are not old enough to sign up for this site.');
			return true;
		}
	}

	public function submit() 
	{

		if($this->config->item('registration'))
		{
			$month = $this->input->post('months');
			$day = $this->input->post('days');
			$year = $this->input->post('years');
			@$birthday = date("m/d/Y",mktime(0,0,0,$month,$day,$year));

			if ($this->_submit_validate() === FALSE) {
				$this->index();
				return;
			}
			if($this->birthdate_check($birthday))
			{
				redirect('signup');
			}

			$u = new User();
			$u->username = $this->input->post('username');
			$u->password = $this->input->post('password');
			$u->email = $this->input->post('email');
			$u->first_name = $this->input->post('first_name');
			$u->last_name = $this->input->post('last_name');
			$u->birthdate = $birthday;
			$u->save();

			$this->bannermessage->setBanner('info', 'Account creation success!!');
			redirect('/');
		}
		else
		{
			$this->bannermessage->setBanner('error', 'Account Creation is currently Disabled!!');
			redirect('/');
		}

	}

	private function _submit_validate() 
	{

		// validation rules
		$this->form_validation->set_rules('username', 'Username',
			'required|alpha_numeric|min_length[6]|max_length[12]|unique[User.username]');

		$this->form_validation->set_rules('password', 'Password',
			'required|min_length[6]|max_length[12]');

		$this->form_validation->set_rules('passconf', 'Confirm Password',
			'required|matches[password]');

		$this->form_validation->set_rules('first_name', 'First Name',
			'required|max_length[255]');

		$this->form_validation->set_rules('last_name', 'Last Name',
			'required|max_length[255]');

		$this->form_validation->set_rules('email', 'E-mail',
			'required|valid_email|unique[User.email]');

		return $this->form_validation->run();

	}

}