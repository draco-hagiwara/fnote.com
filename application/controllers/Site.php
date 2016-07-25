<?php

//class Top extends CI_Controller {
class Site extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

		redirect('https://fnote.com.dev/');

    }


    public function pf()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	// URIセグメントからクライアントSITEIDを取得
    	$segments = $this->uri->segment_array();

    	// 表示用にデータの取得
    	$this->load->model('Entry', 'ent', TRUE);
    	$entry_data = $this->ent->get_entry_siteid($segments[3]);

    	$this->smarty->assign('list', $entry_data[0]);
    	$this->view('site/pf.tpl');

    }

    public function inquiry_conf()
    {

    	$post_data = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE) {

	    	// 表示用にデータの取得
	    	$this->load->model('Entry', 'ent', TRUE);
	    	$entry_data = $this->ent->get_entry_siteid($post_data['en_cl_siteid']);

	    	$this->smarty->assign('list', $entry_data[0]);

    		$this->view('site/pf.tpl');

    	} else {

    		$this->smarty->assign('en_cl_siteid', $post_data['en_cl_siteid']);

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

	    	// 表示用にデータの取得
	    	$this->load->model('Entry', 'ent', TRUE);
	    	$entry_data = $this->ent->get_entry_siteid($post_data['en_cl_siteid']);

	    	$this->smarty->assign('list', $entry_data[0]);

	    	$this->view('site/pf.tpl');
    		return;
    	}

    	// 不要パラメータ削除
    	$post_data['co_cl_siteid'] = $post_data['en_cl_siteid'];
    	unset($post_data["en_cl_siteid"]) ;
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
    	if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
    	} else {
    		echo "メール送信エラー";
    		log_message('error', 'site::[inquiry_comp()]客先問合せ処理 メール送信エラー');
    	}

    	$_site_url = "site/pf/" . $post_data['co_cl_siteid'] ."/";

    	$this->smarty->assign('_site_url', $_site_url);
    	$this->smarty->assign('en_cl_siteid', $post_data['co_cl_siteid']);
    	$this->view('site/inquiry_comp.tpl');

    }


    // フォーム・バリデーションチェック
    private function _set_validation()
    {
    	$rule_set = array(
    			array(
    					'field'   => 'co_contact_name',
    					'label'   => 'お名前',
    					'rules'   => 'trim|required|max_length[100]'
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