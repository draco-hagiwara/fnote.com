<?php

class Contact extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    // 問合せフォーム
    public function index()
    {

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

        $this->view('contact/index.tpl');

    }

    // 確認画面表示
    public function confirm()
    {

        // バリデーション・チェック
		$this->_set_validation();												// バリデーション設定
        if ($this->form_validation->run() == FALSE)
        {
            $this->view('contact/index.tpl');
        } else {
            $this->view('contact/confirm.tpl');
        }

    }

    // 完了画面表示
    public function complete()
    {

        // バリデーション・チェック
		$this->_set_validation();                                             // バリデーション設定
        $this->form_validation->run();

        // 「戻る」ボタン押下の場合
        if ( $this->input->post('_back') ) {
            $this->view('contact/index.tpl');
            return;
        }

        // メール送信先設定
        $mail['from']      = "";
        $mail['from_name'] = "";
        $mail['subject']   = "";
        $mail['to']        = "";
        $mail['cc']        = $this->input->post('inputEmail');
        $mail['bcc']       = "";

        // メール本文置き換え文字設定
        $arrRepList = array(
                'inputName'    => $this->input->post('inputName'),
                'inputEmail'   => $this->input->post('inputEmail'),
                'inputTel'     => $this->input->post('inputTel'),
                'inputComment' => $this->input->post('inputComment')
        );

        // メールテンプレートの読み込み
        $this->config->load('config_mailtpl');                                  // メールテンプレート情報読み込み
        $mail_tpl = $this->config->item('MAILTPL_CONTACT_TOP_ID');

        // メール送信
        $this->load->model('Mailtpl', 'mailtpl', TRUE);
        if ($this->mailtpl->get_mail_tpl($mail, $arrRepList, $mail_tpl)) {
            $this->view('contact/end.tpl');
        } else {
            echo "メール送信エラー";
            $this->view('contact/end.tpl');
        }

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {
            $rule_set = array(
				array(
						'field'   => 'inputName',
						'label'   => '名　前',
						'rules'   => 'trim|required|max_length[50]'
				),
				array(
						'field'   => 'inputEmail',
						'label'   => 'メールアドレス',
						'rules'   => 'trim|required|valid_email'
				),
				array(
						'field'   => 'inputTel',
						'label'   => '連絡先',
						'rules'   => 'trim|regex_match[/^[0-9\-]+$/]|max_length[15]'
				),
				array(
						'field'   => 'inputComment',
						'label'   => 'お問合せ内容',
						'rules'   => 'trim|max_length[100]'
				)
        );

        $this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み
    }

}
