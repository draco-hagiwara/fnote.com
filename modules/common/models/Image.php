<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 該当画像データの取得
     *
     * @param    int
     * @return   array
     */
    public function get_image_imseq($im_seq)
    {

    	$set_where["im_seq"] = $im_seq;

    	$query = $this->db->get_where('tb_image', $set_where);

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
    public function get_image_clseq($cl_seq)
    {

    	$sql = 'SELECT
    			  im_seq,
    			  im_status,
    			  im_type,
    			  im_size,
    			  im_width,
    			  im_height,
    			  im_filename,
    			  im_title,
    			  im_description,
    			  im_disp_no,
    			  im_cl_siteid,
    			  im_create_date
    			FROM tb_image ';

    	// WHERE文 作成
    	$sql .= ' WHERE im_cl_seq = ' . $cl_seq;

    	$sql .= ' ORDER BY im_disp_no ASC';

    	// クエリー実行
    	$query = $this->db->query($sql);

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
    public function get_image_clsiteid($cl_siteid)
    {

    	$set_where["im_cl_siteid"] = $cl_siteid;

    	$query = $this->db->get_where('tb_image', $set_where);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 画像情報 登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_image($setData)
    {

    	// データ追加
    	$query = $this->db->insert('tb_image', $setData);

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
    public function update_image_imseq($setData)
    {

    	$where = array(
    			'im_seq' => $setData['im_seq']
    	);

    	$result = $this->db->update('tb_image', $setData, $where);
    	return $result;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_image_siteid($setData)
    {

    	$where = array(
    			'im_cl_siteid' => $setData['im_cl_siteid']
    	);

    	$result = $this->db->update('tb_image', $setData, $where);
    	return $result;
    }

    /**
     * 1レコード削除
     *
     * @param    array()
     * @return   bool
     */
    public function delete_image_seq($setData)
    {

    	$where = array(
    			'im_seq' => $setData['im_seq']
    	);

    	$result = $this->db->delete('tb_image', $where);
    	return $result;
    }

}