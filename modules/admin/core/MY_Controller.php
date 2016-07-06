<?php

class MY_Controller extends CI_Controller {
    protected $template;

    public function __construct()
    {
        parent::__construct();

//         // ログイン有無チェック
//         if ($_SESSION['a_login'] == TRUE) {
//         	$this->smarty->assign('login_chk', $_SESSION['a_login']);
//         } else {
//         	$this->smarty->assign('login_chk', FALSE);
//         }

        // Smarty 設定
        $this->smarty->template_dir = APPPATH . 'views/contents';
        $this->smarty->compile_dir  = APPPATH . 'views/templates_c';
        $this->template = 'layout.tpl';

    }

    public function view($template)
    {
        $this->template = $template;
    }

    public function _output($output)
    {
        if (strlen($output) > 0) {
            echo $output;
        } else {
            $this->smarty->display($this->template);
        }
    }
}