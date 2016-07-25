<?php

class Reply extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['c_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_Seq',   $_SESSION['c_memSeq']);
            $this->smarty->assign('mem_Name',  $_SESSION['c_memName']);
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_Seq',   "");
            $this->smarty->assign('mem_Name',  "");

            redirect('/login/');
        }

    }

    // 問合せ一覧表示
    public function index()
    {

        // バリデーション・チェック
        $this->_set_validation();												// バリデーション設定

        // 1ページ当たりの表示件数
        $this->config->load('config_comm');
        $tmp_per_page = $this->config->item('PAGINATION_PER_PAGE');

        // Pagination 現在ページ数の取得：：URIセグメントの取得
        $segments = $this->uri->segment_array();
        if (isset($segments[3]))
        {
            $tmp_offset = $segments[3];
			$input_post = $this->input->post();
        } else {
            $tmp_offset = 0;
			$input_post = array(
								'orderid'  => '',
								);
        }

        // 問合せ一覧の取得
        $input_post['co_cl_siteid'] = $_SESSION['c_memSiteid'];
        $this->load->model('Contact', 'cont', TRUE);
        list($contact_list, $contact_countall) = $this->cont->get_contactlist($input_post, $tmp_per_page, $tmp_offset);

        $this->smarty->assign('list', $contact_list);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($contact_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall', $contact_countall);

        $this->view('reply/index.tpl');

    }

    // 問合せ内容表示
    public function detail()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	// 更新対象アカウントのデータ取得
    	$input_post = $this->input->post();

    	$tmp_coseq = $input_post['chg_uniq'];

    	$this->load->model('Contact', 'cont', TRUE);
    	$contact_data = $this->cont->get_cont_seq($tmp_coseq);

    	if ($contact_data[0]['co_status'] == 0)
    	{
	    	// ステータス(既読) 書き換え
	    	$set_data['co_seq']    = $tmp_coseq;
	    	$set_data['co_status'] = 1;
	    	$this->cont->update_contact($set_data);
    	}

    	$this->smarty->assign('co_status', $contact_data[0]['co_status']);
    	$this->smarty->assign('list', $contact_data[0]);
    	$this->view('reply/detail.tpl');

    }

    // 問合せ確認
    public function comp()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	// 更新対象アカウントのデータ取得
    	$input_post = $this->input->post();
    	$tmp_coseq = $input_post['co_seq'];

    	$this->load->model('Contact', 'cont', TRUE);
    	$contact_data = $this->cont->get_cont_seq($tmp_coseq);

    	// ステータス(既読) 書き換え
    	$set_data['co_seq']    = $tmp_coseq;
    	$set_data['co_status'] = 2;
    	$this->cont->update_contact($set_data);

        redirect('/reply/');

    }

    // Pagination 設定
    private function _get_Pagination($contact_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/reply/';						// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $contact_countall;							// 総件数。where指定するか？
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

    // フォーム・バリデーションチェック : クライアント
    private function _set_validation()
    {
    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
