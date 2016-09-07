<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tenpocoupon extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * クーポンSEQから情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_coupon_seq($seq_no)
    {

    	$set_where["cp_seq"] = $seq_no;

    	$query = $this->db->get_where('tb_tenpocoupon', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * Site_idから情報を取得する
     *
     * @param    varchar
     * @return   bool
     */
    public function get_coupon_siteid($siteid)
    {

    	$set_where["cp_status"]    = 0;
    	$set_where["cp_cl_siteid"] = $siteid;

    	$query = $this->db->get_where('tb_tenpocoupon', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 店舗クーポンの取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_couponlist($arr_post, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE
    	$set_select["cp_cl_siteid"]  = $arr_post['cp_cl_siteid'];

    	// ORDER BY
    	if ($arr_post['orderid'] == 'ASC')
    	{
    	}else {
    		$set_orderby["cp_end_date"] = 'DESC';
    	}

    	// 対象クアカウントメンバーの取得
    	$coupon_list = $this->_select_couponlist($set_select, $set_orderby, $tmp_per_page, $tmp_offset);

    	return $coupon_list;

    }

    /**
     * 店舗クーポン一覧の取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function _select_couponlist($set_select, $set_orderby, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = "SELECT
    			  cp_seq,
    			  cp_status,
    			  cp_title,
    			  cp_start_date,
    			  cp_end_date,
    			  cp_update
    			FROM tb_tenpocoupon
    			WHERE cp_cl_siteid = '" . $set_select["cp_cl_siteid"] . "'";

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
    	$coupon_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$coupon_list = $query->result('array');

    	return array($coupon_list, $coupon_countall);
    }


    /**
     * 店舗クーポン 新規登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_coupon($setData, $user_type=3)
    {

    	// データ追加
    	$query = $this->db->insert('tb_tenpocoupon', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = $user_type;
    	$set_data['lg_type']      = 'tenpocoupon_insert';
    	$set_data['lg_func']      = 'insert_tenpocoupon';
   		$set_data['lg_detail']    = 'cp_seq = ' . $setData["cp_seq"];

    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_coupon($setData)
    {

    	$where = array(
    			'cp_seq' => $setData['cp_seq']
    	);

    	$result = $this->db->update('tb_tenpocoupon', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'tenpocoupon_update';
    	$set_data['lg_func']      = 'update_coupon';
    	$set_data['lg_detail']    = 'cp_seq = ' . $setData['cp_seq'];
    	$this->insert_log($set_data);

    	return $result;
    }

    /**
     * レコード削除
     *
     * @param    int
     * @return   array()
     */
    public function delete_coupon($seq_no)
    {

    	$where = array('cp_seq' => $seq_no);

    	$result = $this->db->delete('tb_tenpocoupon', $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'tenpocoupon_delete';
    	$set_data['lg_func']      = 'delete_coupon';
    	$set_data['lg_detail']    = 'cp_seq = ' . $seq_no;
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
