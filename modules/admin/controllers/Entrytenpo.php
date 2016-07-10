<?php

class Entrytenpo extends MY_Controller
{

// 	private $_options_pref;
// 	private $_pref_name;
// 	private $_cl_seq;
// 	private $_cl_siteid;
// 	private $_cl_id;
// 	private $test;

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


        $this->config->load('config_pref');										// 都道府県情報読み込み

        // 都道府県情報設定
        $this->_options_pref = $this->config->item('pref');
        $this->smarty->assign('opt_pref', $this->_options_pref);

        // 都道府県チェック
        if ($this->input->post('en_pref')) {
        	$pref_id = $this->input->post('en_pref');
        	$this->_pref_name = $this->_options_pref[$pref_id];
        }

    }

    // 店舗情報TOP
    public function index()
    {

        $this->view('entrytenpo/index.tpl');

    }

    // 店舗掲載情報TOP
    public function tenpo_edit()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	// 初期値セット
    	$this->_item_set01();

    	// クライアント情報取得
    	$post_data = $_POST;

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($post_data['chg_uniq'], TRUE);

    	// 一時保存
		$_SESSION['a_cl_seq']    = $cl_data[0]['cl_seq'];
    	$_SESSION['a_cl_siteid'] = $cl_data[0]['cl_siteid'];
		$_SESSION['a_cl_id']     = $cl_data[0]['cl_id'];

		// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);
    	$entry_data = $this->ent->get_entry_clid($cl_data[0]['cl_id']);
		if ($entry_data == FALSE)
		{
			// 空データを取得
			$entry_data = $this->ent->get_entry_clid($cl_data[0]['cl_id'], TRUE);

			$this->smarty->assign('list', $entry_data[0]);
		} else {
			$this->smarty->assign('list', $entry_data[0]);
		}

    	$this->view('entrytenpo/tenpo_edit.tpl');

    }

    // 確認画面表示
    public function tenpo_conf()
    {

    	$post_data = $_POST;

		if ($post_data['submit'] == 'preview')
		{
			$this->smarty->assign('list', $post_data);

			$this->view('entrytenpo/tenpo_pre.tpl');
			return;
		}


    	// 初期値セット
    	$this->_item_set01();

        // 都道府県チェック
        $this->smarty->assign('pref_name', $this->_pref_name);

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    	} else {

    		// データ設定
    		$post_data["en_cl_seq"]    = $_SESSION['a_cl_seq'];
    		$post_data["en_cl_id"]     = $_SESSION['a_cl_id'];
    		$post_data["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

    		// 不要パラメータ削除
    		unset($post_data["submit"]) ;

    		// DB書き込み
    		$this->load->model('Entry', 'ent', TRUE);
    		$_row_id = $this->ent->inup_tenpo($post_data);
    	}

		$this->smarty->assign('list', $post_data);
    	$this->view('entrytenpo/tenpo_edit.tpl');

    }

    // プレビュー画面表示
    public function tenpo_pre()
    {

    	$post_data = $_POST;

    	// 営業アクセスの場合
    	if ($_SESSION['a_memType'] == 1)
    	{

    		// クライアント情報取得
    		$this->load->model('Client', 'cl', TRUE);
    		$cl_data = $this->cl->get_cl_seq($post_data['chg_uniq'], TRUE);

    		// 店舗データの取得
    		$this->load->model('Entry', 'ent', TRUE);
    		$entry_data = $this->ent->get_entry_clseq($post_data['chg_uniq']);

    		$entry_data[0]['cl_status']  = $cl_data[0]['cl_status'];
    		$entry_data[0]['cl_comment'] = $cl_data[0]['cl_comment'];


//     		print_r($entry_data);
//     		print("<br><br>");

	    	$this->smarty->assign('list', $entry_data[0]);
	    	$this->view('entrytenpo/tenpo_pre.tpl');

	    	return;
    	}



    	$this->smarty->assign('list', $post_data);
    	$this->view('entrytenpo/tenpo_pre.tpl');

    }

    // 店舗記事情報TOP
    public function report_edit()
    {

    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

    	// 初期値セット
//     	$this->_item_set01();

    	// クライアント情報取得
    	$post_data = $_POST;

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($post_data['chg_uniq'], TRUE);

    	// 一時保存
    	$_SESSION['a_cl_seq']    = $cl_data[0]['cl_seq'];
    	$_SESSION['a_cl_siteid'] = $cl_data[0]['cl_siteid'];
    	$_SESSION['a_cl_id']     = $cl_data[0]['cl_id'];

    	// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);
    	$entry_data = $this->ent->get_entry_clid($cl_data[0]['cl_id']);
    	if ($entry_data == FALSE)
    	{
    		// 空データを取得
    		$entry_data = $this->ent->get_entry_clid($cl_data[0]['cl_id'], TRUE);

    		$this->smarty->assign('list', $entry_data[0]);
    	} else {
    		$this->smarty->assign('list', $entry_data[0]);
    	}

    	$this->view('entrytenpo/report_edit.tpl');

    }

    // 確認画面表示
    public function report_conf()
    {

    	$post_data = $_POST;

//     	print_r($post_data);
//     	print("<br><br>");


    	if ($post_data['submit'] == 'preview')
    	{
    		$this->smarty->assign('list', $post_data);

    		$this->view('entrytenpo/report_pre.tpl');
    		return;

    	} elseif ($post_data['submit'] == 'save') {

	    	// バリデーション・チェック
	    	$this->_set_validation02();
	    	if ($this->form_validation->run() == FALSE) {
	    		$this->smarty->assign('list', $post_data);
	    	} else {

	    		// データ設定
	    		$post_data["en_cl_seq"]    = $_SESSION['a_cl_seq'];
	    		$post_data["en_cl_id"]     = $_SESSION['a_cl_id'];
	    		$post_data["en_cl_siteid"] = $_SESSION['a_cl_siteid'];
	    		$post_data["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

	    		// 不要パラメータ削除
	    		unset($post_data["submit"]) ;

	    		// DB書き込み
	    		$this->load->model('Entry', 'ent', TRUE);
	    		$_row_id = $this->ent->inup_tenpo($post_data);

	    		// クライアントデータのステータス変更「編集」
	    		$this->load->model('Client', 'cl', TRUE);
	    		$set_data['cl_seq']    = $_SESSION['a_cl_seq'];
	    		$set_data['cl_status'] = 4;
	    		$this->cl->update_client($set_data);

		    	// 再表示用にデータの取得
		    	$this->load->model('Entry', 'ent', TRUE);
		    	$entry_data = $this->ent->get_entry_clid($post_data["en_cl_id"]);

	    		$this->smarty->assign('list', $entry_data[0]);

	    	}

	    } else {

	    	// バリデーション・チェック
	    	$this->_set_validation02();
	    	if ($this->form_validation->run() == FALSE) {
	    		$this->smarty->assign('list', $post_data);
	    	} else {
		    	// クライアントデータのステータス変更「営業確認」
		    	$this->load->model('Client', 'cl', TRUE);
		    	$set_data['cl_seq']     = $_SESSION['a_cl_seq'];
		    	$set_data['cl_status']  = 5;
		    	$set_data['cl_comment'] = NULL;
		    	$this->cl->update_client($set_data);

		    	// クライアントデータから担当営業を取得
		    	$clac_data = $this->cl->get_clac_seq($_SESSION['a_cl_seq'], NULL);

		    	// 営業へ承認メール送信。
		    	// メール送信先設定
		    	$mail['from']      = "";
		    	$mail['from_name'] = "";
		    	$mail['subject']   = "";
		    	$mail['to']        = $clac_data[0]['salseacmail'];
		    	$mail['cc']        = $clac_data[0]['adminacmail'];
		    	$mail['bcc']       = "";

		    	// メール本文置き換え文字設定
		    	$arrRepList = array(
		    			'ac_salsename01'  => $clac_data[0]['salsename01'],
		    			'ac_salsename02'  => $clac_data[0]['salsename02'],
		    			'cl_company'      => $clac_data[0]['cl_company'],
		    			'ac_editorname01' => $clac_data[0]['editorname01'],
		    			'ac_editorname02' => $clac_data[0]['editorname02'],
		    	);

		    	// メールテンプレートの読み込み
		    	$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
		    	$mail_tpl = $this->config->item('MAILTPL_SALSE_ACCEPT_D');

		    	// メール送信
		    	$this->load->model('Mailtpl', 'mailtpl', TRUE);
		    	if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
		    	} else {
		    		echo "メール送信エラー";
		    		log_message('error', 'Entryconf::[complete()]管理者登録処理 メール送信エラー');
		    	}

		    	// 再表示用にデータの取得
		    	$this->load->model('Entry', 'ent', TRUE);
		    	$entry_data = $this->ent->get_entry_clid($clac_data[0]['cl_id']);

		    	$this->smarty->assign('list', $entry_data[0]);
	    	}
    	}

	    $this->view('entrytenpo/report_edit.tpl');

    }

    // プレビュー画面表示
    public function request()
    {

    	$post_data = $_POST;

    	    	print_r($post_data);
    	//     	exit;

    	switch ($post_data['submit'])
    	{
            case 'salse_ok':

    			print("<br>salse_ok<br>");

    			// クライアントステータス変更：「6:クライアント確認」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $post_data['cl_seq'];
    			$set_data['cl_id']      = $post_data['cl_id'];
    			$set_data['cl_status']  = 6;
    			$set_data['cl_comment'] = $post_data['cl_comment'];

    			$this->cl->update_client($set_data);

    			// クライアントデータから担当営業を取得
    			$clac_data = $this->cl->get_clac_seq($post_data['cl_seq'], NULL);

    			// クライアントへ承認メール送信。
    			// メール送信先設定
    			$mail['from']      = "";
    			$mail['from_name'] = "";
    			$mail['subject']   = "";
    			$mail['to']        = $clac_data[0]['cl_mail'];
    			$mail['cc']        = $clac_data[0]['salseacmail'] . ";" . $clac_data[0]['adminacmail'];
    			$mail['bcc']       = "";

    			// メール本文置き換え文字設定
    			$arrRepList = array(
    					'cl_company'      => $clac_data[0]['cl_company'],
    					'cl_president01'  => $clac_data[0]['cl_president01'],
    					'cl_president02'  => $clac_data[0]['cl_president02'],
    					'ac_salsename01'  => $clac_data[0]['salsename01'],
    					'ac_salsename02'  => $clac_data[0]['salsename02'],
    			);

    			// メールテンプレートの読み込み
    			$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    			$mail_tpl = $this->config->item('MAILTPL_SALSE_OK_ID');

    			// メール送信
    			$this->load->model('Mailtpl', 'mailtpl', TRUE);
    			if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    			} else {
    				echo "メール送信エラー";
    				log_message('error', 'Entrytenpo::[request()]営業記事承認処理 メール送信エラー');
    			}

    			redirect('/clientlist/');

                break;
            case 'salse_ng':

    			print("<br>salse_ng<br>");

    			// クライアントステータス変更：「9:再編集」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $post_data['cl_seq'];
    			$set_data['cl_id']      = $post_data['cl_id'];
    			$set_data['cl_status']  = 9;
    			$set_data['cl_comment'] = $post_data['cl_comment'];

    			$this->cl->update_client($set_data);

    			// クライアントデータから担当者を取得
    			$clac_data = $this->cl->get_clac_seq($post_data['cl_seq'], NULL);

    			// クライアントへ承認メール送信。
    			// メール送信先設定
    			$mail['from']      = "";
    			$mail['from_name'] = "";
    			$mail['subject']   = "";
    			$mail['to']        = $clac_data[0]['editoracmail'];
    			$mail['cc']        = $clac_data[0]['salseacmail'] . ";" . $clac_data[0]['adminacmail'];
    			$mail['bcc']       = "";

    			// メール本文置き換え文字設定
    			$arrRepList = array(
    					'ac_editorname01' => $clac_data[0]['editorname01'],
    					'ac_editorname02' => $clac_data[0]['editorname02'],
    					'cl_company'      => $clac_data[0]['cl_company'],
//     					'cl_president01'  => $clac_data[0]['cl_president01'],
//     					'cl_president02'  => $clac_data[0]['cl_president02'],
    					'ac_salsename01'  => $clac_data[0]['salsename01'],
    					'ac_salsename02'  => $clac_data[0]['salsename02'],
    					'cl_comment'      => $post_data['cl_comment'],
    					'member'          => "営業",
    			);

    			// メールテンプレートの読み込み
    			$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    			$mail_tpl = $this->config->item('MAILTPL_SALSE_NG_ID');

    			// メール送信
    			$this->load->model('Mailtpl', 'mailtpl', TRUE);
    			if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    			} else {
    				echo "メール送信エラー";
    				log_message('error', 'Entrytenpo::[request()]営業記事非承認処理 メール送信エラー');
    			}

    			redirect('/clientlist/');

                break;
            case 'final':

    			print("<br>final<br>");







    			redirect('/clientlist/');

                break;
            default:
        }

//         // 再表示用にデータの取得
//         $this->load->model('Entry', 'ent', TRUE);
//         $entry_data = $this->ent->get_entry_clid($clac_data[0]['cl_id']);

//         $entry_data[0]['cl_status'] = 99;

//         $this->smarty->assign('list', $entry_data[0]);
//     	$this->view('entrytenpo/tenpo_pre.tpl');

    }

    // 初期値セット
    private function _item_set01()
    {

    	// カテゴリセット
    	$arroptions_en_cate01 = array (
    									''  => '選択してください',
    									'0' => '飲食',
    									'1' => '弁護士',
    							);
    	$arroptions_en_cate02 = array (
						    			''  => '選択してください',
						    			'0' => '和食',
						    			'1' => 'イタリア',
						    	);
    	$arroptions_en_cate03 = array (
						    			''  => '選択してください',
						    			'0' => '日本料理',
						    			'1' => 'ラーメン',
						    	);

    	$this->smarty->assign('opt_en_cate01',  $arroptions_en_cate01);
    	$this->smarty->assign('opt_en_cate02',  $arroptions_en_cate02);
    	$this->smarty->assign('opt_en_cate03',  $arroptions_en_cate03);

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
    					'field'   => 'en_cate01',
    					'label'   => 'カテゴリ１選択',
    					'rules'   => 'trim|max_length[2]'
    			),
    			array(
    					'field'   => 'en_cate02',
    					'label'   => 'カテゴリ２選択',
    					'rules'   => 'trim|max_length[2]'
    			),
    			array(
    					'field'   => 'en_cate03',
    					'label'   => 'カテゴリ３選択',
    					'rules'   => 'trim|max_length[2]'
    			),
    			array(
    					'field'   => 'en_shopname',
    					'label'   => '店舗名称',
    					'rules'   => 'trim|required|max_length[10]'
    			),
    			array(
    					'field'   => 'en_shopname_sub',
    					'label'   => '店舗名称(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_url',
    					'label'   => '店舗サイトURL',
    					'rules'   => 'trim|regex_match[/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/]|max_length[100]'
    			),
    			array(
    					'field'   => 'en_zip01',
    					'label'   => '郵便番号（3ケタ）',
    					'rules'   => 'trim|required|max_length[3]|is_numeric'
    			),
    			array(
    					'field'   => 'en_zip02',
    					'label'   => '郵便番号（4ケタ）',
    					'rules'   => 'trim|required|max_length[4]|is_numeric'
    			),
    			array(
    					'field'   => 'en_pref',
    					'label'   => '都道府県',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'en_addr01',
    					'label'   => '市区町村',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'en_addr02',
    					'label'   => '町名・番地',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'en_buil',
    					'label'   => 'ビル・マンション名など',
    					'rules'   => 'trim|max_length[100]'
    			),
    			array(
    					'field'   => 'en_tel',
    					'label'   => '電話番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'en_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'en_opentime',
    					'label'   => '営業時間(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_holiday',
    					'label'   => '定休日(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_since',
    					'label'   => '創業／設立日(テキスト)',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'en_parking',
    					'label'   => '駐車場情報(テキスト)',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'en_seat',
    					'label'   => '座席情報(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_card',
    					'label'   => 'カード情報(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_access',
    					'label'   => 'アクセス情報(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_access_sub',
    					'label'   => 'アクセス情報予備(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_contents01',
    					'label'   => 'メニュー情報１(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_contents02',
    					'label'   => 'メニュー情報２(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_description',
    					'label'   => 'ディスクリプション',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_keywords',
    					'label'   => 'キーワード',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_sns01',
    					'label'   => 'ＳＮＳコード１',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_sns02',
    					'label'   => 'ＳＮＳコード２',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_sns03',
    					'label'   => 'ＳＮＳコード３',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_sns04',
    					'label'   => 'ＳＮＳコード４',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_sns05',
    					'label'   => 'ＳＮＳコード５',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_free01',
    					'label'   => 'フリー１',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_free02',
    					'label'   => 'フリー２',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_free03',
    					'label'   => 'フリー３',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_free04',
    					'label'   => 'フリー４',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_free05',
    					'label'   => 'フリー５',
    					'rules'   => 'trim|max_length[1000]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'en_title01',
    					'label'   => 'タイトル',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'en_body01',
    					'label'   => '記事本文',
    					'rules'   => 'trim|required|max_length[50000]'
    			),
    			array(
    					'field'   => 'en_title02',
    					'label'   => 'タイトルサブ',
    					'rules'   => 'trim|max_length[100]'
    			),
    			array(
    					'field'   => 'en_body02',
    					'label'   => '記事本文サブ',
    					'rules'   => 'trim|max_length[50000]'
    			),
    			array(
    					'field'   => 'en_entry_tags',
    					'label'   => 'タグ',
    					'rules'   => 'trim|max_length[255]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
