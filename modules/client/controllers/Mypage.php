<?php

class Mypage extends MY_Controller
{

    public function __construct()
    {
            parent::__construct();

        if ($_SESSION['c_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_Seq',   $_SESSION['c_memSeq']);
            $this->smarty->assign('mem_Name',  $_SESSION['c_memName']);
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_Seq',   "");
            $this->smarty->assign('mem_Name',  "");

            redirect('/login/');
        }
    }

    // マイページTOP
    public function index()
    {

        $this->view('mypage/index.tpl');

    }

    // サポート問合せフォーム
    public function contact()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$this->view('mypage/contact.tpl');

    }

    // 完了画面表示
    public function end()
    {

        // バリデーション・チェック
		$this->_set_validation();                                             // バリデーション設定
        $this->form_validation->run();

        // 「戻る」ボタン押下の場合
        if ( $this->input->post('_back') ) {
            $this->view('mypage/contact.tpl');
            return;
        }

        // メール送信先設定
        $mail['from']      = "";
        $mail['from_name'] = "";
        $mail['subject']   = "";
        $mail['to']        = "";
        $mail['cc']        = $this->input->post('inputEmail');
        $mail['bcc']       = "";

        // メール本文置き換え文字設定
        $arrRepList = array(
                'inputName'    => $this->input->post('inputName'),
                'inputEmail'   => $this->input->post('inputEmail'),
                'inputTel'     => $this->input->post('inputTel'),
                'inputComment' => $this->input->post('inputComment')
        );

        // メールテンプレートの読み込み
        $this->config->load('config_mailtpl');                                  // メールテンプレート情報読み込み
        $mail_tpl = $this->config->item('MAILTPL_CONTACT_CL_ID');

        // メール送信
        $this->load->model('Mailtpl', 'mailtpl', TRUE);
        if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl, 3)) {
            $this->view('mypage/end.tpl');
        } else {
            echo "メール送信エラー";
            $this->view('mypage/end.tpl');
        }

    }

    // 確認画面表示
    public function confirm()
    {

        // バリデーション・チェック
		$this->_set_validation();												// バリデーション設定
        if ($this->form_validation->run() == FALSE)
        {
            $this->view('mypage/contact.tpl');
        } else {
            $this->view('mypage/confirm.tpl');
        }

    }

    // 基本設定情報の変更
    public function info()
    {

    	$this->smarty->assign('err_clid',  FALSE);
    	$this->smarty->assign('err_passwd',  FALSE);

    	$input_post = $this->input->post();

    	$this->load->model('Client', 'cl', TRUE);
    	$clseq_deta = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);


    	if (isset($input_post['submit']) && ($input_post['submit'] == 'idpw'))
    	{

    		// IDおよびパスワード更新

	    	// バリデーション・チェック
    		$this->_set_validation01();
	    	if ($this->form_validation->run() == TRUE)
	    	{

	    		// パスワード再入力チェック
	    		if ($input_post['cl_pw'] !== $input_post['retype_password']) {
	    			$this->smarty->assign('err_passwd', TRUE);
	    			$this->view('mypage/chidpw.tpl');
	    			return;
	    		}

	    		// ログインID入力チェック
	    		if ($this->cl->check_loginid($clseq_deta[0]["cl_seq"], $input_post["cl_id"])) {

	    			$this->smarty->assign('err_clid', TRUE);
	    			$this->smarty->assign('list', $clseq_deta[0]);

	    			$this->view('mypage/chgidpw.tpl');
	    			return;
	    		}

	    		$set_data["cl_seq"] = $_SESSION['c_memSeq'];
	    		$set_data["cl_id"]  = $input_post['cl_id'];
	    		$set_data["cl_pw"]  = $input_post['cl_pw'];

	    		$res = $this->cl->update_client($set_data, TRUE, 3);
	    		if (!$res)
	    		{
	    			log_message('error', 'Mypage::[info()]クライアントIDPW変更処理 update_clientエラー');
	    		}

	    	}
    	} elseif (isset($input_post['submit']) && ($input_post['submit'] == 'blog')) {

    		// ブログ基本設定

    		// バリデーション・チェック
    		$this->_set_validation02();
    		if ($this->form_validation->run() == TRUE)
    		{

    			$set_data["cl_seq"]           = $_SESSION['c_memSeq'];
    			$set_data["cl_blog_title"]    = $input_post['cl_blog_title'];
    			$set_data["cl_blog_overview"] = $input_post['cl_blog_overview'];
    			$set_data["cl_blog_status"]   = $input_post['optionsRadios01'];

    			$res = $this->cl->update_client($set_data, FALSE, 3);
    			if (!$res)
    			{
    				log_message('error', 'Mypage::[info()]ブログ基本設定情報変更処理 update_clientエラー');
    			}

    		}

    	} else {
    		$this->_set_validation01();
    		$this->_set_validation02();
    	}

    	// クライアント情報再読み込み
    	$clseq_deta = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);

    	$this->smarty->assign('cl_id',            $clseq_deta[0]['cl_id']);
    	$this->smarty->assign('cl_blog_title',    $clseq_deta[0]['cl_blog_title']);
    	$this->smarty->assign('cl_blog_overview', $clseq_deta[0]['cl_blog_overview']);
    	$this->smarty->assign('cl_blog_status',   $clseq_deta[0]['cl_blog_status']);

    	$this->view('mypage/info.tpl');

    }

    // フォーム・バリデーションチェック :: サポート問合せ
    private function _set_validation()
    {
            $rule_set = array(
				array(
						'field'   => 'inputName',
						'label'   => '名前',
						'rules'   => 'trim|required|max_length[50]'
				),
				array(
						'field'   => 'inputEmail',
						'label'   => 'メールアドレス',
						'rules'   => 'trim|required|valid_email'
				),
				array(
						'field'   => 'inputTel',
						'label'   => '連絡先',
						'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
				),
				array(
						'field'   => 'inputComment',
						'label'   => 'お問合せ内容',
						'rules'   => 'trim|max_length[1000]'
				)
        );

        $this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック :: IDおよびパスワード更新
    private function _set_validation01()
    {

    	$rule_set = array(
    			array(
    					'field'   => 'cl_id',
    					'label'   => 'ログインID',
    					'rules'   => 'trim|required|alpha_dash|max_length[20]'		// 英数字、アンダースコア("_")、ダッシュ("-") のみ
    			),
    			array(
    					'field'   => 'cl_pw',
    					'label'   => 'パスワード',
    					'rules'   => 'trim|required|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]|matches[retype_password]'
    			),
    			array(
    					'field'   => 'retype_password',
    					'label'   => 'パスワード再入力',
    					'rules'   => 'trim|required|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]|matches[cl_pw]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

    // フォーム・バリデーションチェック :: ブログ基本設定
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'cl_blog_title',
    					'label'   => 'ブログ・タイトル',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'cl_blog_overview',
    					'label'   => 'ブログ・概要',
    					'rules'   => 'trim|max_length[500]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }


}
