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
    	// セッションデータをクリア
    	$this->load->model('comm_auth', 'comm_auth', TRUE);
    	if (isset($_SESSION['c_adminSeq']))
    	{
    		$this->comm_auth->delete_session('a_client');
    	} else {
    		$this->comm_auth->delete_session('client');
    	}

    	$this->view('maintenance/maintenance.tpl');
    }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */