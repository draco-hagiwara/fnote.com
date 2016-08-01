<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * カテゴリデータ取得 : seq
     *
     * @param    char
     * @return   array
     */
    public function get_category_seq($ca_seq)
    {

    	$sql = 'SELECT * FROM `mb_category` '
    			. 'WHERE `ca_seq` = ' . $ca_seq;

    	$query = $this->db->query($sql);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第一階層カテゴリデータ取得
     *
     * @param    char
     * @return   array
     */
    public function get_category_parent1()
    {

    	$sql = 'SELECT * FROM `mb_category` '
    			. 'WHERE `ca_level` = 1 ORDER BY ca_dispno ASC';

    	$query = $this->db->query($sql);

		$get_data = $query->result('array');

		return $get_data;

    }

    /**
     * 第二階層カテゴリデータ取得
     *
     * @param    char
     * @return   array
     */
    public function get_category_parent2($cate01)
    {

    	$sql = 'SELECT * FROM `mb_category` '
    			. 'WHERE `ca_parent` = ? ORDER BY ca_dispno ASC';

    	$values = array(
    			$cate01,
    	);

    	$query = $this->db->query($sql, $values);

		$get_data = $query->result('array');

		return $get_data;

    }

    /**
     * 第三階層カテゴリデータ取得
     *
     * @param    char
     * @return   array
     */
    public function get_category_parent3($cate02)
    {

    	$sql = 'SELECT * FROM `mb_category` '
    			. 'WHERE `ca_parent` = ? ORDER BY ca_dispno ASC';

    	$values = array(
    			$cate02,
    	);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * カテゴリの取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_categorylist($arr_post, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE
//     	$set_select["ca_seq"]    = $ca_seq;
//     	$set_select["ca_parent"] = $ca_parent;
    	//     	$set_select["ac_name02"] = $arr_post['ac_name'];
//     	$set_select["ac_mail"]   = $arr_post['ac_mail'];

//     	if ($arr_post['ac_type'] != 2)
//     	{
//     		$set_select["ac_seq"] = $arr_post['ac_seq'];
//     	}

    	// ORDER BY
    	if ($arr_post['orderid'] == 'ASC')
    	{
    		$set_orderby["ca_seq"] = $arr_post['orderid'];
    	}else {
    		$set_orderby["ca_seq"] = 'DESC';
    	}

    	// カテゴリの取得
    	$cate_list = $this->_select_categorylist($arr_post, $set_orderby, $tmp_per_page, $tmp_offset);

    	return $cate_list;

    }

    /**
     * 対象カテゴリの取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function _select_categorylist($set_select, $set_orderby, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT *
    			FROM mb_category ';

    	// WHERE文 作成
    	if (isset($set_select["ca_seq"]))
    	{
	    	$sql .= ' WHERE ca_seq    = ' . $set_select['ca_seq'] .    ' ORDER BY ca_seq ASC ';
	    } elseif (isset($set_select["ca_parent"])) {
    		$sql .= ' WHERE ca_parent = ' . $set_select['ca_parent'] . ' ORDER BY ca_seq ASC ';
	    } else {
	    	$sql .= ' ORDER BY ca_seq ASC ';
	    }



    	 //     	.
//         			    ' OR  ac_name02 LIKE \'%' . $this->db->escape_like_str($set_select['ac_name02']) . '%\' )'.
//         			    ' AND ac_mail   LIKE \'%' . $this->db->escape_like_str($set_select['ac_mail']) .   '%\'';

//     	// ORDER BY文 作成
//     	$tmp_firstitem = FALSE;
//     	foreach ($set_orderby as $key => $val)
//     	{
//     		if (isset($val))
//     		{
//     			if ($tmp_firstitem == FALSE)
//     			{
//     				$sql .= ' ORDER BY ' . $key . ' ' . $val;
//     				$tmp_firstitem = TRUE;
//     			} else {
//     				$sql .= ' , ' . $key . ' ' . $val;
//     			}
//     		}
//     	}

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$cate_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$cate_list = $query->result('array');

    	return array($cate_list, $cate_countall);
    }

    /**
     * カテゴリ新規登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_category($setData)
    {

    	// データ追加
    	$query = $this->db->insert('mb_category', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();
    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_category($setData)
    {

    	$where = array(
    			'ca_seq' => $setData['ca_seq']
    	);

    	$result = $this->db->update('mb_category', $setData, $where);
    	return $result;
    }









}