<?php

class Entrytenpo extends MY_Controller
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

    	// クライアント情報取得
    	$input_post = $this->input->post();

    	// 初期値セット
    	$this->_item_set();

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($input_post['chg_uniq'], TRUE);

    	// 一時保存
		$_SESSION['a_cl_seq']    = $cl_data[0]['cl_seq'];
    	$_SESSION['a_cl_siteid'] = $cl_data[0]['cl_siteid'];
		$_SESSION['a_cl_id']     = $cl_data[0]['cl_id'];

		// 日付け初期化
		for ($i = 0; $i < 3; $i++)
		{
			for ($j = 0; $j < 7; $j++)
			{
				$eigyo_chk[$i][$j] = FALSE;
			}
		}

		// 定休日初期化
		for ($i = 0; $i < 8; $i++)
		{
			$closed_chk[0][$i] = FALSE;
		}

		// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);
    	$entry_data = $this->ent->get_entry_siteid($cl_data[0]['cl_siteid']);
    	if ($entry_data == FALSE)
		{
			// tb_entry のカラムを取得
			$entry_col = $this->ent->get_entry_columns();
			foreach ($entry_col as $key => $value)
			{
				$set_data[$value['COLUMN_NAME']] = NULL;
			}

			// カテゴリセット : 初期値で「その他」固定表示
			$this->config->load('config_comm');
			$_cat_big = $this->config->item('CATEGORY_INI_BIG');
			$_cat_med = $this->config->item('CATEGORY_INI_MED');
			$_cat_sml = $this->config->item('CATEGORY_INI_SML');

			$_SESSION['a_cate01'] = $_cat_big;
			$_SESSION['a_cate02'] = $_cat_med;
			$_SESSION['a_cate03'] = $_cat_sml;
			$_SESSION['a_cate11'] = $_cat_big;
			$_SESSION['a_cate12'] = $_cat_med;
			$_SESSION['a_cate13'] = $_cat_sml;
			$_SESSION['a_cate21'] = $_cat_big;
			$_SESSION['a_cate22'] = $_cat_med;
			$_SESSION['a_cate23'] = $_cat_sml;

			list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($_cat_big, $_cat_med, $_cat_sml);		// 初期値で「その他」固定表示
			$this->smarty->assign('opt_en_cate01', $opt_en_cate01);
			$this->smarty->assign('opt_en_cate02', $opt_en_cate02);
			$this->smarty->assign('opt_en_cate03', $opt_en_cate03);

			$this->smarty->assign('opt_en_cate11', $opt_en_cate01);
			$this->smarty->assign('opt_en_cate12', $opt_en_cate02);
			$this->smarty->assign('opt_en_cate13', $opt_en_cate03);

			$this->smarty->assign('opt_en_cate21', $opt_en_cate01);
			$this->smarty->assign('opt_en_cate22', $opt_en_cate02);
			$this->smarty->assign('opt_en_cate23', $opt_en_cate03);

			$set_data['en_cate01'] = $_cat_big;
			$set_data['en_cate02'] = $_cat_med;
			$set_data['en_cate03'] = $_cat_sml;
			$set_data['en_cate11'] = $_cat_big;
			$set_data['en_cate12'] = $_cat_med;
			$set_data['en_cate13'] = $_cat_sml;
			$set_data['en_cate21'] = $_cat_big;
			$set_data['en_cate22'] = $_cat_med;
			$set_data['en_cate23'] = $_cat_sml;

			$this->smarty->assign('eigyo_chk',  $eigyo_chk);				// 営業時間
			$this->smarty->assign('closed_chk', $closed_chk);				// 定休日

			$this->smarty->assign('list', $set_data);

		} else {
			$this->smarty->assign('list', $entry_data[0]);

			// カテゴリセット
			$_SESSION['a_cate01'] = $entry_data[0]['en_cate01'];
			$_SESSION['a_cate02'] = $entry_data[0]['en_cate02'];
			$_SESSION['a_cate03'] = $entry_data[0]['en_cate03'];
			$_SESSION['a_cate11'] = $entry_data[0]['en_cate11'];
			$_SESSION['a_cate12'] = $entry_data[0]['en_cate12'];
			$_SESSION['a_cate13'] = $entry_data[0]['en_cate13'];
			$_SESSION['a_cate21'] = $entry_data[0]['en_cate21'];
			$_SESSION['a_cate22'] = $entry_data[0]['en_cate22'];
			$_SESSION['a_cate23'] = $entry_data[0]['en_cate23'];

			// 営業時間セット
			$this->_item_eigyo_set();

			list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($entry_data[0]['en_cate01'], $entry_data[0]['en_cate02'], $entry_data[0]['en_cate03']);
			$this->smarty->assign('opt_en_cate01', $opt_en_cate01);
			$this->smarty->assign('opt_en_cate02', $opt_en_cate02);
			$this->smarty->assign('opt_en_cate03', $opt_en_cate03);

			list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($entry_data[0]['en_cate11'], $entry_data[0]['en_cate12'], $entry_data[0]['en_cate13']);
			$this->smarty->assign('opt_en_cate11', $opt_en_cate01);
			$this->smarty->assign('opt_en_cate12', $opt_en_cate02);
			$this->smarty->assign('opt_en_cate13', $opt_en_cate03);

			list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($entry_data[0]['en_cate21'], $entry_data[0]['en_cate22'], $entry_data[0]['en_cate23']);
			$this->smarty->assign('opt_en_cate21', $opt_en_cate01);
			$this->smarty->assign('opt_en_cate22', $opt_en_cate02);
			$this->smarty->assign('opt_en_cate23', $opt_en_cate03);

		}

		// プレビュー用にチェック用ticketを発行
		$_ticket = md5(uniqid(mt_rand(), true));
		$_SESSION['a_ticket'] = $_ticket;
		$this->smarty->assign('ticket', $_ticket);

    	$this->view('entrytenpo/tenpo_edit.tpl');

    }

    // 確認画面表示
    public function tenpo_conf()
    {

    	$input_post = $this->input->post();

    	// 初期値セット
    	$this->_item_set();

    	// カテゴリセット
    	list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate01'], $input_post['en_cate02'], $input_post['en_cate03']);
    	$this->smarty->assign('opt_en_cate01', $opt_en_cate01);
    	$this->smarty->assign('opt_en_cate02', $opt_en_cate02);
    	$this->smarty->assign('opt_en_cate03', $opt_en_cate03);

    	list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate11'], $input_post['en_cate12'], $input_post['en_cate13']);
    	$this->smarty->assign('opt_en_cate11', $opt_en_cate01);
    	$this->smarty->assign('opt_en_cate12', $opt_en_cate02);
    	$this->smarty->assign('opt_en_cate13', $opt_en_cate03);

    	list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate21'], $input_post['en_cate22'], $input_post['en_cate23']);
    	$this->smarty->assign('opt_en_cate21', $opt_en_cate01);
    	$this->smarty->assign('opt_en_cate22', $opt_en_cate02);
    	$this->smarty->assign('opt_en_cate23', $opt_en_cate03);

        // 都道府県チェック
        $this->smarty->assign('pref_name', $this->_pref_name);

        $this->load->model('Entry', 'ent', TRUE);

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    	} else {

    		if (isset($input_post["_submit"]) && ($input_post["_submit"] == 'save'))
    		{
    			// 店舗情報の保存

	    		// 営業時間セット
	    		$arr_setdata = $input_post;
	    		$set_data = $this->_eigyo_time_set($arr_setdata);

	    		// データ設定
	    		$set_data["en_cl_seq"]    = $_SESSION['a_cl_seq'];
	    		$set_data["en_cl_id"]     = $_SESSION['a_cl_id'];
	    		$set_data["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

	    		// DB書き込み
	    		$_row_id = $this->ent->inup_tenpo($set_data);

    		} elseif (isset($input_post["_submit"]) && ($input_post["_submit"] == 'preview')) {

    			// 店舗情報の一時保存

    			// 営業時間セット
    			$arr_setdata = $input_post;
    			$_set_data = $this->_eigyo_time_set($arr_setdata);

    			// データ設定
    			$_set_data["en_cl_seq"]    = $_SESSION['a_cl_seq'];
    			$_set_data["en_cl_id"]     = $_SESSION['a_cl_id'];
    			$_set_data["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

    			// データをセット
    			foreach ($_set_data as $key => $value)
    			{
    				$item = str_replace("en_", "ep_", $key);
    				$set_data[$item] = $value;
    			}

    			// 店舗データの取得
    			$entry_data = $this->ent->get_entry_seq($input_post['en_seq']);

    			// 記事本文からのプレビュー
    			$set_data['ep_title01']   = $entry_data[0]['en_title01'];
    			$set_data['ep_body01']    = $entry_data[0]['en_body01'];
    			$set_data['ep_title02']   = $entry_data[0]['en_title02'];
    			$set_data['ep_body02']    = $entry_data[0]['en_body02'];

    			// 不要パラメータ削除
    			unset($set_data["ep_create_date"]) ;
    			unset($set_data["ep_update_date"]) ;

    			// DB書き込み
    			$this->load->model('Entry_pre', 'pre', TRUE);
    			$this->pre->inup_entry_pre($set_data);

    		}
    	}

    	// プレビュー用にチェック用ticketを発行
    	$_ticket = md5(uniqid(mt_rand(), true));
    	$_SESSION['a_ticket'] = $_ticket;
    	$this->smarty->assign('ticket', $_ticket);

    	// 再読み込み
    	// 日付け初期化
    	$this->_item_eigyo_set();

		$this->smarty->assign('list', $input_post);
    	$this->view('entrytenpo/tenpo_edit.tpl');

    }

    // プレビュー画面表示
    public function tenpo_pre()
    {

    	$input_post = $this->input->post();

    	// クライアント情報取得
    	$this->load->model('Client', 'cl', TRUE);

    	// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);

    	// 営業アクセスの場合
    	if ($_SESSION['a_memType'] == 1)
    	{
    		$cl_data = $this->cl->get_cl_seq($input_post['chg_uniq'], TRUE);
    		$entry_data = $this->ent->get_entry_clseq($input_post['chg_uniq']);
    	} else {
    		$cl_data = $this->cl->get_cl_seq($_SESSION['a_cl_seq'], TRUE);
    		$entry_data = $this->ent->get_entry_clseq($_SESSION['a_cl_seq']);
    	}

    	$entry_data[0]['cl_status']  = $cl_data[0]['cl_status'];
    	$entry_data[0]['cl_comment'] = $cl_data[0]['cl_comment'];

	    $this->smarty->assign('list', $entry_data[0]);
	    $this->view('entrytenpo/tenpo_pre.tpl');

    }

    // カテゴリ選択
    public function tenpo_cate()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$input_post = $this->input->post();

		// 第一カテゴリ
    	if ($_SESSION['a_cate01'] != $input_post['en_cate01'])
    	{
    		$_SESSION['a_cate01'] = $input_post["en_cate01"];
    		$_SESSION['a_cate02'] = $input_post["en_cate02"];
    		$_SESSION['a_cate03'] = $input_post["en_cate03"];

    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate01'], TRUE);
    		$this->smarty->assign('opt_en_cate01', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate02', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate03', $opt_en_cate03);

    		$input_post["en_cate02"] = 0;
    		$input_post["en_cate03"] = 0;

    	} elseif ($_SESSION['a_cate02'] != $input_post['en_cate02']) {
    		$_SESSION['a_cate01'] = $input_post["en_cate01"];
    		$_SESSION['a_cate02'] = $input_post["en_cate02"];
    		$_SESSION['a_cate03'] = $input_post["en_cate03"];

    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate01'], FALSE, TRUE);
    		$this->smarty->assign('opt_en_cate01', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate02', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate03', $opt_en_cate03);

    		$input_post["en_cate03"] = 0;
    	} else {
    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate01'], $input_post['en_cate02'], $input_post['en_cate03']);
    		$this->smarty->assign('opt_en_cate01', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate02', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate03', $opt_en_cate03);
    	}

		// 第二カテゴリ
    	if ($_SESSION['a_cate11'] != $input_post['en_cate11'])
    	{
    		$_SESSION['a_cate11'] = $input_post["en_cate11"];
    		$_SESSION['a_cate12'] = $input_post["en_cate12"];
    		$_SESSION['a_cate13'] = $input_post["en_cate13"];

    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate11'], TRUE);
    		$this->smarty->assign('opt_en_cate11', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate12', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate13', $opt_en_cate03);

    		$input_post["en_cate12"] = 0;
    		$input_post["en_cate13"] = 0;

    	} elseif ($_SESSION['a_cate12'] != $input_post['en_cate12']) {
    		$_SESSION['a_cate02'] = $input_post["en_cate12"];							// 応急処置

    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate11'], FALSE, TRUE);
    		$this->smarty->assign('opt_en_cate11', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate12', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate13', $opt_en_cate03);

    		$_SESSION['a_cate02'] = $input_post["en_cate02"];
    		$_SESSION['a_cate11'] = $input_post["en_cate11"];
    		$_SESSION['a_cate12'] = $input_post["en_cate12"];
    		$_SESSION['a_cate13'] = $input_post["en_cate13"];

    		$input_post["en_cate13"] = 0;
    	} else {
    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate11'], $input_post['en_cate12'], $input_post['en_cate13']);
    		$this->smarty->assign('opt_en_cate11', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate12', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate13', $opt_en_cate03);
    	}

		// 第三カテゴリ
    	if ($_SESSION['a_cate21'] != $input_post['en_cate21'])
    	{
    		$_SESSION['a_cate21'] = $input_post["en_cate21"];
    		$_SESSION['a_cate22'] = $input_post["en_cate22"];
    		$_SESSION['a_cate23'] = $input_post["en_cate23"];

    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate21'], TRUE);
    		$this->smarty->assign('opt_en_cate21', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate22', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate23', $opt_en_cate03);

    		$input_post["en_cate22"] = 0;
    		$input_post["en_cate23"] = 0;

    	} elseif ($_SESSION['a_cate22'] != $input_post['en_cate22']) {
    		$_SESSION['a_cate02'] = $input_post["en_cate22"];

    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate21'], FALSE, TRUE);
    		$this->smarty->assign('opt_en_cate21', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate22', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate23', $opt_en_cate03);

    		$_SESSION['a_cate02'] = $input_post["en_cate02"];
    		$_SESSION['a_cate21'] = $input_post["en_cate21"];
    		$_SESSION['a_cate22'] = $input_post["en_cate22"];
    		$_SESSION['a_cate23'] = $input_post["en_cate23"];

    		$input_post["en_cate23"] = 0;
    	} else {
    		list($opt_en_cate01, $opt_en_cate02, $opt_en_cate03) = $this->_item_cate_set($input_post['en_cate21'], $input_post['en_cate22'], $input_post['en_cate23']);
    		$this->smarty->assign('opt_en_cate21', $opt_en_cate01);
    		$this->smarty->assign('opt_en_cate22', $opt_en_cate02);
    		$this->smarty->assign('opt_en_cate23', $opt_en_cate03);
    	}

    	// 初期値セット
    	$this->_item_set();

    	// 営業時間セット
    	$this->load->model('Entry', 'ent', TRUE);
    	$this->_item_eigyo_set();

		$this->smarty->assign('list', $input_post);

    	$this->view('entrytenpo/tenpo_edit.tpl');

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
    	$_SESSION['a_cl_id']     = $cl_data[0]['cl_id'];
    	$_SESSION['a_cl_status'] = $cl_data[0]['cl_status'];

    	// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);
    	$entry_data = $this->ent->get_entry_siteid($cl_data[0]['cl_siteid']);
    	if ($entry_data == FALSE)
    	{
    		// 空データを取得
//     		$entry_data = $this->ent->get_entry_siteid($cl_data[0]['cl_siteid'], TRUE);
//     		$this->smarty->assign('list', $entry_data[0]);

    		$this->smarty->assign('list', NULL);
    	} else {
    		$this->smarty->assign('list', $entry_data[0]);
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
    	$this->view('entrytenpo/report_edit.tpl');

    }

    // レビジョン管理
    public function report_rev()
    {

    	// バリデーション・チェック
    	$this->_set_validation03();												// バリデーション設定

    	// レビジョン情報取得
    	$input_post = $this->input->post();

    	$this->load->model('Revision', 'rev', TRUE);
    	$this->load->model('Entry', 'ent', TRUE);

    	if (isset($input_post['chg_uniq']))
    	{
	    	// 復元：表示用データセット
    		$rev_data = $this->rev->get_revision_rvseq($input_post['chg_uniq']);

	    	$set_data["en_title01"] = $rev_data[0]['rv_entry_title01'];
	    	$set_data["en_body01"]  = $rev_data[0]['rv_entry_body01'];
	    	$set_data["en_title02"] = $rev_data[0]['rv_entry_title02'];
	    	$set_data["en_body02"]  = $rev_data[0]['rv_entry_body02'];
	    	$set_data["en_seq"]     = $rev_data[0]['rv_en_seq'];

	    	$this->smarty->assign('list', $set_data);

    	} elseif (isset($input_post['del_uniq'])) {

    		// データ取得
    		$rev_data = $this->rev->get_revision_rvseq($input_post['del_uniq']);

    		// データ削除
    		$this->rev->delete_revision($input_post['del_uniq']);

    		// 店舗データの取得
    		$entry_data = $this->ent->get_entry_siteid($rev_data[0]['rv_cl_siteid']);
    		if ($entry_data == FALSE)
    		{
    			$this->smarty->assign('list', NULL);
    		} else {
    			$this->smarty->assign('list', $entry_data[0]);
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

    	$this->view('entrytenpo/report_edit.tpl');

    }

    // 確認画面表示
    public function report_conf()
    {

    	$input_post = $this->input->post();

	    $this->load->model('Client',   'cl',  TRUE);
	    $this->load->model('Entry',    'ent', TRUE);
	    $this->load->model('Revision', 'rev', TRUE);

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
	    		$entry_data = $this->ent->get_entry_seq($input_post['en_seq']);

	    		// データをセット
	    		foreach ($entry_data[0] as $key => $value)
	    		{
	    			$item = str_replace("en_", "ep_", $key);
	    			$set_data[$item] = $value;
	    		}

	    		// 記事本文からのプレビュー
	    		$set_data['ep_title01']   = $input_post['en_title01'];
	    		$set_data['ep_body01']    = $input_post['en_body01'];
	    		$set_data['ep_title02']   = $input_post['en_title02'];
	    		$set_data['ep_body02']    = $input_post['en_body02'];

	    		$set_data["ep_cl_seq"]    = $_SESSION['a_cl_seq'];
	    		$set_data["ep_cl_id"]     = $_SESSION['a_cl_id'];
	    		$set_data["ep_cl_siteid"] = $_SESSION['a_cl_siteid'];
	    		$set_data['ep_auth']      = $_SESSION['a_ticket'];

	    		// 不要パラメータ削除
	    		unset($set_data["ep_create_date"]) ;
	    		unset($set_data["ep_update_date"]) ;

	    		// DB書き込み
	    		$this->load->model('Entry_pre', 'pre', TRUE);
	    		$this->pre->inup_entry_pre($set_data);

	    		// 再表示用にデータの取得
	    		$entry_data = $this->ent->get_entry_siteid($_SESSION['a_cl_siteid']);
	    		if ($entry_data == FALSE)
	    		{
	    			// 空データ
	    			$this->smarty->assign('list', NULL);
	    		} else {
	    			$this->smarty->assign('cl_status', $input_post['cl_status']);

	    			// データを戻す
	    			foreach ($set_data as $key => $value)
	    			{
	    				$item = str_replace("ep_", "en_", $key);
	    				$item_data[$item] = $value;
	    			}

	    			$this->smarty->assign('list', $item_data);
	    		}

	    		// レビジョンデータの一覧取得
	    		$rev_data = $this->rev->get_revision_clseq($entry_data[0]["en_cl_seq"]);
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
	    		$input_post["en_cl_seq"]    = $_SESSION['a_cl_seq'];
	    		$input_post["en_cl_id"]     = $_SESSION['a_cl_id'];
	    		$input_post["en_cl_siteid"] = $_SESSION['a_cl_siteid'];

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
	    		$_row_id = $this->ent->inup_tenpo($input_post);

	    		$this->cl->update_client($set_data);

		    	// 再表示用にデータの取得
		    	$entry_data = $this->ent->get_entry_siteid($input_post["en_cl_siteid"]);
		    	if ($entry_data == FALSE)
		    	{
		    		// 空データ
		    		$this->smarty->assign('list', NULL);
		    	} else {
			    	$this->smarty->assign('cl_status', $set_data['cl_status']);
			    	$this->smarty->assign('list', $entry_data[0]);
		    	}

		    	// レビジョンデータの一覧取得
		    	$rev_data = $this->rev->get_revision_clseq($input_post["en_cl_seq"]);
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
	    		$entry_data = $this->ent->get_entry_siteid($_SESSION['a_cl_siteid']);
	    		if ($entry_data == FALSE)
	    		{
	    			// 空データ
	    			$this->smarty->assign('list', NULL);
	    		} else {
	    			$this->smarty->assign('cl_status', $input_post['cl_status']);
	    			$this->smarty->assign('list', $entry_data[0]);
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
	    		$set_data["rv_entry_title01"] = $input_post['en_title01'];
	    		$set_data["rv_entry_body01"]  = $input_post['en_body01'];
	    		$set_data["rv_length01"]      = 0;
	    		$set_data["rv_entry_title02"] = $input_post['en_title02'];
	    		$set_data["rv_entry_body02"]  = $input_post['en_body02'];
	    		$set_data["rv_length02"]      = 0;
	    		$set_data["rv_cl_seq"]        = $_SESSION['a_cl_seq'];
	    		$set_data["rv_cl_siteid"]     = $_SESSION['a_cl_siteid'];
	    		$set_data["rv_en_seq"]        = $input_post['en_seq'];

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
	    		$entry_data = $this->ent->get_entry_siteid($_SESSION['a_cl_siteid']);
	    		$rev_data = $this->rev->get_revision_siteid($_SESSION['a_cl_siteid']);

				$this->smarty->assign('cl_status', $_SESSION['a_cl_status']);
	    		$this->smarty->assign('list',      $entry_data[0]);
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
		    	$entry_data = $this->ent->get_entry_siteid($clac_data[0]['cl_siteid']);

    			$this->smarty->assign('cl_status', $set_data['cl_status']);
		    	$this->smarty->assign('list', $entry_data[0]);

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

	    $this->view('entrytenpo/report_edit.tpl');

    }

    // プレビュー画面表示
    public function request()
    {

    	$input_post = $this->input->post();

    	switch ($input_post['submit'])
    	{
            case 'salse_ok':

    			// クライアントステータス変更：「6:クライアント確認」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $input_post['cl_seq'];
    			$set_data['cl_id']      = $input_post['cl_id'];
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
    			$set_data['cl_id']      = $input_post['cl_id'];
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
            	$set_data['cl_id']      = $input_post['cl_id'];
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

				$this->view('entrytenpo/tenpo_pre.tpl');

                break;
            default:
        }

    }

    // 初期値セット
    private function _item_set()
    {

    	// 時刻セット
    	for ($i=0; $i < 24; $i++)
    	{
    		$arr_time_h[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
    	}

    	// 分セット
    	for ($i=0; $i < 60; $i+=5)
    	{
    		$arr_time_m[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
    	}

    	$this->smarty->assign('opt_time_h', $arr_time_h);
    	$this->smarty->assign('opt_time_m', $arr_time_m);

    }

    // カテゴリセット
    private function _item_cate_set($cate01, $cate02=FALSE, $cate03=FALSE)
    {

    	$this->load->model('Category', 'cate', TRUE);

    	$arroptions_en_cate01 = array();
    	$arroptions_en_cate02 = array();
    	$arroptions_en_cate03 = array();

    	// 第一階層カテゴリデータ取得
    	$cate01_data = $this->cate->get_category_parent1();
    	foreach ($cate01_data as $key => $value)
    	{
    		$arroptions_en_cate01[$value['ca_seq']] = $value['ca_name'];
    	}

    	// 第二階層カテゴリデータ取得
    	$cate02_data = $this->cate->get_category_parent2($cate01);
    	foreach ($cate02_data as $key => $value)
    	{
    		$arroptions_en_cate02[$value['ca_seq']] = $value['ca_name'];
    	}

    	// 第三階層カテゴリデータ取得
		if ($cate02 == TRUE)
		{
			if ($cate03 == TRUE)
			{
				$cate03_data = $this->cate->get_category_parent3($cate02);
				foreach ($cate03_data as $key => $value)
				{
					$arroptions_en_cate03[$value['ca_seq']] = $value['ca_name'];
				}
			} else {
				$cate03_data = $this->cate->get_category_parent3($cate02_data[0]['ca_seq']);
				foreach ($cate03_data as $key => $value)
				{
					$arroptions_en_cate03[$value['ca_seq']] = $value['ca_name'];
				}
			}
		} else {
	    	$cate03_data = $this->cate->get_category_parent3($_SESSION['a_cate02']);
	    	foreach ($cate03_data as $key => $value)
	    	{
	    		$arroptions_en_cate03[$value['ca_seq']] = $value['ca_name'];
	    	}


	    	print("<br><br>");
	    	print_r($arroptions_en_cate03);


		}

		return array($arroptions_en_cate01, $arroptions_en_cate02, $arroptions_en_cate03);

//     	$this->smarty->assign('opt_en_cate01',  $arroptions_en_cate01);
//     	$this->smarty->assign('opt_en_cate02',  $arroptions_en_cate02);
//     	$this->smarty->assign('opt_en_cate03',  $arroptions_en_cate03);

    }

    // 営業時間初期値セット
    private function _item_eigyo_set()
    {

    	// 日付け初期化
    	for ($i = 0; $i < 3; $i++)
    	{
    		for ($j = 0; $j < 7; $j++)
    		{
    			$eigyo_chk[$i][$j] = FALSE;
    		}
    	}

    	// 定休日初期化
    	for ($i = 0; $i < 8; $i++)
    	{
    		$closed_chk[0][$i] = FALSE;
    	}

    	$entry_data = $this->ent->get_entry_siteid($_SESSION['a_cl_siteid']);
    	if (isset($entry_data[0]['en_eigyo']))
    	{

    		$cnt = 0;
    		foreach(explode("/", $entry_data[0]['en_eigyo']) as $value){

    			$unit = explode(",", $value);

    			// 営業日セット
    			foreach(str_split($unit[0]) as  $val)
    			{
    				$eigyo_chk[$cnt][$val] = " checked";
    			}

    			// 営業時間セット
    			preg_match_all('/[0-9]+/i', $unit[1], $eigyo_time[$cnt]);

    			$cnt++;

    		}

    		// 定休日セット
    		foreach(str_split($entry_data[0]['en_closed']) as  $val)
    		{
    			$closed_chk[0][$val] = " checked";
    		}

    		$this->smarty->assign('eigyo_time', $eigyo_time);
    	}

    	$this->smarty->assign('eigyo_chk',  $eigyo_chk);
    	$this->smarty->assign('closed_chk', $closed_chk);


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

    // 営業時間をデータセット
    private function _eigyo_time_set($arr_setdata)
    {


    	// 営業時間セット:1
    	$_eigyobi1 = "";
    	if (isset($arr_setdata["eigyo1"]))
    	{
    		foreach ($arr_setdata["eigyo1"] as $key => $val)
    		{
    			$_eigyobi1 .= $val;
    		}

    		unset($arr_setdata["eigyo1"]) ;

    	}

    	$_eigyobi1  .= ","
    			. str_pad($arr_setdata["eigyo_time11"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time12"], 2, "0", STR_PAD_LEFT)
    			. "-"
    			. str_pad($arr_setdata["eigyo_time21"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time22"], 2, "0", STR_PAD_LEFT)
    			. "+"
    		    . str_pad($arr_setdata["eigyo_time31"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time32"], 2, "0", STR_PAD_LEFT)
    		    . "-"
    		    . str_pad($arr_setdata["eigyo_time41"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time42"], 2, "0", STR_PAD_LEFT)
    		    ;


    	// 営業時間セット:2
    	$_eigyobi2 = "";
    	if (isset($arr_setdata["eigyo2"]))
    	{
    		foreach ($arr_setdata["eigyo2"] as $key => $val)
    		{
    			$_eigyobi2 .= $val;
    		}

    		unset($arr_setdata["eigyo2"]) ;

    	}

    	$_eigyobi2  .= ","
    			. str_pad($arr_setdata["eigyo_time51"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time52"], 2, "0", STR_PAD_LEFT)
    			. "-"
    			. str_pad($arr_setdata["eigyo_time61"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time62"], 2, "0", STR_PAD_LEFT)
    			. "+"
    		    . str_pad($arr_setdata["eigyo_time71"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time72"], 2, "0", STR_PAD_LEFT)
    		    . "-"
    		    . str_pad($arr_setdata["eigyo_time81"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time82"], 2, "0", STR_PAD_LEFT)
    		    ;

    	// 営業時間セット:3
    	$_eigyobi3 = "";
    	if (isset($arr_setdata["eigyo3"]))
    	{
    		foreach ($arr_setdata["eigyo3"] as $key => $val)
    		{
    			$_eigyobi3 .= $val;
    		}

    		unset($arr_setdata["eigyo3"]) ;

    	}

    	$_eigyobi3  .= ","
    			. str_pad($arr_setdata["eigyo_time91"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time92"], 2, "0", STR_PAD_LEFT)
    			. "-"
    			. str_pad($arr_setdata["eigyo_time101"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time102"], 2, "0", STR_PAD_LEFT)
    			. "+"
    		    . str_pad($arr_setdata["eigyo_time111"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time112"], 2, "0", STR_PAD_LEFT)
    		    . "-"
    		    . str_pad($arr_setdata["eigyo_time121"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time122"], 2, "0", STR_PAD_LEFT)
    		    ;

    	$arr_setdata["en_eigyo"] = $_eigyobi1 . "/" . $_eigyobi2 . "/" . $_eigyobi3;

    	// 定休日セット
    	if (isset($arr_setdata["closed"]))
    	{
    		$_closed = "";
    		foreach ($arr_setdata["closed"] as $key => $val)
    		{
    			$_closed .= $val;
    		}

    		$arr_setdata["en_closed"] = $_closed;

    		unset($arr_setdata["closed"]) ;
    	}

    	// 不要パラメータ削除
    	unset($arr_setdata["_submit"]) ;
    	unset($arr_setdata["ticket"]) ;
    	unset($arr_setdata["add"]) ;
    	unset($arr_setdata["eigyo_time11"]) ;
    	unset($arr_setdata["eigyo_time12"]) ;
    	unset($arr_setdata["eigyo_time21"]) ;
    	unset($arr_setdata["eigyo_time22"]) ;
    	unset($arr_setdata["eigyo_time31"]) ;
    	unset($arr_setdata["eigyo_time32"]) ;
    	unset($arr_setdata["eigyo_time41"]) ;
    	unset($arr_setdata["eigyo_time42"]) ;
    	unset($arr_setdata["eigyo_time51"]) ;
    	unset($arr_setdata["eigyo_time52"]) ;
    	unset($arr_setdata["eigyo_time61"]) ;
    	unset($arr_setdata["eigyo_time62"]) ;
    	unset($arr_setdata["eigyo_time71"]) ;
    	unset($arr_setdata["eigyo_time72"]) ;
    	unset($arr_setdata["eigyo_time81"]) ;
    	unset($arr_setdata["eigyo_time82"]) ;
    	unset($arr_setdata["eigyo_time91"]) ;
    	unset($arr_setdata["eigyo_time92"]) ;
    	unset($arr_setdata["eigyo_time101"]) ;
    	unset($arr_setdata["eigyo_time102"]) ;
    	unset($arr_setdata["eigyo_time111"]) ;
    	unset($arr_setdata["eigyo_time112"]) ;
    	unset($arr_setdata["eigyo_time121"]) ;
    	unset($arr_setdata["eigyo_time122"]) ;

    	return $arr_setdata;

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
    					'rules'   => 'trim|required|max_length[100]'
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
    					'field'   => 'en_sns05',
    					'label'   => 'ＳＮＳコード５',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'en_google_map',
    					'label'   => 'googleマップコード',
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
    			array(
    					'field'   => 'rv_description',
    					'label'   => '保存タイトル',
    					'rules'   => 'trim|max_length[50]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック
    private function _set_validation03()
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
    			array(
    					'field'   => 'rv_description',
    					'label'   => '保存タイトル',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
