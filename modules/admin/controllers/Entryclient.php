<?php

class Entryclient extends MY_Controller
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

        $this->smarty->assign('err_siteid',  FALSE);
        $this->smarty->assign('err_clid',    FALSE);

    }

    // 管理者新規会員登録TOP
    public function index()
    {

    	// セッションのチェック

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定
    	$this->form_validation->run();

//     	// 初期値セット
//     	$this->_item_set01();

    	// 担当編集リスト作成
    	$this->load->model('Account', 'ac', TRUE);
    	$this->_item_editor();

    	// 担当営業リスト作成
    	$this->_item_sales();

        $this->view('entryclient/index.tpl');

    }

    // 確認画面表示
    public function confirm()
    {

    	$this->getData = $this->input->post();

    	// 担当編集リスト作成
    	$this->load->model('Account', 'ac', TRUE);
    	$this->_item_editor($this->getData["cl_editor_id"]);

    	// 担当営業リスト作成
    	$this->_item_sales($this->getData["cl_sales_id"]);

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    		$this->view('entryclient/index.tpl');
    	} else {
    		$this->load->model('Client', 'cl', TRUE);

    		// サイトID(URL名)入力チェック
    		if (isset($this->getdata["cl_siteid"]))
    		{
	    		if ($this->cl->check_siteid($this->getData["cl_seq"], $this->getData["cl_siteid"])) {
	    			$this->smarty->assign('err_siteid', TRUE);
	    			$this->view('entryclient/index.tpl');
	    			return;
	    		}
    		}

    		// ログインID入力チェック
    		if (isset($this->getdata["cl_id"]))
    		{
	    		if ($this->cl->check_loginid($this->getData["cl_seq"], $this->getData["cl_id"])) {
	    			$this->smarty->assign('err_clid', TRUE);
	    			$this->view('entryclient/index.tpl');
	    			return;
	    		}
    		}

    		$this->view('entryclient/confirm.tpl');
    	}
    }

    // 完了画面表示
    public function complete()
    {

    	// セッションのチェック

    	// バリデーション・チェック
    	$this->_set_validation();
    	$this->form_validation->run();

    	// 担当編集リスト作成
    	$this->load->model('Account', 'ac', TRUE);
    	$this->_item_editor();

    	// 担当営業リスト作成
    	$this->_item_sales();

//     	// 初期値セット
//     	$this->_item_set01();

    	// 「戻る」ボタン押下の場合
    	if ( $this->input->post('_back') ) {
//     		$this->smarty->assign('err_email',  FALSE);
//     		$this->smarty->assign('err_passwd', FALSE);
    		$this->view('entryclient/index.tpl');
    		return;
    	}

    	// DB書き込み
    	$this->setData = $this->input->post();

    	// 担当編集者＆営業のＩＤを取り出す
    	$_tmp_editor_id = explode(' : ', $this->setData['_editor_id'], 3);
    	$this->setData['cl_editor_id'] = $_tmp_editor_id[0];
    	$_tmp_salse_id = explode(' : ', $this->setData['_sales_id'], 3);
    	$this->setData['cl_sales_id'] = $_tmp_salse_id[0];

    	// authキーの作成
    	$_tmp_authkey = $this->_makeRandStr();
    	$this->setData["cl_auth"]     = $_tmp_authkey;
    	$this->setData["cl_admin_id"] = $_SESSION['a_memSeq'];

    	// 不要パラメータ削除
    	unset($this->setData["_sales_id"]) ;
    	unset($this->setData["_editor_id"]) ;
    	unset($this->setData["submit"]) ;
    	unset($this->setData["retype_password"]) ;

    	$this->load->model('Client', 'cl', TRUE);
    	$_row_id = $this->cl->insert_client($this->setData, TRUE);
    	if (!is_numeric($_row_id))
    	{
    		log_message('error', 'entryclient::[complete()]クライアント登録処理 insert_clientエラー');
    	}

    	// メール送信先設定
    	$mail['from']      = "";
    	$mail['from_name'] = "";
    	$mail['subject']   = "";
    	$mail['to']        = $this->setData["cl_mail"];
    	$mail['cc']        = "";
    	$mail['bcc']       = "";

    	// メール本文置き換え文字設定
        $this->config->load('config_comm');
        $tmp_limittime = $this->config->item('CLIENT_ADD_LIMITTIME');						// 仮登録制限時間設定

        $tmp_uri = site_url() . 'entryconf/cl_edit/' . $_row_id . '/' . $_tmp_authkey ;		// 本登録URI設定

    	$arrRepList = array(
    			'cl_company'     => $this->input->post('cl_company'),
    			'cl_president01' => $this->input->post('cl_president01'),
    			'cl_president02' => $this->input->post('cl_president02'),
    			'tmp_uri'        => $tmp_uri,
                'tmp_limittime'  => $tmp_limittime,
    	);

    	// メールテンプレートの読み込み
    	$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    	$mail_tpl = $this->config->item('MAILTPL_ENT_CLIENT_ID');

    	// メール送信
    	$this->load->model('Mailtpl', 'mailtpl', TRUE);
    	if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    		$this->view('entryclient/end.tpl');
    	} else {
    		echo "メール送信エラー";
    		log_message('error', 'entryclient::[complete()]クライアント登録処理 メール送信エラー');
    		$this->view('entryclient/end.tpl');
    	}

    }






//     // 初期値セット
//     private function _item_set01()
//     {

//     	// 管理者登録状態セット
//         $this->config->load('config_status');
//         $arroptions_ac_status = $this->config->item('ADMIN_ACCOUNT_STATUS');

//     	// 管理者種類セット
//         $this->config->load('config_comm');
//         $arroptions_ac_type = $this->config->item('ADMIN_ACCOUNT_TYPE');

//     	$this->smarty->assign('options_ac_status',  $arroptions_ac_status);
//     	$this->smarty->assign('options_ac_type',  $arroptions_ac_type);

//     }

//     // 初期値セット
//     private function _item_set02()
//     {

//     	// 管理者登録状態セット
//     	$this->config->load('config_status');
//     	$arroptions_ac_status = $this->config->item('ADMIN_ACCOUNT_STATUS');

//     	// 管理者種類セット
//     	$this->config->load('config_comm');
//     	$arroptions_ac_type = $this->config->item('ADMIN_ACCOUNT_TYPE');

//     	$this->smarty->assign('options_ac_status',  $arroptions_ac_status);
//     	$this->smarty->assign('options_ac_type',  $arroptions_ac_type);
//     	$this->smarty->assign('account_type', $arroptions_ac_type[$this->input->post('ac_type')]);

//     }


    // 担当営業リスト作成
    private function _item_sales($cl_sales_id = NULL)
    {

	    $_salse_list = $this->ac->get_contact(1);

	    foreach ($_salse_list as $value) {
	    	foreach ($value as $key => $val) {
				if ($key == 'ac_seq')
				{
					$_name = $val . ' : ';
				} elseif ($key == 'ac_name01') {
					$_name = $_name . $val;
				} else {
					$arroptions_cl_sales[] = $_name . ' ' . $val;
				}
	    	}
	    }

	    if ($cl_sales_id == NULL)
	    {
	    	$this->smarty->assign('options_cl_sales_id',  $arroptions_cl_sales);
	    } else {
	    	$_salse_num = intval($cl_sales_id);
	    	$this->smarty->assign('options_cl_sales_id',  $arroptions_cl_sales[$_salse_num]);
	    }
    }

    // 担当編集リスト作成
    private function _item_editor($cl_editor_id = NULL)
    {

    	$_editor_list = $this->ac->get_contact(0);

	    foreach ($_editor_list as $value) {
	    	foreach ($value as $key => $val) {
				if ($key == 'ac_seq')
				{
					$_name = $val . ' : ';
				} elseif ($key == 'ac_name01') {
					$_name = $_name . $val;
				} else {
					$arroptions_cl_editor[] = $_name . ' ' . $val;
				}
	    	}
	    }

	    if ($cl_editor_id == NULL)
	    {
	    	$this->smarty->assign('options_cl_editor_id',  $arroptions_cl_editor);
	    } else {
	    	$_editor_num = intval($cl_editor_id);
	    	$this->smarty->assign('options_cl_editor_id',  $arroptions_cl_editor[$_editor_num]);
	    }
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
    					'field'   => 'cl_sales_id',
    					'label'   => '担当営業選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'cl_editor_id',
    					'label'   => '担当編集者選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'cl_contract_str',
    					'label'   => '契約開始日',
    					'rules'   => 'trim|regex_match[/^\d{4}\/\d{1,2}\/\d{1,2}+$/]|max_length[10]'
    			),
    			array(
    					'field'   => 'cl_contract_end',
    					'label'   => '契約終了日',
    					'rules'   => 'trim|regex_match[/^\d{4}\/\d{1,2}\/\d{1,2}+$/]|max_length[10]'
    			),
    			array(
    					'field'   => 'cl_siteid',
    					'label'   => 'サイトID(URL名)',
    					'rules'   => 'trim|alpha_numeric|max_length[20]'				// 英数字のみ
    			),
    			array(
    					'field'   => 'cl_id',
    					'label'   => 'ログインID',
    					'rules'   => 'trim|alpha_dash|max_length[20]'					// 英数字、アンダースコア("_")、ダッシュ("-") のみ
    			),
    			array(
    					'field'   => 'cl_pw',
    					'label'   => '仮パスワード',
    					'rules'   => 'trim|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]'
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
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
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
