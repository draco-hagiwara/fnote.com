<?php

//class Top extends CI_Controller {
class Top extends MY_Controller
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

        $this->smarty->assign('serch_keyword', NULL);
        $this->smarty->assign('serch_access',  NULL);

    }









    // テストOKで「Batch.php」に移行
    public function batchtest()
    {



    	$this->load->model('Tenpocoupon', 'cp',  TRUE);

    	// 該当のデータを取得
    	$coupon_data = $this->cp->get_coupon_enddate();
    	if ($coupon_data != FALSE)
    	{
    		$date = new DateTime();

	    	foreach ($coupon_data as $key => $val)
	    	{

	    		print_r($val);

	    		$set_data['cp_seq']      = $val['cp_seq'];
	    		$set_data['cp_end_date'] = $date->modify('+1 months - 1 days')->format('Y-m-d');		// 1ヶ月後

	    		$this->cp->update_coupon($set_data);

	    	}
    	}


    	$this->view('top/index.tpl');

    }







    public function index()
    {

//     	// カテゴリ一覧を表示
//     	$this->load->model('Categroup', 'cate', TRUE);

//     	$list_cate01 = array();
//     	$i = 0;
//     	$j = 0;
//     	$k = 0;

//     	$cate01_data = $this->cate->get_category_parent1();												// 第一カテゴリを取得
//     	foreach ($cate01_data as $key => $val)
//     	{

//     		// 第一カテゴリ
//     		$_catelist01[$i]['ca_id']   = sprintf('%02d', $cate01_data[$key]['ca_id']);
//     		$_catelist01[$i]['ca_name'] = $cate01_data[$key]['ca_name'];

//     		$cate02_data = $this->cate->get_category_parent2($cate01_data[$key]['ca_seq']);				// 第二カテゴリを取得
//     		foreach ($cate02_data as $key2 => $val2)
//     		{

//     			$cate03_data = $this->cate->get_category_parent3($cate02_data[$key2]['ca_seq']);		// 第三カテゴリを取得
//     			foreach ($cate03_data as $key3 => $val3)
//     			{

// //     				// 第一カテゴリ
// //     				$_catelist01[$i]['ca_id']   = sprintf('%02d', $cate01_data[$key]['ca_id']);
// //     				$_catelist01[$i]['ca_name'] = $cate01_data[$key]['ca_name'];

//     				// 第一+第二カテゴリ
//     				$_catelist02[$i][$j]['ca_id']   = $_catelist01[$i]['ca_id'] . sprintf('%02d', $cate02_data[$key2]['ca_id']);
//     				$_catelist02[$i][$j]['ca_name'] = $cate01_data[$key]['ca_name'] . " => " . $cate02_data[$key2]['ca_name'];

//     				// 第一+第二+第三カテゴリ
//     				$_catelist03[$i][$j][$k]['ca_id']   = $_catelist02[$i][$j]['ca_id'] . sprintf('%02d', $cate03_data[$key3]['ca_id']);
//     				$_catelist03[$i][$j][$k]['ca_name'] = $_catelist02[$i][$j]['ca_name'] . " => " . $cate03_data[$key3]['ca_name'];

//     				$k++;

//     			}

//     			$j++;
//     			$k = 0;

//     		}

//     		$i++;
//     		$j = 0;

//     	}

//     	$this->smarty->assign('list_cate01',  $_catelist01);
//     	$this->smarty->assign('list_cate02',  $_catelist02);
//     	$this->smarty->assign('list_cate03',  $_catelist03);

    	$this->smarty->assign('serch_keyword', NULL);
    	$this->smarty->assign('serch_access',  NULL);

        $this->view('top/index.tpl');

    }

    // 検索結果表示
//     public function search()
//     {

//     	$input_post = $this->input->post();

//         // 検索項目の保存
//         if (isset($input_post['submit']) && ($input_post['submit'] == '_search'))
//         {
//             // セッションをフラッシュデータとして保存
//             $data = array(
//                     'top_keyword' => $input_post['keyword'],
//                     'top_access'  => $input_post['access'],
//             );
//             $this->session->set_userdata($data);

//             $set_search['keyword'] = $input_post['keyword'];
//             $set_search['access']  = $input_post['access'];
//             $set_search['orderid'] = "";

//         } else {
//             // セッションからフラッシュデータ読み込み
//             $set_search['keyword'] = $_SESSION['top_keyword'];
//             $set_search['access']  = $_SESSION['top_access'];
//             $set_search['orderid'] = "";
//         }

//         // Pagination 現在ページ数の取得：：URIセグメントの取得
//         $segments = $this->uri->segment_array();
//         if (isset($segments[3]))
//         {
//             $tmp_offset = $segments[3];
//         } else {
//             $tmp_offset = 0;
//         }

//         // 1ページ当たりの表示件数
//         $this->config->load('config_comm');
//         $tmp_per_page = $this->config->item('PAGINATION_PER_PAGE');

//         // 検索対象データの取得
//         $this->load->model('Tenpoinfo', 'tnp', TRUE);
//         list($tenpo_list, $tenpo_countall) = $this->tnp->get_searchlist($set_search, $tmp_per_page, $tmp_offset);

//         // Pagination 設定
//         $set_pagination = $this->_get_Pagination($tenpo_countall, $tmp_per_page);

//         $this->smarty->assign('set_pagination', $set_pagination['page_link']);
//         $this->smarty->assign('countall',       $tenpo_countall);
//         $this->smarty->assign('list',           $tenpo_list);

//         $this->smarty->assign('serch_keyword',  $_SESSION['top_keyword']);
//         $this->smarty->assign('serch_access',   $_SESSION['top_access']);

//         $this->view('top/search.tpl');

//     }

    // このサイトについて
    public function guide()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定1
        $this->form_validation->run();

        $this->view('top/guide.tpl');

    }

    // 掲載希望の事業者様へ
    public function publish()
    {

    	// バリデーション・チェック
    	$this->_set_validation();                                            // バリデーション設定1
    	$this->form_validation->run();

    	$this->view('top/publish.tpl');

    }

    // 運営会社
    public function aboutus()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定
        $this->form_validation->run();

        $this->view('top/aboutus.tpl');

    }

    // プライバシーポリシー・個人情報保護方針
    public function privacy()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定
        $this->form_validation->run();

        $this->view('top/privacy.tpl');

    }

    // 利用規約
    public function rules()
    {

    	// バリデーション・チェック
    	$this->_set_validation();                                            // バリデーション設定
    	$this->form_validation->run();

    	$this->view('top/rules.tpl');

    }

    // 会員規約
    public function member()
    {

    	// バリデーション・チェック
    	$this->_set_validation();                                            // バリデーション設定
    	$this->form_validation->run();

    	$this->view('top/member.tpl');

    }

    // サイトマップ
    public function sitemap()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定
        $this->form_validation->run();

        $this->view('top/sitemap.tpl');

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

    // 項目 初期値セット
    private function _form_item_set00()
    {

        // ジャンル 選択項目セット
        $this->load->model('comm_select', 'select', TRUE);
        $genre_list = $this->select->get_genre();

        $this->smarty->assign('options_genre_list',   $genre_list);

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