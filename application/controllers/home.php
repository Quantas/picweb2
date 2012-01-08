<?php
class Home extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function Home()
	{
		parent::Controller();
	}

	public function index()
	{

		$vars['using_ie'] = using_ie();

		$vars['randomImage'] = Doctrine_Query::create()
		->select('p.id, p.name, p.album_id, p.image, p.type')
		->from('picture p')
		->where('p.nsfw = 0')
		->orderBy('rand()')
		->limit(1)
		->setHydrationMode(Doctrine::HYDRATE_ARRAY)
		->execute();
			
		$vars['image_count'] = Doctrine_Query::create()
		->select('COUNT(*) image_count')
		->from('picture p')
		->setHydrationMode(Doctrine::HYDRATE_ARRAY)
		->execute();
		$vars['db_size'] = Doctrine_Query::create()
		->select('sum(p.size) db_size')
		->from('picture p')
		->setHydrationMode(Doctrine::HYDRATE_ARRAY)
		->execute();
		$vars['user_count'] = Doctrine_Query::create()
		->select('count(*) user_count')
		->from('user u')
		->setHydrationMode(Doctrine::HYDRATE_ARRAY)
		->execute();
			
		$vars['content_view'] = 'home';
		$vars['title'] = 'Home';
		$this->load->view('template', $vars);
	}

}