<?php

class Tenpo_coupon extends MY_Controller
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

    // 店舗クーポン情報表示
    public function index()
    {

        // バリデーション・チェック
        $this->_set_validation01();												// バリデーション設定

        // 1ページ当たりの表示件数
        $tmp_per_page = 25;
//         $this->config->load('config_comm');
//         $tmp_per_page = $this->config->item('PAGINATION_PER_PAGE');

        // Pagination 現在ページ数の取得：：URIセグメントの取得
        $segments = $this->uri->segment_array();
        if (isset($segments[3]))
        {
            $tmp_offset = $segments[3];
			$input_post = $this->input->post();
			$input_post['orderid'] = 'DESC';
        } else {
            $tmp_offset = 0;
			$input_post['orderid'] = 'DESC';
        }

        // クーポン情報の取得
        $input_post['cp_cl_siteid'] = $_SESSION['c_memSiteid'];
        $this->load->model('Tenpocoupon', 'cp', TRUE);
        list($coupon_list, $coupon_countall) = $this->cp->get_couponlist($input_post, $tmp_per_page, $tmp_offset);

        $this->smarty->assign('list', $coupon_list);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($coupon_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall',       $coupon_countall);

        $this->view('tenpo_coupon/index.tpl');

    }

    // 詳細情報表示
    public function detail()
    {

    	$input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$tmp_seq = $input_post['chg_uniq'];

    	$this->load->model('Tenpocoupon', 'cp', TRUE);
    	$_coupon_data = $this->cp->get_coupon_seq($tmp_seq);

    	// デザインテンプレのセット
    	$this->config->load('config_comm');
    	$options_tpl = $this->config->item('TENPO_COUPON_DESIGN');
    	$this->smarty->assign('options_tpl', $options_tpl);

    	$options_tplimg = $this->config->item('TENPO_COUPON_TEMPLATE');
    	$this->smarty->assign('tpl_img', $options_tplimg[$_coupon_data[0]['cp_template']]);

    	$this->smarty->assign('list', $_coupon_data[0]);

    	$this->view('tenpo_coupon/detail.tpl');

    }

    // 入力情報更新
    public function comp()
    {

    	$input_post = $this->input->post();

    	// 更新対象アカウントのデータ取得
    	$this->load->model('Tenpocoupon', 'cp', TRUE);
    	$tmp_seq = $input_post['cp_seq'];

    	// バリデーション・チェック
		$this->_set_validation();												// バリデーション設定
    	if ($this->form_validation->run() == TRUE)
    	{
    		if ($input_post['_submit'] == '_chg')
    		{
    			$set_data['cp_seq']        = $input_post['cp_seq'];
    			$set_data['cp_status']     = $input_post['optionsRadios01'];
    			$set_data['cp_template']   = $input_post['cp_template'];
    			$set_data['cp_title']      = $input_post['cp_title'];
    			$set_data['cp_content']    = $input_post['cp_content'];
    			$set_data['cp_use']        = $input_post['cp_use'];
    			$set_data['cp_presen']     = $input_post['cp_presen'];
    			$set_data['cp_memo']       = $input_post['cp_memo'];
    			$set_data['cp_start_date'] = $input_post['cp_start_date'];
    			$set_data['cp_end_date']   = $input_post['cp_end_date'];
    			$set_data['cp_update']     = $input_post['optionsRadios02'];
    			$set_data['cp_cl_seq']     = $_SESSION['c_memSeq'];
    			$set_data['cp_cl_siteid']  = $_SESSION['c_memSiteid'];

				$this->cp->update_coupon($set_data);

    		} elseif ($input_post['_submit'] == '_del') {

    				$this->cp->delete_coupon($tmp_seq);

    				redirect('/tenpo_coupon/');
   			}
    	}

    	// 再読み込み
    	$_coupon_data = $this->cp->get_coupon_seq($tmp_seq);

    	$this->smarty->assign('list',   $_coupon_data[0]);
    	$this->smarty->assign('cp_seq', $tmp_seq);

    	// デザインテンプレのセット
    	$this->config->load('config_comm');
    	$options_tpl = $this->config->item('TENPO_COUPON_DESIGN');
    	$this->smarty->assign('options_tpl', $options_tpl);

    	$options_tplimg = $this->config->item('TENPO_COUPON_TEMPLATE');
    	$this->smarty->assign('tpl_img', $options_tplimg[$_coupon_data[0]['cp_template']]);

        $this->view('tenpo_coupon/detail.tpl');

    }

    // 店舗メニューの登録
    public function create_coupon()
    {

    	$input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();

    	if ($input_post['_submit'] == '_chg')
    	{
	    	if ($this->form_validation->run() == TRUE)
	    	{

	    		$set_data['cp_status']     = $input_post['optionsRadios01'];
	    		$set_data['cp_template']   = $input_post['cp_template'];
	    		$set_data['cp_title']      = $input_post['cp_title'];
	    		$set_data['cp_content']    = $input_post['cp_content'];
	    		$set_data['cp_use']        = $input_post['cp_use'];
	    		$set_data['cp_presen']     = $input_post['cp_presen'];
	    		$set_data['cp_memo']       = $input_post['cp_memo'];
	    		$set_data['cp_start_date'] = $input_post['cp_start_date'];
	    		$set_data['cp_end_date']   = $input_post['cp_end_date'];
	    		$set_data['cp_update']     = $input_post['optionsRadios02'];
	    		$set_data['cp_cl_seq']     = $_SESSION['c_memSeq'];
	    		$set_data['cp_cl_siteid']  = $_SESSION['c_memSiteid'];

	    		$this->load->model('Tenpocoupon', 'cp', TRUE);

	    		$_row_id = $this->cp->insert_coupon($set_data);
	    		if (!is_numeric($_row_id))
	    		{
	    			log_message('error', 'Tenpo_Coupon::[create_coupon()]店舗クーポン登録処理 insert_couponエラー');
	    		}

	    		redirect('/tenpo_coupon/');
	    	}
    	}


    	// デザインテンプレのセット
    	$this->config->load('config_comm');
    	$options_tpl = $this->config->item('TENPO_COUPON_DESIGN');

    	$this->smarty->assign('options_tpl', $options_tpl);

    	$this->view('tenpo_coupon/create_coupon.tpl');

    }

    // Pagination 設定
    private function _get_Pagination($_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/tenpo_coupon/search/';		// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $_countall;									// 総件数。where指定するか？
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

    // フォーム・バリデーションチェック : メニュー編集
    private function _set_validation()
    {
    	$rule_set = array(
				array(
						'field'   => 'cp_title',
						'label'   => 'タイトル',
						'rules'   => 'trim|required|max_length[25]'
				),
				array(
						'field'   => 'cp_content',
						'label'   => 'クーポン内容',
						'rules'   => 'trim|required|max_length[80]'
				),
				array(
						'field'   => 'cp_use',
						'label'   => '利用条件',
						'rules'   => 'trim|required|max_length[120]'
				),
				array(
						'field'   => 'cp_presen',
						'label'   => '提示条件',
						'rules'   => 'trim|required|max_length[80]'
				),
				array(
						'field'   => 'cp_memo',
						'label'   => '備考',
						'rules'   => 'trim|max_length[80]'
				),
        		array(
                        'field'   => 'cp_start_date',
                        'label'   => '開始日付(yyyy-dd-mm)',
                        'rules'   => 'trim|regex_match[/^\d{4}-\d{1,2}-\d{1,2}+$/]|max_length[10]'
                ),
        		array(
                        'field'   => 'cp_end_date',
                        'label'   => '終了日付(yyyy-dd-mm)',
                        'rules'   => 'trim|required|regex_match[/^\d{4}-\d{1,2}-\d{1,2}+$/]|max_length[10]'
                ),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック
    private function _set_validation01()
    {
    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
