<?php class About extends MY_Controller
{

    public function __construct() 
    {
		parent::__construct();
    }

    function index()
    {
        $vars['content_view'] = 'about';
        $vars['title'] = 'About';
        $this->load->view('template',$vars);
    }

    function tou()
    {
        $vars['content_view'] = 'tou';
        $vars['title'] = 'Terms of Use';
        $this->load->view('template',$vars);
    }

    function pp()
    {
        $vars['content_view'] = 'pp';
        $vars['title'] = 'Privacy Policy';
        $this->load->view('template',$vars);
    }

}
?>