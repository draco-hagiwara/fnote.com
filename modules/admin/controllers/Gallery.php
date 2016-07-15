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

    	require_once('../modules/admin/config/config_gallery.php');

    	$pager = $this->galleryfun->pagerOut(file($file_path),$pagelengthAdmin,$pagerDispLength);


print("<br>INDEX<br>");
print_r($_POST);
print("<br><br>");
print("<br>INDEX<br>");
print_r($_GET);
print("<br><br>");
// exit;


    	//モードを取得
    	$mode = '';
    	if(!empty($_GET['mode'])){
    		$mode = h($_GET['mode']);
    	}

        // バリデーション・チェック
        $this->_set_validation();												// バリデーション設定






        $mode = 'img_order';

        $lines = $this->galleryfun->newsListSort(file($file_path));
        $max_i = count($lines);

        if($mode == 'img_order'){
        	$pager['index'] = 0;
        	$pagelengthAdmin = $max_i;
        }



        print("<br>pager :: ");
        print_r($pager['index']);
        print("<br>pager :: ");
        print($pagelengthAdmin);
        print("<br>img_updir :: ");
        print($img_updir);



        for($i = $pager['index']; ($i-$pager['index']) < $pagelengthAdmin; $i++){
        	if(!empty($lines[$i])){
        		$lines_array[$i] = explode(",",$lines[$i]);
        		$id=$lines_array[$i][0];
        		$lines_array[$i][3] = rtrim($lines_array[$i][3]);							// image_type
        		$lines_array[$i][1] = $this->galleryfun->ymd2format($lines_array[$i][1]);	// 日付フォーマットの適用
        		$alt_text = str_replace('<br />','',$lines_array[$i][2]);



//         		print("<br>");
//         		print_r($lines_array);
//         		print("<br>");
//         		print($id);
//         		print("<br>");
//         		print($alt_text);
//         		print("<br><br>");
        		print("<br>no_disp :: ");
        		print_r($lines_array[$i][0]);





        		if(strpos($lines_array[$i][0], 'no_disp') !== false){
        			$img_id = str_replace('no_disp','',$lines_array[$i][0]);

        			$_html_char[$i] = '<li class="no_disp"> ' . $lines_array[$i][1] . '<a class="photo" href="' . $img_updir . '/' . $img_id . '.' . $lines_array[$i][3] . '" title="' . $lines_array[$i][1] . '<br />' . $lines_array[$i][2] . '"><img src="' . $img_updir . '/thumb_' . $img_id . '.' . $lines_array[$i][3] . '" height="75" alt="' . $lines_array[$i][2] . '" title="' . $alt_text . '" /></a><a class="button" href="?mode=disp&id=' . $id . '&page=' . $pager['pageid'] . '>表示する</a><a class="button" href="?mode=edit&id=' . $id . '&page=' . $pager['pageid'] . '>[編集・削除]</a><div class="hidden_text">非表示中</div><input type="hidden" name="sort[]" value="' . $id . '" /></li>"';

        			print("<br>_html_char1 :: ");
        			print_r($_html_char[$i]);
					print("<br><br>");

        			echo <<<EOF

EOF;
				}else{

        			$_html_char[$i] = '<li>' . $lines_array[$i][1] . '  <a class="photo" href="http://fnote.com.dev/' . $img_updir . '/' . $id . '.' . $lines_array[$i][3] . '" title="' . $lines_array[$i][1] . '<br />' . $lines_array[$i][2] . '"><img src="http://fnote.com.dev/' . $img_updir . '/thumb_' . $id . '.' . $lines_array[$i][3] . '" alt="' . $lines_array[$i][2] . '" height="75" title="' . $alt_text . '" /></a><a class="button" href="?mode=no_disp&id=' . $id . '&page=' . $pager['pageid'] . '">非表示にする</a><a class="button" href="?mode=edit&id=' . $id . '&page=' . $pager['pageid'] . '">編集・削除</a><input type="hidden" name="sort[]" value="' . $id .'" /></li>';

        			print("<br>_html_char2 :: ");
					print_r($_html_char[$i]);
					print("<br><br>");


					echo <<<EOF

EOF;
				}
			}
		}




        $this->smarty->assign('imgWidthHeight', $imgWidthHeight);
        $this->smarty->assign('mode', 'img_order');
        $this->smarty->assign('lines', $lines);
        $this->smarty->assign('max_i', $max_i);


        $this->view('gallery/index.tpl');

    }

    // 画像管理 初期表示
    public function gd_new()
    {

    	require_once('../modules/admin/config/config_gallery.php');


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
// exit;

    	if(is_uploaded_file($_FILES["upfile"]["tmp_name"])){
    		if ($_FILES["upfile"]["size"] < $maxImgSize) {
    			$imgType = $_FILES['upfile']['type'];
    			if ($imgType == 'image/gif' || strpos($_FILES['upfile']['name'],'.gif') !== false || strpos($_FILES['upfile']['name'],'.GIF') !== false) {
    				$extension = 'gif';
    				$image = ImageCreateFromGIF($_FILES['upfile']['tmp_name']); //GIFファイルを読み込む
    			} else if ($imgType == 'image/png' || $imgType == 'image/x-png' || strpos($_FILES['upfile']['name'],'.png') !== false || strpos($_FILES['upfile']['name'],'.PNG') !== false) {
    				$extension = 'png';
    				$image = ImageCreateFromPNG($_FILES['upfile']['tmp_name']); //PNGファイルを読み込む
    			} else if ($imgType == 'image/jpeg' || $imgType == 'image/pjpeg' || strpos($_FILES['upfile']['name'],'.jpg') !== false || strpos($_FILES['upfile']['name'],'.JPG') !== false || strpos($_FILES['upfile']['name'],'.jpeg') !== false || strpos($_FILES['upfile']['name'],'.JPEG') !== false) {
    				$extension = 'jpg';
    				$image = ImageCreateFromJPEG($_FILES['upfile']['tmp_name']); //JPEGファイルを読み込む

    				//画像の回転（iPhoneの縦写真が横写真として保存されてしまう問題の対策）
    				if(function_exists('exif_read_data')){
    					if($exif_datas = @exif_read_data($_FILES['upfile']['tmp_name'])){
    						if(isset($exif_datas['Orientation'])){
    							if($exif_datas['Orientation'] == 6){
    								$image = imagerotate($image, 270, 0);
    							}elseif($exif_datas['Orientation'] == 3){
    								$image = imagerotate($image, 180, 0);
    							}
    						}
    					}
    				}

    			} else if ($extension == '') {
    				exit("<center>【許可されていない拡張子です。jpg、gif、pngのいずれかのみです】<br /><br /><a href='admin.php'>戻る&gt;&gt;</a></center>");
    			}

    			if(strpos($id,'no_disp') !== false) {
    				$file_id = str_replace('no_disp','',$id);
    				$filename = $file_id.".".$extension;//ファイル名を指定
    			}else{
    				$filename = $id.".".$extension;//ファイル名を指定
    			}

// print("<br>image :: ");
// print($image);
// // print("<br>file_id :: ");
// // print($file_id);
// print("<br>filename :: ");
// print($filename);
// exit;




    			//拡張子違いのファイルを削除
    			$this->galleryfun->fileDelFunc($img_updir,$id);

    			$img_file_path = $img_updir.'/'.$filename;//ファイルパスを指定
    			$img_file_path_thumb = $img_updir.'/'.'thumb_'.$filename;//サムネイルファイルパスを指定

    			//読み込んだ画像のサイズ
    			$width = ImageSX($image); //横幅（ピクセル）
    			$height = ImageSY($image); //縦幅（ピクセル）




// print("<br>img_file_path :: ");
// print($img_file_path);
// print("<br>img_file_path_thumb :: ");
// print($img_file_path_thumb);
// print("<br>width :: ");
// print($width);
// print("<br>height :: ");
// print($height);
// exit;




    			if($width>$imgWidthHeight or $height>$imgWidthHeight){//画像の縦または横が$imgWidthHeightより大きい場合は縮小して保存
    				if ($height < $width){//横写真の場合の処理
    					$new_width = $imgWidthHeight; //幅指定px
    					$rate = $new_width / $width; //縦横比を算出
    					$new_height = $rate * $height;

    					//サムネイル用処理
    					$new_width_thumb = $imgWidthHeightThumb;//高さ指定px
    					$rate_thumb = $new_width_thumb / $width;//縦横比を算出
    					$new_height_thumb = $rate_thumb * $height;

    				}else{//縦写真の場合の処理
    					$new_height = $imgWidthHeight; //高さ指定px
    					$rate = $new_height / $height; //縦横比を算出
    					$new_width = $rate * $width;

    					//サムネイル用処理
    					$new_height_thumb = $imgWidthHeightThumb; //高さ指定px
    					$rate_thumb = $new_height_thumb / $height; //縦横比を算出
    					$new_width_thumb = $rate_thumb * $width;
    				}

    				$new_image = ImageCreateTrueColor($new_width, $new_height);
    				$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);//サムネイル作成

    				ImageCopyResampled($new_image,$image,0,0,0,0,$new_width,$new_height,$width,$height);
    				ImageCopyResampled($new_image_thumb,$image,0,0,0,0,$new_width_thumb,$new_height_thumb,$width,$height);//サムネイル作成

    				if($extension == 'jpg'){

    					if(!@is_int($img_quality)) $img_quality = 80;//画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
    					ImageJPEG($new_image, $img_file_path, $img_quality); //3つ目の引数はクオリティー（0～100）
    					ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); //サムネイル作成
    				}
    				elseif ($extension == 'gif') {
    					ImageGIF($new_image, $img_file_path);//環境によっては使えない
    					ImageGIF($new_image_thumb, $img_file_path_thumb);//サムネイル作成
    				}
    				elseif ($extension == 'png') {
    					ImagePNG($new_image, $img_file_path);
    					ImagePNG($new_image_thumb, $img_file_path_thumb);//サムネイル作成
    				}

    				//メモリを解放
    				imagedestroy ($image); //イメージIDの破棄
    				imagedestroy ($new_image); //元イメージIDの破棄
    				imagedestroy ($new_image_thumb); //サムネイル元イメージIDの破棄

    			}else{//画像が$imgWidthHeightより小さい場合はそのまま保存
    				move_uploaded_file($_FILES['upfile']['tmp_name'],$img_file_path);

    				//----------------------------------------------------------------------
    				//  サムネイル生成処理  (START)
    				//----------------------------------------------------------------------
    				if($width>$imgWidthHeightThumb or $height>$imgWidthHeightThumb){//画像の縦または横がサムネイル指定サイズより大きい場合は生成
    					if ($height < $width){//横写真の場合の処理

    						$new_width_thumb = $imgWidthHeightThumb;//高さ指定px
    						$rate_thumb = $new_width_thumb / $width;//縦横比を算出
    						$new_height_thumb = $rate_thumb * $height;

    					}else{//縦写真の場合の処理

    						$new_height_thumb = $imgWidthHeightThumb; //高さ指定px
    						$rate_thumb = $new_height_thumb / $height; //縦横比を算出
    						$new_width_thumb = $rate_thumb * $width;
    					}
    					$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);//サムネイル作成
    					ImageCopyResampled($new_image_thumb,$image,0,0,0,0,$new_width_thumb,$new_height_thumb,$width,$height);//サムネイル作成

    					if($extension == 'jpg'){
    						if(!@is_int($img_quality)) $img_quality = 80;//画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
    						ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); //サムネイル作成
    					}
    					elseif($extension == 'gif') {
    						ImageGIF($new_image_thumb, $img_file_path_thumb);//サムネイル作成
    					}
    					elseif($extension == 'png') {
    						ImagePNG($new_image_thumb, $img_file_path_thumb);//サムネイル作成
    					}
    					imagedestroy ($new_image_thumb); //サムネイル元イメージIDの破棄
    				}else{
    					//サムネイルが設定サイズより小さい場合はそのまま保存
    					copy($img_file_path,$img_file_path_thumb);
    				}
    				//----------------------------------------------------------------------
    				//  サムネイル生成処理  (END)
    				//----------------------------------------------------------------------

    			}
    			@chmod($img_file_path, 0666);
    			@chmod($img_file_path_thumb, 0666);

    		}else{
    			$maxImgSize = number_format($maxImgSize);
    			exit("<center>【画像がファイルサイズオーバーです。{$maxImgSize}バイト以下にして下さい】<br /><br /><a href='admin.php'>戻る&gt;&gt;</a></center>");
    		}
    	}
    	//----------------------------------------------------------------------
    	//  画像縮小保存処理 GD必須 (END)
    	//----------------------------------------------------------------------

    	$up_ymd=mb_convert_kana($_POST['year'], 'n',"UTF-8")."/".mb_convert_kana($_POST['month'], 'n',"UTF-8")."/".mb_convert_kana($_POST['day'], 'n',"UTF-8");
    	$up_ymd = str_replace(",","",$up_ymd);
    	if(isset($_POST['title'])){
    		$title = $this->galleryfun->replace_func($_POST['title']);
    	}

    	if($extension == ""){
    		$extension = $_POST['extension_type'];
    	}
    	//並び順。デフォルトは空にする
    	$dspno = "";
    	if(isset($_POST['dspno'])){
    		$dspno = $_POST['dspno'];
    	}

    	$lines = file($file_path);

    	$fp = @fopen($file_path, "r+b") or die("fopen Error!!DESUYO--!!!");
    	$writeData = $id  . "," .$up_ymd. "," .$title. "," .$extension. ",".$dspno.",". "\n";
    	// 俳他的ロック
    	if(flock($fp, LOCK_EX)){
    		ftruncate($fp,0);
    		rewind($fp);
    		// 書き込み
    		if (isset($_POST['submit'])){
    			fwrite($fp, $writeData);
    			if($max_line!='') $max_line --;
    		}
    		if ($max_line!='' and count($lines) > $max_line) {
    			$max_i = $max_line;
    		} else {
    			$max_i = count($lines);
    		}
    		for ($i = 0; $i < $max_i; $i++) {
    			if (isset($_POST['edit_submit'])){
    				$lines_array[$i] = explode(",",$lines[$i]);
    				if($lines_array[$i][0] != $id){
    					fwrite($fp, $lines[$i]);
    				}else{
    					fwrite($fp, $writeData);
    				}
    			}else{
    				fwrite($fp, $lines[$i]);
    			}
    		}
    	}
    	fclose($fp);






//     	//モードを取得
//     	$mode = '';
//     	if(!empty($_GET['mode'])){
//     		$mode = h($_GET['mode']);
//     	}

    	// バリデーション・チェック
    	$this->_set_validation();												// バリデーション設定



    	$lines = $this->galleryfun->newsListSort(file($file_path));
    	$max_i = count($lines);

    	$this->smarty->assign('imgWidthHeight', $imgWidthHeight);
    	$this->smarty->assign('mode', 'img_order');
    	$this->smarty->assign('lines', $lines);
    	$this->smarty->assign('max_i', $max_i);

    	$this->view('gallery/index.tpl');

    }





    // フォーム・バリデーションチェック
    private function _set_validation()
    {

    	$rule_set = array(
    	);

    	$this->load->library('form_validation', $rule_set);                     // バリデーションクラス読み込み

    }

}
