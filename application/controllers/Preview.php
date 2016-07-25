<?php

//class Top extends CI_Controller {
class Preview extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

		redirect('https://fnote.com.dev/');

    }

    public function pf()
    {

    	$input_post = $this->input->post();

    	// 「ticket」チェック
    	if (isset($input_post['ticket']))
    	{
	    	if ($input_post['ticket'] !== $_SESSION['a_ticket'])
	    	{
	    		show_404();
	    	}
    	} else {
    		show_404();
    	}

    	// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);

		$entry_data = $this->ent->get_entry_seq($input_post['en_seq']);

    	$this->smarty->assign('list', $entry_data[0]);

    	$this->smarty->assign('list', $entry_data[0]);
    	$this->view('preview/pf.tpl');

    }


    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */