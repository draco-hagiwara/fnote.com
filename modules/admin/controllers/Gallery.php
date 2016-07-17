<?php

class Gallery extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($_SESSION['a_login'] == TRUE)
        {
            $this->smarty->assign('login_chk', TRUE);
            $this->smarty->assign('mem_type',  $_SESSION['a_memType']);
            $this->smarty->assign('mem_Seq',   $_SESSION['a_memSeq']);

//             require_once('../modules/admin/config/config_gallery.php');
            $this->load->library('galleryfun');                            		// バリデーションクラス読み込み

        } else {
            $this->smarty->assign('login_chk', FALSE);
            $this->smarty->assign('mem_type',  "");
            $this->smarty->assign('mem_Seq',   "");

            redirect('/login/');
        }

    }

    // 画像管理 初期表示
    public function index()
    {

        $this->view('gallery/index.tpl');

    }

    // 画像管理 一覧表示
    public function gd_list()
    {


    	$input_post = $this->input->post();


//     	print_r($input_post);
//     	print("<br>");




    	if (isset($input_post['result']))
    	{
	    	$result = $input_post['result'];
	    	$result_array = explode(',', $result);
	    	$hairetu = serialize($result_array);
	    	$nom = 0;


// 	    	print("result_array = ");
// 	    	print_r($result_array);
// 	    	print("<br><br>");


	    	while ( $nom < count($result_array))
	    	{

// 	    			    	print($result_array[$nom]);
// 	    			    	print(" = ");
// 	    					print($nom);
// 	    			    	print("<br>");


	    		$sql = "UPDATE tb_image SET im_disp_no = " . ($nom + 1)
	    				. " WHERE im_seq = " . $result_array[$nom] ;

	    		// クエリー実行
	    		$query = $this->db->query($sql);

	    		$nom++;
	    	}

    	}



    	// 画像リスト読み込み
    	$this->load->model('Image', 'img', TRUE);
    	$img_data = $this->img->get_image_clseq($input_post['chg_uniq']);

    	$str_html = array();
    	foreach ($img_data as $key => $value)
    	{

    			$sort_id = $value["im_seq"];
    			$image_url = '<img border="1" src="https://fnote.com.dev/images/fnote/s/thumb_' . $value["im_filename"] . '" height="75">';

    			$str_html[$key] = <<<EOS
         		<li class="ns" id="$sort_id">{$image_url}</li>
EOS;
    	}


//     	print_r($str_html);
//     	print("<br>");




    	// バリデーション・チェック
    	$this->_set_validation02();												// バリデーション設定

    	$this->smarty->assign('chg_uniq', $input_post['chg_uniq']);
    	$this->smarty->assign('str_html', $str_html);
    	$this->view('gallery/gd_list.tpl');

    }

    // 画像登録 初期表示
    public function gd_add()
    {

    	$input_post = $this->input->post();


    	print_r($input_post);
    	print("<br><br>");


//     	require_once('../modules/admin/config/config_gallery.php');

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定


    	$this->smarty->assign('cl_seq', $input_post['chg_uniq']);

    	$this->view('gallery/gd_add.tpl');

    }

    // 画像登録 新規登録
    public function gd_new()
    {

    	$input_post = $this->input->post();


// print_r($input_post);
// print("<br><br>");




    	// バリデーション・チェック
    	$this->_set_validation();
    	if ($this->form_validation->run() == FALSE)
    	{
    		$this->view('gallery/create.tpl');
    		return ;
    	} else {

    		// クライアント情報取得
    		$this->load->model('Client', 'cl', TRUE);
    		$cl_data = $this->cl->get_cl_seq($input_post['cl_seq'], TRUE);








// 	    	require_once('../modules/admin/config/config_gallery.php');


    		//■画像アップ時に自動縮小後の画像の幅、または高さ（縦横比を保つため横写真は横、縦写真は縦がその値となります単位はpx）
    		//※アップ画像が以下より大きければ縮小処理を行います。逆にそれ以下の場合は縮小処理せずそのまま保存します。
    		//ギャラリーをスマホ、携帯でも使用する場合、あまり大きいと容量も増すので大きくとも400～600ぐらいがベストかと。
    		$imgWidthHeight = $input_post['im_height'];
//     		$imgWidthHeight = 600;

    		//■サムネイルのサイズ（単位はpx）
    		//ファイル名の先頭に「 thumb_ 」が付きます。ファイルサイズの軽いサムネイルを表示したい場合に利用ください
    		//PC、スマホ、携帯で共通利用します。
    		$imgWidthHeightThumb = 200;

    		//■画像アップ時のJPGの画質（0～100）※jpg時のみ　数値が大きいほど→画質良→ファイルサイズ大となる
    		$img_quality = 80;

    		//■アップ画像の最大サイズ※単位はバイト　
    		//※デフォルトは2MB（ただしサーバーのphp.iniの設定による。上限2MBの場合有り。変更可 ※サーバマニュアル等参考）
    		$maxImgSize = 2048000;

//     		$file_path = dirname(__FILE__).'/data/news.dat';					//データファイルのパス
    		$img_updir = "/home/fnote/www/fnote.com.dev/public/images/" . $cl_data[0]['cl_siteid'] . "/s";				//画像の保存先を指定
    		$extensionTypeList = array('jpg','gif','png');



// print(dirname(__FILE__));
// print("<br><br>");






	    	$this->load->library('galleryfun');

// print_r($_POST);
// print("<br><br>");
//exit;


	    	//各記事にユニークなIDを付与　uniqid（PHP3以下）が無ければ年月日時分秒
	    	$id = $this->galleryfun->generateID();

	    	//----------------------------------------------------------------------
	    	//  画像縮小保存処理 GD必須 (START)
	    	//----------------------------------------------------------------------
// print("<br>id :: ");
// print($id);
// print("<br>tmp_name :: ");
// print_r($_FILES["upfile"]["tmp_name"]);
// print("<br>size :: ");
// print_r($_FILES["upfile"]["size"]);
// print("<br>maxImgSize :: ");
// print($maxImgSize);
// print("<br>type : ");
// print_r($_FILES["upfile"]["type"]);
// print("<br>name :: ");
// print_r($_FILES["upfile"]["name"]);
// // exit;

	    	if (is_uploaded_file($_FILES["upfile"]["tmp_name"]))
	    	{
	    		if ($_FILES["upfile"]["size"] < $maxImgSize)
	    		{
	    			$imgType = $_FILES['upfile']['type'];

	    			if ($imgType == 'image/gif' || strpos($_FILES['upfile']['name'],'.gif') !== false || strpos($_FILES['upfile']['name'],'.GIF') !== false)
	    			{
	    				$extension = 'gif';
	    				$image = ImageCreateFromGIF($_FILES['upfile']['tmp_name']); 									//GIFファイルを読み込む
	    			} else if ($imgType == 'image/png' || $imgType == 'image/x-png' || strpos($_FILES['upfile']['name'],'.png') !== false || strpos($_FILES['upfile']['name'],'.PNG') !== false)
	    			{
	    				$extension = 'png';
	    				$image = ImageCreateFromPNG($_FILES['upfile']['tmp_name']); 									//PNGファイルを読み込む
	    			} else if ($imgType == 'image/jpeg' || $imgType == 'image/pjpeg' || strpos($_FILES['upfile']['name'],'.jpg') !== false || strpos($_FILES['upfile']['name'],'.JPG') !== false || strpos($_FILES['upfile']['name'],'.jpeg') !== false || strpos($_FILES['upfile']['name'],'.JPEG') !== false)
	    			{
	    				$extension = 'jpg';
	    				$image = ImageCreateFromJPEG($_FILES['upfile']['tmp_name']); 									//JPEGファイルを読み込む

	    				//画像の回転（iPhoneの縦写真が横写真として保存されてしまう問題の対策）
	    				if (function_exists('exif_read_data'))
	    				{
	    					if ($exif_datas = @exif_read_data($_FILES['upfile']['tmp_name']))
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
	    				exit("<center>【許可されていない拡張子です。jpg、gif、pngのいずれかのみです】<br /><br /><a href='admin.php'>戻る&gt;&gt;</a></center>");
	    			}

	    			if (strpos($id,'no_disp') !== false)
	    			{
	    				$file_id = str_replace('no_disp','',$id);
	    				$filename = $file_id.".".$extension;															//ファイル名を指定
	    			} else {
	    				$filename = $id.".".$extension;																	//ファイル名を指定
	    			}

// print("<br>image :: ");
// print($image);
// // print("<br>file_id :: ");
// // print($file_id);
// print("<br>filename :: ");
// print($filename);
// // exit;




	    			//拡張子違いのファイルを削除
					$this->galleryfun->fileDelFunc($img_updir,$id);

	    			$img_file_path = $img_updir.'/'.$filename;															//ファイルパスを指定
	    			$img_file_path_thumb = $img_updir.'/'.'thumb_'.$filename;											//サムネイルファイルパスを指定

	    			//読み込んだ画像のサイズ
	    			$width = ImageSX($image);																			//横幅（ピクセル）
	    			$height = ImageSY($image);																			//縦幅（ピクセル）




// print("<br>img_file_path :: ");
// print($img_file_path);
// print("<br>img_file_path_thumb :: ");
// print($img_file_path_thumb);
// print("<br>width :: ");
// print($width);
// print("<br>height :: ");
// print($height);
// // exit;




					//画像の縦または横が$imgWidthHeightより大きい場合は縮小して保存
	    			if ($width > $imgWidthHeight or $height > $imgWidthHeight)
	    			{
	    				if ($height < $width)																			//横写真の場合の処理
	    				{
	    					$new_width = $imgWidthHeight; 																//幅指定px
	    					$rate = $new_width / $width; 																//縦横比を算出
	    					$new_height = $rate * $height;

	    					//サムネイル用処理
	    					$new_width_thumb = $imgWidthHeightThumb;													//高さ指定px
	    					$rate_thumb = $new_width_thumb / $width;													//縦横比を算出
	    					$new_height_thumb = $rate_thumb * $height;

	    				} else {																						//縦写真の場合の処理
	    					$new_height = $imgWidthHeight; 																//高さ指定px
	    					$rate = $new_height / $height; 																//縦横比を算出
	    					$new_width = $rate * $width;

	    					//サムネイル用処理
	    					$new_height_thumb = $imgWidthHeightThumb; 													//高さ指定px
	    					$rate_thumb = $new_height_thumb / $height; 													//縦横比を算出
	    					$new_width_thumb = $rate_thumb * $width;
	    				}

	    				// TrueColor イメージを新規に作成する
	    				$new_image = ImageCreateTrueColor($new_width, $new_height);
	    				$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);					//サムネイル作成

	    				// 再サンプリングを行いイメージの一部をコピー、伸縮する
	    				ImageCopyResampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	    				ImageCopyResampled($new_image_thumb, $image, 0, 0, 0, 0, $new_width_thumb, $new_height_thumb, $width, $height);		//サムネイル作成

	    				if ($extension == 'jpg')
	    				{
	    					if (!@is_int($img_quality)) $img_quality = 80;												//画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
	    					ImageJPEG($new_image, $img_file_path, $img_quality); 										//3つ目の引数はクオリティー（0～100）
	    					ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); 							//サムネイル作成
	    				}
	    				elseif ($extension == 'gif') {
	    					ImageGIF($new_image, $img_file_path);														//環境によっては使えない
	    					ImageGIF($new_image_thumb, $img_file_path_thumb);											//サムネイル作成
	    				}
	    				elseif ($extension == 'png') {
	    					ImagePNG($new_image, $img_file_path);
	    					ImagePNG($new_image_thumb, $img_file_path_thumb);											//サムネイル作成
	    				}

	    				//メモリを解放
	    				imagedestroy ($image); 																			//イメージIDの破棄
	    				imagedestroy ($new_image); 																		//元イメージIDの破棄
	    				imagedestroy ($new_image_thumb); 																//サムネイル元イメージIDの破棄

	    			//画像が$imgWidthHeightより小さい場合はそのまま保存
	    			} else {
	    				move_uploaded_file($_FILES['upfile']['tmp_name'], $img_file_path);

	    				//----------------------------------------------------------------------
	    				//  サムネイル生成処理  (START)
	    				//----------------------------------------------------------------------
	    				//画像の縦または横がサムネイル指定サイズより大きい場合は生成
	    				if( $width > $imgWidthHeightThumb or $height > $imgWidthHeightThumb)
	    				{
	    					//横写真の場合の処理
	    					if ($height < $width)
	    					{
	    						$new_width_thumb = $imgWidthHeightThumb;												//高さ指定px
	    						$rate_thumb = $new_width_thumb / $width;												//縦横比を算出
	    						$new_height_thumb = $rate_thumb * $height;

	    					//縦写真の場合の処理
	    					} else {

	    						$new_height_thumb = $imgWidthHeightThumb; 												//高さ指定px
	    						$rate_thumb = $new_height_thumb / $height; 												//縦横比を算出
	    						$new_width_thumb = $rate_thumb * $width;
	    					}

	    					$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);				//サムネイル作成
	    					ImageCopyResampled($new_image_thumb, $image, 0, 0, 0, 0, $new_width_thumb, $new_height_thumb, $width, $height);		//サムネイル作成

	    					if ($extension == 'jpg')
	    					{
	    						if (!@is_int($img_quality)) $img_quality = 80;											//画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
	    						ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); 						//サムネイル作成
	    					} elseif ($extension == 'gif') {
	    						ImageGIF($new_image_thumb, $img_file_path_thumb);										//サムネイル作成
	    					} elseif($extension == 'png') {
	    						ImagePNG($new_image_thumb, $img_file_path_thumb);										//サムネイル作成
	    					}

	    					imagedestroy ($new_image_thumb); 															//サムネイル元イメージIDの破棄

	    				} else {
	    					//サムネイルが設定サイズより小さい場合はそのまま保存
	    					copy($img_file_path, $img_file_path_thumb);
	    				}

	    				//----------------------------------------------------------------------
	    				//  サムネイル生成処理  (END)
	    				//----------------------------------------------------------------------

	    			}


// print("<br>img_file_path :: ");
// print($img_file_path);
// print("<br>img_file_path_thumb :: ");
// print($img_file_path_thumb);


	    			@chmod($img_file_path, 0666);
	    			@chmod($img_file_path_thumb, 0666);


	    			// DB書き込み用
	    			$_size   = getimagesize ($img_file_path);															//画像の大きさを取得

	    			$setdate['im_width']  = $_size[0];
	    			$setdate['im_height'] = $_size[1];
	    			$setdate['im_size']   = filesize($img_file_path);


	    		} else {
	    			$maxImgSize = number_format($maxImgSize);
	    			exit("<center>【画像がファイルサイズオーバーです。{$maxImgSize}バイト以下にして下さい】<br /><br /><a href='admin.php'>戻る&gt;&gt;</a></center>");
	    		}
	    	}

	    	//----------------------------------------------------------------------
	    	//  画像縮小保存処理 GD必須 (END)
	    	//----------------------------------------------------------------------

// 	    	$up_ymd=mb_convert_kana($_POST['year'], 'n',"UTF-8")."/".mb_convert_kana($_POST['month'], 'n',"UTF-8")."/".mb_convert_kana($_POST['day'], 'n',"UTF-8");
// 	    	$up_ymd = str_replace(",","",$up_ymd);
// 	    	if(isset($_POST['title'])){
// 	    		$title = $this->galleryfun->replace_func($_POST['title']);
// 	    	}

// 	    	if($extension == ""){
// 	    		$extension = $_POST['extension_type'];
// 	    	}
// 	    	//並び順。デフォルトは空にする
// 	    	$dspno = "";
// 	    	if(isset($_POST['dspno'])){
// 	    		$dspno = $_POST['dspno'];
// 	    	}

// 	    	$lines = file($file_path);

// 	    	$fp = @fopen($file_path, "r+b") or die("fopen Error!!DESUYO--!!!");
// 	    	$writeData = $id  . "," .$up_ymd. "," .$title. "," .$extension. ",".$dspno.",". "\n";
// 	    	// 俳他的ロック
// 	    	if(flock($fp, LOCK_EX)){
// 	    		ftruncate($fp,0);
// 	    		rewind($fp);
// 	    		// 書き込み
// 	    		if (isset($_POST['submit'])){
// 	    			fwrite($fp, $writeData);
// 	    			if($max_line!='') $max_line --;
// 	    		}
// 	    		if ($max_line!='' and count($lines) > $max_line) {
// 	    			$max_i = $max_line;
// 	    		} else {
// 	    			$max_i = count($lines);
// 	    		}
// 	    		for ($i = 0; $i < $max_i; $i++) {
// 	    			if (isset($_POST['edit_submit'])){
// 	    				$lines_array[$i] = explode(",",$lines[$i]);
// 	    				if($lines_array[$i][0] != $id){
// 	    					fwrite($fp, $lines[$i]);
// 	    				}else{
// 	    					fwrite($fp, $writeData);
// 	    				}
// 	    			}else{
// 	    				fwrite($fp, $lines[$i]);
// 	    			}
// 	    		}
// 	    	}
// 	    	fclose($fp);
    	}








    	// DBへ書き出す
    	$setdate['im_title']       = $input_post['im_title'];
    	$setdate['im_description'] = $input_post['im_description'];
    	$setdate['im_status']      = 1;
    	$setdate['im_type']        = $imgType;
    	$setdate['im_filename']    = $filename;
    	$setdate['im_cl_seq']      = $input_post['cl_seq'];
    	$setdate['im_cl_siteid']   = $cl_data[0]['cl_siteid'];

    	$this->load->model('Image', 'img', TRUE);
    	$_row_id = $this->img->insert_image($setdate);
    	if (!is_numeric($_row_id))
    	{
    		log_message('error', 'gallery::[gd_add()]画像登録処理 insert_imageエラー');
    	}


// print_r($setdate);
// print("<br><br>");




    	$this->smarty->assign('cl_seq', $input_post['cl_seq']);
//     	$this->smarty->assign('imgWidthHeight', $imgWidthHeight);
//     	$this->smarty->assign('mode', 'img_order');
//     	$this->smarty->assign('lines', $lines);
//     	$this->smarty->assign('max_i', $max_i);

    	$this->view('gallery/gd_add.tpl');

    }



    // フォーム・バリデーションチェック
    private function _set_validation()
    {

    	$rule_set = array(
    			array(
    					'field'   => 'im_title',
    					'label'   => 'タイトル（alt）',
    					'rules'   => 'trim|max_length[50]'
    			),
    			array(
    					'field'   => 'im_width',
    					'label'   => '横サイズ',
    					'rules'   => 'trim|required|numeric|max_length[4]'
    			),
    			array(
    					'field'   => 'im_height',
    					'label'   => '縦サイズ',
    					'rules'   => 'trim|required|numeric|max_length[4]'
    			),
    			array(
    					'field'   => 'im_description',
    					'label'   => '画像説明',
    					'rules'   => 'trim|max_length[255]'
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
