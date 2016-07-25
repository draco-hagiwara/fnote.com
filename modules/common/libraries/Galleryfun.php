<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Gallery 画像管理専用用クラス
 *
 */
class Galleryfun
{

    //----------------------------------------------------------------------
    // 　関数定義（基本的に変更不可） (START)
    //----------------------------------------------------------------------

    function h($string) {
    	return htmlspecialchars($string, ENT_QUOTES,'utf-8');
    }

    //IDをセット
    function generateID(){
    	if(isset($_POST['edit_submit'])){
    		$id = $_POST['id'];
    	}elseif(function_exists('uniqid') && function_exists('mt_rand')){//PHP4以上
    		//$id = @date("Ymd").'_'.md5(uniqid(rand(),TRUE));
    		$id = @date("Ymd").'_'.uniqid(mt_rand(10000,99999));
    	}else{
    		$id = @date("YmdHis");
    	}
    	return $id;
    }

    //パーミッションチェック関数
    function permissionCheck($file_path,$img_updir,$perm_check01,$perm_check02,$perm_check03){
    	$messe = '';
    	if(!is_writable($img_updir)){
    		$messe = $perm_check02;
    		exit($messe);
    	}
    	elseif (!is_writable($file_path)){
    		$messe = str_replace(dirname(__FILE__).'/','',$file_path).$perm_check01;
    		exit($messe);
    	}
    	elseif(@$_GET['check']=='permission'){
    		$messe = $perm_check03;
    	}
    	return $messe;
    }

    //完了メッセージセット
    function compMesse($str){
    	$messe = '';
    	if($str == 'registComp'){
    		$messe = '登録が完了しました';
    	}
    	elseif($str == 'editComp'){
    		$messe = '更新が完了しました';
    	}
    	return $messe;
    }

    //ニュースリストの並び順（日付順）用関数
    function newsListSort($lines){
    	$jj = 0;
    	$index=array();
    	$index2=array();
    	foreach($lines as $val){
    		$lines_array = explode(",",$val);
    		if(empty($lines_array[4])){
    			$index[] = 0;
    		}else{
    			$index[] = $lines_array[4];
    		}
    		$index2[] = $jj++;
    	}

    	array_multisort($index,SORT_ASC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$lines);
    	return $lines;
    }

    //ニュースリストの並び順（日付順）ユーザ閲覧ページ用（ページャー実装時のカウントずれ補正）
    function newsListSortUser($lines,$copyright){
    	if(empty($copyright)) $lines = array('01','02');
    	$linesTempArray=array();
    	$index=array();
    	$index2=array();
    	$jj = 0;
    	foreach($lines as $lineVal){
    		if(strpos($lineVal, 'no_disp')===false) $linesTempArray[] = $lineVal;
    	}
    	foreach($linesTempArray as $val){
    		$lines_array = explode(",",$val);

    		if(empty($lines_array[4])){
    			$index[] = 0;
    		}else{
    			$index[] = $lines_array[4];
    		}

    		$index2[] = $jj++;
    	}
    	array_multisort($index,SORT_ASC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$linesTempArray);
    	return $linesTempArray;
    }

    //登録文字列の置換
    function replace_func($str){
    	$str = $this->h($str);
    	$str = str_replace("\n","<br />",$str);
    	$str = str_replace("\r","",$str);
    	$str = str_replace(",","、",$str);
    	if (@get_magic_quotes_gpc()) $str = @stripslashes($str);
    	return $str;
    }

    //NULLバイト除去//
    function sanitize($arr){
    	if(is_array($arr)){
    		return array_map('sanitize',$arr);
    	}
    	return str_replace("\0","",$arr);
    }

    //ページャー関数（HTML部は変更可）
    function pager($totalPage, $pageid, $pagerDispLength){
    	global $pagerNext,$pagerPrev,$overPagerPattern,$encodingType;
    	$pager = '';
    	$next = $pageid+1;
    	$prev = $pageid-1;
    	$startPage =  ($pageid-floor($pagerDispLength/2)> 0) ? ($pageid-floor($pagerDispLength/2)) : 1;
    	$endPage =  ($startPage> 1) ? ($pageid+floor($pagerDispLength/2)) : $pagerDispLength;
    	$startPage = ($totalPage <$endPage)? $startPage-($endPage-$totalPage):$startPage;
    	if($pageid != 1 ) {
    		$pager .= '<a href="?page='.$prev.'">'.$pagerPrev.'</a>';
    	}
    	if($startPage>= 2){
    		$pager .= '<a href="?page=1" class="btnFirst">1</a>';
    		if($startPage>= 3) $pager .= '<span class="overPagerPattern">'.$overPagerPattern.'</span>'; //ドットの表示
    	}
    	for($i=$startPage; $i <= $endPage ; $i++){
    		$class = ($pageid == $i) ? ' class="current"':"";//現在のページ番号にclass追加
    		if($i <= $totalPage && $i> 0 )//1以上最大ページ数以下の場合
    			$pager .= '<a href="?page='.$i.'"'.$class.'>'.$i.'</a>';//ページ番号リンク表示
    	}
    	if($totalPage> $endPage){
    		if($totalPage-1> $endPage ) $pager .= '<span class="overPagerPattern">'.$overPagerPattern.'</span>'; //ドットの表示
    		$pager .= '<a href="?page='.$totalPage.'" class="btnLast">'.$totalPage.'</a>';
    	}
    	if($pageid <$totalPage){
    		$pager .= '<a href="?page='.$next.'">'.$pagerNext.'</a>';
    	}
    	if($encodingType!='UTF-8') $pager = mb_convert_encoding($pager,"$encodingType",'UTF-8');
    	return $pager;
    }

    //ページャー関数（HTML部は変更可） 携帯（ガラケー用）
    function pager_mobile($totalPage, $pageid, $pagerDispLength){
    	global $pagerNext,$pagerPrev,$overPagerPattern,$encodingType;
    	$pager = '';
    	$next = $pageid+1;
    	$prev = $pageid-1;
    	$startPage =  ($pageid-floor($pagerDispLength/2)> 0) ? ($pageid-floor($pagerDispLength/2)) : 1;
    	$endPage =  ($startPage> 1) ? ($pageid+floor($pagerDispLength/2)) : $pagerDispLength;
    	$startPage = ($totalPage <$endPage)? $startPage-($endPage-$totalPage):$startPage;
    	$pager .= '<span style="font-size:small"><font size="2">';
    	if($pageid != 1 ) {
    		$pager .= '[<a href="?page='.$prev.'">'.$pagerPrev.'</a>]';
    	}
    	if($startPage>= 2){
    		$pager .= '[<a href="?page=1" class="btnFirst">1</a>]';
    		if($startPage>= 3) $pager .= '<span class="overPagerPattern">'.$overPagerPattern.'</span>'; //ドットの表示
    	}
    	for($i=$startPage; $i <= $endPage ; $i++){
    		$class = ($pageid == $i) ? ' class="current"':"";//現在のページ番号にclass追加
    		if($i <= $totalPage && $i> 0 )//1以上最大ページ数以下の場合
    			$pager .= '[<a href="?page='.$i.'"'.$class.'>'.$i.'</a>]';//ページ番号リンク表示
    	}
    	if($totalPage> $endPage){
    		if($totalPage-1> $endPage ) $pager .= '<span class="overPagerPattern">'.$overPagerPattern.'</span>'; //ドットの表示
    		$pager .= '[<a href="?page='.$totalPage.'" class="btnLast">'.$totalPage.'</a>]';
    	}
    	if($pageid <$totalPage){
    		$pager .= '[<a href="?page='.$next.'">'.$pagerNext.'</a>]';
    	}
    	$pager .= "</font></span>";
    	if($encodingType!='UTF-8') $pager = mb_convert_encoding($pager,"$encodingType",'UTF-8');
    	return $pager;
    }

    //ページャー起動（管理画面用）
    function pagerOut($lines,$pagelength,$pagerDispLength,$str=''){

    	$totalPage = ceil(count($lines)/$pagelength);	// 合計ページ数 $max_i = ceil($max_i/$pagelength);
    	if(!empty($_GET['page'])){
    		$pager['pageid'] = h($_GET['page']);
    	}else{
    		$pager['pageid'] = 1;
    	}

    	if(count($lines) > $pagelength){
    		if($str == 'mb'){
    			$pager['pager_res'] = pager_mobile($totalPage, $pager['pageid'],$pagerDispLength);
    		}else{
    			$pager['pager_res'] = pager($totalPage, $pager['pageid'],$pagerDispLength);
    		}
    	}else{
    		$pager['pager_res'] = '';
    	}


    	$pager['index'] = ($pager['pageid'] - 1) * $pagelength;

    	return $pager;
    }

    //表示側日付フォーマットの設定
    function ymd2format($str){
    	global $up_ymd_japanese,$delimiter_text;
    	$up_ymd = explode('/',$str);
    	if($up_ymd_japanese == 1){
    		$res = $up_ymd[0].'年'.$up_ymd[1].'月'.$up_ymd[2].'日';
    	}else{
    		$res = $up_ymd[0].$delimiter_text.$up_ymd[1].$delimiter_text.$up_ymd[2];
    	}
    	return $res;
    }

    function PHPkoubou($encodingType,$copyright,$warningMesse){
    	if(empty($copyright)) exit($warningMesse);
    	if(strpos($copyright,' href="http://www.php-factory.net') === false && strpos($copyright,"<span id=") === false) exit($warningMesse);
    	if($encodingType!='UTF-8') {
    		$copyright = mb_convert_encoding($copyright,$encodingType,'UTF-8');
    	}
    	echo $copyright;
    }

    //並び順変更
    function orderChange($file_path){
    	$writeData = '';
    	$fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
    	$lines = file($file_path);

    	if (flock($fp, LOCK_EX)) {
    		ftruncate($fp,0);
    		rewind($fp);
    		foreach($_POST['sort'] as $key => $val){
    			foreach($lines as $lines_val){
    				$lines_array = explode(',',$lines_val);
    				if($lines_array[0] == $val){
    					$lines_array[4] = $key;
    					for($i = 0;$i < 5;$i++){//下位バージョン互換用（カラム数が変わるためループ数を直接指定）
    						$writeData .= rtrim($lines_array[$i],"\n").',';
    					}
    					$writeData .= "\n";
    					break(1);
    				}
    			}
    		}
    		fwrite($fp, $writeData);
    	}
    	fclose($fp);
    	return '並び替えが完了しました';
    }

    function delDetaToImg($file_path,$max_line,$img_updir){
    	$messe = '';
    	$id = $_POST['id'];
    	$extension_type = $_POST['extension_type'];
    	$lines = file($file_path);
    	$fp = @fopen("$file_path", "r+b") or die("なぜかファイルオープンエラー");
    	if(flock($fp, LOCK_EX)) {
    		ftruncate($fp,0);
    		rewind($fp);
    		if ($max_line!='' and count($lines) > $max_line) {
    			$max_i = $max_line;
    		} else {
    			$max_i = count($lines);
    		}
    		for ($i = 0; $i < $max_i; $i++) {
    			$lines_array[$i] = explode(",",$lines[$i]);
    			if($lines_array[$i][0] != $id){
    				fwrite($fp, $lines[$i]);
    			}else{
    				$lines[$i] = '';
    				fwrite($fp, $lines[$i]);
    			}
    		}
    	}
    	@fclose($fp);
    	//アップ画像も削除
    	if(strpos($id,'no_disp') !== false) $id = str_replace('no_disp','',$id);
    	fileDelFunc($img_updir,$id);

    	return "削除完了しました！";
    }

    //画像削除
    function fileDelFunc($img_updir,$id){
//     	global $extensionTypeList;
    	$extensionTypeList = array('jpg','gif','png');
    	foreach($extensionTypeList as $extensionTypeListVal){
    		$imgPathL = $img_updir.'/'.$id.'.'.$extensionTypeListVal;
    		$imgPathS = $img_updir.'/thumb_'.$id.'.'.$extensionTypeListVal;
    		if(file_exists($imgPathL)) unlink($imgPathL);
    		if(file_exists($imgPathS)) unlink($imgPathS);
    	}
    }

    function dispModeChange($mode,$file_path,$max_line){
    	$messe = '';
    	$id = h($_GET['id']);
    	$lines = file($file_path);
    	$fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
    	if(flock($fp, LOCK_EX)){
    		ftruncate($fp,0);
    		rewind($fp);
    		if($max_line!='' && count($lines) > $max_line) {
    			$max_i = $max_line;
    		}else{
    			$max_i = count($lines);
    		}

    		for($i = 0; $i < $max_i; $i++){
    			$lines_array[$i] = explode(",",$lines[$i]);
    			if($lines_array[$i][0]!= $id){
    				fwrite($fp, $lines[$i]);
    			}else{

    				if($mode=='disp'){//表示処理
    					$lines[$i] = str_replace("no_disp","",$lines[$i]);
    					$messe= "表示処理完了しました！ ";
    				}else if($mode=='no_disp'){//非表示処理
    					$messe= "非表示処理完了しました！ ";
    					$lines[$i] ="no_disp".$lines[$i];
    				}
    				fwrite($fp, $lines[$i]);
    			}
    		}
    	}
    	fclose($fp);
    	return $messe;
    }

}
