<?php
class Albums extends MY_Controller {

    public function Albums()
    {
        parent::__construct();
        check_login();
        if ($this->input->post('submit'))
        {
            $this->submit();
        }
    }
	
	function index()
	{
            $vars['albums'] = Doctrine::getTable('Album')->findAll();
            $vars['content_view'] = 'albums';
            $vars['title'] = 'Albums';
            $this->load->view('template',$vars);
	}
	
    function submit() {
        $a = new Album();
        $a->name = $this->input->post('album_name');
        $a->user_id = Current_User::user()->id;
        $a->save();

        redirect('user_account/profile');
	}

    function delete($album_id) {
        $a = Doctrine::getTable('Album')->find($album_id);
        if (Current_User::user()->id == $a->user_id){
            try
            {
            $a->delete();
            }
            catch (Exception $e)
            {
                $this->bannermessage->setBanner('error', 'Unable to delete ' . $a->name . ', it contains someone\'s display pic.');
            }
            redirect('user_account/profile');
        }
        else{
            $vars['content_view'] = 'notallowed';
            $vars['title'] = 'Not Allowed';
            $this->load->view('template',$vars);
        }
    }
	
	function downloadAlbum($album_id)
	{
		$this->load->library('zip');
		$album = Doctrine::getTable('Album')->find($album_id);
		
		$images = Doctrine_Query::create()
		->select('p.type, p.image, p.name')
		->from('picture p')
		->where('p.album_id = ' . $album_id)
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->execute();

                if(count($images) > 0)
                {
                    foreach($images as $image):
                            if ($image->type == 'image/jpg' || $image->type == 'image/jpeg')
                                    $name = $image->name.".jpg";
                            else if ($image->type == 'image/gif')
                                    $name = $image->name.".gif";
                            else
                                    $name = $image->name.".png";

                            $data = $image->image;
                            $this->zip->add_data($name, $data);
                    endforeach;

                    $this->zip->download($album->name.'.zip');
                }
                else
                {
                    $this->bannermessage->setBanner('error', 'Album is empty');
                    redirect('user_account/profile');
                }
	}

}