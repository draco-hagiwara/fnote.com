<?php

class Accountlist extends MY_Controller
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

        $this->smarty->assign('err_email',  FALSE);
        $this->smarty->assign('err_passwd', FALSE);
        $this->smarty->assign('mess',       FALSE);

    }

    // アカウント検索一覧TOP
    public function index()
    {

//         // セッションデータをクリア
//         $this->load->model('comm_auth', 'comm_auth', TRUE);
//         $this->comm_auth->delete_session('admin');

        // バリデーション・チェック
        $this->_set_validation();												// バリデーション設定
        $this->form_validation->run();

        // 1ページ当たりの表示件数
        $this->config->load('config_comm');
        $tmp_per_page = $this->config->item('PAGINATION_PER_PAGE');

        // 検索項目 初期値セット
//         $this->_search_set();

        // Pagination 現在ページ数の取得：：URIセグメントの取得
        $segments = $this->uri->segment_array();
        if (isset($segments[3]))
        {
            $tmp_offset = $segments[3];
			$tmp_inputpost = $this->input->post();
        } else {
            $tmp_offset = 0;
			$tmp_inputpost = array(
								'ac_name' => '',
								'ac_mail' => '',
								'orderid' => '',
								);
        }

        // Type別に表示を制限する(管理者以外)
       	$tmp_inputpost['ac_seq']  = $_SESSION['a_memSeq'];
        $tmp_inputpost['ac_type'] = $_SESSION['a_memType'];

        // アカウントメンバーの取得
        $this->load->model('Account', 'ac', TRUE);
        list($account_list, $account_countall) = $this->ac->get_accountlist($tmp_inputpost, $tmp_per_page, $tmp_offset);

        $this->smarty->assign('list', $account_list);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($account_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall', $account_countall);

        $this->view('accountlist/index.tpl');

    }

    // 一覧表示
    public function search()
    {

        // 検索項目の保存が上手くいかない。応急的に対応！
        if ($this->input->post('submit') == '_submit')
        {
            // セッションをフラッシュデータとして保存
            $data = array(
                    'a_ac_name' => $this->input->post('ac_name'),
                    'a_ac_mail' => $this->input->post('ac_mail'),
            );
            $this->session->set_userdata($data);

            $tmp_inputpost = $this->input->post();
            $tmp_inputpost['orderid'] = "";
            unset($tmp_inputpost["submit"]);

        } else {
            // セッションからフラッシュデータ読み込み
            $tmp_inputpost['ac_name'] = $_SESSION['a_ac_name'];
            $tmp_inputpost['ac_mail'] = $_SESSION['a_ac_mail'];
            $tmp_inputpost['orderid'] = "";
        }

        // バリデーション・チェック
        $this->_set_validation();												// バリデーション設定
        $this->form_validation->run();

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

        // Type別に表示を制限する(管理者以外)
       	$tmp_inputpost['ac_seq']  = $_SESSION['a_memSeq'];
        $tmp_inputpost['ac_type'] = $_SESSION['a_memType'];

        // アカウントメンバーの取得
        $this->load->model('Account', 'ac', TRUE);
        list($account_list, $account_countall) = $this->ac->get_accountlist($tmp_inputpost, $tmp_per_page, $tmp_offset);

        $this->smarty->assign('list', $account_list);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($account_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall', $account_countall);

        $this->view('accountlist/index.tpl');

    }

    // アカウント情報編集
    public function detail()
    {

    	// 初期値セット
    	$this->_item_set();

    	// 更新対象アカウントのデータ取得
    	$input_post = $this->input->post();
    	$this->load->model('Account', 'ac', TRUE);

    	if ($_SESSION['a_memType'] != 2)
    	{
    		$tmp_acid = $_SESSION['a_memSeq'];
    	} else {
    		$tmp_acid = $input_post['ac_uniq'];
    	}

    	$get_data = $this->ac->get_ac_seq($tmp_acid, TRUE);

    	$this->smarty->assign('info', $get_data[0]);

    	// バリデーション設定
    	$this->_set_validation02();

//         $this->smarty->assign('err_email',  FALSE);
//         $this->smarty->assign('err_passwd', FALSE);
        $this->view('accountlist/detail.tpl');

    }

    // アカウント情報チェック
    public function detailchk()
    {

    	// 初期値セット
    	$this->_item_set();

    	$tmp_inputpost = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation02();
    	if ($this->form_validation->run() == FALSE)
    	{
//     		$this->smarty->assign('err_email',  FALSE);
// 	    	$this->smarty->assign('err_passwd', FALSE);
    	} else {

	    	// メールアドレスの重複チェック
	    	$this->load->model('Account', 'ac', TRUE);

	    	if ($_SESSION['a_memType'] != 2)
	    	{
	    		$_seq = $_SESSION['a_memSeq'];
	    	} else {
	    		$_seq = $tmp_inputpost['ac_seq'];
	    	}

	    	if ($this->ac->check_mailaddr($_seq, $tmp_inputpost['ac_mail'])) {
	    		$this->smarty->assign('err_email',  TRUE);
	    		$this->smarty->assign('err_passwd', FALSE);

    			$this->smarty->assign('info', $tmp_inputpost);
	    		$this->view('accountlist/detail.tpl');
	    		return;
	    	}

	    	// パスワード再入力チェック
	    	if ($tmp_inputpost['ac_pw'] !== $tmp_inputpost['retype_password']) {
	    		$this->smarty->assign('err_email',  FALSE);
	    		$this->smarty->assign('err_passwd', TRUE);

    			$this->smarty->assign('info', $tmp_inputpost);
	    		$this->view('accountlist/detail.tpl');
	    		return;
	    	}

	    	// DB書き込み
	    	// 不要パラメータ削除
	    	unset($tmp_inputpost["submit"]) ;
	    	unset($tmp_inputpost["retype_password"]) ;

	    	$this->ac->update_account($tmp_inputpost, TRUE);

// 	    	$this->smarty->assign('err_email',  FALSE);
// 	    	$this->smarty->assign('err_passwd', FALSE);
	    	$this->smarty->assign('mess',  "更新が完了しました。");
    	}

    	$this->smarty->assign('info', $tmp_inputpost);
    	$this->view('accountlist/detail.tpl');

    }



    // Pagination 設定
    private function _get_Pagination($account_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/accountlist/search/';		// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $account_countall;							// 総件数。where指定するか？
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
    private function _item_set()
    {

    	// 管理者登録状態セット
    	$this->config->load('config_status');
    	$arroptions_ac_status = $this->config->item('ADMIN_ACCOUNT_STATUS');

    	// 管理者種類セット
    	$this->config->load('config_comm');
    	$arroptions_ac_type = $this->config->item('ADMIN_ACCOUNT_TYPE');

    	$this->smarty->assign('options_ac_status',  $arroptions_ac_status);
    	$this->smarty->assign('options_ac_type',  $arroptions_ac_type);
    	$this->smarty->assign('account_type', $arroptions_ac_type[$this->input->post('ac_type')]);

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {

    	$rule_set = array(
    			array(
    					'field'   => 'ac_name',
    					'label'   => '名前',
    					'rules'   => 'trim|max_length[20]'
    			),
    			array(
    					'field'   => 'ac_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|max_length[100]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

    // フォーム・バリデーションチェック
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'ac_type',
    					'label'   => '管理種類選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'ac_department',
    					'label'   => '所属部署',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'ac_name01',
    					'label'   => '担当者姓',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'ac_name02',
    					'label'   => '担当者名',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'ac_id',
    					'label'   => 'ログインID',
    					'rules'   => 'trim|required|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'ac_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|required|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'ac_tel',
    					'label'   => '担当者電話番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'ac_mobile',
    					'label'   => '担当者携帯番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'ac_pw',
    					'label'   => 'パスワード',
    					'rules'   => 'trim|required|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]|matches[retype_password]'
    			),
    			array(
    					'field'   => 'retype_password',
    					'label'   => 'パスワード再入力',
    					'rules'   => 'trim|required|regex_match[/^[\x21-\x7e]+$/]|min_length[8]|max_length[50]|matches[ac_pw]'
    			)
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}

