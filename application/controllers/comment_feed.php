<?php class Comment_feed extends MY_Controller
{
	public function Comment()
	{
        parent::__construct();
    }
	
	function index()
	{
		$comments = Doctrine_Query::create()
			->select('c.id, c.user_id, c.picture_id, c.comment, DATE_FORMAT(c.updated_at, \'%m/%d/%Y\') as updated_at')
			->from('Comment c')
			->limit(15)
			->orderBy('c.updated_at DESC')
			->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->execute();
		try { $vars['nsfw_pref'] = @Current_User::user()->show_nsfw; }catch(Exception $e){ $vars['nsfw_pref'] = 0; }
		$vars['comments'] = $comments;
		$vars['content_view'] = 'commentFeed';
		$vars['title'] = 'Comment Feed';
		$this->load->view('template',$vars);
	}
	
}?>