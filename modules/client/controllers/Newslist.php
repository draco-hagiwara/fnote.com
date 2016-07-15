<?php

class Newslist extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['c_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_Seq',   $_SESSION['c_memSeq']);
            $this->smarty->assign('mem_Site',  $_SESSION['c_memSiteid']);
            $this->smarty->assign('mem_Name',  $_SESSION['c_memName']);

        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_Seq',   "");
            $this->smarty->assign('mem_Name',  "");

            redirect('/login/');
        }

    }

    // 新着・お知らせ管理 初期表示
    public function index()
    {

    	$this->_set_validation();

    	// 1ページ当たりの表示件数
    	$tmp_per_page = 10;

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_offset = $segments[3];
    	} else {
    		$tmp_offset = 0;
    	}

    	// 新着・お知らせ管理データを取得
		$this->load->model('News', 'nw', TRUE);
		list($news_list, $news_countall) = $this->nw->get_newslist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);


//     	print("<br>");
//     	print_r($news_list);
//     	print("<br>");
//     	print_r($news_countall);
//     	exit;

		// Pagination 設定
		$set_pagination = $this->_get_Pagination($news_countall, $tmp_per_page);

		$this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('nw_seq', NULL);
		$this->smarty->assign('list', $news_list);
		$this->smarty->assign('low', NULL);
		$this->smarty->assign('countall', $news_countall);

        $this->view('newslist/index.tpl');

    }

    // 新着・お知らせ管理 詳細更新
    public function detail()
    {

    	$input_post = $this->input->post();

	    $this->load->model('news', 'nw', TRUE);

	    $this->_set_validation();

    	// 一覧から「編集」ボタン押下
    	if (isset($input_post['chg_uniq']))
    	{

    		// 選択された対象データ読み込み
    		$news_data = $this->nw->get_news_seq($input_post['chg_uniq']);

    		// Pagination 現在ページ数の取得：：URIセグメントの取得
	    	$segments = $this->uri->segment_array();
	    	if (isset($segments[3]))
	    	{
	    		$tmp_offset = $segments[3];
	    	} else {
	    		$tmp_offset = 0;
	    	}

	    	// 1ページ当たりの表示件数
	    	$tmp_per_page = 10;

	    	// 新着・お知らせ管理データを取得
	    	$this->load->model('News', 'nw', TRUE);
	    	list($news_list, $news_countall) = $this->nw->get_newslist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

	    	// Pagination 設定
	    	$set_pagination = $this->_get_Pagination($news_countall, $tmp_per_page);

	    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
	    	$this->smarty->assign('nw_seq', $input_post['chg_uniq']);
	    	$this->smarty->assign('list', $news_list);
	    	$this->smarty->assign('countall', $news_countall);



// 	    	print_r($news_list);
// 	    	print("<br>");
// 	    	print_r($news_countall);
// 	    	print("<br>");


    		$this->smarty->assign('low', $news_data[0]);

    		$this->view('newslist/index.tpl');
    		return;

    	} else {

// 	    	$this->_set_validation();
	    	if ($this->form_validation->run() == FALSE)
	    	{

	    		// 選択された対象データ読み込み
	    		$news_data = $this->nw->get_news_seq($input_post['nw_seq']);

	    		// 1ページ当たりの表示件数
	    		$tmp_per_page = 10;

	    		// Pagination 現在ページ数の取得：：URIセグメントの取得
	    		$segments = $this->uri->segment_array();
	    		if (isset($segments[3]))
	    		{
	    			$tmp_offset = $segments[3];
	    		} else {
	    			$tmp_offset = 0;
	    		}

	    		// 新着・お知らせ管理データを取得
				$this->load->model('News', 'nw', TRUE);
				list($news_list, $news_countall) = $this->nw->get_newslist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

				// Pagination 設定
				$set_pagination = $this->_get_Pagination($news_countall, $tmp_per_page);

				$this->smarty->assign('set_pagination', $set_pagination['page_link']);
				$this->smarty->assign('nw_seq', NULL);
				$this->smarty->assign('list', $news_list);
				$this->smarty->assign('countall', $news_countall);
				$this->smarty->assign('low', $news_data[0]);

				$this->view('newslist/index.tpl');

	    		return;
	    	}


	    	$setData['nw_status']    = $input_post['optionsRadios02'];
	    	$setData['nw_type']      = $input_post['optionsRadios01'];
	    	$setData['nw_title']     = $input_post['nw_title'];
	    	$setData['nw_body']      = $input_post['input'];
	    	$setData['nw_start_date'] = $input_post['nw_start_date'];
	    	$setData['nw_end_date']  = $input_post['nw_end_date'];


// 	    	print("<br>");
// 	    	print_r($input_post['chg_uniq']);
	//     	print("<br>");
	    	print_r($input_post);
	    	print("<br>");
	//     	print_r($setData);
	//     	print("<br>");
// 	    	print_r($_SESSION);
// 	    	exit;



	    	// 新規か更新かを判定
	    	if ($input_post['submit'] == 'submit')
	    	{
	    		if ($input_post['nw_seq'] != '')
	    		{

		    		// 更新処理
		    		$setData['nw_seq']    = $input_post['nw_seq'];

		    		$this->nw->update_news($setData);

	    		} else {

	    			// 新規登録
	    			$setData['nw_cl_seq']    = $_SESSION['c_memSeq'];
	    			$setData['nw_cl_siteid'] = $_SESSION['c_memSiteid'];

	    			$_row_id = $this->nw->insert_news($setData);
	    			if (!is_numeric($_row_id))
	    			{
	    				log_message('error', 'Newslist::[detail()]新着お知らせ登録処理 insert_newsエラー');
	    			}

	    		}

	    	} elseif (isset($input_post['submit']) == 'delete') {

	    		// 削除処理
	    		$nw_seq    = $input_post['nw_seq'];

	    		$this->nw->delete_news($nw_seq);

	    	}
    	}

    	redirect('/newslist/');

    }

//     // ページリスト表示
//     private function _get_pagelist($tmp_offset)
//     {

// 	    		// 1ページ当たりの表示件数
// 	    		$tmp_per_page = 10;

// 	    		// 新着・お知らせ管理データを取得
// 				$this->load->model('News', 'nw', TRUE);
// 				list($news_list, $news_countall) = $this->nw->get_accountlist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

// 				// Pagination 設定
// 				$set_pagination = $this->_get_Pagination($news_countall, $tmp_per_page);

// 				$this->smarty->assign('set_pagination', $set_pagination['page_link']);
// 	        	$this->smarty->assign('nw_seq', NULL);
// 				$this->smarty->assign('list', $news_list);
// 	        	$this->smarty->assign('countall', $news_countall);

// 	    		return;

//     }

    // Pagination 設定
    private function _get_Pagination($news_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/newslist/';					// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $news_countall;								// 総件数。where指定するか？
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

    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
				array(
						'field'   => 'nw_title',
						'label'   => '名前',
						'rules'   => 'trim|required|max_length[50]'
				),
        		array(
                        'field'   => 'nw_start_date',
                        'label'   => '表示開始日付',
                        'rules'   => 'trim|required|regex_match[/^\d{4}-\d{1,2}-\d{1,2}+$/]|max_length[10]'
                ),
        		array(
                        'field'   => 'nw_end_date',
                        'label'   => '表示終了日付',
                        'rules'   => 'trim|required|regex_match[/^\d{4}-\d{1,2}-\d{1,2}+$/]|max_length[10]'
                ),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}