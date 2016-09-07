<?php

//class Top extends CI_Controller {
class Searchlist extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

//         $this->local->library('user_agent');
        if ( $this->agent->is_mobile() ) {
        	// モバイル端末アクセスです。
        	$this->smarty->assign('PcorMob', TRUE);
        } else {
        	// モバイル端末アクセスではありません。
        	$this->smarty->assign('PcorMob', FALSE);
        }

    }

    public function index()
    {

    	$input_post = $this->input->post();

        // 検索項目の保存
        if (isset($input_post['submit']) && ($input_post['submit'] == '_search'))
        {
            // セッションをフラッシュデータとして保存
            $data = array(
                    'top_keyword' => $input_post['keyword'],
                    'top_access'  => $input_post['access'],
            );
            $this->session->set_userdata($data);

            $set_search['keyword'] = $input_post['keyword'];
            $set_search['access']  = $input_post['access'];
            $set_search['orderid'] = "";

        } else {
            // セッションからフラッシュデータ読み込み
            $set_search['keyword'] = $_SESSION['top_keyword'];
            $set_search['access']  = $_SESSION['top_access'];
            $set_search['orderid'] = "";
        }

        // Pagination 現在ページ数の取得：：URIセグメントの取得
        $segments = $this->uri->segment_array();
        if (isset($segments[3]))
        {
            $tmp_offset = $segments[3];
        } else {
            $tmp_offset = 0;
        }

        // 1ページ当たりの表示件数
        $this->config->load('config_comm');
        $tmp_per_page = $this->config->item('PAGINATION_PER_PAGE');

        // 検索対象データの取得
        $this->load->model('Tenpoinfo', 'tnp', TRUE);
        list($tenpo_list, $tenpo_countall) = $this->tnp->get_searchlist($set_search, $tmp_per_page, $tmp_offset);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($tenpo_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall',       $tenpo_countall);
        $this->smarty->assign('list',           $tenpo_list);

        $this->smarty->assign('serch_keyword',  $_SESSION['top_keyword']);
        $this->smarty->assign('serch_access',   $_SESSION['top_access']);

        $this->view('searchlist/index.tpl');

    }

    // Pagination 設定
    private function _get_Pagination($countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/top/search/';				// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
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
        );

        $this->load->library('form_validation', $rule_set);                        // バリデーションクラス読み込み

    }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */