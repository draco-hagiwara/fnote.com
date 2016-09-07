<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tenpomenu extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * メニューSEQから情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_menu_seq($seq_no)
    {

    	$set_where["mn_seq"] = $seq_no;

    	$query = $this->db->get_where('tb_tenpomenu', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * メニューparent(親階層)から情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_menu_parent($parent_no)
    {

    	$set_where["mn_parent"] = $parent_no;

    	$query = $this->db->get_where('tb_tenpomenu', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第一階層メニューデータ取得
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent1($siteid)
    {

    	$sql = 'SELECT mn_seq, mn_id01, mn_id02, mn_id03, mn_name, mn_parent, mn_level, mn_dispno, mn_cnt, mn_cl_seq, mn_cl_siteid FROM `tb_tenpomenu` '
    			. 'WHERE mn_status = 0 AND `mn_cl_siteid` = ? AND `mn_level` = 1 ORDER BY mn_dispno ASC';
//     			. 'WHERE `mn_cl_siteid` = ? AND `mn_level` = 1 ORDER BY mn_dispno ASC';

    	$values = array($siteid);

	   	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第二階層メニューデータ取得
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent2($seq01, $siteid)
    {

    	$sql = 'SELECT mn_seq, mn_id01, mn_id02, mn_id03, mn_name, mn_parent, mn_level, mn_dispno, mn_cnt, mn_cl_seq, mn_cl_siteid FROM `tb_tenpomenu` '
    			. 'WHERE mn_status = 0 AND `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_dispno ASC';
//     			. 'WHERE `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_dispno ASC';

    	$values = array($seq01,$siteid);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第三階層メニューデータ取得
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent3($seq02, $siteid)
    {

    	$sql = 'SELECT mn_seq, mn_id01, mn_id02, mn_id03, mn_name, mn_parent, mn_level, mn_dispno, mn_cnt, mn_cl_seq, mn_cl_siteid FROM `tb_tenpomenu` '
    			. 'WHERE mn_status = 0 AND `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_dispno ASC';
//     			. 'WHERE `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_dispno ASC';

    	$values = array($seq02, $siteid);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第三階層メニューデータ取得 (全データ)
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent3_data($seq02, $siteid)
    {

    	$sql = 'SELECT * FROM `tb_tenpomenu` '
    			. 'WHERE mn_status = 0 AND `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_dispno ASC';

    	$values = array($seq02, $siteid);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 店舗メニューの取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_menulist($arr_post, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE
    	$set_select["mn_cl_siteid"]  = $arr_post['mn_cl_siteid'];

    	// ORDER BY
    	if ($arr_post['orderid'] == 'ASC')
    	{
    		$set_orderby["mn_seq"] = $arr_post['orderid'];
    	}else {
    		$set_orderby["mn_seq"] = 'DESC';
    	}

    	// 対象クアカウントメンバーの取得
    	$menu_list = $this->_select_menulist($set_select, $set_orderby, $tmp_per_page, $tmp_offset);

    	return $menu_list;

    }

    /**
     * 店舗メニュー一覧の取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function _select_menulist($set_select, $set_orderby, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = "SELECT
    			  mn_seq,
    			  mn_status,
    			  mn_id01,
    			  mn_id02,
    			  mn_id03,
    			  mn_name,
    			  mn_parent,
    			  mn_level,
    			  mn_dispno,
    			  mn_menu,
    			  mn_price,
    			  mn_info,
    			  mn_cnt,
    			  mn_cl_seq,
    			  mn_cl_siteid,
    			  mn_update_date
    			FROM tb_tenpomenu
    			WHERE mn_cl_siteid = '" . $set_select["mn_cl_siteid"] . "'";
//     			WHERE mn_status = 0 AND mn_cl_siteid = '" . $set_select["mn_cl_siteid"] . "'";

    	// ORDER BY文 作成
    	$tmp_firstitem = FALSE;
    	foreach ($set_orderby as $key => $val)
    	{
    		if (isset($val))
    		{
    			if ($tmp_firstitem == FALSE)
    			{
    				$sql .= ' ORDER BY ' . $key . ' ' . $val;
    				$tmp_firstitem = TRUE;
    			} else {
    				$sql .= ' , ' . $key . ' ' . $val;
    			}
    		}
    	}

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$menu_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$menu_list = $query->result('array');

    	return array($menu_list, $menu_countall);
    }

    /**
     * 第一メニュー：最終データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent1_last($siteid)
    {

    	$sql = 'SELECT * FROM `tb_tenpomenu` '
    			. 'WHERE `mn_cl_siteid` = ? AND `mn_level` = 1 ORDER BY mn_seq DESC LIMIT 1';

    	$values = array($siteid);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第二メニュー：最終データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent2_last($seq01, $siteid)
    {

    	$sql = 'SELECT * FROM `tb_tenpomenu` '
    			. 'WHERE `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_seq DESC LIMIT 1';

    	$values = array($seq01, $siteid);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 第三メニュー：最終データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_menu_parent3_last($seq02, $siteid)
    {

    	$sql = 'SELECT * FROM `tb_tenpomenu` '
    			. 'WHERE `mn_parent` = ? AND `mn_cl_siteid` = ? ORDER BY mn_seq DESC LIMIT 1';

    	$values = array($seq02, $siteid);

    	$query = $this->db->query($sql, $values);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 店舗メニュー 新規登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_tenpomenu($setData, $user_type=3)
    {

    	// データ追加
    	$query = $this->db->insert('tb_tenpomenu', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'tenpomenu_insert';
    	$set_data['lg_func']      = 'insert_tenpomenu';
   		$set_data['lg_detail'] = 'mn_name = ' . $setData["mn_name"];

    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_menu($setData)
    {

    	$where = array(
    			'mn_seq' => $setData['mn_seq']
    	);

    	$result = $this->db->update('tb_tenpomenu', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'tenpomenu_update';
    	$set_data['lg_func']      = 'update_tenpomenu';
    	$set_data['lg_detail']    = 'mn_seq = ' . $setData['mn_seq'];
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
