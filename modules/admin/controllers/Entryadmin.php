<?php

class Entryadmin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    // ログイン 初期表示
    public function index()
    {

        $this->view('entryadmin/index.tpl');

    }

}
