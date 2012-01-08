<?php
class Image extends MY_Controller
{
	public function __construct() 
	{
		parent::__construct();
		check_login();
	}

	function displayThumb($Id=FALSE)
	{
		if ($Id)
		{
			$pic = Doctrine_Query::create()
			->select('p.thumb, p.type')
			->from('picture p')
			->where('p.id = ?', $Id)
			->fetchOne();
			header("Content-type: " . $pic->type);
			$content = $pic->thumb;
			$content = stripslashes($content);
			$content = base64_decode($content);

			print $content;
		}
	}

	function getPic($Id=FALSE)
	{
		if ($Id)
		{
			$pic = Doctrine_Query::create()
			->select('p.image, p.type')
			->from('picture p')
			->where('p.id = ?', $Id)
			->fetchOne();

			if ($pic->type == 'image/jpg' || $pic->type == 'image/jpeg')
			$name = $pic->name.".jpg";
			else if ($pic->type == 'image/gif')
			$name = $pic->name.".gif";
			else
			$name = $pic->name.".png";

			header('Content-disposition: attachment; filename='.$name);

			header("Content-type: " . $pic->type);
			$content = $pic->image;
			$content = stripslashes($content);
			$content = base64_decode($content);

			print $content;
		}
	}

	function addComment() {
		$newComment = new Comment();
		$newComment->comment = $this->input->xss_clean($this->input->post('comment'));
		$newComment->picture_id = $this->input->post('picture_id');
		$newComment->user_id = Current_User::user()->id;
		$newComment->save();

		redirect('gallery/pictureView/'. $this->input->post('album_id') . '/' . $this->input->post('picture_id'));
	}
}

?>