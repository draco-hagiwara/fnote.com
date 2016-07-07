<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Common STATUS
| -------------------------------------------------------------------
*/


// アカウント登録状態
$config['ADMIN_ACCOUNT_STATUS'] =
array(
        ''  => '選択してください',
		"0" => "登録中",
		"1" => "有効",
		"9" => "無効",
);

// クライアント登録状態
$config['CLIENT_ACCOUNT_STATUS'] =
array(
		''  => '選択してください',
		"0" => "登録中",
		"1" => "審査",
		"2" => "受注",
		"3" => "取材",
		"4" => "編集",
		"5" => "営業確認",
		"6" => "クライアント確認",
		"7" => "編集最終確認",
		"8" => "掲載",
		"9" => "解約",
);




/* End of file config_comm.php */
/* Location: ./application/config/config_comm.php */