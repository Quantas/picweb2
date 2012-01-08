<?php class User_account extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		check_login();
	}

	function index()
	{
		redirect('user_account/profile');
	}

	function Profile($id=FALSE)
	{
		if(!$id)
		{
			$vars['uid'] = Current_User::user()->id;
		}
		else
		{
			$vars['uid'] = $id;
		}

		if($vars['uid'] == Current_User::user()->id)
		{
			$vars['is_me'] = TRUE;
		}
		else
		{
			$vars['is_me'] = FALSE;
		}

		$vars['albums'] = Doctrine::getTable('Album')->findByUser_Id($vars['uid']);

		$vars['userData'] = Doctrine_Query::create()
		->select('u.id, u.username, u.birthdate, u.first_name, u.last_name, u.quota, u.email, DATE_FORMAT(u.created_at, \'%m/%d/%Y\') as created_at')
		->from('user u')
		->where('id = ?', $vars['uid'])
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->fetchOne();

		$vars['albumCount'] = Doctrine_Query::create()
		->select('count(*) albumCount')
		->from('album a')
		->where('user_id = ?', $vars['uid'])
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->fetchOne();

		$vars['imageCount'] = Doctrine_Query::create()
		->select('count(*) imageCount')
		->from('picture p, album a')
		->where('a.id = p.album_id and a.user_id = ?', $vars['uid'])
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->fetchOne();

		$vars['spaceUsage'] = Doctrine_Query::create()
		->select('sum(p.size) totalSize')
		->from('picture p, album a')
		->where('a.id = p.album_id and a.user_id = ?', $vars['uid'])
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->fetchOne();

		$vars['content_view'] = 'profile';
		$vars['title'] = 'Profile';
		$this->load->view('template',$vars);
	}

	function toggleNsfw()
	{
		$user = Current_User::user();

		if(($user->show_nsfw==0) && ($this->birthdayCheck()))
		{
			$user->show_nsfw = 1;
		}
		else
		{
			$user->show_nsfw = 0;
		}
		$user->save();
		if(!$this->birthdayCheck())
		{
			$this->bannermessage->setBanner('error', 'Not of Age to see Mature content!!');
		}
		redirect('/user_account/profile');
	}

	function birthdayCheck()
	{
		$bday = Current_User::user()->birthdate;
		$month = substr($bday,0,2);
		$day = substr($bday,3,2);
		$year = substr($bday,6,4);
		$birthstamp = mktime(0, 0, 0, $month, $day, $year);
		$diff = time() - $birthstamp;
		$age_years = floor($diff / 31556926);

		if($age_years>=18)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function updateInfo()
	{

	}

	function passForm()
	{
		$vars['content_view'] = 'passwordChange';
		$vars['title'] = 'Change Password';
		$this->load->view('template',$vars);
	}

	function changePassword()
	{
		$user = Doctrine::getTable('User')->find(Current_User::user()->id);
		$u_input = new User();

		$u_input->password = $this->input->post('oldpass');

		if($user->password == $u_input->password)
		{
			if($this->input->post('password') == $this->input->post('passconf'))
			{
				$user->password = $this->input->post('password');
				$user->save();
				$this->bannermessage->setBanner('info', 'Successfully changed password.');
			}
			else
			{
				$this->bannermessage->setBanner('error', 'Passwords do not match.');
			}
		}
		else
		{
			$this->bannermessage->setBanner('error', 'Current password does not match.');
		}
		unset($u_input);
		redirect('user_account/profile');
	}

	function deleteAccount()
	{
		//check referer so people dont 'Accidentally' delete their accounts...
		if(strpos(@$_SERVER['HTTP_REFERER'], '/user_account/profile'))
		{
			$user = Doctrine::getTable('User')->find(Current_User::user()->id);

			try
			{
				$user->delete();
			}
			catch(Exception $e)
			{
				$this->bannermessage->setBanner('error', 'Could not delete your account.<br />' . $e->getMessage());
				redirect('/user_account/profile/');
			}

			$this->session->sess_destroy();

			redirect('/');
		}
		else
		{
			$this->bannermessage->setBanner('error', 'Improper User Account Delete.');
			redirect('/user_account/profile/');
		}

	}
}
?>