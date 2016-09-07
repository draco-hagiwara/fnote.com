<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tenpoinfo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * データ有無判定＆データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_tenpo_seq($tp_seq)
    {

    	$set_where["tp_status"] = 0;
		$set_where["tp_seq"]    = $tp_seq;

    	$query = $this->db->get_where('tb_tenpoinfo', $set_where);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * データ有無判定＆データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_tenpo_siteid($tp_cl_siteid, $empty = FALSE)
    {

    	if ($empty == TRUE){
    		$set_where["tp_cl_seq"] = 0;
    	} else {
    		$set_where["tp_status"]    = 0;
    		$set_where["tp_cl_siteid"] = $tp_cl_siteid;
    	}

    	$query = $this->db->get_where('tb_tenpoinfo', $set_where);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

//     /**
//      * データ有無判定＆データ取得
//      *
//      * @param    char
//      * @return   array
//      */
//     public function get_entry_clid($cl_id, $empty = FALSE)
//     {

//     	if ($empty == TRUE){
//     		$set_where["en_cl_seq"] = 0;
//     	} else {
//     		$set_where["en_cl_id"] = $cl_id;
//     	}

//     	$query = $this->db->get_where('tb_entry', $set_where);

//     	// データ有無判定
//     	if ($query->num_rows() > 0) {
//     		$get_data = $query->result('array');
//     		return $get_data;
//     	} else {
//     		return FALSE;
//     	}
//     }

//     /**
//      * データ有無判定＆データ取得
//      *
//      * @param    char
//      * @return   array
//      */
//     public function get_entry_clseq($cl_seq)
//     {

//     	$set_where["en_cl_seq"] = $cl_seq;

//     	$query = $this->db->get_where('tb_entry', $set_where);

//     	// データ有無判定
//     	if ($query->num_rows() > 0) {
//     		$get_data = $query->result('array');
//     		return $get_data;
//     	} else {
//     		return FALSE;
//     	}
//     }

//     /**
//      * カラムのみ取得
//      *
//      * @param
//      * @return   array
//      */
//     public function get_entry_columns()
//     {

//     	$sql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA= \'fnote\' AND TABLE_NAME= \'tb_entry\'';

//     	$query = $this->db->query($sql);

//     	$get_col = $query->result('array');

//     	return $get_col;

//     }













    /**
     * キーワード検索対象データの取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_searchlist($set_search, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE

    	// [キーワード]をスペースで分割＆セット
    	$_split_keyword = $this->_split_word($set_search['keyword']);
    	foreach ($_split_keyword as $key => $value)
    	{

    		$set_select_like[$key]["tp_shopname"]   = $value;					// 店舗名
    		$set_select_like[$key]["tp_overview"]   = $value;					// 店舗概要
    		$set_select_like[$key]["tp_searchword"] = $value;					// 検索キーワード

    	}

    	// [アクセス]をスペースで分割＆セット
    	$_split_access = $this->_split_word($set_search['access']);
    	foreach ($_split_access as $key => $value)
    	{

    		$set_select_like[$key]["tp_prefname"]   = $value;					// 都道府県
    		$set_select_like[$key]["tp_addr01"]     = $value;					// 住所1
    		$set_select_like[$key]["tp_addr02"]     = $value;					// 住所2
    		$set_select_like[$key]["tp_accessinfo"] = $value;					// アクセス

    	}

    	// 対象クライアントメンバーの取得
    	$tenpo_list = $this->select_searchlist($set_select_like, $tmp_per_page, $tmp_offset);

    	return $tenpo_list;

    }

    /**
     * キーワード検索対象データの取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function select_searchlist($set_select_like, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT
    			  tp_seq,
    			  tp_cl_seq,
    			  tp_cl_siteid,
    			  tp_shopname,
    			  tp_shopname_sub,
    			  tp_zip01,
    			  tp_zip02,
    			  tp_pref,
    			  tp_prefname,
    			  tp_addr01,
    			  tp_addr02,
    			  tp_buil,
    			  tp_tel,
    			  tp_mail,
    			  tp_accessinfo,
    			  tp_overview
    			FROM tb_tenpoinfo WHERE tp_status = 0 ';

    	// WHERE-LIKE文 作成
    	$flg = FALSE;
    	foreach ($set_select_like as $key => $val)
    	{
    		foreach ($val as $key1 => $val1)
    		{

	    		if (isset($val1) && $val1 != '')
	    		{
	    			if ($flg == FALSE)
	    			{
	    				$sql .= ' AND ( ' . $key1 . ' LIKE \'%' . $this->db->escape_like_str($val1) . '%\'';
	    				$flg = TRUE;
	    			} else {
	    				$sql .= ' OR ' . $key1 . ' LIKE \'%' . $this->db->escape_like_str($val1) . '%\'';
	    			}
	    		}
    		}
    	}
    	if ($flg == TRUE)
    	{
    		$sql .= ' ) ';
    	}

    	// ORDER BY文 作成
    	$sql .= ' ORDER BY tp_update_date DESC, tp_cl_seq ASC';

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$tenpo_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$tenpo_list = $query->result('array');

    	return array($tenpo_list, $tenpo_countall);

    }













    /**
     * ジャンル検索対象データの取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_genrelist($set_genre, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE
    	if ($set_genre['level'] == 1)
    	{
    		$set_select_like["tp_cate"]  = $set_genre['id'] . '-';
    	} elseif ($set_genre['level'] == 2) {
    		$rep_id = str_split($set_genre['id'], 2);							// 2桁毎に分割
    		$set_select_like["tp_cate"]  = $rep_id[0] . '-' . $rep_id[1];
    	} elseif ($set_genre['level'] == 3) {
    		$rep_id = str_split($set_genre['id'], 2);
    		$set_select_like["tp_cate"]  = $rep_id[0] . '-' . $rep_id[1] . $rep_id[2];
    	}

    	// 対象クライアントメンバーの取得
    	$tenpo_list = $this->select_genrelist($set_select_like, $tmp_per_page, $tmp_offset);

    	return $tenpo_list;

    }

    /**
     * ジャンル検索対象データの取得
     *
     * @param    array() : WHERE句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function select_genrelist($set_select_like, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT
    			  tp_seq,
    			  tp_cl_seq,
    			  tp_cl_siteid,
    			  tp_shopname,
    			  tp_shopname_sub,
    			  tp_zip01,
    			  tp_zip02,
    			  tp_pref,
    			  tp_prefname,
    			  tp_addr01,
    			  tp_addr02,
    			  tp_buil,
    			  tp_tel,
    			  tp_mail,
    			  tp_accessinfo,
    			  tp_overview
    			FROM tb_tenpoinfo WHERE tp_status = 0 ';

    	// WHERE-LIKE文 作成 :: 形式 = ( tp_cate LIKE '%00-0000%' )
    	$sql .= ' AND ( tp_cate ' . ' LIKE \'%' . $this->db->escape_like_str($set_select_like["tp_cate"]) . '%\' )';

    	// ORDER BY文 作成
    	$sql .= ' ORDER BY tp_update_date DESC, tp_cl_seq ASC';

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$tenpo_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
//     	$query = $this->db->query($sql);
    	$tenpo_list = $query->result('array');

    	return array($tenpo_list, $tenpo_countall);

    }




    public function sql_regexp()
    {

    	$sql = "SELECT * FROM tb_tenpoinfo WHERE tp_status = 0 AND tp_cate REGEXP '\/02[0-9A-F]{4}\/'";

    	$query = $this->db->query($sql);
    	$tenpo_countall = $query->num_rows();

    	// クエリー実行
    	$tenpo_list = $query->result('array');



    	print($tenpo_countall);
    	print("<br>");
    	print($tenpo_list);
    	print("<br>");
    	exit;


    }




    /**
     * 店舗情報の登録＆更新
     *
     * @param    array()
     * @return   int
     */
    public function inup_tenpo($setData, $user_type=2)
    {

    	// INSERT or UPDATE
    	$sql = 'SELECT * FROM `tb_tenpoinfo` '
    			. 'WHERE `tp_cl_siteid` = ? ';

    	$values = array(
    			$setData['tp_cl_siteid'],
    	);

    	$query = $this->db->query($sql, $values);
    	if ($query->num_rows() > 0) {

    		// データ更新
	    	$where = array(
	    			'tp_cl_siteid' => $setData['tp_cl_siteid']
	    	);

	    	$result = $this->db->update('tb_tenpoinfo', $setData, $where);

	    	// ログ書き込み
	    	$set_data['lg_user_type'] = $user_type;
	    	$set_data['lg_type']      = 'tenpoinfo_update';
	    	$set_data['lg_func']      = 'inup_tenpo';
	    	$set_data['lg_detail']    = 'tp_cl_siteid = ' . $setData['tp_cl_siteid'];
	    	$this->insert_log($set_data);


    	} else {

    		// データ追加
    		$result = $this->db->insert('tb_tenpoinfo', $setData);

    		// ログ書き込み
    		$set_data['lg_user_type'] = $user_type;
    		$set_data['lg_type']      = 'tenpoinfo_insert';
	    	$set_data['lg_func']      = 'inup_tenpo';
    		$set_data['lg_detail']    = 'tp_cl_siteid = ' . $setData['tp_cl_siteid'];
    		$this->insert_log($set_data);

    	}

    	return $result;

    }

    /**
     * ログ書き込み
     *
     * @param    array()
     * @return   int
     */
    public function insert_log($setData)
    {

    	if ($setData['lg_user_type'] == 2) {
    		$setData['lg_user_id']   = $_SESSION['a_memSeq'];
    	} elseif ($setData['lg_user_type'] == 3) {
    		$setData['lg_user_id']   = $_SESSION['c_memSeq'];
    	} else {
    		$setData['lg_user_id']   = "";
    	}

    	$setData['lg_ip'] = $this->input->ip_address();

    	// データ追加
    	$query = $this->db->insert('tb_log', $setData);

    	//     	// 挿入した ID 番号を取得
    	//     	$row_id = $this->db->insert_id();
    	//     	return $row_id;
    }

    /**
     * 空白文字で分割
     *
     * @param    array() : 検索項目値
     * @return   array()
     */
    public function _split_word($word)
    {

    	// 全角スペースを半角スペースに変換
    	$word = str_replace('　', ' ', $word);

    	// 前後のスペース削除
    	$word = trim($word);

    	// 連続する半角スペースを半角スペースひとつに変換
    	$word = preg_replace('/\s+/', ' ', $word);

    	// 分割
    	$word = explode(' ', $word);

    	return $word;

    }

}