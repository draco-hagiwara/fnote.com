<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends CI_Model
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
    public function get_entry_siteid($en_cl_siteid, $empty = FALSE)
    {

    	if ($empty == TRUE){
    		$set_where["en_cl_seq"] = 0;
    	} else {
    		$set_where["en_cl_siteid"] = $en_cl_siteid;
    	}

    	$query = $this->db->get_where('tb_entry', $set_where);

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
    public function get_entry_clid($cl_id, $empty = FALSE)
    {

    	if ($empty == TRUE){
    		$set_where["en_cl_seq"] = 0;
    	} else {
    		$set_where["en_cl_id"] = $cl_id;
    	}

    	$query = $this->db->get_where('tb_entry', $set_where);

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
    public function get_entry_clseq($cl_seq)
    {

    	$set_where["en_cl_seq"] = $cl_seq;

    	$query = $this->db->get_where('tb_entry', $set_where);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 店舗情報の登録＆更新
     *
     * @param    array()
     * @return   int
     */
    public function inup_tenpo($setData)
    {

    	// INSERT or UPDATE
    	$sql = 'SELECT * FROM `tb_entry` '
    			. 'WHERE `en_cl_id` = ? ';

    	$values = array(
    			$setData['en_cl_id'],
    	);

    	$query = $this->db->query($sql, $values);
    	if ($query->num_rows() > 0) {

    		// データ更新
	    	$where = array(
	    			'en_cl_id' => $setData['en_cl_id']
	    	);

	    	$result = $this->db->update('tb_entry', $setData, $where);
	    	return $result;

    	} else {

    		// データ追加
    		$result = $this->db->insert('tb_entry', $setData);
    		return $result;

    	}

    }





}