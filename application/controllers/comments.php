<?php
class Comments extends MY_Controller 
{

    public function __construct() 
    {
		parent::__construct();
    }

    function getComments($id=FALSE)
    {

        $pic = Doctrine_Query::create()
			->select('p.id, p.album_id')
			->from('picture p')
			->where('p.id = ?', $id)
			->fetchOne();

        $comment = Doctrine_Query::create()
			->select('c.id, c.user_id, c.comment, DATE_FORMAT(c.updated_at, \'%m/%d/%Y at %H:%i\') as updated_at')
			->from('Comment c')
                        ->where('c.picture_id = ?', $id)
                        ->orderBy('updated_at ASC')
                        ->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->execute();

        $vars['comments'] = $comment;
        $vars['pic_id'] = $id;
        $vars['album_id'] = $pic->album_id;
        $this->load->view('comments', $vars);
    }

    function addComment() 
    {
        $newComment = new Comment();
        $newComment->comment = $this->input->post('comment');
        $newComment->picture_id = $this->input->post('picture_id');
        $newComment->user_id = Current_User::user()->id;
        $newComment->save();

        //redirect('comments/getComments/'.$this->input->post('picture_id'));
	}
}?>