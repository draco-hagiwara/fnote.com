<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Common SETTINGS
| -------------------------------------------------------------------
*/

// ログインメンバー
$config['LOGIN_CLIENT']     = 'client';                     // クライアント
$config['LOGIN_ADMIN']      = 'admin';                      // 管理者

// 管理者種類
$config['ADMIN_ACCOUNT_TYPE'] =
array(
        ''  => '選択してください',
		"0" => "Editor (編集者)",
		"1" => "Salse (営業)",
		"2" => "Admin (管理者)",
);






// 管理者：仮登録制限時間デフォルト値
$config['ADMIN_ADD_LIMITTIME'] = '6024';								// 「分」指定 (24h)






/* End of file config_comm.php */
/* Location: ./application/config/config_comm.php */