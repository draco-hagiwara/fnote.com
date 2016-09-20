<?php

class Gallery extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['c_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_Seq',   $_SESSION['c_memSeq']);
            $this->smarty->assign('mem_Name',  $_SESSION['c_memName']);
        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_Seq',   "");
            $this->smarty->assign('mem_Name',  "");

            redirect('/login/');
        }
    }

    // 画像管理 初期表示
    public function index()
    {

    	// セッションデータをクリア
    	$this->load->model('comm_auth', 'comm_auth', TRUE);
    	$this->comm_auth->delete_session('client');

        $this->view('gallery/index.tpl');

    }

    // 画像管理 一覧表示
    public function gd_list()
    {

    	$input_post = $this->input->post();

    	// URIセグメントの取得
    	$segments = $this->uri->segment_array();

    	$this->load->model('Image_gl', 'img', TRUE);

    	// 画像登録・編集処理
    	if (isset($segments[3]) && ($segments[3] == 'nodisp'))
    	{

    		// 非表示処理
    		$set_data["gl_seq"]         = $segments[4];
    		$set_data["gl_status"]      = 0;

    		$this->img->update_image_glseq($set_data);

    		$gd_mode = 'new';

    	} elseif (isset($segments[3]) && ($segments[3] == 'disp')) {

    		// 再表示処理
    		$set_data["gl_seq"]         = $segments[4];
    		$set_data["gl_status"]      = 1;

    		$this->img->update_image_glseq($set_data);

    		$gd_mode = 'new';

    	} elseif (isset($segments[3]) && ($segments[3] == 'edit')) {

    		// 画像編集or削除
    		$gd_mode = 'chg';

    		// 画像リスト読み込み
    		$_SESSION['c_imgseq'] = $segments[4];
    		$img_data = $this->img->get_image_glseq($segments[4]);

    		$this->smarty->assign('list_image', $img_data[0]);

    	} else {

    		// 新規作成
    		$gd_mode = 'new';

    	}


    	// 表示モードを設定 (edit:編集モード/disp:並び替えモード)
    	if (isset($input_post['list_mode']) && ($input_post['list_mode'] == 'sort'))
    	{
    		$list_mode = 'sort';
    	} else {
    		$list_mode = 'edit';
    	}

    	if ($list_mode == 'edit')
    	{

    		// 編集モード

    		// 画像リスト読み込み
    		//$img_data = $this->img->get_image_clseq($_SESSION['c_memSeq']);

    		// 1ページ当たりの表示件数
    		$tmp_per_page = 45;

    		// Pagination 現在ページ数の取得：：URIセグメントの取得
    		//$segments = $this->uri->segment_array();
    		if (isset($segments[3]) && is_numeric($segments[3]))
    		{
    			$tmp_offset = $segments[3];
    		} else {
    			$tmp_offset = 0;
    		}

    		// 画像リスト データを取得
    		list($image_list, $image_countall) = $this->img->get_imagelist($_SESSION['c_memSeq'], $tmp_per_page, $tmp_offset);

    		// Pagination 設定
    		$set_pagination = $this->_get_Pagination($image_countall, $tmp_per_page);

    		$this->smarty->assign('set_pagination', $set_pagination['page_link']);
    		$this->smarty->assign('countall', $image_countall);

    		if ($image_list == FALSE)
    		{
    			$this->smarty->assign('str_html', NULL);
    		} else {
	    		$str_html = array();
	    		foreach ($image_list as $key => $value)
	    		{

	    			$sort_id = $value["gl_seq"];
	    			$create_date = date('Y/m/d', strtotime($value["gl_create_date"]));

	    			if ($value["gl_status"] == 1)
	    			{

	    				// 表示ステータス : lightbox付き
	    				$image_url = '<a class="photo"  href="/images/' . $value["gl_cl_siteid"] . '/b/' . $value["gl_filename"] . '">'
	    							. '<img border="1" src="https://'
	    							. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75"></a>'
	    							. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/nodisp/' . $value["gl_seq"] . '">非表示にする</a>'
	    							. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/edit/' . $value["gl_seq"] . '">[編集・削除]</a> />'
	    							;
// 						$image_url = '<a class="photo"><img border="1" src="https://'
//  									. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75"></a>'
// 									. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/nodisp/' . $value["gl_seq"] . '">非表示にする</a>'
// 									. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/edit/' . $value["gl_seq"] . '">[編集・削除]</a> />'
// 									;


	    				// ヒアドキュメント作成
	    				$str_html[$key] = <<<EOS
		         		<li id="$sort_id">{$create_date}{$image_url}</li>
EOS;

	    			} else {

	    				// 非表示ステータス
	    				$image_url = '<a class="photo"><img border="1" src="https://'
	    							. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75"></a>'
	    							. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/disp/' . $value["gl_seq"] . '">表示する</a>'
	    							. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/edit/' . $value["gl_seq"] . '">[編集・削除]</a>'
	    							. '<div class="hidden_text">非表示中</div> />'
	    							;

	    				$str_html[$key] = <<<EOS
		         		<li class="no_disp" id="$sort_id">{$create_date}{$image_url}</li>
EOS;

	    			}
	    		}

	    		$this->smarty->assign('str_html', $str_html);

    		}

    	} else {

    		// 並び替えモード
	    	if (isset($input_post['result']))
	    	{
		    	$result = $input_post['result'];
		    	$result_array = explode(',', $result);
		    	$hairetu = serialize($result_array);
		    	$nom = 0;


// 		    	print("result_array = ");
// 		    	print_r($result_array);
// 		    	print("<br><br>");


		    	while ( $nom < count($result_array))
		    	{

// 		    			    	print($result_array[$nom]);
// 		    			    	print(" = ");
// 		    					print($nom);
// 		    			    	print("<br>");


		    		$sql = "UPDATE tb_image_gl SET gl_disp_no = " . ($nom + 1)
		    				. " WHERE gl_seq = " . $result_array[$nom] ;

		    		// クエリー実行
		    		$query = $this->db->query($sql);

		    		$nom++;
		    	}

	    	}

	    	// 画像リスト読み込み
	    	$img_data = $this->img->get_image_clseq($_SESSION['c_memSeq']);
    		if ($img_data == FALSE)
    		{
    			$this->smarty->assign('str_html', NULL);
    		} else {
	    		$str_html = array();
		    	foreach ($img_data as $key => $value)
		    	{

		    			$sort_id = $value["gl_seq"];
		    			$create_date = date('Y/m/d', strtotime($value["gl_create_date"]));
		    			$gd_type = $value['gl_type'];
		    			$gd_px   = $value['gl_width'] . ' x ' . $value['gl_height'];
		    			$gd_size = round($value['gl_size'] / 100);

		    			if ($value["gl_status"] == 1)
		    			{

		    				// 表示ステータス
		    				$image_url = '<img border="1" src="https://'
		    							. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75">'
		    							;

		    				$str_html[$key] = <<<EOS
		         								<li id="$sort_id">{$create_date}{$image_url}{$gd_type}<br>{$gd_px}<br>{$gd_size}KB</li>
EOS;

		    			} else {

		    				// 非表示ステータス
		    				$image_url = '<img border="1" src="https://'
		    							. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75"><div class="hidden_text">非表示中</div>'
		    							;

		    				$str_html[$key] = <<<EOS
		         								<li class="no_disp" id="$sort_id">{$create_date}{$image_url}{$gd_type}<br>{$gd_px}<br>{$gd_size}KB</li>
EOS;

		    			}
		    	}

    			$this->smarty->assign('str_html', $str_html);
    			$this->smarty->assign('img_cnt',  count($img_data));

    		}
    	}

    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

    	$this->smarty->assign('gd_mode',   $gd_mode);
    	$this->smarty->assign('list_mode', $list_mode);

    	// 画像カテゴリ読み込み
    	$this->_get_option_imgcate($_SESSION['c_memSeq']);


    	// IEバージョン判定
    	if (preg_match('/(?i)msie [1-9]\./',$_SERVER['HTTP_USER_AGENT']))
    	{
    		$this->smarty->assign('ie_ver', FALSE);
    	} else {
    		$this->smarty->assign('ie_ver', TRUE);
    	}

    	$this->view('gallery/gd_list.tpl');

    }

    // 画像登録 編集削除
    public function gd_edit()
    {

        $input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定

    	$this->load->model('Image_gl', 'img', TRUE);
    	if ($input_post['inlineRadioOptions'] == 0)
    	{

    		// 更新処理
    		$set_data["gl_seq"]         = $_SESSION['c_imgseq'];
    		$set_data["gl_title"]       = $input_post['gl_title'];
    		$set_data["gl_description"] = $input_post['gl_description'];
    		$set_data["gl_tag"]         = $input_post['gl_tag'];
    		$set_data["gl_disp_no"]     = $input_post['gl_disp_no'];
    		$set_data["gl_cate"]        = $input_post['gl_cate'];

    		$this->img->update_image_glseq($set_data);

    	} else {

    		// 削除(データ＆画像)処理：物理的に削除します。
    		$set_data["gl_seq"]         = $_SESSION['c_imgseq'];
    		$this->img->delete_image_seq($set_data);

    		// 存在チェック
    		$dir_path = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['gl_cl_siteid'] . "/b";
    		if (file_exists($dir_path))
    		{
    			$del_flname = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['gl_cl_siteid'] . "/b/" . $input_post['gl_filename'];
    			unlink($del_flname);
    			$del_flname = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['gl_cl_siteid'] . "/b/s_" . $input_post['gl_filename'];
    			unlink($del_flname);
    			$del_flname = $this->input->server("DOCUMENT_ROOT") . "/images/" . $input_post['gl_cl_siteid'] . "/b/t_" . $input_post['gl_filename'];
    			unlink($del_flname);
    		}
    	}

        redirect('/gallery/gd_list/');

    }

    // 画像登録 新規登録  : IE9 以下
    public function gd_new()
    {

    	$input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation02();
    	if ($this->form_validation->run() == FALSE)
    	{
    		$gd_mode   = 'new';
    		$list_mode = 'edit';

    		// 編集モード
    		// 画像リスト読み込み
    		$this->load->model('Image_gl', 'img', TRUE);
    		$img_data = $this->img->get_image_clseq($_SESSION['c_img_clseq']);

    		if ($img_data == FALSE)
    		{
    			$this->smarty->assign('str_html', NULL);
    		} else {
    			$str_html = array();
    			foreach ($img_data as $key => $value)
    			{

    				$sort_id = $value["gl_seq"];
    				$create_date = date('Y/m/d', strtotime($value["gl_create_date"]));

    				if ($value["gl_status"] == 1)
    				{

    					// 表示ステータス : lightbox付き
    					$image_url = '<a class="photo"  href="/images/' . $value["gl_cl_siteid"] . '/b/' . $value["gl_filename"] . '">'
    								. '<img border="1" src="https://'
    								. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75"></a>'
    								. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/nodisp/' . $value["gl_seq"] . '">非表示にする</a>'
    								. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/edit/' . $value["gl_seq"] . '">[編集・削除]</a> />'
    					;


    					// ヒアドキュメント作成
    					$str_html[$key] = <<<EOS
		         		<li id="$sort_id">{$create_date}{$image_url}</li>
EOS;

    				} else {

    					// 非表示ステータス
    					$image_url = '<a class="photo"><img border="1" src="https://'
    								. $this->input->server("SERVER_NAME") . '/images/' . $value["gl_cl_siteid"] . '/b/t_' . $value["gl_filename"] . '" height="75"></a>'
    								. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/disp/' . $value["gl_seq"] . '">表示する</a>'
    								. '<a class="button" href="https://' . $this->input->server("SERVER_NAME") . '/client/gallery/gd_list/edit/' . $value["gl_seq"] . '">[編集・削除]</a>'
    								. '<div class="hidden_text">非表示中</div> />'
    					;

    					$str_html[$key] = <<<EOS
		         		<li class="no_disp" id="$sort_id">{$create_date}{$image_url}</li>
EOS;

    				}
    			}

    			$this->smarty->assign('str_html', $str_html);
    		}

    		$this->smarty->assign('gd_mode', $gd_mode);
    		$this->smarty->assign('list_mode', $list_mode);
    		$this->smarty->assign('img_cnt', count($img_data));

    		$this->view('gallery/gd_list.tpl');
    		return ;

    	} else {

    		// クライアント情報取得
    		$this->load->model('Client', 'cl', TRUE);
    		$cl_data = $this->cl->get_cl_seq($_SESSION['c_img_clseq'], TRUE);

    		require_once('../modules/client/config/config_gallery.php');

    		// 画像の保存先を指定
    		$img_updir = $this->input->server("DOCUMENT_ROOT") . "/images/" . $cl_data[0]['cl_siteid'] . "/b";
    		if (!file_exists($img_updir))
    		{
    			exit("<center>【画像の保存先ディレクトリが存在しません。システム管理者に連絡してください。】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
    		}
    		$extensionTypeList = array('jpg','gif','png');

    		// 登録制限チェック
    		if (count(glob($img_updir . "/*")) >= $max_line)
    		{
    			exit("<center>【登録上限数を超えています。max.500】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
    		}

    		$this->load->library('galleryfun');

    		//----------------------------------------------------------------------
    		//  画像縮小保存処理 GD必須 (START)
    		//----------------------------------------------------------------------
    		// 複数枚の同時登録に対応
    		$cnt = count($_FILES["upfile"]["tmp_name"]);																// 選択されたファイル数をカウント
    		for ($i = 0; $i < $cnt; $i++) {

    			// 各記事にユニークなIDを付与。uniqidが無ければ年月日時分秒
    			$id = $this->galleryfun->generateID();

    			if (is_uploaded_file($_FILES["upfile"]["tmp_name"][$i]))
    			{
    				if ((0 < $_FILES["upfile"]["size"][$i]) && ($_FILES["upfile"]["size"][$i] < $maxImgSize))
    				{
    					$imgType = $_FILES['upfile']['type'][$i];

    					if ($imgType == 'image/gif' || strpos($_FILES['upfile']['name'][$i],'.gif') !== false || strpos($_FILES['upfile']['name'][$i],'.GIF') !== false)
    					{
    						$extension = 'gif';
    						$image = ImageCreateFromGIF($_FILES['upfile']['tmp_name'][$i]); 							// GIFファイルを読み込む
    					} else if ($imgType == 'image/png' || $imgType == 'image/x-png' || strpos($_FILES['upfile']['name'][$i],'.png') !== false || strpos($_FILES['upfile']['name'][$i],'.PNG') !== false)
    					{
    						$extension = 'png';
    						$image = ImageCreateFromPNG($_FILES['upfile']['tmp_name'][$i]); 							// PNGファイルを読み込む
    					} else if ($imgType == 'image/jpeg' || $imgType == 'image/pjpeg' || strpos($_FILES['upfile']['name'][$i],'.jpg') !== false || strpos($_FILES['upfile']['name'][$i],'.JPG') !== false || strpos($_FILES['upfile']['name'][$i],'.jpeg') !== false || strpos($_FILES['upfile']['name'][$i],'.JPEG') !== false)
    					{
    						$extension = 'jpg';
    						$image = ImageCreateFromJPEG($_FILES['upfile']['tmp_name'][$i]); 							// JPEGファイルを読み込む

    						// 画像の回転（iPhoneの縦写真が横写真として保存されてしまう問題の対策）
    						if (function_exists('exif_read_data'))
    						{
    							if ($exif_datas = @exif_read_data($_FILES['upfile']['tmp_name'][$i]))
    							{
    								if (isset($exif_datas['Orientation']))
    								{
    									if ($exif_datas['Orientation'] == 6)
    									{
    										$image = imagerotate($image, 270, 0);
    									} elseif ($exif_datas['Orientation'] == 3)
    									{
    										$image = imagerotate($image, 180, 0);
    									}
    								}
    							}
    						}

    					} else if ($extension == '') {
    						exit("<center>【" . $_FILES['upfile']['name'][$i] . " は許可されていない拡張子です。jpg、gif、pngのいずれかのみです】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
    					}

    					if (strpos($id,'no_disp') !== false)
    					{
    						$file_id = str_replace('no_disp','',$id);
    						$filename = $file_id . "." . $extension;													// ファイル名を指定
    					} else {
    						$filename = $id . "." . $extension;															// ファイル名を指定
    					}

    					// 拡張子違いのファイルを削除
    					$this->galleryfun->fileDelFunc($img_updir,$id);

    					$img_file_path = $img_updir.'/'.$filename;														// ファイルパスを指定
    					$img_file_path_smaho = $img_updir.'/'.'s_'.$filename;											// スマフォファイルパスを指定
    					$img_file_path_thumb = $img_updir.'/'.'t_'.$filename;											// サムネイルファイルパスを指定
    					// $img_file_path_thumb = $img_updir.'/'.'thumb_'.$filename;									// サムネイルファイルパスを指定

    					// 読み込んだ画像のサイズ
    					$width = ImageSX($image);																		// 横幅（ピクセル）
    					$height = ImageSY($image);																		// 縦幅（ピクセル）

    					// 画像の縦または横が$imgWidthHeightより大きい場合は縮小して保存
    					if ($width > $imgWidthHeight or $height > $imgWidthHeight)
    					{
    						if ($height < $width)																		// 横写真の場合の処理
    						{
    							$new_width = $imgWidthHeight; 															// 幅指定px
    							$rate = $new_width / $width; 															// 縦横比を算出
    							$new_height = $rate * $height;

    							// スマホ用処理
    							$new_width_smaho = $imgWidthHeightSmaho;												// 高さ指定px
    							$rate_smaho = $new_width_smaho / $width;												// 縦横比を算出
    							$new_height_smaho = $rate_smaho * $height;

    							// サムネイル用処理
    							$new_width_thumb = $imgWidthHeightThumb;												// 高さ指定px
    							$rate_thumb = $new_width_thumb / $width;												// 縦横比を算出
    							$new_height_thumb = $rate_thumb * $height;

    						} else {																					// 縦写真の場合の処理
    							$new_height = $imgWidthHeight; 															// 高さ指定px
    							$rate = $new_height / $height; 															// 縦横比を算出
    							$new_width = $rate * $width;

    							// スマホ用処理
    							$new_height_smaho = $imgWidthHeightSmaho; 												// 高さ指定px
    							$rate_smaho = $new_height_smaho / $height; 												// 縦横比を算出
    							$new_width_smaho = $rate_smaho * $width;

    							// サムネイル用処理
    							$new_height_thumb = $imgWidthHeightThumb; 												// 高さ指定px
    							$rate_thumb = $new_height_thumb / $height; 												// 縦横比を算出
    							$new_width_thumb = $rate_thumb * $width;
    						}

    						// TrueColor イメージを新規に作成する
    						$new_image = ImageCreateTrueColor($new_width, $new_height);
    						$new_image_smaho = ImageCreateTrueColor($new_width_smaho, $new_height_smaho);				// スマホ作成
    						$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);				// サムネイル作成

    						// 再サンプリングを行いイメージの一部をコピー、伸縮する
    						ImageCopyResampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    						ImageCopyResampled($new_image_smaho, $image, 0, 0, 0, 0, $new_width_smaho, $new_height_smaho, $width, $height);		// スマホ作成
    						ImageCopyResampled($new_image_thumb, $image, 0, 0, 0, 0, $new_width_thumb, $new_height_thumb, $width, $height);		// サムネイル作成

    						if ($extension == 'jpg')
    						{
    							if (!@is_int($img_quality)) $img_quality = 80;											// 画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
    							ImageJPEG($new_image, $img_file_path, $img_quality); 									// 3つ目の引数はクオリティー（0～100）
    							ImageJPEG($new_image_smaho, $img_file_path_smaho, $img_quality); 						// スマホ作成
    							ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); 						// サムネイル作成
    						}
    						elseif ($extension == 'gif') {
    							ImageGIF($new_image, $img_file_path);													// 環境によっては使えない
    							ImageGIF($new_image_smaho, $img_file_path_smaho);										// スマホ作成
    							ImageGIF($new_image_thumb, $img_file_path_thumb);										// サムネイル作成
    						}
    						elseif ($extension == 'png') {
    							ImagePNG($new_image, $img_file_path);
    							ImagePNG($new_image_smaho, $img_file_path_smaho);										// スマホ作成
    							ImagePNG($new_image_thumb, $img_file_path_thumb);										// サムネイル作成
    						}

    						// メモリを解放
    						imagedestroy ($image); 																		// イメージIDの破棄
    						imagedestroy ($new_image); 																	// 元イメージIDの破棄
    						imagedestroy ($new_image_smaho); 															// スマホ元イメージIDの破棄
    						imagedestroy ($new_image_thumb); 															// サムネイル元イメージIDの破棄

    						// 画像が$imgWidthHeightより小さい場合はそのまま保存
    					} else {
    						move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $img_file_path);

    						//----------------------------------------------------------------------
    						//  スマホ生成処理  (START)
    						//----------------------------------------------------------------------
    						// 画像の縦または横がスマホ指定サイズより大きい場合は生成
    						if( $width > $imgWidthHeightSmaho or $height > $imgWidthHeightSmaho)
    						{
    							// 横写真の場合の処理
    							if ($height < $width)
    							{
    								$new_width_smaho = $imgWidthHeightSmaho;											// 高さ指定px
    								$rate_smaho = $new_width_smaho / $width;											// 縦横比を算出
    								$new_height_smaho = $rate_smaho * $height;

    								// 縦写真の場合の処理
    							} else {

    								$new_height_smaho = $imgWidthHeightSmaho; 											// 高さ指定px
    								$rate_smaho = $new_height_smaho / $height; 											// 縦横比を算出
    								$new_width_smaho = $rate_smaho * $width;
    							}

    							$new_image_smaho = ImageCreateTrueColor($new_width_smaho, $new_height_smaho);			// スマホ作成
    							ImageCopyResampled($new_image_smaho, $image, 0, 0, 0, 0, $new_width_smaho, $new_height_smaho, $width, $height);		// スマホ作成

    							if ($extension == 'jpg')
    							{
    								if (!@is_int($img_quality)) $img_quality = 80;										// 画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
    								ImageJPEG($new_image_smaho, $img_file_path_smaho, $img_quality); 					// スマホ作成
    							} elseif ($extension == 'gif') {
    								ImageGIF($new_image_smaho, $img_file_path_smaho);									// スマホ作成
    							} elseif($extension == 'png') {
    								ImagePNG($new_image_smaho, $img_file_path_smaho);									// スマホ作成
    							}

    							imagedestroy ($new_image_smaho); 														// スマホ元イメージIDの破棄

    						} else {
    							//  スマホが設定サイズより小さい場合はそのまま保存
    							copy($img_file_path, $img_file_path_smaho);
    						}

    						//----------------------------------------------------------------------
    						//  スマホ生成処理  (END)
    						//----------------------------------------------------------------------

    						//----------------------------------------------------------------------
    						//  サムネイル生成処理  (START)
    						//----------------------------------------------------------------------
    						//画像の縦または横がサムネイル指定サイズより大きい場合は生成
    						if( $width > $imgWidthHeightThumb or $height > $imgWidthHeightThumb)
    						{
    							// 横写真の場合の処理
    							if ($height < $width)
    							{
    								$new_width_thumb = $imgWidthHeightThumb;											// 高さ指定px
    								$rate_thumb = $new_width_thumb / $width;											// 縦横比を算出
    								$new_height_thumb = $rate_thumb * $height;

    								// 縦写真の場合の処理
    							} else {

    								$new_height_thumb = $imgWidthHeightThumb; 											// 高さ指定px
    								$rate_thumb = $new_height_thumb / $height; 											// 縦横比を算出
    								$new_width_thumb = $rate_thumb * $width;
    							}

    							$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);			// サムネイル作成
    							ImageCopyResampled($new_image_thumb, $image, 0, 0, 0, 0, $new_width_thumb, $new_height_thumb, $width, $height);		// サムネイル作成

    							if ($extension == 'jpg')
    							{
    								if (!@is_int($img_quality)) $img_quality = 80;										// 画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
    								ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); 					// サムネイル作成
    							} elseif ($extension == 'gif') {
    								ImageGIF($new_image_thumb, $img_file_path_thumb);									// サムネイル作成
    							} elseif($extension == 'png') {
    								ImagePNG($new_image_thumb, $img_file_path_thumb);									// サムネイル作成
    							}

    							imagedestroy ($new_image_thumb); 														// サムネイル元イメージIDの破棄

    						} else {
    							// サムネイルが設定サイズより小さい場合はそのまま保存
    							copy($img_file_path, $img_file_path_thumb);
    						}

    						//----------------------------------------------------------------------
    						//  サムネイル生成処理  (END)
    						//----------------------------------------------------------------------

    					}

    					@chmod($img_file_path, 0666);
    					@chmod($img_file_path_smaho, 0666);
    					@chmod($img_file_path_thumb, 0666);

    					// DB書き込み用
    					$_size   = getimagesize ($img_file_path);														// 画像の大きさを取得

    					$setdate['gl_width']  = $_size[0];
    					$setdate['gl_height'] = $_size[1];
    					$setdate['gl_size']   = filesize($img_file_path);

    					// DBへ書き出す
    					//$setdate['gl_title']       = $input_post['gl_title'];
    					//$setdate['gl_description'] = $input_post['gl_description'];
    					//$setdate["gl_tag"]         = $input_post['gl_tag'];
    					$setdate['gl_status']      = 1;
    					$setdate['gl_type']        = $imgType;
    					$setdate['gl_filename']    = $filename;
    					$setdate['gl_cl_seq']      = $_SESSION['c_img_clseq'];
    					$setdate['gl_cl_siteid']   = $cl_data[0]['cl_siteid'];

    					// 店舗データの取得
    					$this->load->model('Tenpoinfo', 'tnp',  TRUE);
    					$tenpo_data = $this->tnp->get_tenpo_siteid($_SESSION['c_memSiteid']);
    					$setdate['gl_tp_seq']      = $tenpo_data[0]['tp_seq'];

    					$this->load->model('Image_gl', 'img', TRUE);
    					$_row_id = $this->img->insert_image($setdate);
    					if (!is_numeric($_row_id))
    					{
    						log_message('error', 'gallery::[gd_new()]店舗ギャラリー登録処理 insert_imageエラー');
    					}

    				} else {
    					$maxImgSize = number_format($maxImgSize);
    					exit("<center>【" . $_FILES['upfile']['name'][$i] . " は画像がファイルサイズオーバーです。{$maxImgSize}バイト以下にして下さい】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
    				}

    			} elseif (0 >= $_FILES["upfile"]["size"][$i]) {
    				exit("<center>【" . $_FILES['upfile']['name'][$i] . " は画像ファイルサイズが　0バイトです。】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
    			} else {
    				exit("<center>【アップロードする画像が選択されていません。】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
    			}
    		}

    		//----------------------------------------------------------------------
    		//  画像縮小保存処理 GD必須 (END)
    		//----------------------------------------------------------------------

    	}

    	$this->smarty->assign('cl_seq', $_SESSION['c_img_clseq']);

    	redirect('/gallery/gd_list/');

    }

    // 画像登録 新規登録 (Drag & Drop) : IE10以上
    public function gd_new_dd()
    {

    	$input_post = $this->input->post();

    	// バリデーション・チェック
    	$this->_set_validation02();

        // クライアント情報取得
        $this->load->model('Client', 'cl', TRUE);
        $cl_data = $this->cl->get_cl_seq($_SESSION['c_memSeq'], TRUE);

        // 画像アップ時初期設定ファイル
        require_once('../modules/client/config/config_gallery.php');

        // 画像の保存先を指定
        $img_updir = $this->input->server("DOCUMENT_ROOT") . "/images/" . $cl_data[0]['cl_siteid'] . "/b";
        if (!file_exists($img_updir))
        {
            exit("【画像の保存先ディレクトリが存在しません。システム管理者に連絡してください。】");
        }
        $extensionTypeList = array('jpg','gif','png');

        // 登録制限チェック
        if (count(glob($img_updir . "/*")) >= $max_line)
        {
            exit("【登録上限数を超えています。max.500】");
        }

        $this->load->library('galleryfun');


        //----------------------------------------------------------------------
        //  画像縮小保存処理 GD必須 (START)
        //----------------------------------------------------------------------
        // 複数枚の同時登録に対応
        $cnt = count($_FILES["files"]["tmp_name"]);                                                                     // 選択されたファイル数をカウント
        for ($i = 0; $i < $cnt; $i++) {

            // 各記事にユニークなIDを付与。uniqidが無ければ年月日時分秒
            $id = $this->galleryfun->generateID();

            if (is_uploaded_file($_FILES["files"]["tmp_name"][$i]))
            {
                if ((0 < $_FILES["files"]["size"][$i]) && ($_FILES["files"]["size"][$i] < $maxImgSize))
                {
                    $imgType = $_FILES['files']['type'][$i];

                    if ($imgType == 'image/gif' || strpos($_FILES['files']['name'][$i],'.gif') !== false || strpos($_FILES['files']['name'][$i],'.GIF') !== false)
                    {
                        $extension = 'gif';
                        $image = ImageCreateFromGIF($_FILES['files']['tmp_name'][$i]);                                  // GIFファイルを読み込む
                    } else if ($imgType == 'image/png' || $imgType == 'image/x-png' || strpos($_FILES['files']['name'][$i],'.png') !== false || strpos($_FILES['files']['name'][$i],'.PNG') !== false)
                    {
                        $extension = 'png';
                        $image = ImageCreateFromPNG($_FILES['files']['tmp_name'][$i]);                                  // PNGファイルを読み込む
                    } else if ($imgType == 'image/jpeg' || $imgType == 'image/pjpeg' || strpos($_FILES['files']['name'][$i],'.jpg') !== false || strpos($_FILES['files']['name'][$i],'.JPG') !== false || strpos($_FILES['files']['name'][$i],'.jpeg') !== false || strpos($_FILES['files']['name'][$i],'.JPEG') !== false)
                    {
                        $extension = 'jpg';
                        $image = ImageCreateFromJPEG($_FILES['files']['tmp_name'][$i]);                                 // JPEGファイルを読み込む

                        // 画像の回転（iPhoneの縦写真が横写真として保存されてしまう問題の対策）
                        if (function_exists('exif_read_data'))
                        {
                            if ($exif_datas = @exif_read_data($_FILES['files']['tmp_name'][$i]))
                            {
                                if (isset($exif_datas['Orientation']))
                                {
                                    if ($exif_datas['Orientation'] == 6)
                                    {
                                        $image = imagerotate($image, 270, 0);
                                    } elseif ($exif_datas['Orientation'] == 3)
                                    {
                                        $image = imagerotate($image, 180, 0);
                                    }
                                }
                            }
                        }

                    } else if ($extension == '') {
                        exit("【" . $_FILES['files']['name'][$i] . " は許可されていない拡張子です。jpg、gif、pngのいずれかのみです】");
                    }

                    if (strpos($id,'no_disp') !== false)
                    {
                        $file_id = str_replace('no_disp','',$id);
                        $filename = $file_id . "." . $extension;                                                        // ファイル名を指定
                    } else {
                        $filename = $id . "." . $extension;                                                             // ファイル名を指定
                    }

                    // 拡張子違いのファイルを削除
                    $this->galleryfun->fileDelFunc($img_updir,$id);

                    $img_file_path = $img_updir.'/'.$filename;                                                          // ファイルパスを指定
                    $img_file_path_smaho = $img_updir.'/'.'s_'.$filename;                                               // スマフォファイルパスを指定
                    $img_file_path_thumb = $img_updir.'/'.'t_'.$filename;                                               // サムネイルファイルパスを指定
                    // $img_file_path_thumb = $img_updir.'/'.'thumb_'.$filename;                                        // サムネイルファイルパスを指定

                    // 読み込んだ画像のサイズ
                    $width = ImageSX($image);                                                                           // 横幅（ピクセル）
                    $height = ImageSY($image);                                                                          // 縦幅（ピクセル）

                    // 画像の縦または横が$imgWidthHeightより大きい場合は縮小して保存
                    if ($width > $imgWidthHeight or $height > $imgWidthHeight)
                    {
                        if ($height < $width)                                                                           // 横写真の場合の処理
                        {
                            $new_width = $imgWidthHeight;                                                               // 幅指定px
                            $rate = $new_width / $width;                                                                // 縦横比を算出
                            $new_height = $rate * $height;

                            // スマホ用処理
                            $new_width_smaho = $imgWidthHeightSmaho;                                                    // 高さ指定px
                            $rate_smaho = $new_width_smaho / $width;                                                    // 縦横比を算出
                            $new_height_smaho = $rate_smaho * $height;

                            // サムネイル用処理
                            $new_width_thumb = $imgWidthHeightThumb;                                                    // 高さ指定px
                            $rate_thumb = $new_width_thumb / $width;                                                    // 縦横比を算出
                            $new_height_thumb = $rate_thumb * $height;

                        } else {                                                                                        // 縦写真の場合の処理
                            $new_height = $imgWidthHeight;                                                              // 高さ指定px
                            $rate = $new_height / $height;                                                              // 縦横比を算出
                            $new_width = $rate * $width;

                            // スマホ用処理
                            $new_height_smaho = $imgWidthHeightSmaho;                                                   // 高さ指定px
                            $rate_smaho = $new_height_smaho / $height;                                                  // 縦横比を算出
                            $new_width_smaho = $rate_smaho * $width;

                            // サムネイル用処理
                            $new_height_thumb = $imgWidthHeightThumb;                                                   // 高さ指定px
                            $rate_thumb = $new_height_thumb / $height;                                                  // 縦横比を算出
                            $new_width_thumb = $rate_thumb * $width;
                        }

                        // TrueColor イメージを新規に作成する
                        $new_image = ImageCreateTrueColor($new_width, $new_height);
                        $new_image_smaho = ImageCreateTrueColor($new_width_smaho, $new_height_smaho);                   // スマホ作成
                        $new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);                   // サムネイル作成

                        // 再サンプリングを行いイメージの一部をコピー、伸縮する
                        ImageCopyResampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                        ImageCopyResampled($new_image_smaho, $image, 0, 0, 0, 0, $new_width_smaho, $new_height_smaho, $width, $height);        // スマホ作成
                        ImageCopyResampled($new_image_thumb, $image, 0, 0, 0, 0, $new_width_thumb, $new_height_thumb, $width, $height);        // サムネイル作成

                        if ($extension == 'jpg')
                        {
                            if (!@is_int($img_quality)) $img_quality = 80;                                              // 画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
                            ImageJPEG($new_image, $img_file_path, $img_quality);                                        // 3つ目の引数はクオリティー（0～100）
                            ImageJPEG($new_image_smaho, $img_file_path_smaho, $img_quality);                            // スマホ作成
                            ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality);                            // サムネイル作成
                        }
                        elseif ($extension == 'gif') {
                            ImageGIF($new_image, $img_file_path);                                                       // 環境によっては使えない
                            ImageGIF($new_image_smaho, $img_file_path_smaho);                                           // スマホ作成
                            ImageGIF($new_image_thumb, $img_file_path_thumb);                                           // サムネイル作成
                        }
                        elseif ($extension == 'png') {
                            ImagePNG($new_image, $img_file_path);
                            ImagePNG($new_image_smaho, $img_file_path_smaho);                                           // スマホ作成
                            ImagePNG($new_image_thumb, $img_file_path_thumb);                                           // サムネイル作成
                        }

                        // メモリを解放
                        imagedestroy ($image);                                                                          // イメージIDの破棄
                        imagedestroy ($new_image);                                                                      // 元イメージIDの破棄
                        imagedestroy ($new_image_smaho);                                                                // スマホ元イメージIDの破棄
                        imagedestroy ($new_image_thumb);                                                                // サムネイル元イメージIDの破棄

                    // 画像が$imgWidthHeightより小さい場合はそのまま保存
                    } else {
                        move_uploaded_file($_FILES['files']['tmp_name'][$i], $img_file_path);

                        //----------------------------------------------------------------------
                        //  スマホ生成処理  (START)
                        //----------------------------------------------------------------------
                        // 画像の縦または横がスマホ指定サイズより大きい場合は生成
                        if( $width > $imgWidthHeightSmaho or $height > $imgWidthHeightSmaho)
                        {
                            // 横写真の場合の処理
                            if ($height < $width)
                            {
                                $new_width_smaho = $imgWidthHeightSmaho;                                                // 高さ指定px
                                $rate_smaho = $new_width_smaho / $width;                                                // 縦横比を算出
                                $new_height_smaho = $rate_smaho * $height;

                                // 縦写真の場合の処理
                            } else {

                                $new_height_smaho = $imgWidthHeightSmaho;                                               // 高さ指定px
                                $rate_smaho = $new_height_smaho / $height;                                              // 縦横比を算出
                                $new_width_smaho = $rate_smaho * $width;
                            }

                            $new_image_smaho = ImageCreateTrueColor($new_width_smaho, $new_height_smaho);               // スマホ作成
                            ImageCopyResampled($new_image_smaho, $image, 0, 0, 0, 0, $new_width_smaho, $new_height_smaho, $width, $height);        // スマホ作成

                            if ($extension == 'jpg')
                            {
                                if (!@is_int($img_quality)) $img_quality = 80;                                          // 画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
                                ImageJPEG($new_image_smaho, $img_file_path_smaho, $img_quality);                        // スマホ作成
                            } elseif ($extension == 'gif') {
                                ImageGIF($new_image_smaho, $img_file_path_smaho);                                       // スマホ作成
                            } elseif($extension == 'png') {
                                ImagePNG($new_image_smaho, $img_file_path_smaho);                                       // スマホ作成
                            }

                            imagedestroy ($new_image_smaho);                                                            // スマホ元イメージIDの破棄

                        } else {
                            //  スマホが設定サイズより小さい場合はそのまま保存
                            copy($img_file_path, $img_file_path_smaho);
                        }

                        //----------------------------------------------------------------------
                        //  スマホ生成処理  (END)
                        //----------------------------------------------------------------------

                        //----------------------------------------------------------------------
                        //  サムネイル生成処理  (START)
                        //----------------------------------------------------------------------
                        //画像の縦または横がサムネイル指定サイズより大きい場合は生成
                        if( $width > $imgWidthHeightThumb or $height > $imgWidthHeightThumb)
                        {
                            // 横写真の場合の処理
                            if ($height < $width)
                            {
                                $new_width_thumb = $imgWidthHeightThumb;                                                // 高さ指定px
                                $rate_thumb = $new_width_thumb / $width;                                                // 縦横比を算出
                                $new_height_thumb = $rate_thumb * $height;

                            // 縦写真の場合の処理
                            } else {

                                $new_height_thumb = $imgWidthHeightThumb;                                               // 高さ指定px
                                $rate_thumb = $new_height_thumb / $height;                                              // 縦横比を算出
                                $new_width_thumb = $rate_thumb * $width;
                            }

                            $new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);               // サムネイル作成
                            ImageCopyResampled($new_image_thumb, $image, 0, 0, 0, 0, $new_width_thumb, $new_height_thumb, $width, $height);        // サムネイル作成

                            if ($extension == 'jpg')
                            {
                                if (!@is_int($img_quality)) $img_quality = 80;                                          // 画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
                                ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality);                        // サムネイル作成
                            } elseif ($extension == 'gif') {
                                ImageGIF($new_image_thumb, $img_file_path_thumb);                                       // サムネイル作成
                            } elseif($extension == 'png') {
                                ImagePNG($new_image_thumb, $img_file_path_thumb);                                       // サムネイル作成
                            }

                            imagedestroy ($new_image_thumb);                                                            // サムネイル元イメージIDの破棄

                        } else {
                            // サムネイルが設定サイズより小さい場合はそのまま保存
                            copy($img_file_path, $img_file_path_thumb);
                        }

                        //----------------------------------------------------------------------
                        //  サムネイル生成処理  (END)
                        //----------------------------------------------------------------------

                    }

                    @chmod($img_file_path, 0666);
                    @chmod($img_file_path_smaho, 0666);
                    @chmod($img_file_path_thumb, 0666);

                    // DB書き込み用
                    $_size   = getimagesize ($img_file_path);                                                           // 画像の大きさを取得

                    $setdate['gl_width']  = $_size[0];
                    $setdate['gl_height'] = $_size[1];
                    $setdate['gl_size']   = filesize($img_file_path);

                    // DBへ書き出す
                    //$setdate['gl_title']       = $input_post['gl_title'];
                    //$setdate['gl_description'] = $input_post['gl_description'];
                    //$setdate["gl_tag"]         = $input_post['gl_tag'];
                    $setdate['gl_status']      = 1;
                    $setdate['gl_type']        = $imgType;
                    $setdate['gl_filename']    = $filename;
                    $setdate['gl_cl_seq']      = $_SESSION['c_memSeq'];
                    $setdate['gl_cl_siteid']   = $cl_data[0]['cl_siteid'];

                    // 店舗データの取得
                    $this->load->model('Tenpoinfo', 'tnp',  TRUE);
                    $tenpo_data = $this->tnp->get_tenpo_siteid($_SESSION['c_memSiteid']);
                    $setdate['gl_tp_seq']      = $tenpo_data[0]['tp_seq'];

                    $this->load->model('Image_gl', 'img', TRUE);
                    $_row_id = $this->img->insert_image($setdate);
                    if (!is_numeric($_row_id))
                    {
                        log_message('error', 'gallery::[gd_new_dd()]店舗ギャラリー画像登録処理 insert_imageエラー');
                    }

                } elseif (0 >= $_FILES["files"]["size"][$i]) {
                    exit("<center>【" . $_FILES['upfile']['name'][$i] . " は画像ファイルサイズが　0バイトです。】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
                } else {
                    $maxImgSize = number_format($maxImgSize);
                    exit("<center>【アップロードする画像が選択されていません。】<br /><br /><a href='gd_list'>戻る&gt;&gt;</a></center>");
                }

            } else {
                exit("【アップロードする画像が選択されていません。】");
            }
        }

        //----------------------------------------------------------------------
        //  画像縮小保存処理 GD必須 (END)
        //----------------------------------------------------------------------


    	$this->smarty->assign('cl_seq', $_SESSION['c_memSeq']);

    	redirect('/gallery/gd_list/');

    }

    // 画像カテゴリリストの取得
    private function _get_option_imgcate($cl_seq)
    {

    	$_arr_opt_imgcate = array('' => '選択してください');

    	$this->load->model('Cate_image', 'cate_img', TRUE);
    	$get_image_cate = $this->cate_img->get_cate_image_clseq($cl_seq);

    	$cnt = 0;
    	$_arr_opt_imgcate = array('' => '選択してください');
    	if ($get_image_cate[0]['ci_status01'] == 0)
    	{
    		$_arr_opt_imgcate[$cnt] = $get_image_cate[0]['ci_name01'];
    		$cnt++;
    	}
    	if ($get_image_cate[0]['ci_status02'] == 0)
    	{
    		$_arr_opt_imgcate[$cnt] = $get_image_cate[0]['ci_name02'];
    		$cnt++;
    	}
    	if ($get_image_cate[0]['ci_status03'] == 0)
    	{
    		$_arr_opt_imgcate[$cnt] = $get_image_cate[0]['ci_name03'];
    		$cnt++;
    	}
    	if ($get_image_cate[0]['ci_status04'] == 0)
    	{
    		$_arr_opt_imgcate[$cnt] = $get_image_cate[0]['ci_name04'];
    		$cnt++;
    	}
    	if ($get_image_cate[0]['ci_status05'] == 0)
    	{
    		$_arr_opt_imgcate[$cnt] = $get_image_cate[0]['ci_name05'];
    		$cnt++;
    	}

    	$this->smarty->assign('opt_imgcate', $_arr_opt_imgcate);

    	return;

    }

    // Pagination 設定
    private function _get_Pagination($countall, $tmp_per_page)
    {

    	$config['base_url']       = base_url() . '/gallery/gd_list/';			// ページの基本URIパス。「/コントローラクラス/アクションメソッド/」
    	$config['per_page']       = $tmp_per_page;								// 1ページ当たりの表示件数。
    	$config['total_rows']     = $countall;									// 総件数。where指定するか？
    	//$config['uri_segment']    = 4;										// オフセット値がURIパスの何セグメント目とするか設定
    	$config['num_links']      = 5;											//現在のページ番号の左右にいくつのページ番号リンクを生成するか設定
    	$config['full_tag_open']  = '<p class="pagination">';					// ページネーションリンク全体を階層化するHTMLタグの先頭タグ文字列を指定
    	$config['full_tag_close'] = '</p>';										// ページネーションリンク全体を階層化するHTMLタグの閉じタグ文字列を指定
    	$config['first_link']     = '最初へ';									// 最初のページを表すテキスト。
    	$config['last_link']      = '最後へ';									// 最後のページを表すテキスト。
    	$config['prev_link']      = '前へ';										// 前のページへのリンクを表わす文字列を指定
    	$config['next_link']      = '次へ';										// 次のページへのリンクを表わす文字列を指定

    	$this->load->library('pagination', $config);							// Paginationクラス読み込み
    	$set_page['page_link'] = $this->pagination->create_links();

    	return $set_page;

    }

    // フォーム・バリデーションチェック
    private function _set_validation()
    {

    	$rule_set = array(
    			array(
    					'field'   => 'gl_title',
    					'label'   => 'タイトル（alt）',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'gl_description',
    					'label'   => '画像説明',
    					'rules'   => 'trim|max_length[255]'
    			),
    			array(
    					'field'   => 'gl_tag',
    					'label'   => 'タグ',
    					'rules'   => 'trim|max_length[20]'
    			),
    			array(
    					'field'   => 'gl_disp_no',
    					'label'   => '表示順序指定',
    					'rules'   => 'trim|numeric|max_length[99999]'
    			),
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

    // フォーム・バリデーションチェック
    private function _set_validation02()
    {

    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

}
