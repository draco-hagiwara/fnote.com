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
			// カテゴリセット
			$this->_item_cate_set('1');										// 初期値で「グルメ」固定表示

			$this->smarty->assign('eigyo_chk',  $eigyo_chk);
			$this->smarty->assign('closed_chk', $closed_chk);

			$this->smarty->assign('list', NULL);
		} else {
			$this->smarty->assign('list', $entry_data[0]);

			// カテゴリセット
			$_SESSION['a_cate01'] = $entry_data[0]['en_cate01'];
			$_SESSION['a_cate02'] = $entry_data[0]['en_cate02'];
			$_SESSION['a_cate03'] = $entry_data[0]['en_cate03'];


			// 営業時間セット
			$this->_item_eigyo_set();
// 			if (isset($entry_data[0]['en_eigyo']))
// 			{

// 				$cnt = 0;
// 				foreach(explode("/", $entry_data[0]['en_eigyo']) as $value){

// 					$unit = explode(",", $value);

// 					// 営業日セット
// 					foreach(str_split($unit[0]) as  $val)
// 					{
// 						$eigyo_chk[$cnt][$val] = " checked";
// 					}

// 					// 営業時間セット
// 					preg_match_all('/[0-9]+/i', $unit[1], $eigyo_time[$cnt]);

// 					$cnt++;

// 				}

// 				// 定休日セット
// 				if (isset($entry_data[0]['en_closed']))
// 				{

// 					$cnt = 0;
// 					foreach(str_split($entry_data[0]['en_closed']) as  $val)
// 					{
// 						$closed_chk[$cnt][$val] = " checked";
// 					}

// 				}

// 				$this->smarty->assign('eigyo_time', $eigyo_time);

// 			}

			$this->_item_cate_set($entry_data[0]['en_cate01']);

		}

		// プレビュー用にチェック用ticketを発行
		$_ticket = md5(uniqid(mt_rand(), true));
		$_SESSION['a_ticket'] = $_ticket;
		$this->smarty->assign('ticket', $_ticket);

// 		$this->smarty->assign('eigyo_chk',  $eigyo_chk);
// 		$this->smarty->assign('closed_chk', $closed_chk);

    	$this->view('entrytenpo/tenpo_edit.tpl');

    }

    // 確認画面表示
    public function tenpo_conf()
    {

    	$input_post = $this->input->post();


//     	print_r($input_post);
//     	exit;




		if (isset($input_post['submit']) && ($input_post['submit'] == 'preview'))
		{
			$this->smarty->assign('list', $input_post);

			$this->view('entrytenpo/tenpo_pre.tpl');
			return;
		}

    	// 初期値セット
    	$this->_item_set();
		if ($input_post["en_cate01"])
		{
			$this->_item_cate_set($input_post["en_cate01"]);
		}

        // 都道府県チェック
        $this->smarty->assign('pref_name', $this->_pref_name);

        $this->load->model('Entry', 'ent', TRUE);

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    	} else {

    		// データ設定
    		$input_post["en_cl_seq"]    = $_SESSION['a_cl_seq'];
    		$input_post["en_cl_id"]     = $_SESSION['a_cl_id'];
    		$input_post["en_cl_siteid"] = $_SESSION['a_cl_siteid'];



//     		print_r($input_post);
//     		exit;


    		// 営業時間セット:1
    		$_eigyobi1 = "";
    		if (isset($input_post["eigyo1"]))
    		{
    			foreach ($input_post["eigyo1"] as $key => $val)
    			{
    				$_eigyobi1 .= $val;
    			}

    			unset($input_post["eigyo1"]) ;

    		}

    		$_eigyobi1  .= ","
    					. str_pad($input_post["eigyo_time11"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time12"], 2, "0", STR_PAD_LEFT)
    					. "-"
    					. str_pad($input_post["eigyo_time21"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time22"], 2, "0", STR_PAD_LEFT)
    					. "+"
    					. str_pad($input_post["eigyo_time31"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time32"], 2, "0", STR_PAD_LEFT)
    					. "-"
    					. str_pad($input_post["eigyo_time41"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time42"], 2, "0", STR_PAD_LEFT)
    					;


    		// 営業時間セット:2
    		$_eigyobi2 = "";
    		if (isset($input_post["eigyo2"]))
    		{
    			foreach ($input_post["eigyo2"] as $key => $val)
    			{
    				$_eigyobi2 .= $val;
    			}

    			unset($input_post["eigyo2"]) ;

    		}

    		$_eigyobi2  .= ","
    					. str_pad($input_post["eigyo_time51"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time52"], 2, "0", STR_PAD_LEFT)
    					. "-"
    					. str_pad($input_post["eigyo_time61"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time62"], 2, "0", STR_PAD_LEFT)
    					. "+"
    					. str_pad($input_post["eigyo_time71"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time72"], 2, "0", STR_PAD_LEFT)
    					. "-"
    					. str_pad($input_post["eigyo_time81"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time82"], 2, "0", STR_PAD_LEFT)
    					;

    		// 営業時間セット:3
    		$_eigyobi3 = "";
    		if (isset($input_post["eigyo3"]))
    		{
    			foreach ($input_post["eigyo3"] as $key => $val)
    			{
    				$_eigyobi3 .= $val;
    			}

    			unset($input_post["eigyo3"]) ;

    		}

    		$_eigyobi3  .= ","
    					. str_pad($input_post["eigyo_time91"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time92"], 2, "0", STR_PAD_LEFT)
    					. "-"
    					. str_pad($input_post["eigyo_time101"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time102"], 2, "0", STR_PAD_LEFT)
    					. "+"
    					. str_pad($input_post["eigyo_time111"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time112"], 2, "0", STR_PAD_LEFT)
    					. "-"
    					. str_pad($input_post["eigyo_time121"], 2, "0", STR_PAD_LEFT)
    					. ":"
    					. str_pad($input_post["eigyo_time122"], 2, "0", STR_PAD_LEFT)
    					;

    		$input_post["en_eigyo"] = $_eigyobi1 . "/" . $_eigyobi2 . "/" . $_eigyobi3;

    		// 定休日セット
    		if (isset($input_post["closed"]))
    		{
    			$_closed = "";
    			foreach ($input_post["closed"] as $key => $val)
    			{
    				$_closed .= $val;
    			}

    			$input_post["en_closed"] = $_closed;

    			unset($input_post["closed"]) ;
    		}


    		// 不要パラメータ削除
//     		unset($input_post["submit"]) ;
    		unset($input_post["add"]) ;
    		unset($input_post["eigyo_time11"]) ;
    		unset($input_post["eigyo_time12"]) ;
    		unset($input_post["eigyo_time21"]) ;
    		unset($input_post["eigyo_time22"]) ;
    		unset($input_post["eigyo_time31"]) ;
    		unset($input_post["eigyo_time32"]) ;
    		unset($input_post["eigyo_time41"]) ;
    		unset($input_post["eigyo_time42"]) ;
    		unset($input_post["eigyo_time51"]) ;
    		unset($input_post["eigyo_time52"]) ;
    		unset($input_post["eigyo_time61"]) ;
    		unset($input_post["eigyo_time62"]) ;
    		unset($input_post["eigyo_time71"]) ;
    		unset($input_post["eigyo_time72"]) ;
    		unset($input_post["eigyo_time81"]) ;
    		unset($input_post["eigyo_time82"]) ;
    		unset($input_post["eigyo_time91"]) ;
    		unset($input_post["eigyo_time92"]) ;
    		unset($input_post["eigyo_time101"]) ;
    		unset($input_post["eigyo_time102"]) ;
    		unset($input_post["eigyo_time111"]) ;
    		unset($input_post["eigyo_time112"]) ;
    		unset($input_post["eigyo_time121"]) ;
    		unset($input_post["eigyo_time122"]) ;

    		// DB書き込み
    		$_row_id = $this->ent->inup_tenpo($input_post);
    	}

    	// プレビュー用にチェック用ticketを発行
    	$_ticket = md5(uniqid(mt_rand(), true));
    	$_SESSION['a_ticket'] = $_ticket;
    	$this->smarty->assign('ticket', $_ticket);


    	// 再読み込み
    	// 日付け初期化
    	$this->_item_eigyo_set();
//     	for ($i = 0; $i < 3; $i++)
//     	{
//     		for ($j = 0; $j < 7; $j++)
//     		{
//     			$eigyo_chk[$i][$j] = FALSE;
//     		}
//     	}

//     	// 定休日初期化
//     	for ($i = 0; $i < 8; $i++)
//     	{
//     		$closed_chk[0][$i] = FALSE;
//     	}

//     	$entry_data = $this->ent->get_entry_siteid($_SESSION['a_cl_siteid']);
//     	if (isset($entry_data[0]['en_eigyo']))
//     	{

//     		$cnt = 0;
//     		foreach(explode("/", $entry_data[0]['en_eigyo']) as $value){

//     			$unit = explode(",", $value);

//     			// 営業日セット
//     			foreach(str_split($unit[0]) as  $val)
//     			{
//     				$eigyo_chk[$cnt][$val] = " checked";
//     			}

//     			// 営業時間セット
//     			preg_match_all('/[0-9]+/i', $unit[1], $eigyo_time[$cnt]);

//     			$cnt++;

//     		}

//     		// 定休日セット
// 			foreach(str_split($entry_data[0]['en_closed']) as  $val)
// 			{
// 				$closed_chk[0][$val] = " checked";
// 			}

//     		$this->smarty->assign('eigyo_time', $eigyo_time);
//     	}

//     	$this->smarty->assign('eigyo_chk',  $eigyo_chk);
//     	$this->smarty->assign('closed_chk', $closed_chk);

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

    	if ($_SESSION['a_cate01'] != $input_post['en_cate01'])
    	{
    		$_SESSION['a_cate01'] = $input_post["en_cate01"];
    		$_SESSION['a_cate02'] = $input_post["en_cate02"];
    		$_SESSION['a_cate03'] = $input_post["en_cate03"];

    		$this->_item_cate_set($input_post['en_cate01'], TRUE);
    		$input_post["en_cate02"] = 0;
    		$input_post["en_cate03"] = 0;

    	} elseif ($_SESSION['a_cate02'] != $input_post['en_cate02']) {
    		$_SESSION['a_cate01'] = $input_post["en_cate01"];
    		$_SESSION['a_cate02'] = $input_post["en_cate02"];
    		$_SESSION['a_cate03'] = $input_post["en_cate03"];

    		$this->_item_cate_set($input_post['en_cate01'], FALSE, TRUE);
    		$input_post["en_cate03"] = 0;
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
    	$this->_set_validation02();												// バリデーション設定

    	// レビジョン情報取得
    	$input_post = $this->input->post();

    	$this->load->model('Revision', 'rev', TRUE);
    	$rev_data = $this->rev->get_revision_rvseq($input_post['chg_uniq']);

    	// 表示用データセット
    	$set_data["en_title01"] = $rev_data[0]['rv_entry_title01'];
    	$set_data["en_body01"]  = $rev_data[0]['rv_entry_body01'];
    	$set_data["en_title02"] = $rev_data[0]['rv_entry_title02'];
    	$set_data["en_body02"]  = $rev_data[0]['rv_entry_body02'];
    	$set_data["en_seq"]     = $rev_data[0]['rv_en_seq'];

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
    	$this->smarty->assign('list', $set_data);

    	$this->view('entrytenpo/report_edit.tpl');

    }

    // 確認画面表示
    public function report_conf()
    {

    	$input_post = $this->input->post();

	    $this->load->model('Client', 'cl', TRUE);
	    $this->load->model('Entry', 'ent', TRUE);
	    $this->load->model('Revision', 'rev', TRUE);

	    if ($input_post['_submit'] == 'preview')
    	{
    		$this->smarty->assign('list', $input_post);

    		$this->view('entrytenpo/report_pre.tpl');
    		return;

    	} elseif ($input_post['_submit'] == 'save') {

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

	    	// バリデーション・チェック
	    	$this->_set_validation02();
	    	if ($this->form_validation->run() == FALSE) {
	    		$this->smarty->assign('list', $input_post);
	    		$this->smarty->assign('cl_status', $input_post['cl_status']);
	    		$this->smarty->assign('revlist', NULL);
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

	    	// バリデーション・チェック
	    	$this->_set_validation02();
	    	if ($this->form_validation->run() == FALSE) {
	    		$this->smarty->assign('list', $input_post);
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

//     	// 選択日付の初期化
//     	for ($i = 0; $i < 3; $i++)
//     	{
// 	    	for ($j = 0; $i < 7; $i++)
// 	    	{
//     			$eigyo_chk[$i][$j] = FALSE;
// 	    	}
//     	}

//     	// 選択時刻の初期化
//     	for ($i = 0; $i < 3; $i++)
//     	{
//     		for ($j = 0; $i < 7; $i++)
//     		{
//     			$eigyo_time[$i][0][$j] = FALSE;
//     		}
//     	}

// 		$eigyo1 = array();
// 		$eigyo2 = array();
// 		$eigyo3 = array();

    	$this->smarty->assign('opt_time_h', $arr_time_h);
    	$this->smarty->assign('opt_time_m', $arr_time_m);
//     	$this->smarty->assign('eigyo_chk',  $eigyo_chk);
//     	$this->smarty->assign('eigyo1',     $eigyo1);
//     	$this->smarty->assign('eigyo2',     $eigyo2);
//     	$this->smarty->assign('eigyo3',     $eigyo3);
    	//     	$this->smarty->assign('eigyo_time', $eigyo_time);

    }

//     // 初期値セット
//     private function _item_set01()
//     {

//     	// カテゴリセット
//     	$arroptions_en_cate01 = array (
//     									''  => '選択してください',
//     									'0' => '飲食',
//     									'1' => '弁護士',
//     							);
//     	$arroptions_en_cate02 = array (
// 						    			''  => '選択してください',
// 						    			'0' => '和食',
// 						    			'1' => 'イタリア',
// 						    	);
//     	$arroptions_en_cate03 = array (
// 						    			''  => '選択してください',
// 						    			'0' => '日本料理',
// 						    			'1' => 'ラーメン',
// 						    	);

//     	$this->smarty->assign('opt_en_cate01',  $arroptions_en_cate01);
//     	$this->smarty->assign('opt_en_cate02',  $arroptions_en_cate02);
//     	$this->smarty->assign('opt_en_cate03',  $arroptions_en_cate03);

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
			$cate03_data = $this->cate->get_category_parent3($cate02_data[0]['ca_seq']);
			foreach ($cate03_data as $key => $value)
			{
				$arroptions_en_cate03[$value['ca_seq']] = $value['ca_name'];
			}
		} else {
	    	$cate03_data = $this->cate->get_category_parent3($_SESSION['a_cate02']);
	    	foreach ($cate03_data as $key => $value)
	    	{
	    		$arroptions_en_cate03[$value['ca_seq']] = $value['ca_name'];
	    	}
		}

    	$this->smarty->assign('opt_en_cate01',  $arroptions_en_cate01);
    	$this->smarty->assign('opt_en_cate02',  $arroptions_en_cate02);
    	$this->smarty->assign('opt_en_cate03',  $arroptions_en_cate03);

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

}
