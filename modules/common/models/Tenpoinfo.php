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

		$set_where["tp_seq"] = $tp_seq;

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

    /**
     * データ有無判定＆データ取得
     *
     * @param    char
     * @return   array
     */
    public function get_tenpo_clseq($cl_seq)
    {

    	$set_where["tp_cl_seq"] = $cl_seq;

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

	    	return $result;

    	} else {

    		// データ追加
    		$result = $this->db->insert('tb_tenpoinfo', $setData);

    		// 挿入した ID 番号を取得
    		$row_id = $this->db->insert_id();

    		// ログ書き込み
    		$set_data['lg_user_type'] = $user_type;
    		$set_data['lg_type']      = 'tenpoinfo_insert';
	    	$set_data['lg_func']      = 'inup_tenpo';
    		$set_data['lg_detail']    = 'tp_cl_siteid = ' . $setData['tp_cl_siteid'];
    		$this->insert_log($set_data);

    		return $row_id;

    	}
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