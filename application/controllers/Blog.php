<?php

//class Top extends CI_Controller {
class Blog extends MY_Controller
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

    }

    public function index()
    {

		redirect(base_url());

    }

	// ブログ一覧＆検索
    public function pf()
    {

    	$post_data = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();
    	$this->_set_validation02();

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();

    	// 検索用セットアップ
    	// 1ページ当たりの表示件数
    	$tmp_per_page = 20;

    	// Pagination 現在ページ数の取得：：URIセグメントの取得
//     	$segments = $this->uri->segment_array();
    	if (isset($segments[4]))
    	{
    		$tmp_offset = $segments[4];
    	} else {
    		if (isset($segments[3]))
    		{
    			$tmp_offset = 0;
    		} else {
    			redirect(base_url());
    		}
    	}

    	if (isset($post_data['bl_keyword']))
    	{
    		$tmp_inputpost = $this->input->post();
    	} else {
    		$tmp_inputpost = array(
    				'bl_keyword' => '',
    				'bar_tag'    => '',
    		);
    	}

    	// ブログ設置有無の確認
    	$this->load->model('Client', 'cl', TRUE);
    	$clseq_deta = $this->cl->get_cl_siteid($segments[3]);
    	if ($clseq_deta[0]['cl_blog_status'] == 0)
    	{
    		$_SESSION['blog_title']    = $clseq_deta[0]['cl_blog_title'];
    		$_SESSION['blog_overview'] = $clseq_deta[0]['cl_blog_overview'];
    	} else {
    		redirect(base_url());
    	}

    	$tmp_inputpost['bar_cl_siteid'] = $segments[3];
    	$tmp_inputpost['orderid']       = '';

    	$this->load->model('Blog_article', 'blar', TRUE);
    	$this->load->model('Blog_comment', 'blcm', TRUE);

    	// ブログデータの取得
    	list($blog_list, $blog_countall) = $this->blar->get_blog_serach($tmp_inputpost, $tmp_per_page, $tmp_offset);

    	// コメントのカウント
    	$cnt = 0;
    	foreach ($blog_list as $key => $val)
    	{
    		$blog_list[$cnt]['bcm_bar_seq'] = $this->blcm->get_comment_cnt($val['bar_seq']);
    		$cnt++;
    	}

    	$this->smarty->assign('list', $blog_list);

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination($blog_countall, $tmp_per_page, $segments[3]);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('countall',       $blog_countall);
    	$this->smarty->assign('siteid',         $segments[3]);

    	$this->view('blog/pf.tpl');

    }

    // コメント表示＆入力
    public function detail()
    {

    	$post_data = $this->input->post();

    	$this->load->model('Blog_article', 'blar', TRUE);
    	$this->load->model('Blog_comment', 'blcm', TRUE);

    	// URLセグメント読み込み
    	$segments = $this->uri->segment_array();

    	// ブログデータの読み込み
    	$artcle_data = $this->blar->get_blog_seq($segments[4]);

    	// バリデーション・チェック
    	$this->_set_validation03();
    	if ($this->form_validation->run() == TRUE)
    	{
    		if ( $this->input->post('submit') )
    		{

    			$set_data['bcm_bar_seq']   = $post_data['bar_seq'];
    			$set_data['bcm_name']      = $post_data['bcm_name'];
    			$set_data['bcm_mail']      = $post_data['bcm_mail'];
    			$set_data['bcm_url']       = $post_data['bcm_url'];
    			$set_data['bcm_text']      = $post_data['bcm_text'];
    			$set_data['bcm_cl_seq']    = $artcle_data[0]['bar_cl_seq'];
    			$set_data['bcm_cl_siteid'] = $artcle_data[0]['bar_cl_siteid'];

    			$set_data['bcm_host']    = $this->input->ip_address();
    			// $set_data['bcm_host']    = gethostbyaddr($this->input->server('REMOTE_ADDR'));	// リモートホスト名だが時間がかかる！

    			// ブログコメントデータの書き込み
    			$comm_data = $this->blcm->insert_blog($set_data);

    		}
    	}

    	// コメントデータの読み込み
    	$comment_data = $this->blcm->get_blog_seq($artcle_data[0]['bar_seq']);

    	// コメントのカウント
    	$comment_cnt = $this->blcm->get_comment_cnt($artcle_data[0]['bar_seq']);


    	$this->smarty->assign('artcle_list', $artcle_data[0]);

    	$this->smarty->assign('comment_list', $comment_data);
    	$this->smarty->assign('comment_cnt',  $comment_cnt);

    	$this->smarty->assign('bar_seq', $artcle_data[0]['bar_seq']);
    	$this->smarty->assign('siteid',  $segments[3]);

    	$this->view('blog/detail.tpl');

    }

    public function inquiry_conf()
    {

    	$post_data = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation02();
    	if ($this->form_validation->run() == FALSE) {

    		// 検索用セットアップ
    		// 1ページ当たりの表示件数
    		$tmp_per_page = 20;
    		$tmp_offset   = 0;

    		// Pagination 現在ページ数の取得：：URIセグメントの取得
   			$tmp_inputpost = array(
    								'bl_keyword' => '',
    								'bar_tag'    => '',
    							);

    		$tmp_inputpost['bar_cl_siteid'] = $post_data['siteid'];
    		$tmp_inputpost['orderid']       = '';

    		$this->load->model('Blog_article', 'blar', TRUE);
    		$this->load->model('Blog_comment', 'blcm', TRUE);

    		// ブログデータの取得
    		list($blog_list, $blog_countall) = $this->blar->get_blog_serach($tmp_inputpost, $tmp_per_page, $tmp_offset);

    		// コメントのカウント
    		$cnt = 0;
    		foreach ($blog_list as $key => $val)
    		{
    			$blog_list[$cnt]['bcm_bar_seq'] = $this->blcm->get_comment_cnt($val['bar_seq']);
    			$cnt++;
    		}

    		$this->smarty->assign('list', $blog_list);

    		// Pagination 設定
    		$set_pagination = $this->_get_Pagination($blog_countall, $tmp_per_page, $post_data['siteid']);

    		$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    		$this->smarty->assign('countall',       $blog_countall);
    		$this->smarty->assign('siteid',         $post_data['siteid']);

    		$this->view('blog/pf.tpl');


    	} else {

    		$this->smarty->assign('siteid', $post_data['siteid']);

    		$this->view('blog/inquiry_conf.tpl');
    	}

    }

    public function inquiry_comp()
    {

    	$post_data = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation02();
    	$this->form_validation->run();

    	// 「戻る」ボタン押下の場合
    	if ( $this->input->post('_back') ) {

    		// 検索用セットアップ
    		// 1ページ当たりの表示件数
    		$tmp_per_page = 20;
    		$tmp_offset   = 0;

    		// Pagination 現在ページ数の取得：：URIセグメントの取得
    		$tmp_inputpost = array(
    				'bl_keyword' => '',
    				'bar_tag'    => '',
    		);

    		$tmp_inputpost['bar_cl_siteid'] = $post_data['siteid'];
    		$tmp_inputpost['orderid']       = '';

    		$this->load->model('Blog_article', 'blar', TRUE);
    		$this->load->model('Blog_comment', 'blcm', TRUE);

    		// ブログデータの取得
    		list($blog_list, $blog_countall) = $this->blar->get_blog_serach($tmp_inputpost, $tmp_per_page, $tmp_offset);

    		// コメントのカウント
    		$cnt = 0;
    		foreach ($blog_list as $key => $val)
    		{
    			$blog_list[$cnt]['bcm_bar_seq'] = $this->blcm->get_comment_cnt($val['bar_seq']);
    			$cnt++;
    		}

    		$this->smarty->assign('list', $blog_list);

    		// Pagination 設定
    		$set_pagination = $this->_get_Pagination($blog_countall, $tmp_per_page, $post_data['siteid']);

    		$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    		$this->smarty->assign('countall',       $blog_countall);
    		$this->smarty->assign('siteid',         $post_data['siteid']);

    		$this->view('blog/pf.tpl');

    		return;

    	}

    	// 不要パラメータ削除
    	$post_data['co_cl_siteid'] = $post_data['siteid'];
    	unset($post_data["siteid"]) ;
    	unset($post_data["submit"]) ;

    	// tb_contact への書き込み
    	$this->load->model('Contact', 'cont', TRUE);
    	$_row_id = $this->cont->insert_contact($post_data, TRUE);
    	if (!is_numeric($_row_id))
    	{
    		log_message('error', 'blog::[inquiry_comp()]ブログ問合せ情報登録処理 insert_contactエラー');
    	}

    	// クライアント情報を取得
    	$this->load->model('Client', 'cl', TRUE);
    	$client_data = $this->cl->get_cl_siteid($post_data["co_cl_siteid"]);

    	// メール送信先設定
    	$mail['from']      = "";
    	$mail['from_name'] = "";
    	$mail['subject']   = "";
    	$mail['to']        = $client_data[0]["cl_mail"];
    	$mail['cc']        = $post_data["co_contact_mail"];
    	$mail['bcc']       = "";

    	// メール本文置き換え文字設定
    	$arrRepList = array(
    			'co_contact_name' => $post_data["co_contact_name"],
    			'co_contact_mail' => $post_data["co_contact_mail"],
    			'co_contact_tel'  => $post_data["co_contact_tel"],
    			'co_contact_body' => $post_data["co_contact_body"],
    	);

    	// メールテンプレートの読み込み
    	$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    	$mail_tpl = $this->config->item('MAILTPL_CONTACT_TENPO_ID');

    	// メール送信
    	$this->load->model('Mailtpl', 'mailtpl', TRUE);
    	if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl, 5)) {
    	} else {
    		echo "メール送信エラー";
    		log_message('error', 'blog::[inquiry_comp()]ブログ問合せ処理 メール送信エラー');
    	}

    	$_site_url = "blog/pf/" . $post_data['co_cl_siteid'] ."/";

    	$this->smarty->assign('_site_url', $_site_url);
    	$this->view('blog/inquiry_comp.tpl');

    }

    // Pagination 設定
    private function _get_Pagination($countall, $tmp_per_page, $siteid)
    {

    	$config['base_url']       = base_url() . '/blog/pf/' . $siteid;			// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
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

    // フォーム・バリデーションチェック : ブログ検索
    private function _set_validation()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'bl_keyword',
    					'label'   => 'キーワード',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'bar_tag',
    					'label'   => 'タグ',
    					'rules'   => 'trim|max_length[50]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック : 問合せ
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'co_contact_name',
    					'label'   => 'お名前',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'co_contact_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|required|max_length[255]|valid_email'
    			),
    			array(
    					'field'   => 'co_contact_tel',
    					'label'   => '電話番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'co_contact_body',
    					'label'   => 'お問合せ内容',
    					'rules'   => 'trim|required|max_length[1000]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック : コメント入力フォーム
    private function _set_validation03()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'bcm_name',
    					'label'   => 'お名前',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'bcm_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|max_length[255]|valid_email'
    			),
    			array(
    					'field'   => 'bcm_url',
    					'label'   => 'URL',
    					'rules'   => 'trim|regex_match[/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/]|max_length[100]'
    			),
    			array(
    					'field'   => 'bcm_text',
    					'label'   => 'お問合せ内容',
    					'rules'   => 'trim|required|max_length[500]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */