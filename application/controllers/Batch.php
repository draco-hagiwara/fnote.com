<?php

class Batch extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // CLI実行かのチェック :: URIからの直接実行拒否
        if (!is_cli()) {
            log_message('error', 'CLI以外からのアクセスがありました。');
            show_404();
        }
    }

    /**
     *  「分」間隔バッチのメイン処理
     */
    public function minute_bat()
    {


    }

    /**
     *  「時::夜間(02:10)」バッチのメイン処理
     */
    public function hour_bat()
    {

    	$_st_day = date("Y-m-d H:i:s", time());

    	// DB & PG のバックアップ処理
    	$this->_system_backup();

    	// セッション情報削除 (一か月前)
    	$this->_sess_destroy();

    	$_ed_day = date("Y-m-d H:i:s", time());
    	log_message('info', 'bat::** 夜間バッチ ** ' . $_st_day . ' => ' . $_ed_day);
    }

    /**
     *  「日」間隔バッチのメイン処理
     */
    public function day_bat()
    {

    }


    /**
     *  DB & PG のシステムバックアップ処理
     */
    public function _system_backup()
    {

    	$time = time();
    	$_set_time = date("Y-m-d H:i:s", $time);

        // インストールパスを取得 :: /home/fnote/www/fnote.com.dev/dbbackup
        $this->load->helper('path');
        $root_path = '../';
        $base_path = set_realpath($root_path);

		// sh に記述
        $strCommand = $base_path . 'dbbackup/backup4mysql.sh';
    	exec( $strCommand );

    	$strCommand = $base_path . 'dbbackup/backup4pg.sh';
    	exec( $strCommand );

    	// ログ出力
    	$_ed_time = date("Y-m-d H:i:s", time());
    	log_message('info', 'bat::バックアップ処理が実行されました。' . $_set_time . ' => ' . $_ed_time);

    }

    /**
     *  セッション情報削除 (一か月前)
     */
    public function _sess_destroy()
    {

    	$time = time();
    	$_set_time = date("Y-m-d H:i:s", $time);

    	// 一か月前のセッションを削除
    	$now_time = time();
    	$del_time = strtotime('-1 month' , $now_time);

    	$this->load->model('Ci_sessions', 'sess', TRUE);
    	$this->sess->destroy_session($del_time);

    	// ログ出力
    	$_ed_time = date("Y-m-d H:i:s", time());
    	log_message('info', 'bat::セッション情報削除が実行されました。' . $_set_time . ' => ' . $_ed_time);

    }


}