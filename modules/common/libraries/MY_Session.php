<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {

	public function __construct()
	{
		$CI = get_instance();

		// CLIからはセッションクラスを読み込まない
		if ($CI->input->is_cli_request()) {
			return;
		}

		parent::__construct();
	}
    
    /**
     * 古いセッションを削除する。古いレコードを削除します。
     * @param  string $maxlifetime セッションのライフタイム session.gc_maxlifetimeの値
     * @return bool
     */
    function gc($maxlifetime)
    {
    	$_st_day = date("Y-m-d H:i:s", time());
        
        $maxlifetime = preg_replace('/[^0-9]/', '', $maxlifetime);
        $sql = "DELETE FROM ci_sessions WHERE (TIMESTAMP(CURRENT_TIMESTAMP) - timestamp) > ${maxlifetime}" ;

        // クエリー実行
        $res = $this->db->query($sql);

    	$_ed_day = date("Y-m-d H:i:s", time());
    	log_message('info', 'sess::** セッションデータ削除 ** ' . $_st_day . ' => ' . $_ed_day);

        return true;
    }
}