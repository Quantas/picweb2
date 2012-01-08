<?php
class Gallery extends MY_Controller 
{

    public function __construct() 
    {
		parent::__construct();
		check_login();
    }

    function index(){
        $this->load->model('Gallery_model');

        if ($this->input->post('upload')){
            $this->Gallery_model->do_upload();
        }
        else
        {
            redirect("/albums/");
        }
    }
	
	function numPics($album_id)
	{
		$result = Doctrine_Query::create()
			->select('COUNT(*) as num_pics')
			->from('picture')
			->where('album_id = ' . $album_id)
			->setHydrationMode(Doctrine::HYDRATE_RECORD)
            ->fetchOne();
			
		return $result->num_pics;
	}
	
	function isMine($album_id)
	{
		$current_id = Current_User::user()->id;
		
		$owner_id = Doctrine_Query::create()
			->select('a.user_id')
			->from('album a')
			->where('a.id = ' . $album_id)
			->setHydrationMode(Doctrine::HYDRATE_ARRAY)
			->execute();
			
		if($current_id == @$owner_id[0]['user_id'])
			return TRUE;
		else
			return FALSE;	
	}

    function display($album_id = 0, $offset = 0){

        if(!($album_id==0))
        {
                $vars['using_ie'] = using_ie();
                
		$vars['album_id'] = $album_id;
		
		$vars['is_mine'] = $this->isMine($album_id);
		
		$vars['pictures'] = Doctrine_Query::create()
			->select('p.id, p.name, p.type, p.thumb, p.width')
			->from('picture p')
			->where('p.album_id = ' . $album_id)
			->limit(16)
                        ->offset($offset)
			->orderBy('p.id')
			->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->execute();

                $vars['nsfw_pref'] = Current_User::user()->show_nsfw;

                $numPicsCount = $this->numPics($album_id);

        if($numPicsCount == 0)
            $vars['empty'] = "Album is empty!";

		
		
		// do we have enough to paginate
        if ($numPicsCount > 16) {
            // PAGINATION
            $this->load->library('pagination');
            $config['base_url'] = base_url() . "gallery/display/$album_id";
            $config['total_rows'] = $numPicsCount;
            $config['per_page'] = 16;
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $vars['pagination'] = $this->pagination->create_links();
        }

        $vars['content_view'] = 'gallery';
        $vars['title'] = 'Gallery';
        $this->load->view('template',$vars);
        }
        else
        {
            redirect('home');
        }
    }
	


	function pictureView($album_id=FALSE, $id=FALSE)
	{
                $vars['using_ie'] = using_ie();

                if(!$album_id)
                {
                    redirect("/albums/");
                }

		if ($id)
		{
			$vars['is_mine'] = $this->isMine($album_id);
			
			$pic = Doctrine_Query::create()
			->select('p.id, p.album_id, p.name, p.size, p.width, p.height, p.type, DATE_FORMAT(p.updated_at, \'%m/%d/%Y %H:%i\') as updated_at, DATE_FORMAT(p.created_at, \'%m/%d/%Y %H:%i\') as created_at')
			->from('picture p')
			->where('p.id = ?', $id)
			->fetchOne();

                        $comments = Doctrine_Query::create()
			->select('c.id, c.user_id, c.comment, DATE_FORMAT(c.updated_at, \'%m/%d/%Y at %H:%i\') as updated_at')
			->from('Comment c')
                        ->where('c.picture_id = ?', $id)
                        ->orderBy('updated_at ASC')
                        ->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->execute();

                        $vars['exif'] = Doctrine_Query::create()
			->select('e.*')
			->from('Exif e')
                        ->where('e.picture_id = ?', $id)
                        ->fetchOne();

			$vars['max_pos'] = $this->numPics($album_id);
			$vars['current_pos'] = $pic->album_pos;

			
			$vars['previous_id'] = Doctrine_Query::create()
									->select('p.id')
									->from('picture p')
									->where('p.album_id = '.$album_id.' and p.album_pos = '.($vars['current_pos'] - 1))
									->setHydrationMode(Doctrine::HYDRATE_RECORD)
									->fetchOne();

			$vars['next_id'] = Doctrine_Query::create()
									->select('p.id')
									->from('picture p')
									->where('p.album_id = '.$album_id.' and p.album_pos = '.($vars['current_pos'] + 1))
									->setHydrationMode(Doctrine::HYDRATE_RECORD)
									->fetchOne();

                        $vars['nsfw_pref'] = Current_User::user()->show_nsfw;
			$vars['comments'] = $comments;
			$vars['album_id'] = $album_id;
			$vars['pic_id'] = $id;
			$vars['pic_name'] = $pic->name;
			$vars['pic_size'] = $pic->size;
			$vars['pic_width'] = $pic->width;
			$vars['pic_height'] = $pic->height;
			$vars['pic_type'] = $pic->type;
                        $vars['pic_nsfw'] = $pic->nsfw;
                        $vars['pic_flagged'] = $pic->flagged;
                        $vars['pic_data'] = $pic->image;
			$vars['pic_owner'] = $pic->Album->User->first_name . " " . $pic->Album->User->last_name;
			$vars['last_updated'] = $pic->updated_at;
			$vars['uploaded'] = $pic->created_at;

                        $viewCounter = $pic->views + 1;
                        $pic->views = $viewCounter;
                        
                        $pic->save();

                        $vars['pic_views'] = $viewCounter;

			$vars['content_view'] = 'pictureView';
			$vars['title'] = 'View Image';
			$this->load->view('template', $vars);
		}
	}
	
	function renameImage($id=FALSE)
	{
		$vars['picName'] = Doctrine_Query::create()
			->select('p.name')
			->from('picture p')
			->where('p.id = ?', $id)
			->fetchOne();
		$vars['content_view'] = 'rename_image';
		$vars['title'] = 'Rename Image';
		$this->load->view('template', $vars);
	}
	
	function doRenameImage($id=FALSE)
	{
		$image = Doctrine::getTable('picture')->find($id);
		$image->name = $this->input->post('image_name');
		$image->save();
		redirect('/gallery/pictureView/'.$image->album_id.'/'.$image->id);
	}

        function toggleNsfw($id=FALSE)
        {
            $image = Doctrine::getTable('picture')->find($id);
            $album_id = $image->album_id;
            $image_name = $image->name;

            if($this->isMine($album_id))
            {
                try
                {
                    if($image->nsfw == 0)
                    {
                        $image->nsfw = 1;
                    }
                    else
                    {
                        $image->nsfw = 0;
                    }

                    $image->save();

                    $this->bannermessage->setBanner('info', 'Updated Mature Flag for ' . $image_name);
                }
                catch(Exception $e)
                {
                    $this->bannermessage->setBanner('error', 'Unable to modify Mature flag on ' . $image_name);
                    redirect('/gallery/pictureView/'.$album_id.'/'.$id);
                }
            }
            else
            {
                $this->bannermessage->setBanner('error', 'Could not modify Mature Flag, ' . $image_name . ' is not yours.');
            }

            redirect('/gallery/pictureView/'.$album_id.'/'.$id);
        }

        function flagNsfw($id=FALSE)
        {
            $image = Doctrine::getTable('picture')->find($id);
            $album_id = $image->album_id;
            $image_name = $image->name;

            try
            {
                $image->flagged = $image->flagged + 1;
                $image->save();
                $this->bannermessage->setBanner('info', 'Flagged ' . $image_name . ' for review.');
            }
            catch(Exception $e)
            {
                $this->bannermessage->setBanner('error', 'Unable to flag ' . $image_name . 'for review.');
                redirect('/gallery/pictureView/'.$album_id.'/'.$id);
            }

            redirect('/gallery/pictureView/'.$album_id.'/'.$id);
        }

	function deleteImage($id=FALSE)
	{
		//delete Image
		$image = Doctrine::getTable('picture')->find($id);
		$album_id = $image->album_id;
		$image_name = $image->name;
		
		if ($this->isMine($album_id))
		{
                    try{

                        $image->delete();
			
			//recalculate image positions
			
			$updateImages = Doctrine::getTable('picture')->findByAlbum_Id($album_id);
			$count = 1;
			$numExecute = 0;
			foreach ($updateImages as $uImage)
			{
					$updateQuery = Doctrine_Query::create()
						->update('picture')
						->set('album_pos', '?', $count)
						->where('id = '.$uImage->id);
					$numExecute += $updateQuery->execute();
					$count++;
			}
			
			$this->bannermessage->setBanner('info', 'Deleted ' . $image_name);
			redirect('gallery/display/' . $album_id);
                    }
                    catch(Exception $e)
                    {
                        $this->bannermessage->setBanner('error', 'Unable to delete ' . $image_name . ', it is someone\'s display pic.');
                        redirect('/gallery/pictureView/'.$album_id.'/'.$id);
                    }
        }
        else
		{
			$this->bannermessage->setBanner('error', 'Unable to delete ' . $image_name . ', it is not yours.');
			redirect('gallery/display/' . $album_id);
		}
	}
}