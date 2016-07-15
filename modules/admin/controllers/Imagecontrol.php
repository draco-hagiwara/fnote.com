<?php

class Imagecontrol extends MY_Controller
{

    /*
     * ADMIN管理者 画像管理ページ
    */
    public function __construct()
    {
        parent::__construct();

        if (isset($_SESSION['a_login']))
        {
        	$this->smarty->assign('login_chk', TRUE);
        	$this->smarty->assign('mem_type',  $_SESSION['a_memType']);
        	$this->smarty->assign('mem_Seq',   $_SESSION['a_memSeq']);
        	$this->view('top/index.tpl');
        } else {
        	$this->smarty->assign('login_chk', FALSE);
        	$this->smarty->assign('mem_type',  "");
        	$this->smarty->assign('mem_Seq',   "");
        	$this->smarty->assign('err_mess',  '');
        	$this->view('login/index.tpl');
        }
    }

    // 初期表示
    public function index()
    {



    	print_r($_POST);
    	print("<br><br>");
    	print_r($_FILES);
    	print("<br><br>");



        $this->_set_validation();												// バリデーション設定

        $this->view('imagecontrol/index.tpl');

    }

    // 初期表示
    public function get_image()
    {



    	print_r($_POST);
    	print("<br><br>");
    	print_r($_FILES);
    	print("<br><br>");
    	exit;

    }

    // 画像管理
    public function manage()
    {

    	$post_data = $_POST;

    	if (@$post_data['mode'] == 'edit')
    	{

    		// 画像一覧を取得
    		$this->load->model('Client', 'cl', TRUE);
    		$cl_data = $this->cl->get_cl_siteid($post_data['cl_siteid'], TRUE);

    		$this->load->model('Image', 'img', TRUE);
    		$img_data = $this->img->get_image_clsiteid($post_data['cl_siteid'], TRUE);

    		foreach ($img_data as $key =>$value)
    		{

    			// ヘッダ更新
    			if ($post_data['form']['header'] == $img_data[$key]['im_seq'])
    			{

    				$setData["im_seq"] = $img_data[$key]['im_seq'];
    				$setData["im_is_header"] = 1;

    				$this->img->update_image_imseq($setData);

    			} else {
    				$setData["im_seq"] = $img_data[$key]['im_seq'];
    				$setData["im_is_header"] = 0;

    				$this->img->update_image_imseq($setData);
    			}

    		}


    		if (isset($post_data['form']['delete']))
    		{
    			foreach ($post_data['form']['delete'] as $key =>$value)
    			{

    				// 削除処理
    				$setData["im_seq"] = $key;
    				$this->img->delete_image_seq($setData);

    			}
    		}

    	} else {

    		// 画像一覧を取得
    		$this->load->model('Client', 'cl', TRUE);
    		$cl_data = $this->cl->get_cl_seq($post_data['chg_uniq'], TRUE);

    	}

    	// 再読み込み
    	$this->load->model('Image', 'img', TRUE);
    	$img_data = $this->img->get_image_clsiteid($cl_data[0]['cl_siteid'], TRUE);

    	$this->_set_validation();												// バリデーション設定

    	$this->smarty->assign('cl_siteid', $cl_data[0]['cl_siteid']);
    	$this->smarty->assign('list', $img_data);
    	$this->view('imagecontrol/manage.tpl');

    }



    // フォーム・バリデーションチェック
    private function _set_validation()
    {

        $rule_set = array(
        );

        $this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

}
