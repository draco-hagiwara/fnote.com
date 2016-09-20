<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cate_image extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * データ有無判定＆データ取得
     *
     * @param    int
     * @return   array
     */
    public function get_cate_image_seq($ci_seq)
    {

		$set_where["ci_seq"] = $ci_seq;

    	$query = $this->db->get_where('tb_cate_image', $set_where);

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
//     public function get_interview_siteid($iv_cl_siteid, $empty = FALSE)
//     {

//     	if ($empty == TRUE){
//     		$set_where["iv_cl_seq"] = 0;
//     	} else {
//     		$set_where["iv_cl_siteid"] = $iv_cl_siteid;
//     	}

//     	$query = $this->db->get_where('tb_interview', $set_where);

//     	// データ有無判定
//     	if ($query->num_rows() > 0) {
//     		$get_data = $query->result('array');
//     		return $get_data;
//     	} else {
//     		return FALSE;
//     	}
//     }

    /**
     * データ有無判定＆データ取得
     *
     * @param    int
     * @return   array
     */
    public function get_cate_image_clseq($cl_seq)
    {

    	$set_where["ci_cl_seq"] = $cl_seq;

    	$query = $this->db->get_where('tb_cate_image', $set_where);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }


    /**
     * 画像カテゴリ分類名称の登録＆更新
     *
     * @param    array()
     * @return   int
     */
    public function inup_cate_image($setData, $user_type=3)
    {

    	// INSERT or UPDATE
    	$sql = 'SELECT * FROM `tb_cate_image` '
    			. 'WHERE `ci_cl_seq` = ? ';

    	$values = array(
    			$setData['ci_cl_seq'],
    	);

    	$query = $this->db->query($sql, $values);
    	if ($query->num_rows() > 0) {

    		// データ更新
	    	$where = array(
	    			'ci_cl_seq' => $setData['ci_cl_seq']
	    	);

	    	$result = $this->db->update('tb_cate_image', $setData, $where);

	    	// ログ書き込み
	    	$set_data['lg_user_type'] = $user_type;
	    	$set_data['lg_type']      = 'cate_image_update';
	    	$set_data['lg_func']      = 'inup_cate_image';
	    	$set_data['lg_detail']    = 'ci_cl_siteid = ' . $setData['ci_cl_siteid'];
	    	$this->insert_log($set_data);


    	} else {

    		// データ追加
    		$result = $this->db->insert('tb_cate_image', $setData);

    		// ログ書き込み
    		$set_data['lg_user_type'] = $user_type;
    		$set_data['lg_type']      = 'cate_image_insert';
	    	$set_data['lg_func']      = 'inup_cate_image';
    		$set_data['lg_detail']    = 'ci_cl_siteid = ' . $setData['ci_cl_siteid'];
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

}