<?php

class Entryconf extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // セッション書き込み

    }

    // 管理者新規会員登録TOP
    public function edit()
    {

    	// セッションのチェック



    	// URIセグメントの取得
        //$this->load->helper('url');
    	$segments = $this->uri->segment_array();
    	$this->_ac_seq  = $segments[3];
    	$this->_ac_auth = $segments[4];

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定
//     	$this->form_validation->run();

    	// 管理者情報の読み込み
        $this->load->model('Account', 'ac', TRUE);
    	$arrData = $this->ac->get_ac_seq($this->_ac_seq);
    	if (count($arrData) != 0)
    	{
    		foreach ($arrData as $val) {
    			$_tmp_type       = $val['ac_type'];
    			$_tmp_department = $val['ac_department'];
    			$_tmp_name01     = $val['ac_name01'];
    			$_tmp_name02     = $val['ac_name02'];
    			$_tmp_id         = $val['ac_id'];
    			$_tmp_auth       = $val['ac_auth'];
    			$_tmp_update     = $val['ac_update_date'];
    		}
    	} else {
    		$this->view('entryconf/end_ng.tpl');
    		return;
    	}

    	// KEYチェック
    	if ($this->_ac_auth != $_tmp_auth)
    	{
    		$this->view('entryconf/end_ng.tpl');
    		return;
    	}

    	// 制限時間チェック
    	$result_timechk = $this->_reentry_timechk($_tmp_update);
    	if ($result_timechk)
    	{
    		$this->view('entryconf/end_ng.tpl');
    		return;
    	}

    	// 初期値セット
    	$this->_item_set02($_tmp_type);

    	$this->smarty->assign('ac_seq'       , $this->_ac_seq);
    	$this->smarty->assign('ac_type'      , $_tmp_type);
    	$this->smarty->assign('ac_department', $_tmp_department);
    	$this->smarty->assign('ac_name01'    , $_tmp_name01);
    	$this->smarty->assign('ac_name02'    , $_tmp_name02);
    	$this->smarty->assign('ac_id'        , $_tmp_id);

    	$this->smarty->assign('err_passwd', FALSE);

    	$this->view('entryconf/edit.tpl');

    }

    // 確認画面表示
    public function confirm()
    {

    	// セッションのチェック

    	// 初期値セット
    	$this->_item_set02($this->input->post('ac_type'));

    	// 管理者情報の読み込み
    	$this->load->model('Account', 'ac', TRUE);
    	$arrData = $this->ac->get_ac_seq($this->input->post('ac_seq'));
    	foreach ($arrData as $val) {
    		$_tmp_type       = $val['ac_type'];
    		$_tmp_department = $val['ac_department'];
    		$_tmp_name01     = $val['ac_name01'];
    		$_tmp_name02     = $val['ac_name02'];
    		$_tmp_id         = $val['ac_id'];
    		$_tmp_auth       = $val['ac_auth'];
    		$_tmp_update     = $val['ac_update_date'];
    	}

    	$this->smarty->assign('ac_seq'       , $this->input->post('ac_seq'));
    	$this->smarty->assign('ac_type'      , $_tmp_type);
    	$this->smarty->assign('ac_department', $_tmp_department);
    	$this->smarty->assign('ac_name01'    , $_tmp_name01);
    	$this->smarty->assign('ac_name02'    , $_tmp_name02);
    	$this->smarty->assign('ac_id'        , $_tmp_id);

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    		$this->smarty->assign('err_passwd', FALSE);
    		$this->view('entryconf/edit.tpl');
    	} else {
    		// パスワード再入力チェック
    		if ($this->input->post('ac_pw') !== $this->input->post('retype_password')) {
    			$this->smarty->assign('err_passwd', TRUE);
    			$this->view('entryconf/edit.tpl');
    			return;
    		}

    		$this->view('entryconf/confirm.tpl');
    	}
    }

    // 完了画面表示
    public function complete()
    {

    	// セッションのチェック

    	// バリデーション・チェック
    	$this->_set_validation();
    	$this->form_validation->run();

    	// 初期値セット
    	$this->_item_set02($this->input->post('ac_type'));

    	// 管理者情報の読み込み
    	$this->load->model('Account', 'ac', TRUE);
    	$arrData = $this->ac->get_ac_seq($this->input->post('ac_seq'));
    	foreach ($arrData as $val) {
    		$_tmp_type       = $val['ac_type'];
    		$_tmp_department = $val['ac_department'];
    		$_tmp_name01     = $val['ac_name01'];
    		$_tmp_name02     = $val['ac_name02'];
    		$_tmp_id         = $val['ac_id'];
    		$_tmp_auth       = $val['ac_auth'];
    		$_tmp_update     = $val['ac_update_date'];
    	}

    	$this->smarty->assign('ac_seq'       , $this->input->post('ac_seq'));
    	$this->smarty->assign('ac_type'      , $_tmp_type);
    	$this->smarty->assign('ac_department', $_tmp_department);
    	$this->smarty->assign('ac_name01'    , $_tmp_name01);
    	$this->smarty->assign('ac_name02'    , $_tmp_name02);
    	$this->smarty->assign('ac_id'        , $_tmp_id);

    	// 「戻る」ボタン押下の場合
    	if ( $this->input->post('_back') ) {
    		$this->smarty->assign('err_passwd', FALSE);
    		$this->view('entryconf/edit.tpl');
    		return;
    	}

    	// ログインID(メールアドレス)の重複チェック
    	$this->load->model('Account', 'ac', TRUE);

    	if ($this->ac->check_loginid($this->input->post('ac_id'), TRUE)) {
    		$this->smarty->assign('err_passwd', FALSE);
    		$this->view('entryconf/edit.tpl');
    		return;
    	}

    	// DB書き込み
    	$_setData["ac_seq"]    = $this->input->post('ac_seq');
    	$_setData["ac_status"] = 1;
    	$_setData["ac_pw"]     = $this->input->post('ac_pw');

    	$res = $this->ac->update_account($_setData, TRUE);
    	if (!$res)
    	{
    		log_message('error', 'Entryconf::[complete()]管理者PW登録処理 insert_accountエラー');
    	}

    	// メール送信先設定
    	$mail['from']      = "";
    	$mail['from_name'] = "";
    	$mail['subject']   = "";
    	$mail['to']        = $_tmp_id;
    	$mail['cc']        = "";
    	$mail['bcc']       = "";

    	// メール本文置き換え文字設定
    	$arrRepList = array(
    			'ac_name01'      => $_tmp_name01,
    			'ac_name02'      => $_tmp_name02,
    			'ac_id'          => $_tmp_id,
    	);

    	// メールテンプレートの読み込み
    	$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    	$mail_tpl = $this->config->item('MAILTPL_ENT_ADMINPW_ID');

    	// メール送信
    	$this->load->model('Mailtpl', 'mailtpl', TRUE);
    	if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    		$this->view('entryconf/end_ok.tpl');
    	} else {
    		echo "メール送信エラー";
    		log_message('error', 'Entryconf::[complete()]管理者登録処理 メール送信エラー');
    		$this->view('entryconf/end_ng.tpl');
    	}

    }

    // 完了画面表示
    public function end_ok()
    {

    	redirect('/login/');

    }

    // 完了画面表示
    public function end_ng()
    {

    	redirect('/login/');

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
    private function _item_set02($_tmp_type)
    {

    	// 管理者登録状態セット
    	$this->config->load('config_status');
    	$arroptions_ac_status = $this->config->item('ADMIN_ACCOUNT_STATUS');

    	// 管理者種類セット
    	$this->config->load('config_comm');
    	$arroptions_ac_type = $this->config->item('ADMIN_ACCOUNT_TYPE');

    	$this->smarty->assign('options_ac_status',  $arroptions_ac_status);
    	$this->smarty->assign('options_ac_type',  $arroptions_ac_type);
    	$this->smarty->assign('account_type', $arroptions_ac_type[$_tmp_type]);

    }




    // 仮パスワード変更制限時間チェック
    private function _reentry_timechk($update_date)
    {
    	$this->config->load('config_comm');
    	$tmp_reentrytime = $this->config->item('ADMIN_ADD_LIMITTIME');					// 仮パスワード保持制限時間設定
    	$count_time = date('Y-m-d H:i:s', strtotime($update_date . "+" . $tmp_reentrytime .  " minute"));

    	$time = time();
    	$tmp_nowtime = date("Y-m-d H:i:s", $time);

    	if (strtotime($count_time) <= strtotime($tmp_nowtime))
    	{
    		return TRUE;
    	}

    	return FALSE;

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
