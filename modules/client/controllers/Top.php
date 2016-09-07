<?php

class Top extends MY_Controller
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

    // ログイン 初期表示
    public function index()
    {

    	$this->_set_validation();

    	// クライアントデータを取得
		$this->load->model('Client', 'cl', TRUE);
    	$cl_data = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);

    	$this->smarty->assign('list', $cl_data[0]);

        $this->view('top/index.tpl');

    }

    // ログイン 初期表示
    public function preview()
    {

    	$post_data = $_POST;

    	switch ($post_data['submit'])
    	{
    		case 'client_ok':

    			print("<br>client_ok<br>");

    			// クライアントステータス変更：「6:クライアント確認」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $post_data['cl_seq'];
//     			$set_data['cl_id']      = $post_data['cl_id'];
    			$set_data['cl_status']  = 7;
    			$set_data['cl_comment'] = $post_data['cl_comment'];

    			$this->cl->update_client($set_data, FALSE, 3);

    			// クライアントデータから全担当者を取得
    			$clac_data = $this->cl->get_clac_seq($post_data['cl_seq'], NULL);

    			// クライアントへ承認メール送信。
    			// メール送信先設定
    			$mail['from']      = "";
    			$mail['from_name'] = "";
    			$mail['subject']   = "";
    			$mail['to']        = $clac_data[0]['adminacmail'];
    			$mail['cc']        = $clac_data[0]['salseacmail'] . ";" . $clac_data[0]['editoracmail'];
    			$mail['bcc']       = "";

    			// メール本文置き換え文字設定
    			$arrRepList = array(
    					'ac_adminname01'  => $clac_data[0]['adminname01'],
    					'ac_adminname02'  => $clac_data[0]['adminname02'],
    					'ac_salsename01'  => $clac_data[0]['salsename01'],
    					'ac_salsename02'  => $clac_data[0]['salsename02'],
    					'ac_editorname01' => $clac_data[0]['editorname01'],
    					'ac_editorname02' => $clac_data[0]['editorname02'],
    					'cl_company'      => $clac_data[0]['cl_company'],
    					'cl_comment'      => $post_data['cl_comment'],
    			);

    			// メールテンプレートの読み込み
    			$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    			$mail_tpl = $this->config->item('MAILTPL_CLIENT_OK_ID');

    			// メール送信
    			$this->load->model('Mailtpl', 'mailtpl', TRUE);
    			if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl, 3)) {
    			} else {
    				echo "メール送信エラー";
    				log_message('error', 'CLIENT_top::[preview()]サイト記事承認処理 メール送信エラー');
    			}

    			redirect('/top/');

    			break;
    		case 'client_ng':

    			print("<br>client_ng<br>");

    			// クライアントステータス変更：「9:再編集」
    			$this->load->model('Client', 'cl', TRUE);

    			$set_data['cl_seq']     = $post_data['cl_seq'];
//     			$set_data['cl_id']      = $post_data['cl_id'];
    			$set_data['cl_status']  = 9;
    			$set_data['cl_comment'] = $post_data['cl_comment'];

    			$this->cl->update_client($set_data, FALSE, 3);

    			// クライアントデータから担当者を取得
    			$clac_data = $this->cl->get_clac_seq($post_data['cl_seq'], NULL);

    			// クライアントへ承認メール送信。
    			// メール送信先設定
    			$mail['from']      = "";
    			$mail['from_name'] = "";
    			$mail['subject']   = "";
    			$mail['to']        = $clac_data[0]['editoracmail'];
    			$mail['cc']        = $clac_data[0]['salseacmail'] . ";" . $clac_data[0]['adminacmail'];
    			$mail['bcc']       = "";

    			// メール本文置き換え文字設定
    			$arrRepList = array(
    					'ac_editorname01' => $clac_data[0]['editorname01'],
    					'ac_editorname02' => $clac_data[0]['editorname02'],
    					'cl_company'      => $clac_data[0]['cl_company'],
//     					'cl_president01'  => $clac_data[0]['cl_president01'],
//     					'cl_president02'  => $clac_data[0]['cl_president02'],
    					'ac_salsename01'  => $clac_data[0]['salsename01'],
    					'ac_salsename02'  => $clac_data[0]['salsename02'],
    					'cl_comment'      => $post_data['cl_comment'],
    					'member'          => "クライアント",
    			);

    			// メールテンプレートの読み込み
    			$this->config->load('config_mailtpl');									// メールテンプレート情報読み込み
    			$mail_tpl = $this->config->item('MAILTPL_SALSE_NG_ID');

    			// メール送信
    			$this->load->model('Mailtpl', 'mailtpl', TRUE);
    			if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl, 3)) {
    			} else {
    				echo "メール送信エラー";
    				log_message('error', 'CLIENT_top::[preview()]サイト記事非承認処理 メール送信エラー');
    			}

    			redirect('/top/');

    			break;
    		default:

    			// クライアントデータの取得
    			$this->load->model('Client', 'cl', TRUE);
    			$cl_data = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);

    			// 表示用にデータの取得
    			$this->load->model('Interview', 'itv', TRUE);
    			$interview_data = $this->itv->get_interview_clseq($_SESSION['c_memSeq']);

    			$interview_data[0]['cl_status'] = $cl_data[0]['cl_status'];
    			$this->smarty->assign('list', $interview_data[0]);
    			$this->view('top/preview.tpl');

    	}
    }

    public function qr_site()
    {

    	$input_post = $this->input->post();

    	// URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_en_seq = $segments[3];
    	} else {
    		$tmp_en_seq = 0;
    	}

    	// 店舗データの取得
    	$this->load->model('Entry', 'ent', TRUE);
    	$entry_data = $this->ent->get_entry_seq($tmp_en_seq);
    	if ($entry_data == FALSE)
    	{
    		show_404();
    	}

    	// QRコード作成
    	$this->smarty->assign('qr_code', NULL);
    	if ($entry_data[0]['en_qrcode_site'] != "")
    	{
//     		require_once("/usr/share/pear7/Image/QRCode.php");
    		require_once("/usr/share/pear/Image/QRCode.php");

    		$qr = new Image_QRCode();
    		$option = array(
    				"module_size"=>3,				//サイズ=>1〜19で指定
    				"image_type"=>"jpeg",			//画像形式=>jpegかpngを指定
    				"output_type"=>"display",		//出力方法=>displayかreturnで指定 returnの場合makeCodeで画像リソースが返される
    				"error_correct"=>"H"			//クオリティ(L<M<Q<H)を指定
    		);
    		$qr_code = $qr->makeCode(htmlspecialchars($entry_data[0]['en_qrcode_site']), $option);
    		imagepng($image, "qr.png");
    		imagedestroy($image);
    	}
    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
