<?php

class Tenpo_interview extends MY_Controller
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


        $this->config->load('config_pref');										// 都道府県情報読み込み

        // 都道府県情報設定
        $this->_options_pref = $this->config->item('pref');
        $this->smarty->assign('opt_pref', $this->_options_pref);

        // 都道府県チェック
        if ($this->input->post('iv_pref')) {
        	$pref_id = $this->input->post('iv_pref');
        	$this->_pref_name = $this->_options_pref[$pref_id];
        }

    }

    // 店舗情報TOP
    public function index()
    {

    	// セッションデータをクリア
    	$this->load->model('comm_auth', 'comm_auth', TRUE);
    	$this->comm_auth->delete_session('admin');

        $this->view('tenpo_interview/index.tpl');

    }

    // 店舗記事情報TOP
    public function report_edit()
    {

    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

    	// クライアント情報取得
    	$input_post = $this->input->post();

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($input_post['chg_uniq'], TRUE);

    	// 一時保存
    	$_SESSION['a_cl_seq']    = $cl_data[0]['cl_seq'];
    	$_SESSION['a_cl_siteid'] = $cl_data[0]['cl_siteid'];
//     	$_SESSION['a_cl_id']     = $cl_data[0]['cl_id'];
    	$_SESSION['a_cl_status'] = $cl_data[0]['cl_status'];

    	// 店舗データの取得
    	$this->load->model('Interview', 'itw', TRUE);
    	$interview_data = $this->itw->get_interview_siteid($cl_data[0]['cl_siteid']);
    	if ($interview_data == FALSE)
    	{
    		// 空データを取得
//     		$entry_data = $this->ent->get_entry_siteid($cl_data[0]['cl_siteid'], TRUE);
//     		$this->smarty->assign('list', $entry_data[0]);

    		$this->smarty->assign('list', NULL);
    	} else {
    		$this->smarty->assign('list', $interview_data[0]);
    	}

    	// リビジョンデータの取得
    	$this->load->model('Revision', 'rev', TRUE);
    	$rev_data = $this->rev->get_revision_siteid($cl_data[0]['cl_siteid']);
    	if ($rev_data == FALSE)
    	{
    		// 空データ
    		$this->smarty->assign('revlist', NULL);
    	} else {
    		$this->smarty->assign('revlist', $rev_data);
    	}

    	// プレビュー用にチェック用ticketを発行
    	$_ticket = md5(uniqid(mt_rand(), true));
    	$_SESSION['a_ticket'] = $_ticket;
    	$this->smarty->assign('ticket', $_ticket);

    	$this->smarty->assign('cl_status', $cl_data[0]['cl_status']);
    	$this->view('tenpo_interview/report_edit.tpl');

    }

    // 確認画面表示
    public function report_conf()
    {

    	$input_post = $this->input->post();

	    $this->load->model('Client',    'cl',  TRUE);
	    $this->load->model('Interview', 'itv', TRUE);
	    $this->load->model('Revision',  'rev', TRUE);

	    if ($input_post['_submit'] == 'preview')
    	{

    		// 記事情報の一時保存

    		// バリデーション・チェック
    		$this->_set_validation02();
    		if ($this->form_validation->run() == FALSE) {
    			$this->smarty->assign('list', $input_post);
    			$this->smarty->assign('cl_status', $input_post['cl_status']);
    			$this->smarty->assign('revlist', NULL);
    		} else {

	    		// 店舗データの取得
	    		$interview_data = $this->itv->get_interview_seq($input_post['iv_seq']);

	    		// データをセット
	    		foreach ($interview_data[0] as $key => $value)
	    		{
	    			$item = str_replace("iv_", "ivp_", $key);
	    			$set_data[$item] = $value;
	    		}

	    		// 記事本文からのプレビュー
	    		$set_data['ivp_title01']   = $input_post['iv_title01'];
	    		$set_data['ivp_body01']    = $input_post['iv_body01'];
	    		$set_data['ivp_title02']   = $input_post['iv_title02'];
	    		$set_data['ivp_body02']    = $input_post['iv_body02'];

	    		$set_data["ivp_cl_seq"]    = $_SESSION['a_cl_seq'];
// 	    		$set_data["ivp_cl_id"]     = $_SESSION['a_cl_id'];
	    		$set_data["ivp_cl_siteid"] = $_SESSION['a_cl_siteid'];
	    		$set_data['ivp_auth']      = $_SESSION['a_ticket'];

	    		// 不要パラメータ削除
	    		unset($set_data["ivp_create_date"]) ;
	    		unset($set_data["ivp_update_date"]) ;

	    		// DB書き込み
	    		$this->load->model('Interview_pre', 'pre', TRUE);
	    		$this->pre->inup_interview_pre($set_data);

	    		// 再表示用にデータの取得
	    		$interview_data = $this->itv->get_interview_siteid($_SESSION['a_cl_siteid']);
	    		if ($interview_data == FALSE)
	    		{
	    			// 空データ
	    			$this->smarty->assign('list', NULL);
	    		} else {
	    			$this->smarty->assign('cl_status', $input_post['cl_status']);

	    			// データを戻す
	    			foreach ($set_data as $key => $value)
	    			{
	    				$item = str_replace("ivp_", "iv_", $key);
	    				$item_data[$item] = $value;
	    			}

	    			$this->smarty->assign('list', $item_data);
	    		}

	    		// レビジョンデータの一覧取得
	    		$rev_data = $this->rev->get_revision_clseq($interview_data[0]["iv_cl_seq"]);
	    		if ($rev_data == FALSE)
	    		{
	    			// 空データ
	    			$this->smarty->assign('revlist', NULL);
	    		} else {
	    			$this->smarty->assign('revlist', $rev_data);
	    		}
    		}

    	} elseif ($input_post['_submit'] == 'save') {

    		// 記事情報の保存

	    	// バリデーション・チェック
	    	$this->_set_validation02();
	    	if ($this->form_validation->run() == FALSE) {
	    		$this->smarty->assign('list', $input_post);
	    		$this->smarty->assign('cl_status', $input_post['cl_status']);
	    		$this->smarty->assign('revlist', NULL);
	    	} else {

	    		// データ設定
	    		$input_post["iv_cl_seq"]    = $_SESSION['a_cl_seq'];
// 	    		$input_post["iv_cl_id"]     = $_SESSION['a_cl_id'];
	    		$input_post["iv_cl_siteid"] = $_SESSION['a_cl_siteid'];

	    		// 文字数カウント
	    		$input_post['iv_length01'] = $this->_get_strlen_cnt($input_post["iv_body01"]);
	    		$input_post['iv_length02'] = $this->_get_strlen_cnt($input_post["iv_body02"]);

	    		$set_data['cl_seq']    = $_SESSION['a_cl_seq'];
	    		if ($input_post["cl_status"] == 8)
	    		{
	    			$set_data['cl_status'] = 8;									// ステータス「掲載」
	    		} elseif ($input_post["cl_status"] == 9) {
	    			$set_data['cl_status'] = 9;									// ステータス変更「再編集」
	    		} else {
	    			$set_data['cl_status'] = 4;									// ステータス変更「編集」
	    		}

	    		// 不要パラメータ削除
	    		unset($input_post["rv_description"]) ;
	    		unset($input_post["cl_status"]) ;
	    		unset($input_post["_submit"]) ;
	    		unset($input_post["ticket"]) ;
	    		unset($input_post["type"]) ;

	    		// DB書き込み
	    		$_row_id = $this->itv->inup_interview($input_post);

	    		$this->cl->update_client($set_data);

		    	// 再表示用にデータの取得
		    	$interview_data = $this->itv->get_interview_siteid($input_post["iv_cl_siteid"]);
		    	if ($interview_data == FALSE)
		    	{
		    		// 空データ
		    		$this->smarty->assign('list', NULL);
		    	} else {
			    	$this->smarty->assign('cl_status', $set_data['cl_status']);
			    	$this->smarty->assign('list', $interview_data[0]);
		    	}

		    	// レビジョンデータの一覧取得
		    	$rev_data = $this->rev->get_revision_clseq($input_post["iv_cl_seq"]);
		    	if ($rev_data == FALSE)
		    	{
		    		// 空データ
		    		$this->smarty->assign('revlist', NULL);
		    	} else {
		    		$this->smarty->assign('revlist', $rev_data);
		    	}
	    	}

	    } elseif ($input_post['_submit'] == 'revision') {

	    	// レビジョン管理

	    	// バリデーション・チェック
	    	$this->_set_validation03();
	    	if ($this->form_validation->run() == FALSE) {

	    		// 再表示用にデータの取得
	    		$interview_data = $this->itv->get_interview_siteid($_SESSION['a_cl_siteid']);
	    		if ($interview_data == FALSE)
	    		{
	    			// 空データ
	    			$this->smarty->assign('list', NULL);
	    		} else {
	    			$this->smarty->assign('cl_status', $input_post['cl_status']);
	    			$this->smarty->assign('list', $interview_data[0]);
	    		}

	    		// レビジョンデータの一覧取得
	    		$rev_data = $this->rev->get_revision_clseq($_SESSION['a_cl_seq']);
	    		if ($rev_data == FALSE)
	    		{
	    			// 空データ
	    			$this->smarty->assign('revlist', NULL);
	    		} else {
	    			$this->smarty->assign('revlist', $rev_data);
	    		}

	    	} else {

	    		// データ設定
	    		$set_data["rv_description"]   = $input_post['rv_description'];
	    		$set_data["rv_entry_title01"] = $input_post['iv_title01'];
	    		$set_data["rv_entry_body01"]  = $input_post['iv_body01'];
	    		$set_data["rv_length01"]      = 0;
	    		$set_data["rv_entry_title02"] = $input_post['iv_title02'];
	    		$set_data["rv_entry_body02"]  = $input_post['iv_body02'];
	    		$set_data["rv_length02"]      = 0;
	    		$set_data["rv_cl_seq"]        = $_SESSION['a_cl_seq'];
	    		$set_data["rv_cl_siteid"]     = $_SESSION['a_cl_siteid'];
	    		$set_data["rv_iv_seq"]        = $input_post['iv_seq'];

	    		// リビジョンデータの取得
	    		$rev_data = $this->rev->get_revision_clseq($_SESSION['a_cl_seq']);

	    		$rev_cnt = count($rev_data);

	    		// 振り分け
	    		if ($rev_cnt >= 5)														// max.5 履歴まで管理
	    		{

	    			// 一番古いデータを読み込み→上書き

	    			// リビジョンデータの取得
	    			$rev_olddata = $this->rev->get_revision_old($_SESSION['a_cl_seq']);

	    			// DB書き込み
	    			$set_data["rv_seq"] = $rev_olddata[0]['rv_seq'];
	    			$_row_id = $this->rev->update_revision($set_data);				// 一番古いデータを上書き

	    		} else {

	    			// そのままinsert
	    			$this->rev->insert_revision($set_data);

	    		}

	    		// 再表示用にデータの取得
	    		$interview_data = $this->itv->get_interview_siteid($_SESSION['a_cl_siteid']);
	    		$rev_data = $this->rev->get_revision_siteid($_SESSION['a_cl_siteid']);

				$this->smarty->assign('cl_status', $_SESSION['a_cl_status']);
	    		$this->smarty->assign('list',      $interview_data[0]);
	    		$this->smarty->assign('revlist',   $rev_data);

	    	}

	    } else {

	    	// 営業承認の確認

	    	// バリデーション・チェック
	    	$this->_set_validation02();
	    	if ($this->form_validation->run() == FALSE) {
	    		$this->smarty->assign('list', $input_post);
	    		$this->smarty->assign('cl_status', $input_post['cl_status']);
	    		$this->smarty->assign('revlist', NULL);
	    	} else {

		    	// クライアントデータのステータス変更「営業確認」
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
		    	$interview_data = $this->itv->get_interview_siteid($clac_data[0]['cl_siteid']);

    			$this->smarty->assign('cl_status', $set_data['cl_status']);
		    	$this->smarty->assign('list', $interview_data[0]);

		    	// レビジョンデータの一覧取得
		    	$rev_data = $this->rev->get_revision_clseq($_SESSION['a_cl_seq']);
		    	if ($rev_data == FALSE)
		    	{
		    		// 空データ
		    		$this->smarty->assign('revlist', NULL);
		    	} else {
		    		$this->smarty->assign('revlist', $rev_data);
		    	}
	    	}
    	}

    	// プレビュー用にチェック用ticketを発行
    	$_ticket = md5(uniqid(mt_rand(), true));
    	$_SESSION['a_ticket'] = $_ticket;
    	$this->smarty->assign('ticket', $_ticket);

	    $this->view('tenpo_interview/report_edit.tpl');

    }

    // プレビュー画面表示
    public function report_pre()
    {

    	$input_post = $this->input->post();

    	// クライアント情報取得
    	$this->load->model('Client', 'cl', TRUE);

    	// 店舗データの取得
    	//     	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$this->load->model('Interview', 'itv', TRUE);

    	// 営業アクセスの場合
    	if ($_SESSION['a_memType'] == 1)
    	{
    		$cl_data = $this->cl->get_cl_seq($input_post['chg_uniq'], TRUE);
    		//     		$tenpo_data     = $this->tnp->get_tenpo_clseq($input_post['chg_uniq']);
    		$interview_data = $this->itv->get_interview_clseq($input_post['chg_uniq']);
    	} else {
    		$cl_data = $this->cl->get_cl_seq($_SESSION['a_cl_seq'], TRUE);
    		//     		$tenpo_data     = $this->tnp->get_tenpo_clseq($_SESSION['a_cl_seq']);
    		$interview_data = $this->itv->get_interview_clseq($_SESSION['a_cl_seq']);
    	}

    	$interview_data[0]['cl_status']  = $cl_data[0]['cl_status'];
    	$interview_data[0]['cl_comment'] = $cl_data[0]['cl_comment'];

    	// 	    $this->smarty->assign('tenpo',     $tenpo_data[0]);
    	$this->smarty->assign('interview', $interview_data[0]);
    	$this->view('tenpo_interview/report_pre.tpl');

    }

    // プレビュー画面からの営業承認
    public function request()
    {

    	$input_post = $this->input->post();

    	switch ($input_post['submit'])
    	{
    		case 'salse_ok':

    			// クライアントステータス変更：「6:クライアント確認」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $input_post['cl_seq'];
//     			$set_data['cl_id']      = $input_post['cl_id'];
    			$set_data['cl_status']  = 6;
    			$set_data['cl_comment'] = $input_post['cl_comment'];

    			$this->cl->update_client($set_data);

    			// クライアントデータから担当営業を取得
    			$clac_data = $this->cl->get_clac_seq($input_post['cl_seq'], NULL);

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

    			// クライアントステータス変更：「9:再編集」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $input_post['cl_seq'];
//     			$set_data['cl_id']      = $input_post['cl_id'];
    			$set_data['cl_status']  = 9;
    			$set_data['cl_comment'] = $input_post['cl_comment'];

    			$this->cl->update_client($set_data);

    			// クライアントデータから担当者を取得
    			$clac_data = $this->cl->get_clac_seq($input_post['cl_seq'], NULL);

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
    					'ac_salsename01'  => $clac_data[0]['salsename01'],
    					'ac_salsename02'  => $clac_data[0]['salsename02'],
    					'cl_comment'      => $input_post['cl_comment'],
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

    			// 掲載開始
    			// クライアントステータス変更：「8:掲載」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $input_post['cl_seq'];
//     			$set_data['cl_id']      = $input_post['cl_id'];
    			$set_data['cl_status']  = 8;
    			//             	$set_data['cl_comment'] = $input_post['cl_comment'];

    			$this->cl->update_client($set_data);

    			// クライアントデータから担当営業を取得
    			$clac_data = $this->cl->get_clac_seq($input_post['cl_seq'], NULL);

    			// クライアントへ承認メール送信。
    			// メール送信先設定
    			$mail['from']      = "";
    			$mail['from_name'] = "";
    			$mail['subject']   = "";
    			$mail['to']        = $clac_data[0]['cl_mail'];
    			$mail['cc']        = $clac_data[0]['salseacmail'] . ";" . $clac_data[0]['editoracmail'] . ";" . $clac_data[0]['adminacmail'];
    			$mail['bcc']       = "";

    			// メール本文置き換え文字設定
    			$arrRepList = array(
    					'cl_company'      => $clac_data[0]['cl_company'],
    					'cl_president01'  => $clac_data[0]['cl_president01'],
    					'cl_president02'  => $clac_data[0]['cl_president02'],
    					'site'            => 'https://' . $this->input->server("SERVER_NAME") . '/site/pf/' . $clac_data[0]['cl_siteid'],
    					'ac_salsename01'  => $clac_data[0]['salsename01'],
    					'ac_salsename02'  => $clac_data[0]['salsename02'],
    			);

    			// メールテンプレートの読み込み
    			$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    			$mail_tpl = $this->config->item('MAILTPL_FINAL_OK_ID');

    			// メール送信
    			$this->load->model('Mailtpl', 'mailtpl', TRUE);
    			if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    			} else {
    				echo "メール送信エラー";
    				log_message('error', 'Entrytenpo::[request()]掲載開始処理 メール送信エラー');
    			}

    			// 再表示用にデータの取得
    			$this->load->model('Entry', 'ent', TRUE);
    			$entry_data = $this->ent->get_entry_siteid($clac_data[0]['cl_siteid']);

    			$this->smarty->assign('cl_status', $set_data['cl_status']);
    			$this->smarty->assign('list', $entry_data[0]);

    			$this->view('tenpo_interview/report_pre.tpl');

    			break;
    		default:
    	}

    }

    // レビジョン管理
    public function report_rev()
    {

    	// バリデーション・チェック
    	$this->_set_validation03();												// バリデーション設定

    	// レビジョン情報取得
    	$input_post = $this->input->post();

    	$this->load->model('Revision',  'rev', TRUE);
    	$this->load->model('Interview', 'itv', TRUE);

    	if (isset($input_post['chg_uniq']))
    	{
    		// 復元：表示用データセット
    		$rev_data = $this->rev->get_revision_rvseq($input_post['chg_uniq']);

    		$set_data["iv_title01"] = $rev_data[0]['rv_entry_title01'];
    		$set_data["iv_body01"]  = $rev_data[0]['rv_entry_body01'];
    		$set_data["iv_title02"] = $rev_data[0]['rv_entry_title02'];
    		$set_data["iv_body02"]  = $rev_data[0]['rv_entry_body02'];
    		$set_data["iv_seq"]     = $rev_data[0]['rv_iv_seq'];

    		$this->smarty->assign('list', $set_data);

    	} elseif (isset($input_post['del_uniq'])) {

    		// データ取得
    		$rev_data = $this->rev->get_revision_rvseq($input_post['del_uniq']);

    		// データ削除
    		$this->rev->delete_revision($input_post['del_uniq']);

    		// 店舗データの取得
    		$interview_data = $this->itv->get_interview_siteid($rev_data[0]['rv_cl_siteid']);
    		if ($interview_data == FALSE)
    		{
    			$this->smarty->assign('list', NULL);
    		} else {
    			$this->smarty->assign('list', $interview_data[0]);
    		}

    	}

    	// レビジョンデータの一覧取得
    	$rev_data = $this->rev->get_revision_clseq($rev_data[0]['rv_cl_seq']);
    	if ($rev_data == FALSE)
    	{
    		// 空データ
    		$this->smarty->assign('revlist', NULL);
    	} else {
    		$this->smarty->assign('revlist', $rev_data);
    	}

    	$this->smarty->assign('cl_status', $_SESSION['a_cl_status']);

    	$this->view('tenpo_interview/report_edit.tpl');

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
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'iv_title01',
    					'label'   => 'タイトル',
    					'rules'   => 'trim|required|max_length[1000]'
    			),
    			array(
    					'field'   => 'iv_body01',
    					'label'   => '記事本文',
    					'rules'   => 'trim|required|max_length[10000]'
    			),
    			array(
    					'field'   => 'iv_title02',
    					'label'   => 'タイトルサブ',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'iv_body02',
    					'label'   => '記事本文サブ',
    					'rules'   => 'trim|max_length[10000]'
    			),
//     			array(
//     					'field'   => 'en_entry_tags',
//     					'label'   => 'タグ',
//     					'rules'   => 'trim|max_length[255]'
//     			),
//     			array(
//     					'field'   => 'rv_description',
//     					'label'   => '保存タイトル',
//     					'rules'   => 'trim|max_length[50]'
//     			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック
    private function _set_validation03()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'iv_title01',
    					'label'   => 'タイトル',
    					'rules'   => 'trim|required|max_length[1000]'
    			),
    			array(
    					'field'   => 'iv_body01',
    					'label'   => '記事本文',
    					'rules'   => 'trim|required|max_length[10000]'
    			),
    			array(
    					'field'   => 'iv_title02',
    					'label'   => 'タイトルサブ',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'iv_body02',
    					'label'   => '記事本文サブ',
    					'rules'   => 'trim|max_length[10000]'
    			),
//     			array(
//     					'field'   => 'iv_entry_tags',
//     					'label'   => 'タグ',
//     					'rules'   => 'trim|max_length[255]'
//     			),
    			array(
    					'field'   => 'rv_description',
    					'label'   => '保存タイトル',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
