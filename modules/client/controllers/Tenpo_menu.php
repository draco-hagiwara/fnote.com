<?php

class Tenpo_menu extends MY_Controller
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

    // 店舗メニュー情報表示
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

        // バリデーション・チェック
        $this->_set_validation02();												// バリデーション設定

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
			$input_post['orderid'] = 'ASC';
        } else {
            $tmp_offset = 0;
			$input_post['orderid'] = 'ASC';
        }

        // メニュー情報の取得
        $input_post['mn_cl_siteid'] = $_SESSION['c_memSiteid'];
        $this->load->model('Tenpomenu', 'mn', TRUE);
        list($menu_list, $menu_countall) = $this->mn->get_menulist($input_post, $tmp_per_page, $tmp_offset);

		// メニュー名称表示を編集 (第一 => 第二 => 第三メニュー)
        foreach ($menu_list as $key => $value)
        {
        	if ($value['mn_level'] == 1)
        	{
        		$_menu_name[$value['mn_seq']] = $value['mn_name'];
        	}
        	if ($value['mn_level'] == 2)
        	{
        		$_menu_name[$value['mn_seq']] = $_menu_name[$value['mn_parent']] . " => " . $value['mn_name'];
        	}
        	if ($value['mn_level'] == 3)
        	{
        		$_menu_name[$value['mn_seq']] = $_menu_name[$value['mn_parent']] . " => " . $value['mn_name'];
        	}
        }

        $this->smarty->assign('list',      $menu_list);
        if (isset($_menu_name))
        {
        	$this->smarty->assign('menu_name', $_menu_name);
        } else {
        	$this->smarty->assign('menu_name', NULL);
        }

        // Pagination 設定
        $set_pagination = $this->_get_Pagination($menu_countall, $tmp_per_page);

        $this->smarty->assign('set_pagination', $set_pagination['page_link']);
        $this->smarty->assign('countall', $menu_countall);

        $this->view('tenpo_menu/index.tpl');

    }

    // 検索表示
    public function search()
    {

    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

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
    		$input_post['orderid'] = 'ASC';
    	} else {
    		$tmp_offset = 0;
    		$input_post['orderid'] = 'ASC';
    	}

    	// メニュー情報の取得
    	$input_post['mn_cl_siteid'] = $_SESSION['c_memSiteid'];
    	$this->load->model('Tenpomenu', 'mn', TRUE);
    	list($menu_list, $menu_countall) = $this->mn->get_menulist($input_post, $tmp_per_page, $tmp_offset);

    	// メニュー名称表示を編集 (第一 => 第二 => 第三メニューを一件ずつ読み込む)
    	foreach ($menu_list as $key => $value)
    	{
    		if ($value['mn_level'] == 1)
    		{
    			$_menu_name[$value['mn_seq']] = $value['mn_name'];
    		}
    		if ($value['mn_level'] == 2)
    		{
    			$get_name = $this->mn->get_menu_seq($value['mn_parent']);
    			$_menu_name[$value['mn_seq']] = $get_name[0]['mn_name'] . " => " . $value['mn_name'];
    		}
    		if ($value['mn_level'] == 3)
    		{
    			$get_name02 = $this->mn->get_menu_seq($value['mn_parent']);
    			$get_name01 = $this->mn->get_menu_seq($get_name02[0]['mn_parent']);
    			$_menu_name[$value['mn_seq']] = $get_name01[0]['mn_name'] . " => " . $get_name02[0]['mn_name'] . " => " . $value['mn_name'];
    		}
    	}

    	$this->smarty->assign('list', $menu_list);

    	if (isset($_menu_name))
    	{
    		$this->smarty->assign('menu_name', $_menu_name);
    	} else {
    		$this->smarty->assign('menu_name', NULL);
    	}

    	// Pagination 設定
    	$set_pagination = $this->_get_Pagination($menu_countall, $tmp_per_page);

    	$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    	$this->smarty->assign('countall', $menu_countall);

    	$this->view('tenpo_menu/index.tpl');

    }

    // 詳細情報表示
    public function detail()
    {

    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

    	// 更新対象アカウントのデータ取得
    	$input_post = $this->input->post();

    	$tmp_seq = $input_post['chg_uniq'];

    	$this->load->model('Tenpomenu', 'menu', TRUE);
    	$_menu_data = $this->menu->get_menu_seq($tmp_seq);

    	$this->smarty->assign('list',   $_menu_data[0]);
//     	$this->smarty->assign('mn_seq', $_menu_data[0]['mn_seq']);

    	$this->smarty->assign('err_mes', NULL);

    	$this->view('tenpo_menu/detail.tpl');

    }

    // 入力情報更新
    public function comp()
    {

    	$err_mes = NULL;
    	$input_post = $this->input->post();

    	// 更新対象アカウントのデータ取得
    	$this->load->model('Tenpomenu', 'menu', TRUE);
    	$tmp_seq = $input_post['mn_seq'];
    	$_menu_data = $this->menu->get_menu_seq($tmp_seq);

    	// バリデーション・チェック
    	if ($_menu_data[0]['mn_level'] == 3)
    	{
    		$this->_set_validation();											// バリデーション設定
    	} else {
    		$this->_set_validation01();
    	}
    	if ($this->form_validation->run() == TRUE)
    	{

    		if ($input_post['_submit'] == '_chg')
    		{
    			// ステータスが変更になった場合
    			if (($_menu_data[0]['mn_status'] == 0) && ($_menu_data[0]['mn_status'] != $input_post['optionsRadios01']))			// 「非公開」に変更
    			{

    				// 第一メニューを「非公開」にした場合
    				if ($_menu_data[0]['mn_level'] == 1)
    				{
    					$set_chg_data2 = $_menu_data[0]['mn_seq'];
    					$_parent_data2 = $this->menu->get_menu_parent($set_chg_data2);
    					foreach ($_parent_data2 as $key2 => $val2)
    					{

    						$set_chg_data3 = $_parent_data2[$key2]['mn_seq'];
    						$_parent_data3 = $this->menu->get_menu_parent($set_chg_data3);
    						foreach ($_parent_data3 as $key3 => $val3)
    						{
    							// 第三メニューのステータス書き換え
    							$set_data3['mn_seq']    = $_parent_data3[$key3]['mn_seq'];
    							$set_data3['mn_status'] = 1;
    							$this->menu->update_menu($set_data3);
    						}

    						// 第二メニューのステータス書き換え
    						$set_data2['mn_seq']    = $_parent_data2[$key2]['mn_seq'];
    						$set_data2['mn_status'] = 1;
    						$set_data2['mn_cnt']    = 0;
    						$this->menu->update_menu($set_data2);
    					}

    				// 第二メニューを「非公開」にした場合
    				} elseif ($_menu_data[0]['mn_level'] == 2) {

    					$set_chg_data3 = $_menu_data[0]['mn_seq'];
    					$_parent_data3 = $this->menu->get_menu_parent($set_chg_data3);
    					foreach ($_parent_data3 as $key3 => $val3)
    					{
    						// 第三メニューのステータス書き換え
    						$set_data3['mn_seq']    = $_parent_data3[$key3]['mn_seq'];
    						$set_data3['mn_status'] = 1;
     						$this->menu->update_menu($set_data3);
    					}

    					// 親階層のcnt件数を-1
    					$_cnt_data = $this->menu->get_menu_seq($_menu_data[0]['mn_parent']);
    					$set_cnt_data['mn_seq'] = $_cnt_data[0]['mn_seq'];
    					$set_cnt_data['mn_cnt'] = $_cnt_data[0]['mn_cnt'] - 1;
    					$this->menu->update_menu($set_cnt_data);


    				// 第三メニューを「非公開」にした場合
    				} elseif ($_menu_data[0]['mn_level'] == 3) {
    					$set_data['mn_name']  = $input_post['mn_name'];
    					$set_data['mn_menu']  = $input_post['mn_menu'];
    					$set_data['mn_price'] = $input_post['mn_price'];
    					$set_data['mn_info']  = $input_post['area'];

    					// 親階層のcnt件数を-1
    					$_cnt_data = $this->menu->get_menu_seq($_menu_data[0]['mn_parent']);
    					$set_cnt_data['mn_seq'] = $_cnt_data[0]['mn_seq'];
    					$set_cnt_data['mn_cnt'] = $_cnt_data[0]['mn_cnt'] - 1;
    					$this->menu->update_menu($set_cnt_data);
    				}

    				// 最後に自身を更新
    				$set_data['mn_seq']    = $_menu_data[0]['mn_seq'];
    				$set_data['mn_status'] = 1;
    				$set_data['mn_cnt']    = 0;
    				$this->menu->update_menu($set_data);

    			} elseif (($_menu_data[0]['mn_status'] == 1) && ($_menu_data[0]['mn_status'] != $input_post['optionsRadios01'])) {	// 「公開」に変更

    				// 親階層が「公開」ステータスかを確認
    				if ($_menu_data[0]['mn_level'] == 1)
    				{

    					$set_data['mn_seq']    = $_menu_data[0]['mn_seq'];
    					$set_data['mn_name']   = $input_post['mn_name'];
    					$set_data['mn_status'] = $input_post['optionsRadios01'];

    					$this->menu->update_menu($set_data);

    				} elseif ($_menu_data[0]['mn_level'] == 2) {

    					$_chk_data = $this->menu->get_menu_seq($_menu_data[0]['mn_parent']);
    					if ($_chk_data[0]['mn_status'] == 0)
    					{
	    					$set_data2['mn_seq']    = $_menu_data[0]['mn_seq'];
	    					$set_data2['mn_name']   = $input_post['mn_name'];
	    					$set_data2['mn_status'] = $input_post['optionsRadios01'];

	    					$this->menu->update_menu($set_data2);

	    					// 第一メニューにcnt数を書き込み
	    					$set_data1['mn_seq'] = $_chk_data[0]['mn_seq'];
	    					$set_data1['mn_cnt'] = $_chk_data[0]['mn_cnt'] + 1;

	    					$this->menu->update_menu($set_data1);

    					} else {
    						$err_mes = '第一メニューが「非公開」です。第一メニューのステータスを変更してから実行してください。';
    					}

    				} elseif ($_menu_data[0]['mn_level'] == 3) {

    					$_chk_data = $this->menu->get_menu_seq($_menu_data[0]['mn_parent']);
    					if ($_chk_data[0]['mn_status'] == 0)
    					{
    						$set_data3['mn_seq']    = $_menu_data[0]['mn_seq'];
    						$set_data3['mn_name']   = $input_post['mn_name'];
    						$set_data3['mn_status'] = $input_post['optionsRadios01'];
    						$set_data3['mn_menu']   = $input_post['mn_menu'];
    						$set_data3['mn_price']  = $input_post['mn_price'];
    						$set_data3['mn_info']   = $input_post['area'];

    						$this->menu->update_menu($set_data3);

    						// 第二メニューにcnt数を書き込み
    						$set_data2['mn_seq'] = $_chk_data[0]['mn_seq'];
    						$set_data2['mn_cnt'] = $_chk_data[0]['mn_cnt'] + 1;

    						$this->menu->update_menu($set_data2);

    					} else {
    						$err_mes = '上位メニューが「非公開」です。上位メニューのステータスを変更してから実行してください。';
    					}

    				}

    			} else {														// ステータスの変更なし

    				if ($_menu_data[0]['mn_level'] == 3)
    				{
    					$set_data['mn_seq']   = $_menu_data[0]['mn_seq'];
    					$set_data['mn_name']  = $input_post['mn_name'];
    					$set_data['mn_menu']  = $input_post['mn_menu'];
    					$set_data['mn_price'] = $input_post['mn_price'];
    					$set_data['mn_info']  = $input_post['area'];

    					$this->menu->update_menu($set_data);
    				} else {
    					$set_data['mn_seq']   = $_menu_data[0]['mn_seq'];
    					$set_data['mn_name']  = $input_post['mn_name'];

    					$this->menu->update_menu($set_data);
    				}
    			}

    		} elseif ($input_post['_submit'] == '_del') {

    			// トランザクション・START
    			$this->db->trans_strict(FALSE);                                 // StrictモードをOFF
    			$this->db->trans_start();                                       // trans_begin

    			// 対象データを削除
    			if ($_menu_data[0]['mn_level'] == 3)
    			{
    				// 自身削除
    				$this->menu->delete_menu($_menu_data[0]['mn_seq']);

    				// Level2 のカウント数修正
    				$_chk_data02 = $this->menu->get_menu_seq($_menu_data[0]['mn_parent']);

    				$set_data02['mn_seq'] = $_chk_data02[0]['mn_seq'];
    				$set_data02['mn_cnt'] = $_chk_data02[0]['mn_cnt'] - 1;

    				$this->menu->update_menu($set_data02);

    			} elseif ($_menu_data[0]['mn_level'] == 2) {

    				// 自身削除
    				$this->menu->delete_menu($_menu_data[0]['mn_seq']);

    				// Level1 のカウント数修正
    				$_chk_data01 = $this->menu->get_menu_seq($_menu_data[0]['mn_parent']);

    				$set_data01['mn_seq'] = $_chk_data01[0]['mn_seq'];
    				$set_data01['mn_cnt'] = $_chk_data01[0]['mn_cnt'] - 1;

    				$this->menu->update_menu($set_data01);

    				// Level3 の対象データ削除
    				$_chk_data03 = $this->menu->get_menu_parent($_menu_data[0]['mn_seq']);
    				foreach ($_chk_data03 as $val)
    				{
    					$this->menu->delete_menu($val['mn_seq']);
    				}

    			} elseif ($_menu_data[0]['mn_level'] == 1) {

    				// 自身削除
    				$this->menu->delete_menu($_menu_data[0]['mn_seq']);

    				// Level2 の対象データ削除
    				$_chk_data02 = $this->menu->get_menu_parent($_menu_data[0]['mn_seq']);
    				foreach ($_chk_data02 as $value)
    				{
    					$this->menu->delete_menu($value['mn_seq']);

    					// Level3 の対象データ削除
    					$_chk_data03 = $this->menu->get_menu_parent($value['mn_seq']);
    					foreach ($_chk_data03 as $val)
    					{
    						$this->menu->delete_menu($val['mn_seq']);
    					}
    				}
    			}

    			// トランザクション・COMMIT
    			$this->db->trans_complete();                                    // trans_rollback & trans_commit
    			if ($this->db->trans_status() === FALSE)
    			{
    				log_message('error', 'CLIENT::[Tenpo_menu.comp()] サイトメニュー管理削除処理 トランザクションエラー');
    			}

    			redirect('/tenpo_menu/');

    		}
    	}

    	// 再読み込み
    	$_menu_data = $this->menu->get_menu_seq($tmp_seq);

    	$this->smarty->assign('list',    $_menu_data[0]);
    	$this->smarty->assign('mn_seq',  $_menu_data[0]['mn_seq']);
    	$this->smarty->assign('err_mes', $err_mes);

        $this->view('tenpo_menu/detail.tpl');

    }

    // 店舗メニューの登録
    public function create_menu()
    {

    	$input_post = $this->input->post();

    	$err_mess01 = NULL;
    	$err_mess02 = NULL;
    	$err_mess03 = NULL;

    	// バリデーション・チェック
    	$this->_set_validation02();

    	$options_menu01 = array("" => '選択してください');
    	$options_menu02 = array("" => '選択してください');
    	$options_menu03 = array("" => '選択してください');

    	$this->load->model('Tenpomenu', 'menu', TRUE);
    	$this->load->model('Tenpoinfo', 'tnp',  TRUE);

    	// 店舗データの取得
    	$tenpo_data = $this->tnp->get_tenpo_siteid($_SESSION['c_memSiteid']);

    	// メニュー登録
    	if (isset($input_post['new']))
    	{

    		// 第一メニュー追加
    		if ($input_post['new'] == "menu01")
    		{
    			if ($input_post['mn_name01'] != "")
    			{
    				// 最終データを読み込む
    				$_menu_data = $this->menu->get_menu_parent1_last($_SESSION['c_memSiteid']);
    				if (isset($_menu_data[0]['mn_id01']))
    				{
    					$_mn_id = hexdec($_menu_data[0]['mn_id01']) + 1;		// 16進数の文字列を10進数に変換
    				} else {
    					$_mn_id = 1;
    				}
    				$set_data['mn_id01'] = dechex($_mn_id);						// 10進数の数値の16進数に変換

    				$set_data['mn_name']      = $input_post['mn_name01'];
    				$set_data['mn_level']     = 1;								// １メニュー
    				$set_data['mn_dispno']    = 0;
    				$set_data['mn_cl_seq']    = $_SESSION['c_memSeq'];
    				$set_data['mn_cl_siteid'] = $_SESSION['c_memSiteid'];
    				$set_data['mn_tp_seq']    = $tenpo_data[0]['tp_seq'];

    				$_row_id = $this->menu->insert_tenpomenu($set_data);
    				if (!is_numeric($_row_id))
    				{
    					$err_mess01 = '「第一 MENU」の登録に失敗しました。';
    				}
    			} else {
    				$err_mess01 = '「第一 MENU」欄に文字を入力してください。';
    			}
    		}

    		// 第二メニュー追加
    		if ($input_post['new'] == "menu02")
    		{
    			if ($input_post['mn_seq01'] != "")
    			{
	    			if ($input_post['mn_name02'] != "")
	    			{
	    				// 最終データを読み込む
	    				$_menu_data = $this->menu->get_menu_parent2_last($input_post['mn_seq01'], $_SESSION['c_memSiteid']);
	    				if (isset($_menu_data[0]['mn_id02']))
	    				{
	    					$_mn_id = hexdec($_menu_data[0]['mn_id02']) + 1;		// 16進数の文字列を10進数に変換
	    				} else {
	    					$_mn_id = 1;
	    				}
	    				$set_data['mn_id02'] = dechex($_mn_id);						// 10進数の数値の16進数に変換

	    				$set_data['mn_name']      = $input_post['mn_name02'];
	    				$set_data['mn_parent']    = $input_post['mn_seq01'];
	    				$set_data['mn_level']     = 2;								// ２メニュー
	    				$set_data['mn_dispno']    = 0;
	    				$set_data['mn_cl_seq']    = $_SESSION['c_memSeq'];
	    				$set_data['mn_cl_siteid'] = $_SESSION['c_memSiteid'];
	    				$set_data['mn_tp_seq']    = $tenpo_data[0]['tp_seq'];

	    				// 第一メニューを読み込み
	    				$_menu1_data = $this->menu->get_menu_seq($input_post['mn_seq01']);
	    				$set_data['mn_id01']      = $_menu1_data[0]['mn_id01'];

	    				$_row_id = $this->menu->insert_tenpomenu($set_data);
	    				if (!is_numeric($_row_id))
	    				{
	    					$err_mess02 = '「第二 MENU」の登録に失敗しました。';
	    				}

// 	    				// 第一メニューにcnt数を書き込み
// 	    				$set_data1['mn_seq'] = $_menu1_data[0]['mn_seq'];
// 	    				$set_data1['mn_cnt'] = $_menu1_data[0]['mn_cnt'] + 1;
// 	    				$this->menu->update_menu($set_data1);

	    			} else {
	    				$err_mess02 = '「第二 MENU」欄に文字を入力してください。';
	    			}
	    		} else {
	    			$err_mess02 = '「第一 MENU」を必ず選択してください。';
	    		}
    		}

    		// 第三メニュー追加
    		if ($input_post['new'] == "menu03")
    		{
    			if (($input_post['mn_seq01'] != "") && ($input_post['mn_seq02'] != ""))
    			{

	    			if ($input_post['mn_name03'] != "")
	    			{
	    				// 最終データを読み込む
	    				$_menu_data = $this->menu->get_menu_parent3_last($input_post['mn_seq02'], $_SESSION['c_memSiteid']);
	    				if (isset($_menu_data[0]['mn_id03']))
	    				{
	    					$_mn_id = hexdec($_menu_data[0]['mn_id03']) + 1;		// 16進数の文字列を10進数に変換
	    				} else {
	    					$_mn_id = 1;
	    				}
	    				$set_data['mn_id03'] = dechex($_mn_id);						// 10進数の数値の16進数に変換

	    				$set_data['mn_name']      = $input_post['mn_name03'];
	    				$set_data['mn_parent']    = $input_post['mn_seq02'];
	    				$set_data['mn_level']     = 3;								// ３メニュー
	    				$set_data['mn_dispno']    = 0;
	    				$set_data['mn_cl_seq']    = $_SESSION['c_memSeq'];
	    				$set_data['mn_cl_siteid'] = $_SESSION['c_memSiteid'];
	    				$set_data['mn_tp_seq']    = $tenpo_data[0]['tp_seq'];

	    				// 第一メニューを読み込み
	    				$_menu2_data = $this->menu->get_menu_seq($input_post['mn_seq02']);
	    				$set_data['mn_id01']      = $_menu2_data[0]['mn_id01'];
	    				$set_data['mn_id02']      = $_menu2_data[0]['mn_id02'];

	    				$_row_id = $this->menu->insert_tenpomenu($set_data);
	    				if (!is_numeric($_row_id))
	    				{
	    					$err_mess03 = '「タイトル」の登録に失敗しました。';
	    				}

// 	    				// 第二メニューにcnt数を書き込み
// 	    				$set_data2['mn_seq'] = $_menu2_data[0]['mn_seq'];
// 	    				$set_data2['mn_cnt'] = $_menu2_data[0]['mn_cnt'] + 1;
// 	    				$this->menu->update_menu($set_data2);

	    			} else {
	    				$err_mess03 = '「タイトル」欄に文字を入力してください。';
	    			}
    			} else {
    				$err_mess03 = '「第一 MENU」または「第二 MENU」を必ず選択してください。';
    			}
    		}

    	// カテゴリ並び替え
    	} else {

    		// 第一カテゴリ並び替え
    		if ((isset($input_post['result01'])) && ($input_post['result01'] != ""))
    		{
    			$result01 = $input_post['result01'];
    			$result_array = explode(',', $result01);

    			$this->_update_menu($result_array);
    		}

    		// 第二カテゴリ並び替え
    		if ((isset($input_post['result02'])) && ($input_post['result02'] != ""))
    		{
    			$result02 = $input_post['result02'];
    			$result_array = explode(',', $result02);

    			$this->_update_menu($result_array);
    		}

    		// 第三カテゴリ並び替え
    		if ((isset($input_post['result03'])) && ($input_post['result03'] != ""))
    		{
    			$result03 = $input_post['result03'];
    			$result_array = explode(',', $result03);

    			$this->_update_menu($result_array);
    		}
    	}

    	// カテゴリ情報取得 ＆ 表示
    	if (isset($input_post['_submit']) && ($input_post['_submit'] == '_new'))
    	{

    		// 第一階層カテゴリデータ取得
    		$menu01_data = $this->menu->get_menu_parent1($_SESSION['c_memSiteid']);
    		if ($menu01_data)
    		{
	    		foreach ($menu01_data as $key => $value)
	    		{
	    			$options_menu01[$value['mn_seq']] = $value['mn_name'];
	    		}
    		}

    	} else {

    		// 第一階層カテゴリデータ取得
    		$menu01_data = $this->menu->get_menu_parent1($_SESSION['c_memSiteid']);
    		foreach ($menu01_data as $key => $value)
    		{
    			$options_menu01[$value['mn_seq']] = $value['mn_name'];
    		}

    		// 第二階層カテゴリデータ取得
    		$menu02_data = $this->menu->get_menu_parent2($input_post['mn_seq01'], $_SESSION['c_memSiteid']);
    		foreach ($menu02_data as $key => $value)
    		{
    			$options_menu02[$value['mn_seq']] = $value['mn_name'];
    		}

    		// 第三階層カテゴリデータ取得
    		if (isset($_SESSION['c_menu01']) && ($_SESSION['c_menu01'] == $input_post["mn_seq01"]))
    		{
    			if (isset($input_post['mn_seq02']))
    			{
    				$menu03_data = $this->menu->get_menu_parent3($input_post['mn_seq02'], $_SESSION['c_memSiteid']);
    				foreach ($menu03_data as $key => $value)
    				{
    					$options_menu03[$value['mn_seq']] = $value['mn_name'];
    				}
    			}
    		}

    		$_SESSION['c_menu01'] = $input_post["mn_seq01"];

    	}

    	$this->smarty->assign('opt_menu01', $options_menu01);
    	$this->smarty->assign('opt_menu02', $options_menu02);
    	$this->smarty->assign('opt_menu03', $options_menu03);
    	$this->smarty->assign('err_mess01', $err_mess01);
    	$this->smarty->assign('err_mess02', $err_mess02);
    	$this->smarty->assign('err_mess03', $err_mess03);

    	// 並び替え用リスト
    	unset($options_menu01['']);
    	unset($options_menu02['']);
    	unset($options_menu03['']);
    	$this->smarty->assign('sort_menu01', $options_menu01);
    	$this->smarty->assign('sort_menu02', $options_menu02);
    	$this->smarty->assign('sort_menu03', $options_menu03);

    	$this->smarty->assign('list',  $input_post);

    	$this->view('tenpo_menu/create_menu.tpl');

    }

    // カテゴリの並び替え更新
    private function _update_menu($result_array)
    {

    	$cnt = 1;
    	foreach ($result_array as $key => $val)
    	{
    		$set_data['mn_seq']    = $val;
    		$set_data['mn_dispno'] = $cnt;

    		// 更新
    		$this->menu->update_menu($set_data);
    		$cnt++;
    	}

    }

    // Pagination 設定
    private function _get_Pagination($_countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/tenpo_menu/search/';			// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
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
						'field'   => 'mn_name',
						'label'   => 'タイトル',
						'rules'   => 'trim|required|max_length[25]'
				),
				array(
						'field'   => 'mn_menu',
						'label'   => 'メニュー名称',
						'rules'   => 'trim|required|max_length[25]'
				),
    			array(
						'field'   => 'mn_price',
						'label'   => '価格',
						'rules'   => 'trim|max_length[15]'
				),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック : メニュー編集
    private function _set_validation01()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'mn_name',
    					'label'   => 'タイトル',
    					'rules'   => 'trim|required|max_length[25]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

    // フォーム・バリデーションチェック : メニュー追加
    private function _set_validation02()
    {
    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
