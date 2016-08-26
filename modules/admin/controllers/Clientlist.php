<?php

class Clientlist extends MY_Controller
{

	private $_arrsaleslist;
	private $_arreditorlist;


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

        $this->smarty->assign('err_siteid', FALSE);
        $this->smarty->assign('err_clid',   FALSE);
        $this->smarty->assign('err_status', FALSE);
        $this->smarty->assign('err_mail',   FALSE);
        $this->smarty->assign('err_passwd', FALSE);
        $this->smarty->assign('mess',       FALSE);

    }

    // アカウント検索一覧TOP
    public function index()
    {

        // バリデーション・チェック
        $this->_set_validation();												// バリデーション設定
        $this->form_validation->run();

        // 1ページ当たりの表示件数
        $this->config->load('config_comm');
        $tmp_per_page = $this->config->item('PAGINATION_PER_PAGE');

        // Pagination 現在ページ数の取得：：URIセグメントの取得
        $segments = $this->uri->segment_array();
        if (isset($segments[3]))
        {
            $tmp_offset = $segments[3];
			$tmp_inputpost = $this->input->post();
        } else {
            $tmp_offset = 0;
			$tmp_inputpost = array(
								'cl_siteid'  => '',
								'cl_company' => '',
								'orderid'    => '',
								);

			// セッションをフラッシュデータとして保存
			$data = array(
					'a_cl_siteid'  => "",
					'a_cl_company' => "",
			);
			$this->session->set_userdata($data);
        }

        // Type別に表示を制限する(管理者以外)
       	$tmp_inputpost['ac_seq']  = $_SESSION['a_memSeq'];
        $tmp_inputpost['ac_type'] = $_SESSION['a_memType'];

        // アカウントメンバーの取得
        $this->load->model('Client', 'cl', TRUE);
        list($client_list, $client_countall) = $this->cl->get_clientlist($tmp_inputpost, $tmp_per_page, $tmp_offset);

        $this->smarty->assign('list', $client_list);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($client_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall', $client_countall);

        $this->view('clientlist/index.tpl');

    }

    // 一覧表示
    public function search()
    {

        // 検索項目の保存が上手くいかない。応急的に対応！
        if ($this->input->post('submit') == '_submit')
        {
            // セッションをフラッシュデータとして保存
            $data = array(
                    'a_cl_siteid'  => $this->input->post('cl_siteid'),
                    'a_cl_company' => $this->input->post('cl_company'),
            );
            $this->session->set_userdata($data);

            $tmp_inputpost = $this->input->post();
            $tmp_inputpost['orderid'] = "";
            unset($tmp_inputpost["submit"]);

        } else {
            // セッションからフラッシュデータ読み込み
            $tmp_inputpost['cl_siteid']  = $_SESSION['a_cl_siteid'];
            $tmp_inputpost['cl_company'] = $_SESSION['a_cl_company'];
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
        $this->load->model('Client', 'cl', TRUE);
        list($client_list, $client_countall) = $this->cl->get_clientlist($tmp_inputpost, $tmp_per_page, $tmp_offset);

        $this->smarty->assign('list', $client_list);

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($client_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall', $client_countall);

        $this->view('clientlist/index.tpl');

    }

    // アカウント情報編集
    public function detail()
    {

    	// 更新対象アカウントのデータ取得
    	$input_post = $this->input->post();

   		$tmp_clseq = $input_post['chg_uniq'];

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($tmp_clseq, TRUE);

    	// 担当営業と編集者を保存
    	$_SESSION['a_salse_seq']  = $cl_data[0]['cl_sales_id'];
    	$_SESSION['a_editor_seq'] = $cl_data[0]['cl_editor_id'];

    	$this->smarty->assign('info', $cl_data[0]);

    	// バリデーション設定
    	$this->_set_validation02();

    	// 初期値セット
    	$this->_item_set();

        $this->view('clientlist/detail.tpl');

    }

    // アカウント情報チェック
    public function detailchk()
    {

    	// 初期値セット
    	$this->_item_set();

    	$input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation02();
    	if ($this->form_validation->run() == FALSE)
    	{
    	} else {

    		$this->load->model('Client', 'cl', TRUE);

    		// サイトID(URL名)入力チェック
    		if ($this->cl->check_siteid($input_post['cl_seq'], $input_post['cl_siteid']))
    		{
    			$this->smarty->assign('err_siteid', TRUE);
    			$this->smarty->assign('info', $input_post);
    			$this->view('clientlist/detail.tpl');
    			return;
    		}

    		// メールアドレス入力チェック
    		if ($this->cl->check_mailaddr($input_post['cl_seq'], $input_post['cl_mail']))
    		{
    			$this->smarty->assign('err_mail', TRUE);
    			$this->smarty->assign('info', $input_post);
    			$this->view('clientlist/detail.tpl');
    			return;
    		}




    		// ステータス変更チェック:「2：受注」で区切る
    		$_status_no = $this->cl->check_statusno($input_post['cl_seq']);


    		print_r($_status_no);
    		print(" :: ");
    		print_r($input_post['cl_status']);
//     		exit;

    		if (($_status_no[0]['cl_status'] < 2) && ($input_post['cl_status'] > 2) && ($input_post['cl_status'] != 20))
    		{
    			$this->smarty->assign('err_status', "必ず「受注」ステータスを選択してください。");
    			$this->smarty->assign('info', $input_post);
    			$this->view('clientlist/detail.tpl');
    			return;
    		} elseif (($_status_no[0]['cl_status'] >= 2) && ($input_post['cl_status'] < 2)) {
    			$this->smarty->assign('err_status', "「受注」ステータス以下は選択できません。");
    			$this->smarty->assign('info', $input_post);
    			$this->view('clientlist/detail.tpl');
    			return;
    		}






    		// メール再発行 or データ更新
    		if ($input_post['submit'] == 're_mail')
    		{

    			$cl_data = $this->cl->get_cl_seq($input_post["cl_seq"], FALSE);

    			// 担当管理者のメール取得
    			$clac_data = $this->cl->get_clac_seq($cl_data[0]["cl_seq"], '');

    			// 当社管理のメール取得
    			$ac_data = $this->ac->get_ac_seq(1, TRUE);

    			// メール送信先設定
    			$mail['from']      = "";
    			$mail['from_name'] = "";
    			$mail['subject']   = "【FNOTE】 新規会員登録申請について (再送)";
    			$mail['to']        = $cl_data[0]["cl_mail"];
    			$mail['cc']        = "";
    			$mail['bcc']       = $clac_data[0]['adminacmail'] . ',' . $ac_data[0]['ac_mail'];

    			// メール本文置き換え文字設定
    			$this->config->load('config_comm');
    			$tmp_limittime = $this->config->item('CLIENT_ADD_LIMITTIME');						// 仮登録制限時間設定

    			$tmp_uri = site_url() . 'entryconf/cl_edit/' . $cl_data[0]["cl_seq"] . '/' . $cl_data[0]["cl_auth"] ;		// 本登録URI設定

    			$arrRepList = array(
    					'cl_company'     => $cl_data[0]['cl_company'],
    					'cl_president01' => $cl_data[0]['cl_president01'],
    					'cl_president02' => $cl_data[0]['cl_president02'],
    					'tmp_uri'        => $tmp_uri,
    					'tmp_limittime'  => $tmp_limittime,
    			);

    			// メールテンプレートの読み込み
    			$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    			$mail_tpl = $this->config->item('MAILTPL_ENT_CLIENT_ID');

    			// メール送信
    			$this->load->model('Mailtpl', 'mailtpl', TRUE);
    			if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {

    				// 「cl_update_date」を更新 <= アクセス時間
    				$cl_data[0]['cl_update_date'] = date('Y-m-d H:i:s');
    				$this->cl->update_client($cl_data[0]);

    				$this->smarty->assign('mess',  "メールが送信されました。");

    			} else {
    				$this->smarty->assign('mess',  "メール送信に失敗しました。");
    				log_message('error', 'Clientlist::[detailchk()]クライアント登録メール再発行処理 メール送信エラー');
    			}

    		} else {

		    	// 担当編集者＆営業のＩＤを取り出す
		    	$_tmp_editor_id = explode(' : ', $this->_arreditorlist[$input_post['cl_editor_id']], 3);
		    	$input_post['cl_editor_id'] = $_tmp_editor_id[0];
		    	$_tmp_salse_id = explode(' : ', $this->_arrsaleslist[$input_post['cl_sales_id']], 3);
		    	$input_post['cl_sales_id'] = $_tmp_salse_id[0];

		    	// DB書き込み
		    	// 不要パラメータ削除
		    	unset($input_post["submit"]) ;
		    	unset($input_post["retype_password"]) ;

		    	$this->cl->update_client($input_post);
		    	$this->smarty->assign('mess',  "更新が完了しました。");

		    	// 掲載日アップ
		    	if ($input_post['cl_status'] == 8)
		    	{
		    		$this->load->model('Entry', 'ent', TRUE);
		    		$set_data['en_cl_siteid']    = $input_post['cl_siteid'];
		    		$set_data['en_posting_date'] = date("Y-m-d H:i:s");
		    		$this->ent->inup_tenpo($set_data);
		    	}

		    	// 「受注」ステータスで審査完了メール送信＆画像用ディレクトリ作成
		    	if ($input_post['cl_status'] == 2)
		    	{
		    		// ディレクトリ存在チェック
		    		$dir_path = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['cl_siteid'] . "/s";
		    		if (!file_exists($dir_path))
		    		{
		    			$dir_path = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['cl_siteid'];
		    			mkdir($dir_path, 0777);
		    			chmod($dir_path, 0777);
		    			$dir_path = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['cl_siteid'] . "/s/";	// サイト用画像ディレクトリ
		    			mkdir($dir_path, 0775);
		    			chmod($dir_path, 0775);
		    			$dir_path = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['cl_siteid'] . "/b/";	// ブログ用画像ディレクトリ
		    			mkdir($dir_path, 0775);
		    			chmod($dir_path, 0775);
		    		}

		    		// 審査完了メール送信
		    		// 担当管理者のメール取得
		    		$clac_data = $this->cl->get_clac_seq($input_post['cl_seq'], '');

		    		// 当社管理のメール取得
		    		$this->load->model('Account', 'ac', TRUE);
		    		$ac_data = $this->ac->get_ac_seq(1, TRUE);

		    		// メール送信先設定
		    		$mail['from']      = "";
		    		$mail['from_name'] = "";
		    		$mail['subject']   = "";
		    		$mail['to']        = $input_post['cl_mail'];
		    		$mail['cc']        = "";
		    		$mail['bcc']       = $clac_data[0]['adminacmail'] . ',' . $ac_data[0]['ac_mail'];

		    		// メール本文置き換え文字設定
		    		$arrRepList = array(
		    				'cl_company'     => $input_post['cl_company'],
		    				'cl_president01' => $input_post['cl_president01'],
		    				'cl_president02' => $input_post['cl_president02'],
		    				'cl_id'          => $input_post['cl_id'],
		    		);

		    		// メールテンプレートの読み込み
		    		$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
		    		$mail_tpl = $this->config->item('MAILTPL_ENT_CLIENT_IDPW');

		    		// メール送信
		    		$this->load->model('Mailtpl', 'mailtpl', TRUE);
		    		if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
		    			$this->view('entryconf/end_ok.tpl');
		    		} else {
		    			echo "メール送信エラー";
		    			log_message('error', 'Clientlist::[detailchk()]クライアント審査完了処理 メール送信エラー');
		    			$this->view('entryconf/end_ng.tpl');
		    		}
		    	}

		    	// ステータス変更は詳細をログに出力
    	    	$log_data['lg_user_type'] = "2";
    	    	$log_data['lg_type']      = 'client_status_chg';
    	    	$log_data['lg_func']      = 'clientlist_detailchk';
    	    	$log_data['lg_detail']    = 'cl_id = ' . $input_post['cl_id']
    	    	                            . ' / status_chg = ' . $input_post['cl_status']
    	    	                            ;
    	    	$this->cl->insert_log($log_data);

		    	// 初期値セット
		    	$_SESSION['a_salse_seq']  = $input_post['cl_sales_id'];
		    	$_SESSION['a_editor_seq'] = $input_post['cl_editor_id'];
		    	$this->_item_set();

    		}
    	}

    	$this->smarty->assign('info', $input_post);
    	$this->view('clientlist/detail.tpl');

    }

    // Pagination 設定
    private function _get_Pagination($client_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/clientlist/search/';			// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $client_countall;							// 総件数。where指定するか？
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

    	// クライアント登録状態セット
    	$this->config->load('config_status');
    	$arroptions_cl_status = $this->config->item('CLIENT_ACCOUNT_STATUS');

    	// 担当編集リスト作成
    	$this->load->model('Account', 'ac', TRUE);
    	$this->_item_editor();

    	// 担当営業リスト作成
    	$this->_item_sales();

    	$this->smarty->assign('options_cl_status',  $arroptions_cl_status);

    }

    // 担当営業リスト作成
    private function _item_sales($cl_sales_id = NULL)
    {

    	$_salse_list = $this->ac->get_contact(1);

    	foreach ($_salse_list as $value) {
    		foreach ($value as $key => $val) {
    			if ($key == 'ac_seq')
    			{
    				$_name = $val . ' : ';
    			} elseif ($key == 'ac_name01') {
    				$_name = $_name . $val;
    			} else {
    				$arroptions_cl_sales[] = $_name . ' ' . $val;
    			}
    		}
    	}

    	if ($cl_sales_id == NULL)
    	{
    		$this->smarty->assign('options_cl_sales_id',  $arroptions_cl_sales);
    		$this->_arrsaleslist = $arroptions_cl_sales;
    	} else {
    		$_salse_num = intval($cl_sales_id);
    		$this->smarty->assign('options_cl_sales_id',  $arroptions_cl_sales[$_salse_num]);
    	}

    	// 担当営業の抽出
    	$ac_data = $this->ac->get_ac_seq($_SESSION['a_salse_seq'], TRUE);
    	$_salse_name = $ac_data[0]['ac_seq'] . ' : ' . $ac_data[0]['ac_name01'] . ' ' . $ac_data[0]['ac_name02'];

    	$_select_salse_no = "";
    	foreach ($arroptions_cl_sales as $key => $val)
    	{
    		if ($val == $_salse_name)
    		{
    			$_select_salse_no = $key;
    		}
    	}

    	$this->smarty->assign('salse_name',     $_salse_name);
    	$this->smarty->assign('select_salesno', $_select_salse_no);

    }

    // 担当編集リスト作成
    private function _item_editor($cl_editor_id = NULL)
    {

    	$_editor_list = $this->ac->get_contact(0);

    	foreach ($_editor_list as $value) {
    		foreach ($value as $key => $val) {
    			if ($key == 'ac_seq')
    			{
    				$_name = $val . ' : ';
    			} elseif ($key == 'ac_name01') {
    				$_name = $_name . $val;
    			} else {
    				$arroptions_cl_editor[] = $_name . ' ' . $val;
    			}
    		}
    	}

    	if ($cl_editor_id == NULL)
    	{
    		$this->smarty->assign('options_cl_editor_id',  $arroptions_cl_editor);
    		$this->_arreditorlist = $arroptions_cl_editor;
    	} else {
    		$_editor_num = intval($cl_editor_id);
    		$this->smarty->assign('options_cl_editor_id',  $arroptions_cl_editor[$_editor_num]);
    	}

    	// 担当編集の抽出
    	$ac_data = $this->ac->get_ac_seq($_SESSION['a_editor_seq'], TRUE);
    	$_editor_name = $ac_data[0]['ac_seq'] . ' : ' . $ac_data[0]['ac_name01'] . ' ' . $ac_data[0]['ac_name02'];

    	$_select_editor_no = "";
    	foreach ($arroptions_cl_editor as $key => $val)
    	{
    		if ($val == $_editor_name)
    		{
    			$_select_editor_no = $key;
    		}
    	}

    	$this->smarty->assign('editor_name',     $_editor_name);
    	$this->smarty->assign('select_editorno', $_select_editor_no);

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {

    	$rule_set = array(
    			array(
    					'field'   => 'cl_siteid',
    					'label'   => 'サイトID',
    					'rules'   => 'trim|alpha_numeric|max_length[20]'
    			),
    			array(
    					'field'   => 'cl_company',
    					'label'   => '会社名',
    					'rules'   => 'trim|max_length[50]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

    // フォーム・バリデーションチェック
    private function _set_validation02()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'cl_status',
    					'label'   => 'ステータス選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'cl_sales_id',
    					'label'   => '担当営業選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'cl_editor_id',
    					'label'   => '担当編集者選択',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'cl_contract_str',
    					'label'   => '契約開始日',
    					'rules'   => 'trim|regex_match[/^\d{4}\-|\/\d{1,2}\-|\/\d{1,2}+$/]|max_length[10]'
    			),
    			array(
    					'field'   => 'cl_contract_end',
    					'label'   => '契約終了日',
    					'rules'   => 'trim|regex_match[/^\d{4}\-|\/\d{1,2}\-|\/\d{1,2}+$/]|max_length[10]'
    			),
    			array(
    					'field'   => 'cl_siteid',
    					'label'   => 'サイトID(URL名)',
    					'rules'   => 'trim|required|alpha_numeric|max_length[20]'			// 英数字のみ
    			),
    			array(
    					'field'   => 'cl_company',
    					'label'   => '会社名',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_president01',
    					'label'   => '代表者姓',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_president02',
    					'label'   => '代表者名',
    					'rules'   => 'trim|required|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_department',
    					'label'   => '所属部署',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'cl_person01',
    					'label'   => '担当者姓',
    					'rules'   => 'trim|required|max_length[20]'
    			),
    			array(
    					'field'   => 'cl_person02',
    					'label'   => '担当者名',
    					'rules'   => 'trim|required|max_length[20]'
    			),
    			array(
    					'field'   => 'cl_tel',
    					'label'   => '担当者電話番号',
    					'rules'   => 'trim|required|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'cl_mobile',
    					'label'   => '担当者携帯番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'cl_fax',
    					'label'   => 'FAX番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'cl_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|required|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'cl_mailsub',
    					'label'   => 'メールアドレス(サブ)',
    					'rules'   => 'trim|max_length[100]|valid_email'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}

