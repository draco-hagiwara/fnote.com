<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Model
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