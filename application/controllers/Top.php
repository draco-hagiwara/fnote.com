<?php

//class Top extends CI_Controller {
class Top extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

//         $this->local->library('user_agent');
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

        $this->view('top/index.tpl');

    }

    // ご利用ガイド
    public function guide()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定1
        $this->form_validation->run();

        $this->view('top/guide.tpl');

    }

    // 会社概要
    public function aboutus()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定
        $this->form_validation->run();

        $this->view('top/aboutus.tpl');

    }

    // 個人情報保護方針
    public function privacy()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定
        $this->form_validation->run();

        $this->view('top/privacy.tpl');

    }

    // サイトマップ
    public function sitemap()
    {

        // バリデーション・チェック
        $this->_set_validation();                                            // バリデーション設定
        $this->form_validation->run();

        $this->view('top/sitemap.tpl');

    }

    // 項目 初期値セット
    private function _form_item_set00()
    {

        // ジャンル 選択項目セット
        $this->load->model('comm_select', 'select', TRUE);
        $genre_list = $this->select->get_genre();

        $this->smarty->assign('options_genre_list',   $genre_list);

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {

        $rule_set = array(
        );

        $this->load->library('form_validation', $rule_set);                        // バリデーションクラス読み込み

    }

}

/* End of file top.php */
/* Location: ./application/controllers/top.php */