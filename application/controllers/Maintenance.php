<?php

//class Top extends CI_Controller {
class Maintenance extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

//         $this->local->library('user_agent');
        if ( $this->agent->is_mobile() ) {
        	// モバイル端末アクセスです。
        	$this->smarty->assign('PcorMob', TRUE);
        } else {
        	// モバイル端末アクセスではありません。
        	$this->smarty->assign('PcorMob', FALSE);
        }

    }

    public function index()
    {
    	$this->view('maintenance/maintenance.tpl');
    }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */