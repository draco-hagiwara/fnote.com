<?php

class Top extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['a_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_type',  $_SESSION['a_memType']);
            $this->smarty->assign('mem_Seq',   $_SESSION['a_memSeq']);
            //             $this->smarty->assign('login_name', $_SESSION['a_memNAME']);
//             $this->smarty->assign('auth_cd',    $_SESSION['a_authCD']);
// $_SESSION['a_login'] = FALSE;
// print_r($_SESSION['a_memID']);
// exit;
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_type',  "");
            $this->smarty->assign('mem_Seq',   "");
            //             $this->smarty->assign('login_name', '');

            redirect('/login/');
        }

    }

    // ログイン 初期表示
    public function index()
    {

//         // セッションデータをクリア
//         $this->load->model('comm_auth', 'comm_auth', TRUE);
//         $this->comm_auth->delete_session('admin');

        $this->view('top/index.tpl');

    }

}
