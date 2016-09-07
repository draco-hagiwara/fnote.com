<?php

//class Top extends CI_Controller {
class Genre extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if ( $this->agent->is_mobile() ) {
        	// モバイル端末アクセスです。
        	$this->smarty->assign('PcorMob', TRUE);
        } else {
        	// モバイル端末アクセスではありません。
        	$this->smarty->assign('PcorMob', FALSE);
        }

        $this->smarty->assign('serch_keyword', NULL);
        $this->smarty->assign('serch_access',  NULL);

    }

    public function index()
    {

    	// カテゴリ一覧を表示
    	$this->load->model('Categroup', 'cate', TRUE);

    	$list_cate01 = array();
    	$i = 0;
    	$j = 0;
    	$k = 0;

    	$cate01_data = $this->cate->get_category_parent1();												// 第一カテゴリを取得
    	foreach ($cate01_data as $key => $val)
    	{

    		// 第一カテゴリ
    		$_catelist01[$i]['ca_id']   = sprintf('%02d', $cate01_data[$key]['ca_id']);
    		$_catelist01[$i]['ca_name'] = $cate01_data[$key]['ca_name'];

    		$cate02_data = $this->cate->get_category_parent2($cate01_data[$key]['ca_seq']);				// 第二カテゴリを取得
    		foreach ($cate02_data as $key2 => $val2)
    		{

    			$cate03_data = $this->cate->get_category_parent3($cate02_data[$key2]['ca_seq']);		// 第三カテゴリを取得
    			foreach ($cate03_data as $key3 => $val3)
    			{

    				//     				// 第一カテゴリ
    				//     				$_catelist01[$i]['ca_id']   = sprintf('%02d', $cate01_data[$key]['ca_id']);
    				//     				$_catelist01[$i]['ca_name'] = $cate01_data[$key]['ca_name'];

    				// 第一+第二カテゴリ
    				$_catelist02[$i][$j]['ca_id']   = $_catelist01[$i]['ca_id'] . sprintf('%02d', $cate02_data[$key2]['ca_id']);
    				$_catelist02[$i][$j]['ca_name'] = $cate01_data[$key]['ca_name'] . " => " . $cate02_data[$key2]['ca_name'];

    				// 第一+第二+第三カテゴリ
    				$_catelist03[$i][$j][$k]['ca_id']   = $_catelist02[$i][$j]['ca_id'] . sprintf('%02d', $cate03_data[$key3]['ca_id']);
    				$_catelist03[$i][$j][$k]['ca_name'] = $_catelist02[$i][$j]['ca_name'] . " => " . $cate03_data[$key3]['ca_name'];

    				$k++;

    			}

    			$j++;
    			$k = 0;

    		}

    		$i++;
    		$j = 0;

    	}

    	$this->smarty->assign('list_cate01',  $_catelist01);
    	$this->smarty->assign('list_cate02',  $_catelist02);
    	$this->smarty->assign('list_cate03',  $_catelist03);

    	$this->view('genre/index.tpl');

    }

    public function genrelist()
    {

//     	$input_post = $this->input->post();

    	// URIセグメントからジャンルIDを取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$set_genre['id']    = $segments[3];
    		$set_genre['level'] = $segments[4];
    	} else {
    		show_404();
    	}

    	if (isset($segments[5]))
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
    	list($tenpo_list, $tenpo_countall) = $this->tnp->get_genrelist($set_genre, $tmp_per_page, $tmp_offset);

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination($tenpo_countall, $tmp_per_page);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('countall',       $tenpo_countall);
    	$this->smarty->assign('list',           $tenpo_list);

        $this->view('genre/genrelist.tpl');

    }

    // Pagination 設定
    private function _get_Pagination($countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/genrelist/list/';			// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
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