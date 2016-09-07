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

    // DB & System バックアップ
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

    // セッション情報削除 (一か月前)
    public function sess_destroy()
    {

    	// 一か月前のセッションを削除
    	$now_time = time();
    	$del_time = strtotime('-1 month' , $now_time);
//     	$del_time = strtotime('-1 hour' , $now_time);

    	$this->load->model('Ci_sessions', 'sess', TRUE);
    	$this->sess->destroy_session($del_time);

    	$this->view('system/index.tpl');

    }

    // カテゴリ 順位設定＆登録
    public function categroup_new()
    {

    	$input_post = $this->input->post();

    	$err_mess01 = NULL;
    	$err_mess02 = NULL;
    	$err_mess03 = NULL;

    	// バリデーション・チェック
    	$this->_set_validation02();

    	$arroptions_ca_cate01 = array();
    	$arroptions_ca_cate02 = array();
    	$arroptions_ca_cate03 = array();

    	$this->load->model('Categroup', 'cate', TRUE);

    	// カテゴリ登録
    	if (isset($input_post['new']))
    	{

    		// 第一カテゴリ追加
    		if ($input_post['new'] == "cate01")
    		{
    			if ($input_post['ca_name01'] != "")
    			{
    				// 最終データを読み込む
    				$_cate_data = $this->cate->get_cate_parent1_last();
    				if (isset($_cate_data[0]['ca_id']))
    				{
    					$_ca_id = hexdec($_cate_data[0]['ca_id']) + 1;			// 16進数の文字列を10進数に変換
    				} else {
    					$_ca_id = 1;
    				}
    				$set_data['ca_id']     = dechex($_ca_id);					// 10進数の数値の16進数に変換

    				$set_data['ca_name']   = $input_post['ca_name01'];
    				$set_data['ca_level']  = 1;									// １カテ
    				$set_data['ca_dispno'] = 0;

    				$_row_id = $this->cate->insert_category($set_data);
    				if (!is_numeric($_row_id))
    				{
    					$err_mess01 = 'カテゴリの登録に失敗しました。';
    				}
    			} else {
    				$err_mess01 = 'カテゴリ欄に文字を入力してください。';
    			}
    		}

    		// 第二カテゴリ追加
    		if ($input_post['new'] == "cate02")
    		{
    			if ($input_post['ca_name02'] != "")
    			{
    				// 最終データを読み込む
    				$_cate_data = $this->cate->get_cate_parent2_last($input_post['ca_cate01']);
    				if (isset($_cate_data[0]['ca_id']))
    				{
    					$_ca_id = hexdec($_cate_data[0]['ca_id']) + 1;			// 16進数の文字列を10進数に変換
    				} else {
    					$_ca_id = 1;
    				}
    				$set_data['ca_id']     = dechex($_ca_id);					// 10進数の数値の16進数に変換

    				$set_data['ca_name']   = $input_post['ca_name02'];
    				$set_data['ca_parent'] = $input_post['ca_cate01'];
    				$set_data['ca_level']  = 2;									// ２カテ
    				$set_data['ca_dispno'] = 0;

    				$_row_id = $this->cate->insert_category($set_data);
    				if (!is_numeric($_row_id))
    				{
    					$err_mess02 = 'カテゴリの登録に失敗しました。';
    				}
    			} else {
    				$err_mess02 = 'カテゴリ欄に文字を入力してください。';
    			}
    		}

    		// 第三カテゴリ追加
    		if ($input_post['new'] == "cate03")
    		{
    			if ($input_post['ca_name03'] != "")
    			{
    				// 最終データを読み込む
    				$_cate_data = $this->cate->get_cate_parent3_last($input_post['ca_cate02']);
    				if (isset($_cate_data[0]['ca_id']))
    				{
    					$_ca_id = hexdec($_cate_data[0]['ca_id']) + 1;			// 16進数の文字列を10進数に変換
    				} else {
    					$_ca_id = 1;
    				}
    				$set_data['ca_id']     = dechex($_ca_id);					// 10進数の数値の16進数に変換

    				$set_data['ca_name']   = $input_post['ca_name03'];
    				$set_data['ca_parent'] = $input_post['ca_cate02'];
    				$set_data['ca_level']  = 3;									// ３カテ
    				$set_data['ca_dispno'] = 0;

    				$_row_id = $this->cate->insert_category($set_data);
    				if (!is_numeric($_row_id))
    				{
    					$err_mess03 = 'カテゴリの登録に失敗しました。';
    				}
    			} else {
    				$err_mess03 = 'カテゴリ欄に文字を入力してください。';
    			}
    		}

    	// カテゴリ並び替え
    	} else {

    		// 第一カテゴリ並び替え
    		if ((isset($input_post['result01'])) && ($input_post['result01'] != ""))
    		{
    			$result01 = $input_post['result01'];
    			$result_array = explode(',', $result01);

    			$this->_update_category($result_array);
    		}

    		// 第二カテゴリ並び替え
    		if ((isset($input_post['result02'])) && ($input_post['result02'] != ""))
    		{
    			$result02 = $input_post['result02'];
    			$result_array = explode(',', $result02);

    			$this->_update_category($result_array);
    		}

    		// 第三カテゴリ並び替え
    		if ((isset($input_post['result03'])) && ($input_post['result03'] != ""))
    		{
    			$result03 = $input_post['result03'];
    			$result_array = explode(',', $result03);

    			$this->_update_category($result_array);
    		}
    	}

    	// カテゴリ情報取得
    	if (count($input_post) == 0)
    	{

    		// 第一階層カテゴリデータ取得
    		$cate01_data = $this->cate->get_category_parent1();
    		foreach ($cate01_data as $key => $value)
    		{
    			$arroptions_ca_cate01[$value['ca_seq']] = $value['ca_name'];
    		}

    	} else {

    		// 第一階層カテゴリデータ取得
    		$cate01_data = $this->cate->get_category_parent1();
    		foreach ($cate01_data as $key => $value)
    		{
    			$arroptions_ca_cate01[$value['ca_seq']] = $value['ca_name'];
    		}

    		// 第二階層カテゴリデータ取得
    		$cate02_data = $this->cate->get_category_parent2($input_post['ca_cate01']);
    		foreach ($cate02_data as $key => $value)
    		{
    			$arroptions_ca_cate02[$value['ca_seq']] = $value['ca_name'];
    		}

    		// 第三階層カテゴリデータ取得
    		if (isset($_SESSION['a_cate01']) && ($_SESSION['a_cate01'] == $input_post["ca_cate01"]))
    		{
    			if (isset($input_post['ca_cate02']))
    			{
    				$cate03_data = $this->cate->get_category_parent3($input_post['ca_cate02']);
    				foreach ($cate03_data as $key => $value)
    				{
    					$arroptions_ca_cate03[$value['ca_seq']] = $value['ca_name'];
    				}
    			}
    		}

    		$_SESSION['a_cate01'] = $input_post["ca_cate01"];

    	}

    	$this->smarty->assign('opt_ca_cate01',  $arroptions_ca_cate01);
    	$this->smarty->assign('opt_ca_cate02',  $arroptions_ca_cate02);
    	$this->smarty->assign('opt_ca_cate03',  $arroptions_ca_cate03);
    	$this->smarty->assign('err_mess01',     $err_mess01);
    	$this->smarty->assign('err_mess02',     $err_mess02);
    	$this->smarty->assign('err_mess03',     $err_mess03);

    	$this->smarty->assign('list',  $input_post);

    	$this->view('system/categroup_new.tpl');

    }

    // カテゴリ 一覧表示
    public function categroup_search()
    {

    	$input_post = $this->input->post();

    	$arroptions_ca_cate01 = array();
    	$arroptions_ca_cate02 = array();
    	$arroptions_ca_cate03 = array();

    	$this->load->model('Categroup', 'cate', TRUE);

    	// 検索項目の保存が上手くいかない。応急的に対応！
    	$tmp_inputpost['ca_seq']    = NULL;
    	$tmp_inputpost['ca_parent'] = NULL;
    	$tmp_inputpost['orderid']   = "ASC";
    	if ((isset($input_post['submit'])) && ($input_post['submit'] == '_submit'))
    	{

    		// 第一or第二 のどちらを変えたかのチェック
    		if ($_SESSION['a_cate01'] == $input_post["ca_cate01"])
    		{

    			if (isset($input_post['ca_cate02']) && $input_post['ca_cate02'] != "") {
    				$tmp_inputpost['ca_parent'] = $input_post['ca_cate02'];
    				$_SESSION['a_cate02']       = $input_post["ca_cate02"];
    			} elseif (isset($input_post['ca_cate01']) && ($input_post['ca_cate01'] != "")) {
    				$tmp_inputpost['ca_parent'] = $input_post['ca_cate01'];
    				$_SESSION['a_cate02']       = "";
    			}

    		} else {

    			if (isset($input_post['ca_cate01']) && $input_post['ca_cate01'] == "") {
    				$_SESSION['a_cate01']       = "";
    				$_SESSION['a_cate02']       = "";
    			} elseif (isset($input_post['ca_cate01']) && $input_post['ca_cate01'] != "") {
    				$tmp_inputpost['ca_parent'] = $input_post['ca_cate01'];
    				$_SESSION['a_cate01']       = $input_post["ca_cate01"];
    				$_SESSION['a_cate02']       = "";

    			}
    		}

    	} else {

    		// ページング時のカテゴリ保存
    		if (isset($_SESSION['a_cate02']) && ($_SESSION['a_cate02'] != ""))
    		{
    			$tmp_inputpost['ca_parent'] = $_SESSION['a_cate02'];
    			$input_post["ca_cate01"]    = $_SESSION['a_cate01'];
    			$input_post["ca_cate02"]    = $_SESSION['a_cate02'];
    		} elseif (isset($_SESSION['a_cate01']) && ($_SESSION['a_cate01'] != "")) {
    			$tmp_inputpost['ca_parent'] = $_SESSION['a_cate01'];
    			$input_post["ca_cate01"]    = $_SESSION['a_cate01'];
    		}

    	}

    	// バリデーション・チェック
    	$this->_set_validation03();												// バリデーション設定

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_offset = $segments[3];
    	} else {
    		$tmp_offset = 0;
    	}

    	// 1ページ当たりの表示件数 :: 固定とする
    	$tmp_per_page = 10;

    	// カテゴリの取得
    	list($cate_list, $cate_countall) = $this->cate->get_categorylist($tmp_inputpost, $tmp_per_page, $tmp_offset);

    	$this->smarty->assign('list', $cate_list);

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination($cate_countall, $tmp_per_page);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('countall', $cate_countall);

    	// カテゴリ情報取得
    	if (count($input_post) == 0)
    	{

    		// 第一階層カテゴリデータ取得
    		$cate01_data = $this->cate->get_category_parent1();

    		$arroptions_ca_cate01[''] = "選択してください。";
    		foreach ($cate01_data as $key => $value)
    		{
    			$arroptions_ca_cate01[$value['ca_seq']] = $value['ca_name'];
    		}

    	} else {

    		// 第一階層カテゴリデータ取得
    		$cate01_data = $this->cate->get_category_parent1();

    		$arroptions_ca_cate01[''] = "選択してください。";
    		foreach ($cate01_data as $key => $value)
    		{
    			$arroptions_ca_cate01[$value['ca_seq']] = $value['ca_name'];
    		}

    		// 第二階層カテゴリデータ取得
    		$cate02_data = $this->cate->get_category_parent2($input_post['ca_cate01']);

    		$arroptions_ca_cate02[''] = "選択してください。";
    		foreach ($cate02_data as $key => $value)
    		{
    			$arroptions_ca_cate02[$value['ca_seq']] = $value['ca_name'];
    		}

    		// 第三階層カテゴリデータ取得はチェックしない

    		$_SESSION['a_cate01'] = $input_post["ca_cate01"];

    	}

    	$this->smarty->assign('opt_ca_cate01', $arroptions_ca_cate01);
    	$this->smarty->assign('opt_ca_cate02', $arroptions_ca_cate02);
    	$this->smarty->assign('opt_ca_cate03', $arroptions_ca_cate03);

    	$this->smarty->assign('serch_item', $input_post);
    	$this->smarty->assign('ca_name',    NULL);

    	$this->view('system/categroup_chg.tpl');

    }

    // カテゴリ 更新
    public function categroup_chg()
    {

    	$input_post = $this->input->post();

    	$arroptions_ca_cate01 = array();
    	$arroptions_ca_cate02 = array();
    	$arroptions_ca_cate03 = array();

    	$this->load->model('Categroup', 'cate', TRUE);

    	// 対象データ
    	if (isset($input_post['chg_uniq']))
    	{

    		$_SESSION['a_chgcate'] = $input_post['chg_uniq'];
    		$cate_seq_data = $this->cate->get_category_seq($input_post['chg_uniq']);
    		$this->smarty->assign('ca_name',  $cate_seq_data[0]['ca_name']);

    	}

    	// カテゴリ名変更
    	if ((isset($input_post['submit'])) && ($input_post['submit'] == 'catechg'))
    	{

    		$set_data['ca_seq']    = $_SESSION['a_chgcate'];
    		$set_data['ca_name']   = $input_post['ca_name'];
    		$_SESSION['a_chgcate'] = NULL;

    		// 更新
    		$this->cate->update_category($set_data);

    		$this->smarty->assign('ca_name',  "");

    	}

    	$tmp_inputpost['ca_seq']    = NULL;
    	$tmp_inputpost['ca_parent'] = NULL;
    	if (isset($_SESSION['a_cate02']) && ($_SESSION['a_cate02'] != ""))
    	{
    		$tmp_inputpost['ca_parent'] = $_SESSION['a_cate02'];
    	} elseif (isset($_SESSION['a_cate01']) && ($_SESSION['a_cate01'] != "")) {
    		$tmp_inputpost['ca_parent'] = $_SESSION['a_cate01'];
    		$_SESSION['a_cate02'] = "";
    	} else {
    		$_SESSION['a_cate01'] = "";
    		$_SESSION['a_cate02'] = "";
    	}
    	$tmp_inputpost['orderid'] = "ASC";

    	// バリデーション・チェック
    	$this->_set_validation03();												// バリデーション設定

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_offset = $segments[3];
    	} else {
    		$tmp_offset = 0;
    	}

    	// 1ページ当たりの表示件数 :: 固定とする
    	$tmp_per_page = 10;

    	// カテゴリの取得
    	list($cate_list, $cate_countall) = $this->cate->get_categorylist($tmp_inputpost, $tmp_per_page, $tmp_offset);

    	$this->smarty->assign('list', $cate_list);

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination($cate_countall, $tmp_per_page);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('countall', $cate_countall);

    	// カテゴリ情報取得
    	if (isset($_SESSION['a_cate01']) && ($_SESSION['a_cate01'] == ""))
    	{

    		// 第一階層カテゴリデータ取得
    		$cate01_data = $this->cate->get_category_parent1();

    		$arroptions_ca_cate01[''] = "選択してください。";
    		foreach ($cate01_data as $key => $value)
    		{
    			$arroptions_ca_cate01[$value['ca_seq']] = $value['ca_name'];
    		}

    	} else {

    		// 第一階層カテゴリデータ取得
    		$cate01_data = $this->cate->get_category_parent1();

    		$arroptions_ca_cate01[''] = "選択してください。";
    		foreach ($cate01_data as $key => $value)
    		{
    			$arroptions_ca_cate01[$value['ca_seq']] = $value['ca_name'];
    		}

    		// 第二階層カテゴリデータ取得
    		$cate02_data = $this->cate->get_category_parent2($_SESSION['a_cate02']);

    		$arroptions_ca_cate02[''] = "選択してください。";
    		foreach ($cate02_data as $key => $value)
    		{
    			$arroptions_ca_cate02[$value['ca_seq']] = $value['ca_name'];
    		}

    	}

    	$this->smarty->assign('opt_ca_cate01',  $arroptions_ca_cate01);
    	$this->smarty->assign('opt_ca_cate02',  $arroptions_ca_cate02);
    	$this->smarty->assign('opt_ca_cate03',  $arroptions_ca_cate03);

    	$serch_item['ca_cate01'] = $_SESSION['a_cate01'];
    	$serch_item['ca_cate02'] = $_SESSION['a_cate02'];
    	$this->smarty->assign('serch_item',  $input_post);

    	$this->view('system/categroup_chg.tpl');


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

    // カテゴリの並び替え更新
    private function _update_category($result_array)
    {

    	$cnt = 1;
    	foreach ($result_array as $key => $val)
    	{
    		$set_data['ca_seq']    = $val;
    		$set_data['ca_dispno'] = $cnt;

    		// 更新
    		$this->cate->update_category($set_data);
    		$cnt++;
    	}

    }

    // Pagination 設定
    private function _get_Pagination($cate_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/system/categroup_search/';	// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $cate_countall;								// 総件数。where指定するか？
    	//$config['uri_segment']    = 4;										// オフセット値がURIパスの何セグメント目とするか設定
    	$config['num_links']      = 5;											//現在のページ番号の左右にいくつのページ番号リンクを生成するか設定
    	$config['full_tag_open']  = '<p class="pagination">';					// ページネーションリンク全体を階層化するHTMLタグの先頭タグ文字列を指定
    	$config['full_tag_close'] = '</p>';										// ページネーションリンク全体を階層化するHTMLタグの閉じタグ文字列を指定
    	$config['first_link']     = '最初へ';									// 最初のページを表すテキスト。
    	$config['last_link']      = '最後へ';									// 最後のページを表すテキスト。
    	$config['prev_link']      = '前へ';										// 前のページへのリンクを表わす文字列を指定
    	$config['next_link']      = '次へ';										// 次のページへのリンクを表わす文字列を指定

    	$this->load->library('pagination', $config);							// Paginationクラス読み込み
    	$set_page['page_link'] = $this->pagination->create_links();

    	return $set_page;

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

    // フォーム・バリデーションチェック
    private function _set_validation02()
    {

    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

    // フォーム・バリデーションチェック
    private function _set_validation03()
    {

    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

}
