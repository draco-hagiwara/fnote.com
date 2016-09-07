<?php

//class Top extends CI_Controller {
class Qr extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function qr_site()
    {

    	$input_post = $this->input->post();

    	// URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_tp_seq = $segments[3];
    	} else {
    		$tmp_tp_seq = 0;
    	}

    	// 店舗データの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$tenpo_data = $this->tnp->get_tenpo_seq($tmp_tp_seq);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	}

    	// QRコード作成
//     	$this->smarty->assign('qr_code', NULL);
    	if ($tenpo_data[0]['tp_qrcode_site'] != "")
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
    		$qr_code = $qr->makeCode(htmlspecialchars($tenpo_data[0]['tp_qrcode_site']), $option);
    		imagepng($image, "qr.png");
    		imagedestroy($image);
    	}
    }

    public function qr_gol()
    {

    	$input_post = $this->input->post();

    	// URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_tp_seq = $segments[3];
    	} else {
    		$tmp_tp_seq = 0;
    	}

    	// 店舗データの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$tenpo_data = $this->tnp->get_tenpo_seq($tmp_tp_seq);
    	if ($tenpo_data == FALSE)
    	{
    		show_404();
    	}

    	// QRコード作成
//     	$this->smarty->assign('qr_code', NULL);
    	if ($tenpo_data[0]['tp_qrcode_google'] != "")
    	{
    		//     		require_once("/usr/share/pear7/Image/QRCode.php");
    		require_once("/usr/share/pear/Image/QRCode.php");

    		$qr = new Image_QRCode();
    		$option = array(
    				"module_size"=>2,				//サイズ=>1〜19で指定
    				"image_type"=>"jpeg",			//画像形式=>jpegかpngを指定
    				"output_type"=>"display",		//出力方法=>displayかreturnで指定 returnの場合makeCodeで画像リソースが返される
    				"error_correct"=>"H"			//クオリティ(L<M<Q<H)を指定
    		);
    		$qr_code = $qr->makeCode(htmlspecialchars($tenpo_data[0]['tp_qrcode_google']), $option);
    		imagepng($image, "qr.png");
    		imagedestroy($image);
    	}
    }

    public function qr_pre()
    {

    	$input_post = $this->input->post();

    	// URIセグメントの取得
    	$segments = $this->uri->segment_array();
    	if (isset($segments[3]))
    	{
    		$tmp_tp_seq = $segments[3];
    	} else {
    		$tmp_tp_seq = 0;
    	}

    	// 店舗データの取得
    	$this->load->model('Tenpoinfo', 'tnp', TRUE);
    	$pre_data = $this->tnp->get_tenpo_seq($tmp_tp_seq);
		if ($pre_data == FALSE)
		{
			show_404();
		}

		// QRコード作成
		$this->smarty->assign('qr_code', NULL);
		if ($pre_data[0]['ep_qrcode_site'] != "")
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
			$qr_code = $qr->makeCode(htmlspecialchars($pre_data[0]['ep_qrcode_site']), $option);
			imagepng($image, "qr.png");
			imagedestroy($image);
		}

    }

//     // フォーム・バリデーションチェック
//     private function _set_validation()
//     {
//     	$rule_set = array(
//     	);

//     	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
//     }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */