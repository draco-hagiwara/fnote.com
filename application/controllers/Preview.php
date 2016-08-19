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


//     	print_r($input_post);
//     	print("<br>");
//     	print_r($input_post['ticket']);
//     	print("<br>");
//     	print_r($_SESSION['a_ticket']);
//     	print("<br>");
//     	exit;



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
		$this->load->model('Entry_pre', 'pre', TRUE);
		$pre_data = $this->pre->get_entry_seq($input_post['en_seq']);
		if ($pre_data == FALSE)
		{
			show_404();
		}

// 		// データを戻す
// 		foreach ($set_data as $key => $value)
// 		{
// 			$item = str_replace("ep_", "en_", $key);
// 			$item_data[$item] = $value;
// 		}






// 		if ($input_post["type"] == 'body')
// 		{

// 			// 記事本文のフォームデータをセット
// 			$entry_data[0]['en_title01']   = $input_post['en_title01'];
// 			$entry_data[0]['en_body01']    = $input_post['en_body01'];
// 			$entry_data[0]['en_title02']   = $input_post['en_title02'];
// 			$entry_data[0]['en_body02']    = $input_post['en_body02'];

// 			$entry_data[0]["en_cl_seq"]    = $_SESSION['a_cl_seq'];
// 			$entry_data[0]["en_cl_id"]     = $_SESSION['a_cl_id'];
// 			$entry_data[0]["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

// 			$this->smarty->assign('list', $entry_data[0]);

// 		} elseif ($input_post["type"] == 'info') {

// 			// 店舗情報のフォームデータをセット
// 			$input_post['en_title01']   = $entry_data[0]['en_title01'];
// 			$input_post['en_body01']    = $entry_data[0]['en_body01'];
// 			$input_post['en_title02']   = $entry_data[0]['en_title02'];
// 			$input_post['en_body02']    = $entry_data[0]['en_body02'];

// 			$input_post["en_cl_seq"]    = $_SESSION['a_cl_seq'];
// 			$input_post["en_cl_id"]     = $_SESSION['a_cl_id'];
// 			$input_post["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

// 			$this->smarty->assign('list', $input_post);

// 		} else {
// 			show_404();
// 		}

		$this->smarty->assign('list', $pre_data[0]);

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