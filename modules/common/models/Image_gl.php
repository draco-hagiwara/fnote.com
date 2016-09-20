<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_gl extends CI_Model
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
    public function get_image_glseq($gl_seq)
    {

    	$set_where["gl_seq"] = $gl_seq;

    	$query = $this->db->get_where('tb_image_gl', $set_where);

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
    			  gl_seq,
    			  gl_status,
    			  gl_type,
    			  gl_size,
    			  gl_width,
    			  gl_height,
    			  gl_filename,
    			  gl_title,
    			  gl_description,
    			  gl_tag,
    			  gl_disp_no,
    			  gl_cate,
    			  gl_goodcnt,
    			  gl_cl_seq,
    			  gl_cl_siteid,
    			  gl_create_date,
    			  gl_update_date
    			FROM tb_image_gl ';

    	// WHERE文 作成
    	$sql .= ' WHERE gl_cl_seq = ' . $cl_seq;

    	if ($status == TRUE)
    	{
    		$sql .= ' AND gl_status = 1';
    	}

    	$sql .= ' ORDER BY gl_disp_no ASC, gl_update_date DESC';

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

    	$set_where["gl_status"]    = 1;
    	$set_where["gl_cl_siteid"] = $cl_siteid;

    	$query = $this->db->get_where('tb_image_gl', $set_where);

    	// データ有無判定
    	if ($query->num_rows() > 0) {
    		$get_data = $query->result('array');
    		return $get_data;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * データ全件の取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_imagelist($gl_cl_seq, $tmp_per_page, $tmp_offset=0)
    {

    	// 対象クアカウントメンバーの取得
    	$image_list = $this->_select_imagelist($gl_cl_seq, $tmp_per_page, $tmp_offset);

    	return $image_list;

    }

    /**
     * データ全件の取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function _select_imagelist($gl_cl_seq, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT
    			  gl_seq,
    			  gl_status,
    			  gl_type,
    			  gl_size,
    			  gl_width,
    			  gl_height,
    			  gl_filename,
    			  gl_title,
    			  gl_description,
    			  gl_tag,
    			  gl_disp_no,
    			  gl_cate,
    			  gl_goodcnt,
    			  gl_cl_seq,
    			  gl_cl_siteid,
    			  gl_create_date,
    			  gl_update_date
    			FROM tb_image_gl ';

    	// WHERE文 作成
    	$sql .= ' WHERE gl_cl_seq = ' . $gl_cl_seq;
    	$sql .= ' ORDER BY gl_disp_no ASC, gl_update_date DESC';

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$image_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$image_list = $query->result('array');

    	return array($image_list, $image_countall);
    }

    /**
     * 画像情報 登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_image($setData, $user_type=3)
    {

    	// データ追加
    	$query = $this->db->insert('tb_image_gl', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_gl_insert';
    	$set_data['lg_func']      = 'insert_image';
    	$set_data['lg_detail']    = 'gl_filename = ' . $setData['gl_filename'];
    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_image_glseq($setData, $user_type=3)
    {

    	$where = array(
    			'gl_seq' => $setData['gl_seq']
    	);

    	$result = $this->db->update('tb_image_gl', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_gl_update';
    	$set_data['lg_func']      = 'update_image_glseq';
    	$set_data['lg_detail']    = 'gl_seq = ' . $setData['gl_seq'];
    	$this->insert_log($set_data);

    	return $result;
    }

//     /**
//      * 1レコード更新
//      *
//      * @param    array()
//      * @return   bool
//      */
//     public function update_image_siteid($setData, $user_type=2)
//     {

//     	$where = array(
//     			'im_cl_siteid' => $setData['im_cl_siteid']
//     	);

//     	$result = $this->db->update('tb_image', $setData, $where);

//     	// ログ書き込み
//     	$set_data['lg_user_type'] = $user_type;
//     	$set_data['lg_type']      = 'image_update';
//     	$set_data['lg_func']      = 'update_image_siteid';
//     	$set_data['lg_detail']    = 'im_cl_siteid = ' . $setData['im_cl_siteid'];
//     	$this->insert_log($set_data);

//     	return $result;
//     }

    /**
     * 1レコード削除
     *
     * @param    array()
     * @return   bool
     */
    public function delete_image_seq($setData, $user_type=3)
    {

    	$where = array(
    			'gl_seq' => $setData['gl_seq']
    	);

    	$result = $this->db->delete('tb_image_gl', $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'image_gl_delete';
    	$set_data['lg_func']      = 'delete_image_seq';
    	$set_data['lg_detail']    = 'gl_seq = ' . $setData['gl_seq'];
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