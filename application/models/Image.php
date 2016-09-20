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
     * @param    int
     * @param    int
     * @return   array
     */
    public function get_image_clseq($cl_seq, $status=FALSE)
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
    			  im_tag,
    			  im_disp_no,
    			  im_header,
    			  im_cl_siteid,
    			  im_create_date
    			FROM tb_image ';

    	// WHERE文 作成
    	$sql .= ' WHERE im_cl_seq = ' . $cl_seq;

    	if ($status == TRUE)
    	{
    		$sql .= ' AND im_status = 1';
    	}


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
     * TOP画像使用有無データ取得
     *
     * @param    int
     * @return   array
     */
    public function get_image_header($cl_siteid)
    {

    	$sql = 'SELECT im_seq, im_filename FROM tb_image'
    			. ' WHERE im_cl_siteid = ? AND im_header = 1 AND im_status = 1';

    	$values = array($cl_siteid);

    	// クエリー実行
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
     * 画像情報 登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_image($setData, $user_type=2)
    {

    	// データ追加
    	$query = $this->db->insert('tb_image', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_insert';
    	$set_data['lg_func']      = 'insert_image';
    	$set_data['lg_detail']    = 'im_filename = ' . $setData['im_filename'];
    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_image_imseq($setData, $user_type=2)
    {

    	$where = array(
    			'im_seq' => $setData['im_seq']
    	);

    	$result = $this->db->update('tb_image', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_update';
    	$set_data['lg_func']      = 'update_image_imseq';
    	$set_data['lg_detail']    = 'im_seq = ' . $setData['im_seq'];
    	$this->insert_log($set_data);

    	return $result;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_image_siteid($setData, $user_type=2)
    {

    	$where = array(
    			'im_cl_siteid' => $setData['im_cl_siteid']
    	);

    	$result = $this->db->update('tb_image', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_update';
    	$set_data['lg_func']      = 'update_image_siteid';
    	$set_data['lg_detail']    = 'im_cl_siteid = ' . $setData['im_cl_siteid'];
    	$this->insert_log($set_data);

    	return $result;
    }

    /**
     * 1レコード削除
     *
     * @param    array()
     * @return   bool
     */
    public function delete_image_seq($setData, $user_type=2)
    {

    	$where = array(
    			'im_seq' => $setData['im_seq']
    	);

    	$result = $this->db->delete('tb_image', $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_delete';
    	$set_data['lg_func']      = 'delete_image_seq';
    	$set_data['lg_detail']    = 'im_seq = ' . $setData['im_seq'];
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