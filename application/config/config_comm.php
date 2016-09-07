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


// ログ：ユーザ種類
$config['LOG_USER_TYPE'] =
array(
		"1" => "System管理者",
		"2" => "Adminユーザ",
		"3" => "Clientユーザ",
		"4" => "会員",
		"5" => "ビジター",
);

// 店舗クーポン：デザインテンプレート
$config['TENPO_COUPON_DESIGN'] =
array(
		"1" => "デザイン１",
		"2" => "デザイン２",
		"3" => "デザイン３",
		"4" => "デザイン４",
		"5" => "デザイン５",
);

$config['TENPO_COUPON_TEMPLATE'] =
array(
		"1" => "coupon_tenplate01.png",
		"2" => "coupon_tenplate02.png",
		"3" => "coupon_tenplate03.png",
		"4" => "coupon_tenplate04.png",
		"5" => "coupon_tenplate05.png",
);


// Pagination 設定:1ページ当たりの表示件数
// ※ ～/system/libraries/Pagination.php に不具合あり
$config['PAGINATION_PER_PAGE'] = '5';


/* End of file config_comm.php */
/* Location: ./application/config/config_comm.php */