<?php

//class Top extends CI_Controller {
class Site extends MY_Controller
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

		redirect('https://fnote.com.dev/');

    }

	// サイトTOP
    public function pf()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	// 表示用にデータの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$this->load->model('Interview', 'itv', TRUE);

    	$tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	}

    	// 営業の有無をチェック
    	$_close_chk = $this->_tenpo_close_chk($tenpo_data[0]['tp_closed']);


    	print("<br>");
    	print("営業check　：：　");
    	var_dump($_close_chk);
    	print("<br>");


    	if ($_close_chk == FALSE)
    	{
    		print("【定休日】<br>");
    		$_eigyo_chk = 0;
    	} else {



    		// 営業時間のチェック
    		$_open_chk = $this->_tenpo_open_chk($tenpo_data[0]['tp_eigyo']);
    		if ($_open_chk == TRUE)
    		{
    			print("【営業時間外】<br>");
    			$_eigyo_chk = 1;
    		} else {
    			print("【営業中】<br>");
    			$_eigyo_chk = 2;
    		}



    	}

    	$this->smarty->assign('eigyo_chk', $_eigyo_chk);

    	$interview_data = $this->itv->get_interview_siteid($segments[3]);

    	$this->smarty->assign('tenpo',     $tenpo_data[0]);
    	$this->smarty->assign('interview', $interview_data[0]);
    	$this->view('site/pf.tpl');

    }

    // サイトメニュー：メニュー
    public function mn()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	$this->load->model('Tenpoinfo', 'tnp',  TRUE);
    	$this->load->model('Tenpomenu', 'menu', TRUE);

    	// 店舗情報データの取得
    	$tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	} else {
    		$this->smarty->assign('tenpo', $tenpo_data[0]);
    	}

    	// 店舗メニュー(第一)データの取得
    	$_get_menu01 = $this->menu->get_menu_parent1($segments[3]);
    	if (isset($_get_menu01[0]))
    	{

	    	// 各メニューTABの選択
	    	if (isset($segments[4]))
	    	{
	    		$_mn_seq = $segments[4];

	    		$this->smarty->assign('menu_no', $segments[4]);
	    	} else {
	    		$_mn_seq = $_get_menu01[0]['mn_seq'];

	    		$this->smarty->assign('menu_no', $_get_menu01[0]['mn_seq']);
	    	}


	    	// 各メニューTAB内容の表示
	    	// 店舗メニュー(第二)データの取得
	    	$_get_menu02 = $this->menu->get_menu_parent2($_mn_seq, $segments[3]);
	    	$this->smarty->assign('menu02', $_get_menu02);

	    	foreach ($_get_menu02 as $key => $value)
	    	{

	    		// 店舗メニュー(第三)データの取得
	    		$_get_menu02[$key] = $this->menu->get_menu_parent3_data($_get_menu02[$key]['mn_seq'], $segments[3]);

	    	}

	    	$this->smarty->assign('menu01', $_get_menu01);
	    	$this->smarty->assign('menu03', $_get_menu02);

    	} else {
    		$this->smarty->assign('menu_no', NULL);

    		$this->smarty->assign('menu01', NULL);
    		$this->smarty->assign('menu02', NULL);
    		$this->smarty->assign('menu03', NULL);

    	}

    	$this->view('site/mn.tpl');

    }

    // サイトメニュー：こだわり
    public function gd()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	// 表示用にデータの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$this->load->model('Good',      'gd',  TRUE);

    	// 店舗情報データの取得
        $tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	} else {
    		$this->smarty->assign('tenpo',     $tenpo_data[0]);
    	}

    	// こだわり情報データの取得
    	$good_data = $this->gd->get_good_siteid($segments[3]);
    	if ($good_data == FALSE)
    	{
    		$this->smarty->assign('good', NULL);
    	} else {
    		$this->smarty->assign('good', $good_data[0]);
    	}

    	$this->view('site/gd.tpl');

    }

    // サイトメニュー：インタビュー
    public function iv()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	// 表示用にデータの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$this->load->model('Interview', 'itv', TRUE);

    	// 店舗情報データの取得
    	$tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	} else {
    		$this->smarty->assign('tenpo',     $tenpo_data[0]);
    	}

    	// インタビュー情報データの取得
    	$interview_data = $this->itv->get_interview_siteid($segments[3]);
    	if ($interview_data == FALSE)
    	{
    		$this->smarty->assign('interview', NULL);
    	} else {
    		$this->smarty->assign('interview', $interview_data[0]);
    	}

    	$this->view('site/iv.tpl');

    }

    // サイトメニュー：チケット
    public function tc()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	// 表示用にデータの取得
    	$this->load->model('Tenpoinfo',   'tnp', TRUE);
    	$this->load->model('Tenpocoupon', 'cp',  TRUE);

    	// 店舗情報データの取得
    	$tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	} else {
    		$this->smarty->assign('tenpo', $tenpo_data[0]);
    	}

    	// クーポン情報データの取得
    	$coupon_data = $this->cp->get_coupon_siteid($segments[3]);
    	if ($coupon_data == FALSE)
    	{
    		$this->smarty->assign('coupon', NULL);
    	} else {

    		// イメージ画像のパス
    		$this->config->load('config_comm');
    		$options_tplimg = $this->config->item('TENPO_COUPON_TEMPLATE');
    		foreach ($coupon_data as $key => $val)
    		{
    			$coupon_data[$key]['tpl_img'] = $options_tplimg[$coupon_data[$key]['cp_template']];
    		}

    		$this->smarty->assign('coupon', $coupon_data);
    	}

    	$this->view('site/tc.tpl');

    }

    // サイトメニュー：ギャラリー
    public function gl()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	// 表示用にデータの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$this->load->model('Image_gl',  'img', TRUE);

    	// 店舗情報データの取得
    	$tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	} else {
    		$this->smarty->assign('tenpo', $tenpo_data[0]);
    	}

    	// ギャラリー画像データの取得
    	$gl_data = $this->img->get_image_clsiteid($segments[3]);
    	if ($gl_data == FALSE)
    	{
    		$this->smarty->assign('gallery', NULL);
    	} else {

    		// 表示用に編集：横6列表示

//     		// *2016.09.16 以下は masonry / imagesLoaded 使用時のコード
//     		$set_gldata[] = array (
//     								"title"  => "A Day in the Life",
//     								"images" => array(
//     												"thumb" =>  "https://fnote.com.dev/images/client10/b/t_20160913_5763857d7544da4cd8.jpg",
//     												"large" =>  "https://fnote.com.dev/images/client10/b/20160913_5763857d7544da4cd8.jpg",
//     											)
//     							);
//     		$set_gldata[] = array (
//     								"title"  => "A Day in the Life",
//     								"images" => array(
//     												"thumb" =>  "https://fnote.com.dev/images/client10/b/t_20160913_5586457d81245dd90d.jpg",
//     												"large" =>  "https://fnote.com.dev/images/client10/b/20160913_5586457d81245dd90d.jpg",
//     											)
//     							);

//     		$set_gldata = json_encode($set_gldata);

//     		print_r($set_gldata);


    		// *2016.09.15 以下はbootstrap使用時のコード
    		$i = 0;
    		$j = 0;
    		foreach ($gl_data as $key => $value)
    		{
    			$set_gldata[$i][$j]['gl_cl_siteid'] = $value['gl_cl_siteid'];
    			$set_gldata[$i][$j]['gl_filename'] = $value['gl_filename'];
    			$set_gldata[$i][$j]['gl_title'] = $value['gl_title'];

    			$j++;
    			if ($j == 6)
    			{
    				$i++;
    				$j = 0;
    			}

    		}

    		$this->smarty->assign('gallery', $set_gldata);
    	}

    	$this->view('site/gl.tpl');

    }

    // サイトメニュー：クーポン＆地図
    public function mp()
    {

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();
    	if (!isset($segments[3]))
    	{
    		show_404();
    	}

    	// 表示用にデータの取得
    	$this->load->model('Tenpoinfo',   'tnp', TRUE);
    	$this->load->model('Tenpocoupon', 'cp',  TRUE);

    	// 店舗情報データの取得
    	$tenpo_data = $this->tnp->get_tenpo_siteid($segments[3]);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	} else {
    		$this->smarty->assign('tenpo', $tenpo_data[0]);
    	}

    	// クーポン情報データの取得
    	$coupon_data = $this->cp->get_coupon_siteid($segments[3]);
    	if ($coupon_data == FALSE)
    	{
    		$this->smarty->assign('coupon', NULL);
    	} else {

    		// イメージ画像のパス
    		$this->config->load('config_comm');
    		$options_tplimg = $this->config->item('TENPO_COUPON_TEMPLATE');
    		foreach ($coupon_data as $key => $val)
    		{
    			$coupon_data[$key]['tpl_img'] = $options_tplimg[$coupon_data[$key]['cp_template']];
    		}

    		$this->smarty->assign('coupon', $coupon_data);
    	}

    	$this->view('site/mp.tpl');

    }

    // サイト問合せ
    public function inquiry_edit()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();

    	$this->smarty->assign('tp_cl_siteid', $segments[3]);
    	$this->view('site/inquiry_edit.tpl');

    }

    public function inquiry_conf()
    {

    	$post_data = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {

    		$this->smarty->assign('tp_cl_siteid', $post_data['tp_cl_siteid']);

    		$this->view('site/inquiry_edit.tpl');

    	} else {

    		$this->smarty->assign('tp_cl_siteid', $post_data['tp_cl_siteid']);

    		$this->view('site/inquiry_conf.tpl');
    	}
    }

    public function inquiry_comp()
    {

    	$post_data = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();
    	$this->form_validation->run();

    	// 「戻る」ボタン押下の場合
    	if ( $this->input->post('_back') ) {

    		$this->smarty->assign('tp_cl_siteid', $post_data['tp_cl_siteid']);

    		$this->view('site/inquiry_edit.tpl');
    		return;
    	}

    	// 不要パラメータ削除
    	$post_data['co_cl_siteid'] = $post_data['tp_cl_siteid'];
    	unset($post_data["tp_cl_siteid"]) ;
    	unset($post_data["submit"]) ;

    	// tb_contact への書き込み
    	$this->load->model('Contact', 'cont', TRUE);
    	$_row_id = $this->cont->insert_contact($post_data, TRUE);
    	if (!is_numeric($_row_id))
    	{
    		log_message('error', 'site::[inquiry_comp()]客先問合せ情報登録処理 insert_contactエラー');
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
    		log_message('error', 'site::[inquiry_comp()]客先問合せ処理 メール送信エラー');
    	}

    	$_site_url = "site/pf/" . $post_data['co_cl_siteid'] ."/";

    	$this->smarty->assign('_site_url', $_site_url);
    	$this->smarty->assign('tp_cl_siteid', $post_data['co_cl_siteid']);
    	$this->view('site/inquiry_comp.tpl');

    }

    // 定休日チェック
    private function _tenpo_close_chk($tp_closed)
    {

    	// 本日の曜日は？ (0:日曜～6:土曜)
    	$week_int = date('w', time());
		$result = strpos($tp_closed, $week_int);

		print("曜日check　：：　");
		var_dump($result);
		print("<br>");



		// 祝日チェック
		if (is_numeric($result))
		{
			return FALSE;
		} else {
			// 営業中
			$this->load->library('HolidayDateTime');
			$result = $this->holidaydatetime->holiday();

			print("祝日check　：：　");
			var_dump($result);
			print("<br>");

			if ($result)
			{
				return FALSE;
			} else {
				return TRUE;
			}
		}



    }

    // 営業時間チェック
    private function _tenpo_open_chk($tp_open)
    {

    	// 本日の曜日は？ (0:日曜～6:土曜)
    	$week_int = date('w', time());



    	print($week_int);
    	print("<br>");
    	print_r($tp_open);
    	print("<br>");

    	// ３つの設定に分割
    	$open_time01 = explode("/", $tp_open);

    	print("time01::");
    	print_r($open_time01);
    	print("<br>");


    	// 曜日と時間に分割
    	foreach ($open_time01 as $key => $value)
    	{
   			$open_time02[$key] = explode(",", $value);
    	}

    	print("time02::");
    	print_r($open_time02);
    	print("<br>");


    	// 該当曜日の２つの時間を取得
    	foreach ($open_time02 as $key => $value)
    	{

    		print("strpos = ");
    		print(strpos($value[0], $week_int));
    		print("<br>");




    		if (is_numeric(strpos($value[0], $week_int)))
    		{

    			print("該当曜日時間::");
    			print_r($value[1]);
    			print("<br>");



    			$open_time03 = explode("+", $value[1]);
    		}
    	}


    	if (!isset($open_time03))
    	{
    		print("営業時間外3！<br>");

    		return TRUE;
    	} else {
	    	print("time03::");
	    	print_r($open_time03);
	    	print("<br>");
    	}



    	$date = new DateTime();
    	$_now_time = $date->modify('now')->format('H:i');

    	print("now時間::");
    	print($_now_time);
    	print("<br>");




    	// 該当曜日の２つの時間を取得
    	foreach ($open_time03 as $key => $value)
    	{
			$open_time04 = explode("-", $value);

			print("time04::");
			print_r($open_time04);
			print("<br>");


			// 入力時間のチェック : 営業時間が設定されている
			if ($open_time04[0] != $open_time04[1])
			{

				print("入力時間のチェック::");
				print_r($open_time04);
				print("<br>");





				// 24h チェック
				if ($open_time04[0] < $open_time04[1])
				{
					if (($open_time04[0] <= $_now_time) && ($_now_time <= $open_time04[1]))
					{
						print("営業中1！<br>");
						return FALSE;


					} else {
						print("営業時間外1！<br>");

					}


				} else {

					if (($open_time04[0] <= $_now_time) && ($_now_time <= "23:59"))
					{
						print("営業中1！<br>");
						return FALSE;


					} elseif (("0:00" <= $_now_time) && ($_now_time <= $open_time04[1])) {
						print("営業中1！<br>");
						return FALSE;


					} else {
						print("営業時間外2！<br>");
					}

				}


			}

    	}


    	return TRUE;			// 「営業時間外」

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
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


}


/* End of file top.php */
/* Location: ./application/controllers/top.php */