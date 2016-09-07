<?php

class Tenpo_site extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['a_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_type',  $_SESSION['a_memType']);
            $this->smarty->assign('mem_Seq',   $_SESSION['a_memSeq']);
    		$this->smarty->assign('ticket',    NULL);
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_type',  "");
            $this->smarty->assign('mem_Seq',   "");

            redirect('/login/');
        }


        $this->config->load('config_pref');										// 都道府県情報読み込み

        // 都道府県情報設定
        $this->_options_pref = $this->config->item('pref');
        $this->smarty->assign('opt_pref', $this->_options_pref);

        // 都道府県チェック
        if ($this->input->post('tp_pref')) {
        	$pref_id = $this->input->post('tp_pref');
        	$this->_pref_name = $this->_options_pref[$pref_id];
        }

    }

    // 店舗情報TOP
    public function index()
    {

        $this->view('tenpo_site/index.tpl');

    }

    // 店舗掲載情報TOP
    public function tenpo_edit()
    {

    	// クライアント情報取得
    	$input_post = $this->input->post();

    	// 初期値セット
    	$this->_item_set();

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($input_post['chg_uniq'], TRUE);

    	// 一時保存
		$_SESSION['a_cl_seq']    = $cl_data[0]['cl_seq'];
    	$_SESSION['a_cl_siteid'] = $cl_data[0]['cl_siteid'];
// 		$_SESSION['a_cl_id']     = $cl_data[0]['cl_id'];

		// 日付け初期化
		for ($i = 0; $i < 3; $i++)
		{
			for ($j = 0; $j < 7; $j++)
			{
				$eigyo_chk[$i][$j] = FALSE;
			}
		}

		// 定休日初期化
		for ($i = 0; $i < 8; $i++)
		{
			$closed_chk[0][$i] = FALSE;
		}

		// 店舗データの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$tenpo_data = $this->tnp->get_tenpo_siteid($cl_data[0]['cl_siteid']);
    	if ($tenpo_data == FALSE)
		{

			$this->smarty->assign('cate_list',  NULL);						// カテゴリ表示
			$this->smarty->assign('eigyo_chk',  $eigyo_chk);				// 営業時間
			$this->smarty->assign('closed_chk', $closed_chk);				// 定休日

			$this->smarty->assign('list', NULL);

		} else {

			// カテゴリ選択欄表示
			$tenpo_data[0]['tp_cate'] = str_replace("-", "", $tenpo_data[0]['tp_cate']);

			$this->smarty->assign('list', $tenpo_data[0]);

			// 登録カテゴリ名称の表示
			$this->load->model('Categroup', 'cate', TRUE);
			$_cate_namelist = $this->cate->get_category_name($tenpo_data[0]['tp_cate']);
			$this->smarty->assign('cate_list', $_cate_namelist);

			// 営業時間セット
			$this->_item_eigyo_set();

		}

		// プレビュー用にチェック用ticketを発行
		$_ticket = md5(uniqid(mt_rand(), true));
		$_SESSION['a_ticket'] = $_ticket;
		$this->smarty->assign('ticket', $_ticket);

    	$this->view('tenpo_site/tenpo_edit.tpl');

    }

    // 確認画面表示
    public function tenpo_conf()
    {

    	$input_post = $this->input->post();

    	// 初期値セット
    	$this->_item_set();

        // 都道府県チェック
        $this->smarty->assign('pref_name', $this->_pref_name);

    	$this->load->model('Tenpoinfo', 'tnp', TRUE);

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {
    		$input_post['tp_cate'] = "010101";
    	} else {

    		if (isset($input_post["_submit"]) && ($input_post["_submit"] == 'save'))
    		{
    			// 店舗情報の保存

	    		// 営業時間セット
	    		$arr_setdata = $input_post;
	    		$set_data = $this->_eigyo_time_set($arr_setdata);

	    		// データ設定
	    		$set_data["tp_cl_seq"]    = $_SESSION['a_cl_seq'];
// 	    		$set_data["tp_cl_id"]     = $_SESSION['a_cl_id'];
	    		$set_data["tp_cl_siteid"] = $_SESSION['a_cl_siteid'];

	    		$this->_options_pref = $this->config->item('pref');
	    		$set_data["tp_prefname"]  = $this->_options_pref[$input_post['tp_pref']];		// 「都道府県名称」を追加

	    		// カテゴリセット
	    		$i = 0;
	    		$cate_no = explode(',', $input_post['tp_cate']);								// 分割
	    		foreach ($cate_no as $val)
	    		{
	    			$cate_id = str_split($val, 2);												// 2桁毎に分割
	    			if ($i == 0)
	    			{
	    				$_tp_cate  = $cate_id[0] . '-' . $cate_id[1] . $cate_id[2];				// 「00-0000」に結合
	    			} else {
	    				$_tp_cate .= ',' . $cate_id[0] . '-' . $cate_id[1] . $cate_id[2];
	    			}
	    			$i++;
	    		}
	    		$set_data["tp_cate"] = $_tp_cate;

	    		// DB書き込み
	    		$_row_id = $this->tnp->inup_tenpo($set_data);

    		}
    	}

    	// プレビュー用にチェック用ticketを発行
    	$_ticket = md5(uniqid(mt_rand(), true));
    	$_SESSION['a_ticket'] = $_ticket;
    	$this->smarty->assign('ticket', $_ticket);

    	// 再読み込み
    	// 日付け初期化
    	$this->_item_eigyo_set();

    	// 登録カテゴリ名称の表示
    	$this->load->model('Categroup', 'cate', TRUE);
    	$_cate_namelist = $this->cate->get_category_name($input_post['tp_cate']);
    	$this->smarty->assign('cate_list', $_cate_namelist);

		$this->smarty->assign('list', $input_post);
    	$this->view('tenpo_site/tenpo_edit.tpl');

    }

    // カテゴリリスト表示
    public function cate_list()
    {

    	// カテゴリリスト取得
    	$_cate_list = $this->_item_cate_list();

    	$this->smarty->assign('catelist', $_cate_list);

    	$this->view('tenpo_site/cate_list.tpl');

    }

    // 初期値セット
    private function _item_set()
    {

    	// 時刻セット
    	for ($i=0; $i < 24; $i++)
    	{
    		$arr_time_h[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
    	}

    	// 分セット
    	for ($i=0; $i < 60; $i+=5)
    	{
    		$arr_time_m[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
    	}

    	$this->smarty->assign('opt_time_h', $arr_time_h);
    	$this->smarty->assign('opt_time_m', $arr_time_m);

    }

    // カテゴリリスト
    public function _item_cate_list()
    {

    	$this->load->model('Categroup', 'cate', TRUE);

    	// 第一カテゴリを取得
    	$_cate_data1 = $this->cate->get_category_parent1();

    	$_arr_catelist = array();
    	$i = 0;
    	foreach ($_cate_data1 as $val1)
    	{

    		// 第二カテゴリを取得
    		$_cate_data2 = $this->cate->get_category_parent2($val1['ca_seq']);
    		foreach ($_cate_data2 as $key2 => $val2)
    		{

    			// 第三カテゴリを取得
    			$_cate_data3 = $this->cate->get_category_parent3($val2['ca_seq']);
    			foreach ($_cate_data3 as $val3)
    			{

    				$_arr_catelist[$i] = sprintf("%02s", $val1['ca_id']) . sprintf("%02s", $val2['ca_id']) . sprintf("%02s", $val3['ca_id'])
    				. ' :: ' . $val1['ca_name'] . ' -> ' . $val2['ca_name'] . ' -> ' . $val3['ca_name'];
    				$i++;

    			}
    		}
    	}

    	return $_arr_catelist;

    }

    // 営業時間初期値セット
    private function _item_eigyo_set()
    {

    	// 日付け初期化
    	for ($i = 0; $i < 3; $i++)
    	{
    		for ($j = 0; $j < 7; $j++)
    		{
    			$eigyo_chk[$i][$j] = FALSE;
    		}
    	}

    	// 定休日初期化
    	for ($i = 0; $i < 8; $i++)
    	{
    		$closed_chk[0][$i] = FALSE;
    	}

    	$tenpo_data = $this->tnp->get_tenpo_siteid($_SESSION['a_cl_siteid']);
    	if (isset($tenpo_data[0]['tp_eigyo']))
    	{

    		$cnt = 0;
    		foreach(explode("/", $tenpo_data[0]['tp_eigyo']) as $value){

    			$unit = explode(",", $value);

    			// 営業日セット
    			foreach(str_split($unit[0]) as  $val)
    			{
    				$eigyo_chk[$cnt][$val] = " checked";
    			}

    			// 営業時間セット
    			preg_match_all('/[0-9]+/i', $unit[1], $eigyo_time[$cnt]);

    			$cnt++;

    		}

    		// 定休日セット
    		foreach(str_split($tenpo_data[0]['tp_closed']) as  $val)
    		{
    			$closed_chk[0][$val] = " checked";
    		}

    		$this->smarty->assign('eigyo_time', $eigyo_time);
    	}

    	$this->smarty->assign('eigyo_chk',  $eigyo_chk);
    	$this->smarty->assign('closed_chk', $closed_chk);


    }

    /**
     * ランダム文字列の生成
     *
     * @return    varchar
     */
    private function _makeRandStr($length = 15)
    {

    	static $chars;
    	if (!$chars) {
    		$chars = array_flip(array_merge(
    				range('a', 'z'), range('A', 'Z'), range('0', '9')
    		));
    	}

    	$str = '';
    	for ($i = 0; $i < $length; ++$i) {
    		$str .= array_rand($chars);
    	}
    	return $str;

    }

    // 営業時間をデータセット
    private function _eigyo_time_set($arr_setdata)
    {

    	// 営業時間セット:1
    	$_eigyobi1 = "";
    	if (isset($arr_setdata["eigyo1"]))
    	{
    		foreach ($arr_setdata["eigyo1"] as $key => $val)
    		{
    			$_eigyobi1 .= $val;
    		}

    		unset($arr_setdata["eigyo1"]) ;

    	}

    	$_eigyobi1  .= ","
    			. str_pad($arr_setdata["eigyo_time11"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time12"], 2, "0", STR_PAD_LEFT)
    			. "-"
    			. str_pad($arr_setdata["eigyo_time21"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time22"], 2, "0", STR_PAD_LEFT)
    			. "+"
    		    . str_pad($arr_setdata["eigyo_time31"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time32"], 2, "0", STR_PAD_LEFT)
    		    . "-"
    		    . str_pad($arr_setdata["eigyo_time41"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time42"], 2, "0", STR_PAD_LEFT)
    		    ;

    	// 営業時間セット:2
    	$_eigyobi2 = "";
    	if (isset($arr_setdata["eigyo2"]))
    	{
    		foreach ($arr_setdata["eigyo2"] as $key => $val)
    		{
    			$_eigyobi2 .= $val;
    		}

    		unset($arr_setdata["eigyo2"]) ;

    	}

    	$_eigyobi2  .= ","
    			. str_pad($arr_setdata["eigyo_time51"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time52"], 2, "0", STR_PAD_LEFT)
    			. "-"
    			. str_pad($arr_setdata["eigyo_time61"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time62"], 2, "0", STR_PAD_LEFT)
    			. "+"
    		    . str_pad($arr_setdata["eigyo_time71"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time72"], 2, "0", STR_PAD_LEFT)
    		    . "-"
    		    . str_pad($arr_setdata["eigyo_time81"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time82"], 2, "0", STR_PAD_LEFT)
    		    ;

    	// 営業時間セット:3
    	$_eigyobi3 = "";
    	if (isset($arr_setdata["eigyo3"]))
    	{
    		foreach ($arr_setdata["eigyo3"] as $key => $val)
    		{
    			$_eigyobi3 .= $val;
    		}

    		unset($arr_setdata["eigyo3"]) ;

    	}

    	$_eigyobi3  .= ","
    			. str_pad($arr_setdata["eigyo_time91"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time92"], 2, "0", STR_PAD_LEFT)
    			. "-"
    			. str_pad($arr_setdata["eigyo_time101"], 2, "0", STR_PAD_LEFT)
    			. ":"
    			. str_pad($arr_setdata["eigyo_time102"], 2, "0", STR_PAD_LEFT)
    			. "+"
    		    . str_pad($arr_setdata["eigyo_time111"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time112"], 2, "0", STR_PAD_LEFT)
    		    . "-"
    		    . str_pad($arr_setdata["eigyo_time121"], 2, "0", STR_PAD_LEFT)
    		    . ":"
    		    . str_pad($arr_setdata["eigyo_time122"], 2, "0", STR_PAD_LEFT)
    		    ;

    	$arr_setdata["tp_eigyo"] = $_eigyobi1 . "/" . $_eigyobi2 . "/" . $_eigyobi3;

    	// 定休日セット
    	if (isset($arr_setdata["closed"]))
    	{
    		$_closed = "";
    		foreach ($arr_setdata["closed"] as $key => $val)
    		{
    			$_closed .= $val;
    		}

    		$arr_setdata["tp_closed"] = $_closed;

    		unset($arr_setdata["closed"]) ;
    	}

    	// 不要パラメータ削除
    	unset($arr_setdata["_submit"]) ;
    	unset($arr_setdata["ticket"]) ;
    	unset($arr_setdata["add"]) ;
    	unset($arr_setdata["eigyo_time11"]) ;
    	unset($arr_setdata["eigyo_time12"]) ;
    	unset($arr_setdata["eigyo_time21"]) ;
    	unset($arr_setdata["eigyo_time22"]) ;
    	unset($arr_setdata["eigyo_time31"]) ;
    	unset($arr_setdata["eigyo_time32"]) ;
    	unset($arr_setdata["eigyo_time41"]) ;
    	unset($arr_setdata["eigyo_time42"]) ;
    	unset($arr_setdata["eigyo_time51"]) ;
    	unset($arr_setdata["eigyo_time52"]) ;
    	unset($arr_setdata["eigyo_time61"]) ;
    	unset($arr_setdata["eigyo_time62"]) ;
    	unset($arr_setdata["eigyo_time71"]) ;
    	unset($arr_setdata["eigyo_time72"]) ;
    	unset($arr_setdata["eigyo_time81"]) ;
    	unset($arr_setdata["eigyo_time82"]) ;
    	unset($arr_setdata["eigyo_time91"]) ;
    	unset($arr_setdata["eigyo_time92"]) ;
    	unset($arr_setdata["eigyo_time101"]) ;
    	unset($arr_setdata["eigyo_time102"]) ;
    	unset($arr_setdata["eigyo_time111"]) ;
    	unset($arr_setdata["eigyo_time112"]) ;
    	unset($arr_setdata["eigyo_time121"]) ;
    	unset($arr_setdata["eigyo_time122"]) ;

    	return $arr_setdata;

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'tp_cate',
    					'label'   => 'カテゴリ選択',
    					'rules'   => 'trim|required|regex_match[/^[a-z0-9]{6}(,[a-z0-9]{6})*$/]|max_length[510]'		// (6+1)*50=350 : max.50個
    			),
    			array(
    					'field'   => 'tp_shopname',
    					'label'   => '店舗名称',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'tp_shopname_sub',
    					'label'   => '店舗名称(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_url',
    					'label'   => '店舗サイトURL',
    					'rules'   => 'trim|regex_match[/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/]|max_length[100]'
    			),
    			array(
    					'field'   => 'tp_zip01',
    					'label'   => '郵便番号（3ケタ）',
    					'rules'   => 'trim|required|exact_length[3]|is_numeric'
    			),
    			array(
    					'field'   => 'tp_zip02',
    					'label'   => '郵便番号（4ケタ）',
    					'rules'   => 'trim|required|exact_length[4]|is_numeric'
    			),
    			array(
    					'field'   => 'tp_pref',
    					'label'   => '都道府県',
    					'rules'   => 'trim|required|max_length[2]'
    			),
    			array(
    					'field'   => 'tp_addr01',
    					'label'   => '市区町村',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'tp_addr02',
    					'label'   => '町名・番地',
    					'rules'   => 'trim|required|max_length[100]'
    			),
    			array(
    					'field'   => 'tp_buil',
    					'label'   => 'ビル・マンション名など',
    					'rules'   => 'trim|max_length[100]'
    			),
    			array(
    					'field'   => 'tp_tel',
    					'label'   => '電話番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'tp_fax',
    					'label'   => 'FAX番号',
    					'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
    			),
    			array(
    					'field'   => 'tp_mail',
    					'label'   => 'メールアドレス',
    					'rules'   => 'trim|max_length[100]|valid_email'
    			),
    			array(
    					'field'   => 'tp_opentime',
    					'label'   => '営業時間(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_holiday',
    					'label'   => '定休日(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_since',
    					'label'   => '創業／設立日(テキスト)',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'tp_parking',
    					'label'   => '駐車場情報(テキスト)',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'tp_seat',
    					'label'   => '座席情報(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_card',
    					'label'   => 'カード情報(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_accessinfo',
    					'label'   => '最寄駅情報',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'tp_access',
    					'label'   => 'アクセス情報(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_access_sub',
    					'label'   => 'アクセス情報予備(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_pricerange01',
    					'label'   => 'メニュー価格帯１',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'tp_contents01',
    					'label'   => 'メニュー情報１(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_pricerange02',
    					'label'   => 'メニュー価格帯２',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'tp_contents02',
    					'label'   => 'メニュー情報２(テキスト)',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_overview',
    					'label'   => '事業者TOP概要',
    					'rules'   => 'trim|required|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_searchword',
    					'label'   => '検索用キーワード',
    					'rules'   => 'trim|max_length[200]'
    			),
    			array(
    					'field'   => 'tp_description',
    					'label'   => 'ディスクリプション',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_keywords',
    					'label'   => 'キーワード',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_sns01',
    					'label'   => 'ＳＮＳコード１',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_sns02',
    					'label'   => 'ＳＮＳコード２',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_sns03',
    					'label'   => 'ＳＮＳコード３',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_sns04',
    					'label'   => 'ＳＮＳコード４',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_sns05',
    					'label'   => 'ＳＮＳコード５',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_sns05',
    					'label'   => 'ＳＮＳコード５',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_google_map',
    					'label'   => 'googleマップコード',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_qrcode_site',
    					'label'   => 'サイトQRコード',
    					'rules'   => 'trim|max_length[500]'
    			),
    			array(
    					'field'   => 'tp_qrcode_google',
    					'label'   => 'GoogleマップQRコード',
    					'rules'   => 'trim|max_length[500]'
    			),
    			array(
    					'field'   => 'tp_free02',
    					'label'   => 'フリー２',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_free03',
    					'label'   => 'フリー３',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_free04',
    					'label'   => 'フリー４',
    					'rules'   => 'trim|max_length[1000]'
    			),
    			array(
    					'field'   => 'tp_free05',
    					'label'   => 'フリー５',
    					'rules'   => 'trim|max_length[1000]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
