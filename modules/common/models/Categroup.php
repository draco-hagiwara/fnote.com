<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categroup extends CI_Model
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

    	$sql = 'SELECT * FROM `mb_categroup` '
    			. 'WHERE `ca_seq` = ' . $ca_seq;

    	$query = $this->db->query($sql);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * カテゴリデータ取得 : id and level and parent
     *
     * @param    char
     * @return   array
     */
    public function get_category_id($ca_id, $ca_parent=NULL, $ca_level=NULL)
    {

    	$sql = 'SELECT ca_seq, ca_name, ca_id, ca_parent, ca_level, ca_dispno FROM `mb_categroup` '
    			. 'WHERE `ca_id` = \'' . ltrim($ca_id, 0) . '\'';

    	if (isset($ca_parent))
    	{
    		$sql .= ' AND `ca_parent` = ' . $ca_parent;
    	}

    	if (isset($ca_level))
    	{
    		$sql .= ' AND `ca_level` = ' . $ca_level;
    	}

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

    	$sql = 'SELECT ca_seq, ca_name, ca_id, ca_parent, ca_level, ca_dispno FROM `mb_categroup` '
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

    	$sql = 'SELECT ca_seq, ca_name, ca_id, ca_parent, ca_level, ca_dispno FROM `mb_categroup` '
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

    	$sql = 'SELECT ca_seq, ca_name, ca_id, ca_parent, ca_level, ca_dispno FROM `mb_categroup` '
    			. 'WHERE `ca_parent` = ? ORDER BY ca_dispno ASC';

    	$values = array(
    			$cate02,
    	);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * カテゴリIDからリスト取得
     *
     * @param    char
     * @return   array
     */
    public function get_category_name($tp_cate)
    {

    	$cate_no = explode(',', $tp_cate);											// 分割

    	$i = 0;
    	foreach ($cate_no as $val)
    	{

    		$rep_val = str_replace("-", "", $val);
    		$cate_id = str_split($rep_val, 2);										// 2桁毎に分割

    		// 第一カテ名称
    		$cate1 = $this->get_category_id($cate_id[0], NULL, 1);

    		// 第二カテ名称
    		$cate2 = $this->get_category_id($cate_id[1], $cate1[0]['ca_seq'], 2);

    		// 第三カテ名称
    		$cate3 = $this->get_category_id($cate_id[2], $cate2[0]['ca_seq'], 3);

			// 名称
			if (isset($cate1[0]['ca_name']) && isset($cate2[0]['ca_name']) && isset($cate3[0]['ca_name']))
			{
				$cate_name[$i] = $cate1[0]['ca_name'] . ' -> ' . $cate2[0]['ca_name'] . ' -> ' . $cate3[0]['ca_name'];
			} else {
				$cate_name[$i] = "カテゴリのコードエラー";
			}

			$i++;
    	}

    	return $cate_name;

    }

    /**
     * 第一階層カテゴリ：最終データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_cate_parent1_last()
    {

    	$sql = 'SELECT * FROM `mb_categroup` '
    			. 'WHERE `ca_level` = 1 ORDER BY ca_seq DESC LIMIT 1';

    	$query = $this->db->query($sql);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第二階層カテゴリ：最終データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_cate_parent2_last($cate01)
    {

    	$sql = 'SELECT * FROM `mb_categroup` '
    			. 'WHERE `ca_parent` = ? ORDER BY ca_seq DESC LIMIT 1';

    	$values = array(
    			$cate01,
    	);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第三階層カテゴリ：最終データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_cate_parent3_last($cate02)
    {

    	$sql = 'SELECT * FROM `mb_categroup` '
    			. 'WHERE `ca_parent` = ? ORDER BY ca_seq DESC LIMIT 1';

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
    			FROM mb_categroup ';

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
    public function insert_category($setData, $user_type=2)
    {

    	// データ追加
    	$query = $this->db->insert('mb_categroup', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'category_insert';
    	$set_data['lg_func']      = 'insert_category';
    	$set_data['lg_detail']    = 'ca_name = ' . $setData['ca_name'];
    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_category($setData, $user_type=2)
    {

    	$where = array(
    			'ca_seq' => $setData['ca_seq']
    	);

    	$result = $this->db->update('mb_categroup', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'category_update';
    	$set_data['lg_func']      = 'update_category';
    	$set_data['lg_detail']    = '';
//     	$set_data['lg_detail']    = 'ca_name = ' . $setData['ca_name01'] . '/' . $setData['ca_name02'] . '/' . $setData['ca_name03'];
    	$this->insert_log($set_data);

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

}