<?php

class Entryconf extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // セッション書き込み
        if (isset($_SESSION['ticket']))
        {
        } else {
        	$_SESSION['ticket'] = md5(uniqid(mt_rand(), true));
        }

    }

    // アカウント新規会員登録TOP
    public function edit()
    {

    	// セッションのチェック
    	if (isset($_SESSION['ticket'])) {
    		$this->smarty->assign('ticket', $_SESSION['ticket']);
    	} else {
    		$message = 'セッション・エラーが発生しました。';
    		show_error($message, 400);
    	}

    	// URIセグメントの取得
    	$_segment_count = $this->uri->total_segments();
    	if ($_segment_count != 4)
    	{
    		show_404();
    	}

    	$segments = $this->uri->segment_array();
    	$this->_ac_seq  = $segments[3];
    	$this->_ac_auth = $segments[4];

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定
//     	$this->form_validation->run();

    	// アカウント情報の読み込み
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
    		show_404();
//     		$this->view('entryconf/end_ng.tpl');
    		return;
    	}

    	// KEYチェック
    	if ($this->_ac_auth != $_tmp_auth)
    	{
    		show_404();
//     		$this->view('entryconf/end_ng.tpl');
    		return;
    	}

    	// 制限時間チェック
    	$result_timechk = $this->_reentry_timechk($_tmp_update);
    	if ($result_timechk)
    	{
    		$messages = array('登録の制限時間がオーバーしてしまいました。', '', '弊社担当営業までご連絡ください。');
    		show_error($messages, 404, '制限時間オーバー');
//     		$this->view('entryconf/end_ng.tpl');
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
        $this->ticket = $_SESSION['ticket'];
        if (!$this->input->post('ticket') || $this->input->post('ticket') !== $_SESSION['ticket']) {
            $message = 'セッション・エラーが発生しました。';
            show_error($message, 400);
        } else {
            $this->smarty->assign('ticket', $_SESSION['ticket']);
        }

    	// 初期値セット
    	$this->_item_set02($this->input->post('ac_type'));

    	// アカウント情報の読み込み
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
        $this->ticket = $_SESSION['ticket'];
        if (!$this->input->post('ticket') || $this->input->post('ticket') !== $_SESSION['ticket']) {
            $message = 'セッション・エラーが発生しました。';
            show_error($message, 400);
        } else {
            $this->smarty->assign('ticket', $_SESSION['ticket']);
        }

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
    	$_setData["ac_auth"]   = NULL;

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














    // クライアント新規会員登録TOP
    public function cl_edit()
    {

    	// セッションのチェック
    	if (isset($_SESSION['ticket'])) {
    		$this->smarty->assign('ticket', $_SESSION['ticket']);
    	} else {
    		$message = 'セッション・エラーが発生しました。';
    		show_error($message, 400);
    	}

    	// URIセグメントの取得
    	$_segment_count = $this->uri->total_segments();
    	if ($_segment_count != 4)
    	{
    		show_404();
    	}

    	$segments = $this->uri->segment_array();
    	$this->_cl_seq  = $segments[3];
    	$this->_cl_auth = $segments[4];

    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

    	// クライアント情報の読み込み
    	$this->load->model('Client', 'cl', TRUE);
    	$arrData = $this->cl->get_cl_seq($this->_cl_seq);
    	if (count($arrData) != 0)
    	{
    		foreach ($arrData as $val) {
    			$_tmp_cl_siteid      = $val['cl_siteid'];
    			$_tmp_cl_id          = $val['cl_id'];
    			$_tmp_cl_company     = $val['cl_company'];
    			$_tmp_cl_president01 = $val['cl_president01'];
    			$_tmp_cl_president02 = $val['cl_president02'];
    			$_tmp_cl_department  = $val['cl_department'];
    			$_tmp_cl_person01    = $val['cl_person01'];
    			$_tmp_cl_person02    = $val['cl_person02'];
    			$_tmp_cl_tel         = $val['cl_tel'];
    			$_tmp_cl_mobile      = $val['cl_mobile'];
    			$_tmp_cl_fax         = $val['cl_fax'];
    			$_tmp_cl_mail        = $val['cl_mail'];
    			$_tmp_cl_mailsub     = $val['cl_mailsub'];
    			$_tmp_cl_auth        = $val['cl_auth'];
    			$_tmp_cl_update_date = $val['cl_update_date'];
    		}
    	} else {
    		show_404();
    		return;
    	}

    	// KEYチェック
    	if ($this->_cl_auth != $_tmp_cl_auth)
    	{
    		show_404();
    		return;
    	}

    	// 制限時間チェック
    	$result_timechk = $this->_reentry_timechk($_tmp_cl_update_date);
    	if ($result_timechk)
    	{
    		$messages = array('登録の制限時間がオーバーしてしまいました。', '', '弊社担当営業またはサポートセンターまでご連絡ください。');
    		show_error($messages, 404, '制限時間オーバー');
    		return;
    	}

	    $this->smarty->assign('cl_seq'         , $this->_cl_seq);
	    $this->smarty->assign('cl_siteid'      , $_tmp_cl_siteid);
	    $this->smarty->assign('cl_id'          , $_tmp_cl_id);
	    $this->smarty->assign('cl_company'     , $_tmp_cl_company);
	    $this->smarty->assign('cl_president01' , $_tmp_cl_president01);
	    $this->smarty->assign('cl_president02' , $_tmp_cl_president02);
	    $this->smarty->assign('cl_department'  , $_tmp_cl_department) ;
	    $this->smarty->assign('cl_person01'    , $_tmp_cl_person01);
	    $this->smarty->assign('cl_person02'    , $_tmp_cl_person02);
	    $this->smarty->assign('cl_tel'         , $_tmp_cl_tel);
	    $this->smarty->assign('cl_mobile'      , $_tmp_cl_mobile);
	    $this->smarty->assign('cl_fax'         , $_tmp_cl_fax);
	    $this->smarty->assign('cl_mail'        , $_tmp_cl_mail);
	    $this->smarty->assign('cl_mailsub'     , $_tmp_cl_mailsub);

    	$this->smarty->assign('err_siteid',      FALSE);
    	$this->smarty->assign('err_clid',        FALSE);
    	$this->smarty->assign('err_mail',        FALSE);
    	$this->smarty->assign('err_passwd',      FALSE);
    	$this->smarty->assign('err_checkKiyaku', FALSE);

    	$this->view('entryconf/cl_edit.tpl');

    }

    // クライアント確認画面表示
    public function cl_confirm()
    {

    	// セッションのチェック
    	$this->ticket = $_SESSION['ticket'];
    	if (!$this->input->post('ticket') || $this->input->post('ticket') !== $_SESSION['ticket']) {
    		$message = 'セッション・エラーが発生しました。';
    		show_error($message, 400);
    	} else {
    		$this->smarty->assign('ticket', $_SESSION['ticket']);
    	}

    	$getData = $this->input->post();

    	// クライアント情報の読み込み
	    $this->smarty->assign('cl_seq'         , $getData['cl_seq']);
	    $this->smarty->assign('cl_siteid'      , $getData['cl_siteid']);
	    $this->smarty->assign('cl_id'          , $getData['cl_id']);
	    $this->smarty->assign('cl_pw'          , $getData['cl_pw']);
	    $this->smarty->assign('retype_password', $getData['retype_password']);
	    $this->smarty->assign('cl_company'     , $getData['cl_company']);
	    $this->smarty->assign('cl_president01' , $getData['cl_president01']);
	    $this->smarty->assign('cl_president02' , $getData['cl_president02']);
	    $this->smarty->assign('cl_department'  , $getData['cl_department']) ;
	    $this->smarty->assign('cl_person01'    , $getData['cl_person01']);
	    $this->smarty->assign('cl_person02'    , $getData['cl_person02']);
	    $this->smarty->assign('cl_tel'         , $getData['cl_tel']);
	    $this->smarty->assign('cl_mobile'      , $getData['cl_mobile']);
	    $this->smarty->assign('cl_fax'         , $getData['cl_fax']);
	    $this->smarty->assign('cl_mail'        , $getData['cl_mail']);
	    $this->smarty->assign('cl_mailsub'     , $getData['cl_mailsub']);

    	$this->smarty->assign('err_siteid',      FALSE);
    	$this->smarty->assign('err_clid',        FALSE);
    	$this->smarty->assign('err_mail',        FALSE);
    	$this->smarty->assign('err_passwd',      FALSE);
    	$this->smarty->assign('err_checkKiyaku', FALSE);

	    // バリデーション・チェック
    	$this->_set_validation02();
    	if ($this->form_validation->run() == FALSE) {
    		$this->view('entryconf/cl_edit.tpl');
    	} else {
    		// パスワード再入力チェック
    		if ($this->input->post('cl_pw') !== $this->input->post('retype_password')) {
    			$this->smarty->assign('err_passwd', TRUE);
    			$this->view('entryconf/cl_edit.tpl');
    			return;
    		}

    		$this->load->model('Client', 'cl', TRUE);

    		// サイトID(URL名)入力チェック
    		if ($this->cl->check_siteid($getData['cl_seq'], $getData['cl_siteid'])) {
    			$this->smarty->assign('err_siteid', TRUE);
    			$this->view('entryconf/cl_edit.tpl');
    			return;
    		}

    		// ログインID入力チェック
    		if ($this->cl->check_loginid($getData['cl_seq'], $getData['cl_id'])) {
    			$this->smarty->assign('err_clid', TRUE);
    			$this->view('entryconf/cl_edit.tpl');
    			return;
    		}

    		// メールアドレス入力チェック
    		if ($this->cl->check_mailaddr($getData['cl_seq'], $getData['cl_mail'])) {
    			$this->smarty->assign('err_mail', TRUE);
    			$this->view('entryconf/cl_edit.tpl');
    			return;
    		}

    		if (!isset($getData['checkKiyaku'])) {
    			$this->smarty->assign('err_checkKiyaku', TRUE);
    			$this->view('entryconf/cl_edit.tpl');
    			return;
    		}

    		$this->view('entryconf/cl_confirm.tpl');
    	}
    }

    // クライアント完了画面表示
    public function cl_complete()
    {

    	// セッションのチェック
    	$this->ticket = $_SESSION['ticket'];
    	if (!$this->input->post('ticket') || $this->input->post('ticket') !== $_SESSION['ticket']) {
    		$message = 'セッション・エラーが発生しました。';
    		show_error($message, 400);
    	} else {
    		$this->smarty->assign('ticket', $_SESSION['ticket']);
    	}

    	// バリデーション・チェック
    	$this->_set_validation02();
    	$this->form_validation->run();

    	$getData = $this->input->post();

    	// クライアント情報の読み込み
	    $this->smarty->assign('cl_seq'         , $getData['cl_seq']);
	    $this->smarty->assign('cl_siteid'      , $getData['cl_siteid']);
	    $this->smarty->assign('cl_id'          , $getData['cl_id']);
	    $this->smarty->assign('cl_pw'          , $getData['cl_pw']);
	    $this->smarty->assign('cl_company'     , $getData['cl_company']);
	    $this->smarty->assign('cl_president01' , $getData['cl_president01']);
	    $this->smarty->assign('cl_president02' , $getData['cl_president02']);
	    $this->smarty->assign('cl_department'  , $getData['cl_department']) ;
	    $this->smarty->assign('cl_person01'    , $getData['cl_person01']);
	    $this->smarty->assign('cl_person02'    , $getData['cl_person02']);
	    $this->smarty->assign('cl_tel'         , $getData['cl_tel']);
	    $this->smarty->assign('cl_mobile'      , $getData['cl_mobile']);
	    $this->smarty->assign('cl_fax'         , $getData['cl_fax']);
	    $this->smarty->assign('cl_mail'        , $getData['cl_mail']);
	    $this->smarty->assign('cl_mailsub'     , $getData['cl_mailsub']);

    	$this->smarty->assign('err_siteid',      FALSE);
    	$this->smarty->assign('err_clid',        FALSE);
    	$this->smarty->assign('err_mail',        FALSE);
    	$this->smarty->assign('err_passwd',      FALSE);
    	$this->smarty->assign('err_checkKiyaku', FALSE);

    	// 「戻る」ボタン押下の場合
    	if ( $this->input->post('_back') ) {
    		$this->view('entryconf/cl_edit.tpl');
    		return;
    	}

    	// DB書き込み
    	$getData["cl_status"] = 2;
    	$getData["cl_plan"]   = "basic";
    	$getData["cl_auth"]   = NULL;

    	unset($getData["retype_password"]) ;
    	unset($getData["checkKiyaku"]) ;
    	unset($getData["ticket"]) ;
    	unset($getData["submit"]) ;

    	$this->load->model('Client', 'cl', TRUE);
    	$res = $this->cl->update_client($getData, TRUE);
    	if (!$res)
    	{
    		log_message('error', 'Entryconf::[complete()]クライアント承認処理 update_clientエラー');
    	}

    	// メール送信先設定
    	$mail['from']      = "";
    	$mail['from_name'] = "";
    	$mail['subject']   = "";
    	$mail['to']        = $getData['cl_mail'];
    	$mail['cc']        = "";
    	$mail['bcc']       = "";

    	// メール本文置き換え文字設定
    	$arrRepList = array(
    			'cl_company'     => $getData['cl_company'],
    			'cl_president01' => $getData['cl_president01'],
    			'cl_president02' => $getData['cl_president02'],
    			'cl_id'          => $getData['cl_id'],
    	);

    	// メールテンプレートの読み込み
    	$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    	$mail_tpl = $this->config->item('MAILTPL_ENT_CLIENTPW_ID');

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
    	$count_time = date('Y-m-d H:i:s', strtotime($update_date . " + " . $tmp_reentrytime .  " minute"));

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

    // フォーム・バリデーションチェック : アカウント
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

    // フォーム・バリデーションチェック : クライアント
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'cl_siteid',
    					'label'   => 'サイトID(URL名)',
    					'rules'   => 'trim|required|alpha_numeric|max_length[20]'			// 英数字のみ
    			),
    			array(
    					'field'   => 'cl_id',
    					'label'   => 'ログインID',
    					'rules'   => 'trim|required|alpha_dash|max_length[20]'				// 英数字、アンダースコア("_")、ダッシュ("-") のみ
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
    			array(
    					'field'   => 'cl_company',
    					'label'   => '会社名',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_president01',
    					'label'   => '代表者姓',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_president02',
    					'label'   => '代表者名',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_department',
    					'label'   => '所属部署',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_person01',
    					'label'   => '担当者姓',
    					'rules'   => 'trim|required|max_length[20]'
    			),
    			array(
    					'field'   => 'cl_person02',
    					'label'   => '担当者名',
    					'rules'   => 'trim|required|max_length[20]'
    			),
    			array(
    					'field'   => 'cl_tel',
    					'label'   => '担当者電話番号',
    					'rules'   => 'trim|required|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'cl_mobile',
    					'label'   => '担当者携帯番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'cl_fax',
    					'label'   => 'FAX番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'cl_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|required|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'cl_mailsub',
    					'label'   => 'メールアドレス(サブ)',
    					'rules'   => 'trim|max_length[100]|valid_email'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
