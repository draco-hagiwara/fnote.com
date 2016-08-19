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

// カテゴリ：初期表示（selectリスト内で一番上に表示されるカテゴリを指定）
$config['CATEGORY_INI_BIG'] = "22";										// 大カテゴリ：初期値「その他」
$config['CATEGORY_INI_MED'] = "23";										// 中カテゴリ：初期値「その他」
$config['CATEGORY_INI_SML'] = "24";										// 小カテゴリ：初期値「その他」
// $config['CATEGORY_INI_BIG'] = "1";										// 大カテゴリ：初期値「グルメ」
// $config['CATEGORY_INI_MED'] = "4";										// 中カテゴリ：初期値「飲み屋」
// $config['CATEGORY_INI_SML'] = "10";										// 小カテゴリ：初期値「居酒屋」





// 管理者：仮登録制限時間デフォルト値
// $config['ADMIN_ADD_LIMITTIME'] = '60';									// 「分」指定 (60)
$config['ADMIN_ADD_LIMITTIME'] = '6024';								// 「分」指定 (24h)

// クライアント：仮登録制限時間デフォルト値
// $config['CLIENT_ADD_LIMITTIME'] = '60';									// 「分」指定 (60)
$config['CLIENT_ADD_LIMITTIME'] = '6024';								// 「分」指定 (24h)




// ログインロック：失敗回数
$config['LOGIN_LOCK_CNT']         = '5';								// 回数)
// ログインロック：制限時間
$config['LOGIN_LOCK_LIMITTIME']   = '120';								// 「分」指定
// ログインロック：解除時間
$config['LOGIN_LOCK_RELEASETIME'] = '120';								// 「分」指定







// ログ：ユーザ種類
$config['LOG_USER_TYPE'] =
array(
		"1" => "System管理者",
		"2" => "Adminユーザ",
		"3" => "Clientユーザ",
		"4" => "会員",
		"5" => "ビジター",
);



// Pagination 設定:1ページ当たりの表示件数
// ※ ～/system/libraries/Pagination.php に不具合あり
$config['PAGINATION_PER_PAGE'] = '5';


/* End of file config_comm.php */
/* Location: ./application/config/config_comm.php */