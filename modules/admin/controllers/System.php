<?php

class System extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['a_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_type',  $_SESSION['a_memType']);
            $this->smarty->assign('mem_Seq',   $_SESSION['a_memSeq']);
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_type',  "");
            $this->smarty->assign('mem_Seq',   "");

            redirect('/login/');
        }

    }

    // 初期表示
    public function index()
    {

        $this->view('system/index.tpl');

    }

    // 初期表示
    public function backup()
    {

    	// sh に記述

    	// DBのバックアップ
    	$app_path = "/home/fnote/www/fnote.com.dev/dbbackup/";
    	$strCommand = $app_path . 'backup4mysql.sh';
    	exec( $strCommand );

    	// システムのバックアップ
    	$app_path = "/home/fnote/www/fnote.com.dev/dbbackup/";
    	$strCommand = $app_path . 'backup4pg.sh';
    	exec( $strCommand );

    	$this->view('system/index.tpl');

    }

    // ログイン 初期表示
    public function mailtpl()
    {

        // バリデーション・チェック
        $this->_set_validation();												// バリデーション設定

        // 初期値セット
        $this->_init_set();

        // 全メールテンプレの取得
        $this->load->model('Mailtpl', 'mail', TRUE);
        $this->_get_mailtpl_title();

    	$this->view('system/mailtpl.tpl');

    }

    // メールテンプレ選択＆更新
    public function tpldetail()
    {

    	$this->load->model('Mailtpl', 'mail', TRUE);

    	// 全メールテンプレの取得
    	$this->_get_mailtpl_title();

    	$input_post = $this->input->post();
    	if ($input_post['submit'] == '_select')
    	{

    		// メールテンプレート選択
    		// バリデーション・チェック
    		$this->_set_validation();                                           // バリデーション設定

    		// 選択されたメールテンプレート詳細を表示
    		$mailtpl_data = $this->mail->get_mailtpl_list($input_post['mt_id']);
    		$mailtpl_info = $mailtpl_data[0];
    		$this->smarty->assign('mailtpl_info', $mailtpl_info);

    	} elseif ($input_post['submit'] == '_submit') {

    		// メールテンプレート更新
    		// バリデーション・チェック
    		$this->_set_validation();
    		if ($this->form_validation->run() == FALSE)
    		{
    			// 初期値セット
    		} else {

    			$set_update_data['mt_id']        = $input_post['mt_id'];        // テンプレID
    			$set_update_data['mt_subject']   = $input_post['mt_subject'];   // メール件名
    			$set_update_data['mt_body']      = $input_post['mt_body'];      // メール本文
    			$set_update_data['mt_from']      = $input_post['mt_from'];      // メールfrom
    			$set_update_data['mt_from_name'] = $input_post['mt_from_name']; // メールfrom名称
    			$set_update_data['mt_to']        = $input_post['mt_to'];        // メールto
    			$set_update_data['mt_cc']        = $input_post['mt_cc'];        // メールcc
    			$set_update_data['mt_bcc']       = $input_post['mt_bcc'];       // メールbcc

    			// UPDATE
    			$result = $this->mail->update_mailtpl_id($set_update_data);
    		}

    		// 初期値セット
    		$this->_init_set();

    	} else {
    	}

    	$this->view('system/mailtpl.tpl');

    }

    // 全メールテンプレの取得
    private function _get_mailtpl_title()
    {

    	$mailtpl_data = $this->mail->get_mailtpl_list();

    	$options_tpltitle = array();
    	foreach ($mailtpl_data as $key => $val)
    	{
    		$options_tpltitle[$mailtpl_data[$key]['mt_id']] = $mailtpl_data[$key]['mt_title'];
    	}

    	$this->smarty->assign('options_tpltitle', $options_tpltitle);

    }

    // 初期値セット
    private function _init_set()
    {

    	// 各項目を初期化
    	$mailtpl_info['mt_id']        = 1;
    	$mailtpl_info['mt_subject']   = NULL;
    	$mailtpl_info['mt_body']      = NULL;
    	$mailtpl_info['mt_from']      = NULL;
    	$mailtpl_info['mt_from_name'] = NULL;
    	$mailtpl_info['mt_to']        = NULL;
    	$mailtpl_info['mt_cc']        = NULL;
    	$mailtpl_info['mt_bcc']       = NULL;

    	$this->smarty->assign('mailtpl_info', $mailtpl_info);

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {

    	$rule_set = array(
    			array(
    					'field'   => 'mt_id',
    					'label'   => 'テンプレタイトル',
    					'rules'   => 'trim|required|numeric'
    			),
    			array(
    					'field'   => 'mt_subject',
    					'label'   => 'メール件名',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'mt_body',
    					'label'   => 'メール本文',
    					'rules'   => 'trim|required|max_length[1000]'
    			),
    			array(
    					'field'   => 'mt_from',
    					'label'   => 'メールfrom',
    					'rules'   => 'trim|required|valid_email|max_length[50]'
    			),
    			array(
    					'field'   => 'mt_from_name',
    					'label'   => 'メールfrom名称',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'mt_to',
    					'label'   => 'メールto',
    					'rules'   => 'trim|max_length[100]'
    			),
    			array(
    					'field'   => 'mt_cc',
    					'label'   => 'メールcc',
    					'rules'   => 'trim|max_length[100]'
    			),
    			array(
    					'field'   => 'mt_bcc',
    					'label'   => 'メールbcc',
    					'rules'   => 'trim|max_length[100]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

}
