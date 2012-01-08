<?php
class Blog extends MY_Controller {

    public function __construct() 
    {
		parent::__construct();
    }

    function index(){

        		$vars['stories'] = Doctrine_Query::create()
                                            ->select('n.*')
                                            ->from('news n')
                                            ->limit(10)
                                            ->setHydrationMode(Doctrine::HYDRATE_RECORD)
                                            ->execute();

                        $vars['content_view'] = 'blog';
                        $vars['title'] = 'Blog';
                        $this->load->view('template', $vars);
    }

}

?>