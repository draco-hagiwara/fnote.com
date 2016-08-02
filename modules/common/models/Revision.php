<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Revision extends CI_Model
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
    public function get_revision_rvseq($rv_seq)
    {

    	$sql = 'SELECT * FROM `tb_revision` '
    			. 'WHERE `rv_seq` = ?';

    	$values = array(
    			$rv_seq,
    	);

    	$query = $this->db->query($sql, $values);

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
    public function get_revision_clseq($cl_seq)
    {

    	$sql = 'SELECT * FROM `tb_revision` '
    			. 'WHERE `rv_cl_seq` = ? ORDER BY rv_update_date DESC';

    	$values = array(
    					$cl_seq,
    	);

    	$query = $this->db->query($sql, $values);

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
    public function get_revision_siteid($cl_siteid)
    {

    	$sql = 'SELECT * FROM `tb_revision` '
    			. 'WHERE `rv_cl_siteid` = ? ORDER BY rv_update_date DESC';

    	$values = array(
    			$cl_siteid,
    	);

    	$query = $this->db->query($sql, $values);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 一番古いデータを取得
     *
     * @param    char
     * @return   array
     */
    public function get_revision_old($cl_seq)
    {

    	$sql = 'SELECT * FROM `tb_revision` '
    			. 'WHERE `rv_cl_seq` = ? ORDER BY rv_update_date ASC LIMIT 1';

    	$values = array(
    					$cl_seq,
    	);

    	$query = $this->db->query($sql, $values);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 新規登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_revision($setData)
    {

    	// データ追加
    	$query = $this->db->insert('tb_revision', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = 2;
    	$set_data['lg_type']      = 'revision_insert';
    	$set_data['lg_func']      = 'insert_revision';
    	$set_data['lg_detail']    = 'rv_seq = ' . $row_id;
    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_revision($setData)
    {

    	$where = array(
    			'rv_seq' => $setData['rv_seq']
    	);

    	$result = $this->db->update('tb_revision', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 2;
    	$set_data['lg_type']      = 'revision_update';
    	$set_data['lg_func']      = 'update_revision';
    	$set_data['lg_detail']    = 'rv_seq = ' . $setData['rv_seq'];
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