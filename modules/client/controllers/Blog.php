<?php

class Blog extends MY_Controller
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

    // ブログ管理 初期表示
    public function index()
    {

    	// セッションデータをクリア
    	$this->load->model('comm_auth', 'comm_auth', TRUE);
    	if (isset($_SESSION['c_adminSeq']))
    	{
    		$this->comm_auth->delete_session('a_client');
    	} else {
    		$this->comm_auth->delete_session('client');
    	}

    	$this->_set_validation();

    	// 1ページ当たりの表示件数
    	$tmp_per_page = 5;

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_offset = $segments[3];
    	} else {
    		$tmp_offset = 0;
    	}

    	// クライアントデータを取得
    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);
    	$this->smarty->assign('cl', $cl_data[0]);

    	// ブログデータを取得
		$this->load->model('Blog_article', 'blar', TRUE);
		list($blog_list, $blog_countall) = $this->blar->get_bloglist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

		// Pagination 設定
		$set_pagination = $this->_get_Pagination($blog_countall, $tmp_per_page);

		$this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('bar_seq',        NULL);
		$this->smarty->assign('list',           $blog_list);
		$this->smarty->assign('countall',       $blog_countall);

		$_dummy['bar_subject'] = NULL;
		$_dummy['bar_tag']     = NULL;
		$_dummy['bar_comment'] = 0;
		$_dummy['bar_status']  = 0;
		$_dummy['bar_text']    = NULL;
		$this->smarty->assign('low',            $_dummy);

        $this->view('blog/index.tpl');

    }

    // ブログ管理 追加・更新
    public function detail()
    {

    	$input_post = $this->input->post();

	    $this->load->model('Blog_article', 'blar', TRUE);

	    $this->_set_validation();

    	// 一覧から「編集」ボタン押下
    	if (isset($input_post['chg_uniq']))
    	{

    		// 選択された対象データ読み込み
    		$news_data = $this->blar->get_blog_seq($input_post['chg_uniq']);

	    	$this->smarty->assign('bar_seq', $input_post['chg_uniq']);
    		$this->smarty->assign('low',     $news_data[0]);

    	} elseif (isset($input_post['_submit'])) {

	    	if ($this->form_validation->run() == TRUE)
	    	{

		    	// 新規か更新かを判定
		    	if ($input_post['_submit'] == 'addorchg')
		    	{

		    		$set_data['bar_status']  = $input_post['optionsRadios02'];
		    		$set_data['bar_comment'] = $input_post['optionsRadios01'];
		    		$set_data['bar_subject'] = $input_post['bar_subject'];
		    		$set_data['bar_tag']     = $input_post['bar_tag'];
		    		$set_data['bar_text']    = $input_post['area'];

		    		if ($input_post['bar_seq'] != '')
		    		{

			    		// 更新処理
			    		$set_data['bar_seq']    = $input_post['bar_seq'];

			    		$this->blar->update_blog($set_data);

		    		} else {

		    			// 新規登録
		    			$set_data['bar_cl_seq']    = $_SESSION['c_memSeq'];
		    			$set_data['bar_cl_siteid'] = $_SESSION['c_memSiteid'];

		    			$_row_id = $this->blar->insert_blog($set_data);
		    			if (!is_numeric($_row_id))
		    			{
		    				log_message('error', 'Blog::[detail()]ブログ登録更新処理 insert_blogエラー');
		    			}

		    		}

		    	} elseif (isset($input_post['_submit']) == 'delete') {

		    		// 削除処理
		    		$bar_seq    = $input_post['bar_seq'];

		    		$this->blar->delete_blog($bar_seq);

		    	}
	    	}

	    	$this->smarty->assign('bar_seq',        NULL);
			$this->smarty->assign('low',            NULL);

			redirect('/blog/');

    	} else {

    		$this->smarty->assign('bar_seq',        NULL);
    		$this->smarty->assign('low',            NULL);

//     		$_dummy['bar_subject'] = NULL;
//     		$_dummy['bar_tag']     = NULL;
//     		$_dummy['bar_comment'] = 0;
//     		$_dummy['bar_status']  = 0;
//     		$_dummy['bar_text']    = "";
//     		$this->smarty->assign('low',            $_dummy);

    	}

    	// 1ページ当たりの表示件数
    	$tmp_per_page = 5;

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
    	$segments = $this->uri->segment_array();

    	if (isset($segments[3]))
    	{
    		$tmp_offset = $segments[3];
    	} else {
    		$tmp_offset = 0;
    	}

    	// クライアントデータを取得
    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);
    	$this->smarty->assign('cl', $cl_data[0]);

    	// ブログデータを取得
    	list($blog_list, $blog_countall) = $this->blar->get_bloglist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination($blog_countall, $tmp_per_page);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('list',           $blog_list);
    	$this->smarty->assign('countall',       $blog_countall);

    	$this->view('blog/index.tpl');

    }

    // ブログ管理 コメント一覧表示＆削除
    public function comment()
    {

    	$input_post = $this->input->post();

    	$this->load->model('Blog_comment', 'blcm', TRUE);
    	$this->load->model('Blog_article', 'blar', TRUE);

    	$this->_set_validation();

    	// 一覧から「削除」ボタン押下
    	if (isset($input_post['chg_uniq']))
    	{

    		// 選択された対象データを削除
    		$news_data = $this->blcm->delete_comment($input_post['chg_uniq']);

    	}

    	// 1ページ当たりの表示件数
    	$tmp_per_page = 20;

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_offset = $segments[3];
    	} else {
    		$tmp_offset = 0;
    	}

    	// ブログデータを取得
    	$blog_data = $this->blar->get_blog_siteid($_SESSION['c_memSiteid']);

    	// コメントデータを取得
    	list($comment_list, $comment_countall) = $this->blcm->get_commentlist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination02($comment_countall, $tmp_per_page);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('list',           $comment_list);
    	$this->smarty->assign('countall',       $comment_countall);

    	$this->view('blog/comment.tpl');

    }

    // Pagination 設定 : ブログ一覧
    private function _get_Pagination($countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/blog/detail/';				// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $countall;									// 総件数。where指定するか？
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

    // Pagination 設定 : コメント一覧
    private function _get_Pagination02($countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/blog/comment/';				// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $countall;									// 総件数。where指定するか？
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
						'field'   => 'bar_subject',
						'label'   => '題名',
						'rules'   => 'trim|required|max_length[50]'
				),
        		array(
                        'field'   => 'bar_comment',
                        'label'   => 'タグ',
                        'rules'   => 'trim|max_length[50]'
                ),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
