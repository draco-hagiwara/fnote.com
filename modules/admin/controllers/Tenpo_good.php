<?php

class Tenpo_good extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['a_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_type',  $_SESSION['a_memType']);
            $this->smarty->assign('mem_Seq',   $_SESSION['a_memSeq']);
    		$this->smarty->assign('ticket',    NULL);
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_type',  "");
            $this->smarty->assign('mem_Seq',   "");

            redirect('/login/');
        }
    }

    // こだわり情報TOP
    public function index()
    {

        $this->view('tenpo_good/index.tpl');

    }

    // こだわり情報TOP
    public function edit()
    {

    	$input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($input_post['chg_uniq'], TRUE);

    	// 一時保存
    	$_SESSION['a_cl_seq']    = $cl_data[0]['cl_seq'];
    	$_SESSION['a_cl_siteid'] = $cl_data[0]['cl_siteid'];
    	$_SESSION['a_cl_status'] = $cl_data[0]['cl_status'];

    	// 店舗データの取得
    	$this->load->model('Good', 'gd', TRUE);
    	$good_data = $this->gd->get_good_siteid($cl_data[0]['cl_siteid']);
    	if ($good_data == FALSE)
    	{
    		// 空データを取得
//     		$entry_data = $this->ent->get_entry_siteid($cl_data[0]['cl_siteid'], TRUE);
//     		$this->smarty->assign('list', $entry_data[0]);

    		$this->smarty->assign('list', NULL);
    	} else {
    		$this->smarty->assign('list', $good_data[0]);
    	}

    	$this->smarty->assign('cl_status', $cl_data[0]['cl_status']);
    	$this->view('tenpo_good/edit.tpl');

    }

    // 確認画面表示
    public function conf()
    {

    	$input_post = $this->input->post();

	    $this->load->model('Client', 'cl', TRUE);
	    $this->load->model('Good',   'gd', TRUE);

	    // バリデーション・チェック
	    $this->_set_validation();
	    if ($this->form_validation->run() == FALSE) {
	    	$this->smarty->assign('list',      $input_post);
	    	$this->smarty->assign('cl_status', $input_post['cl_status']);
	    } else {

	    	// データ設定
	    	$input_post["gd_cl_seq"]    = $_SESSION['a_cl_seq'];
	    	$input_post["gd_cl_siteid"] = $_SESSION['a_cl_siteid'];

	    	// 文字数カウント
	    	$input_post['gd_length01'] = $this->_get_strlen_cnt($input_post["gd_body01"]);
	    	$input_post['gd_length02'] = $this->_get_strlen_cnt($input_post["gd_body02"]);
	    	$input_post['gd_length03'] = $this->_get_strlen_cnt($input_post["gd_body03"]);
	    	$input_post['gd_length04'] = $this->_get_strlen_cnt($input_post["gd_body04"]);

	    	$set_data['cl_seq']    = $_SESSION['a_cl_seq'];
	    	$set_data['cl_status'] = $_SESSION['a_cl_status'];

	    	// 不要パラメータ削除
	    	unset($input_post["cl_status"]) ;
	    	unset($input_post["_submit"]) ;

	    	// DB書き込み
	    	$_row_id = $this->gd->inup_good($input_post);
	    	$this->cl->update_client($set_data);

			// 再表示用にデータの取得
			$good_data = $this->gd->get_good_siteid($input_post["gd_cl_siteid"]);
			if ($good_data == FALSE)
			{
				// 空データ
				$this->smarty->assign('list', NULL);
			} else {
				$this->smarty->assign('cl_status', $set_data['cl_status']);
				$this->smarty->assign('list',      $good_data[0]);
			}
	    }

	    $this->view('tenpo_good/edit.tpl');

    }

    // 入力された文字列から「空白」「改行」を削除し文字数をカウントする
    private function _get_strlen_cnt($get_str)
    {

    	// 空白削除
    	$string = str_replace(array(' ', '　'), '', $get_str);

    	// 改行削除 ＆ 文字数カウント
    	$get_strlen_cnt = mb_strlen(str_replace(array("\r\n","\r","\n"), '', $string));
    	//$get_strlen_cnt = mb_strlen(str_replace(PHP_EOL, '' , $string));

    	return $get_strlen_cnt;

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'gd_title01',
    					'label'   => 'タイトル1',
    					'rules'   => 'trim|required|max_length[200]'
    			),
    			array(
    					'field'   => 'gd_body01',
    					'label'   => '記事本文1',
    					'rules'   => 'trim|required|max_length[1000]'
    			),
    			array(
    					'field'   => 'gd_title02',
    					'label'   => 'タイトル2',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'gd_body02',
    					'label'   => '記事本文2',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'gd_title03',
    					'label'   => 'タイトル3',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'gd_body03',
    					'label'   => '記事本文3',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'gd_title04',
    					'label'   => 'タイトル4',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'gd_body04',
    					'label'   => '記事本文4',
    					'rules'   => 'trim|max_length[1000]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
