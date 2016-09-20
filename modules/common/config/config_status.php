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
		"9" => "再編集",
		"19" => "掲載停止",
		"20" => "解約",
);

// 画像：ステータス
$config['ADMIN_IMG_STATUS'] =
array(
		"0" => "非表示",
		"1" => "表示",
);

// お客様問合せ返信：ステータス
$config['CLIENT_REPLY_STATUS'] =
array(
		"0" => "未開封",
		"1" => "開封",
		"2" => "対応済",
);

// ブログ：ステータス
$config['CLIENT_BLOG_STATUS'] =
array(
		"0" => "公開",
		"1" => "非公開",
);

// ブログ：コメント
$config['CLIENT_BLOG_COMMENT'] =
array(
		"0" => "コメント受付あり",
		"1" => "コメント受付なし",
);

// 新着お知らせ：ステータス
$config['CLIENT_NEWS_STATUS'] =
array(
		"0" => "表示",
		"1" => "非表示",
);

// 新着お知らせ：タイプ
$config['CLIENT_NEWS_TYPE'] =
array(
		"0" => "新着情報",
		"1" => "お知らせ",
);

// 店舗メニュー：ステータス
$config['TENPO_MENU_STATUS'] =
array(
		"0" => "公開",
		"1" => "非公開",
);

// 店舗クーポン：ステータス
$config['TENPO_COUPON_STATUS'] =
array(
		"0" => "公開",
		"1" => "非公開",
);

// 店舗クーポン：自動更新有無
$config['TENPO_COUPON_UPDATE'] =
array(
		"0" => "更新する",
		"1" => "更新しない",
);

// 店舗ギャラリー画像：ステータス
$config['CLIENT_IMG_STATUS'] =
array(
		"0" => "非表示",
		"1" => "表示",
);

// 店舗ギャラリー分類：ステータス
$config['TENPO_GALLERY_CATE_STATUS'] =
array(
		"0" => "表示",
		"1" => "非表示",
);


// ログインロック
$config['LOGIN_LOCK_STATUS'] =
array(
		"0" => "ロックなし",
		"1" => "ロック状態(ログイン無効)",
);


/* End of file config_comm.php */
/* Location: ./application/config/config_comm.php */