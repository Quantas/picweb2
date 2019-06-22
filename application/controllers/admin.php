<?php class Admin extends MY_Controller
{
    public function __construct() 
    {
		parent::__construct();
        $this->load->model('Admin_model');
    }

   function index()
   {
       if(Current_User::user()->privs < 1)
       {
           show_404('admin');
       }
       else
       {
            $vars['albumData'] = $this->Admin_model->getAllAlbums();
            $vars['userData'] = $this->Admin_model->getUserList();

            $vars['content_view'] = 'admin';
            $vars['title'] = 'Administration';
            $this->load->view('template',$vars);
       }
   }
}