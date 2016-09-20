<?php

class Entryadmin extends MY_Controller
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

        $this->smarty->assign('err_email',  FALSE);
        $this->smarty->assign('err_passwd', FALSE);

    }

    // 管理者新規会員登録TOP
    public function index()
    {

    	// セッションデータをクリア
    	$this->load->model('comm_auth', 'comm_auth', TRUE);
    	$this->comm_auth->delete_session('admin');

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定
    	$this->form_validation->run();

    	// 初期値セット
    	$this->_item_set01();

        $this->view('entryadmin/index.tpl');

    }

    // 確認画面表示
    public function confirm()
    {

    	// セッションのチェック

    	// 初期値セット
    	$this->_item_set02();

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    		$this->view('entryadmin/index.tpl');
    	} else {
    		// パスワード再入力チェック
    		if ($this->input->post('ac_pw') !== $this->input->post('retype_password')) {
    			$this->smarty->assign('err_passwd', TRUE);
    			$this->view('entryadmin/index.tpl');
    			return;
    		}

    		$this->view('entryadmin/confirm.tpl');
    	}
    }

    // 完了画面表示
    public function complete()
    {

    	// バリデーション・チェック
    	$this->_set_validation();
    	$this->form_validation->run();

    	// 初期値セット
    	$this->_item_set01();

    	// 「戻る」ボタン押下の場合
    	if ( $this->input->post('_back') ) {
    		$this->view('entryadmin/index.tpl');
    		return;
    	}

    	// ログインID(メールアドレス)の重複チェック
    	$this->load->model('Account', 'ac', TRUE);

    	if ($this->ac->check_loginid($this->input->post('ac_id'))) {
    		$this->smarty->assign('err_email',  TRUE);
    		$this->view('entryadmin/index.tpl');
    		return;
    	}

    	// DB書き込み
    	$input_post = $this->input->post();

    	// authキーの作成
    	$_tmp_authkey = $this->_makeRandStr();
    	$input_post["ac_auth"] = $_tmp_authkey;

    	// 不要パラメータ削除
    	unset($input_post["submit"]) ;
    	unset($input_post["retype_password"]) ;

    	$_row_id = $this->ac->insert_account($input_post, TRUE);
    	if (!is_numeric($_row_id))
    	{
    		log_message('error', 'Entryadmin::[complete()]管理者登録処理 insert_accountエラー');
    	}

    	// メール送信先設定
    	$mail['from']      = "";
    	$mail['from_name'] = "";
    	$mail['subject']   = "";
    	$mail['to']        = $input_post["ac_id"];
    	$mail['cc']        = "";
    	$mail['bcc']       = "";

    	// メール本文置き換え文字設定
        $this->config->load('config_comm');
        $tmp_limittime = $this->config->item('ADMIN_ADD_LIMITTIME');						// 仮登録制限時間設定

        $tmp_uri = site_url() . 'entryconf/edit/' . $_row_id . '/' . $_tmp_authkey ;		// 本登録URI設定

    	$arrRepList = array(
    			'ac_name01'      => $this->input->post('ac_name01'),
    			'ac_name02'      => $this->input->post('ac_name02'),
    			'tmp_uri'        => $tmp_uri,
                'tmp_limittime' => $tmp_limittime,
    	);

    	// メールテンプレートの読み込み
    	$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    	$mail_tpl = $this->config->item('MAILTPL_ENT_ADMIN_ID');

    	// メール送信
    	$this->load->model('Mailtpl', 'mailtpl', TRUE);
    	if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    		$this->view('entryadmin/end.tpl');
    	} else {
    		echo "メール送信エラー";
    		log_message('error', 'Entryadmin::[complete()]管理者登録処理 メール送信エラー');
    		$this->view('entryadmin/end.tpl');
    	}

    }

    // 初期値セット
    private function _item_set01()
    {

    	// 管理者登録状態セット
        $this->config->load('config_status');
        $arroptions_ac_status = $this->config->item('ADMIN_ACCOUNT_STATUS');

    	// 管理者種類セット
        $this->config->load('config_comm');
        $arroptions_ac_type = $this->config->item('ADMIN_ACCOUNT_TYPE');

    	$this->smarty->assign('options_ac_status',  $arroptions_ac_status);
    	$this->smarty->assign('options_ac_type',  $arroptions_ac_type);

    }

    // 初期値セット
    private function _item_set02()
    {

    	// 管理者登録状態セット
    	$this->config->load('config_status');
    	$arroptions_ac_status = $this->config->item('ADMIN_ACCOUNT_STATUS');

    	// 管理者種類セット
    	$this->config->load('config_comm');
    	$arroptions_ac_type = $this->config->item('ADMIN_ACCOUNT_TYPE');

    	$this->smarty->assign('options_ac_status',  $arroptions_ac_status);
    	$this->smarty->assign('options_ac_type',  $arroptions_ac_type);
    	$this->smarty->assign('account_type', $arroptions_ac_type[$this->input->post('ac_type')]);

    }

    /**
     * ランダム文字列の生成
     *
     * @return    varchar
     */
    private function _makeRandStr($length = 15)
    {

    	static $chars;
    	if (!$chars) {
    		$chars = array_flip(array_merge(
    				range('a', 'z'), range('A', 'Z'), range('0', '9')
    		));
    	}

    	$str = '';
    	for ($i = 0; $i < $length; ++$i) {
    		$str .= array_rand($chars);
    	}
    	return $str;

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'ac_type',
    					'label'   => '管理種類選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'ac_department',
    					'label'   => '所属部署',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'ac_name01',
    					'label'   => '担当者姓',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'ac_name02',
    					'label'   => '担当者名',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'ac_id',
    					'label'   => 'メールアドレス＆ログインID',
    					'rules'   => 'trim|required|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'ac_tel',
    					'label'   => '担当者電話番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'ac_mobile',
    					'label'   => '担当者携帯番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'ac_pw',
    					'label'   => 'パスワード',
    					'rules'   => 'trim|required|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]|matches[retype_password]'
    			),
    			array(
    					'field'   => 'retype_password',
    					'label'   => 'パスワード再入力',
    					'rules'   => 'trim|required|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]|matches[ac_pw]'
    			)
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }


}
