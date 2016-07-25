<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 問合せSEQから登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_cont_seq($seq_no)
    {

    	$set_where["co_seq"]    = $seq_no;

    	$query = $this->db->get_where('tb_contact', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 問合せ一覧の取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_contactlist($arr_post, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE
    	$set_select["co_cl_siteid"]  = $arr_post['co_cl_siteid'];

    	// ORDER BY
    	if ($arr_post['orderid'] == 'ASC')
    	{
    		$set_orderby["co_seq"] = $arr_post['orderid'];
    	}else {
    		$set_orderby["co_seq"] = 'DESC';
    	}

    	// 対象クアカウントメンバーの取得
    	$contact_list = $this->_select_contactlist($set_select, $set_orderby, $tmp_per_page, $tmp_offset);

    	return $contact_list;

    }

    /**
     * 問合せ一覧の取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function _select_contactlist($set_select, $set_orderby, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = "SELECT
    			  co_seq,
    			  co_status,
    			  co_cl_siteid,
    			  co_contact_name,
    			  co_contact_body,
    			  co_contact_tel,
    			  co_contact_mail,
    			  co_create_date
    			FROM tb_contact
    			WHERE co_cl_siteid = '" . $set_select["co_cl_siteid"] . "'";

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
    	$contact_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$contact_list = $query->result('array');

    	return array($contact_list, $contact_countall);
    }

    /**
     * 客先問合せ情報登録処理
     *
     * @param    array()
     * @return   int
     */
    public function insert_contact($setData)
    {

    	// データ追加
    	$query = $this->db->insert('tb_contact', $setData);

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
    public function update_contact($setData)
    {

    	$where = array(
    			'co_seq' => $setData['co_seq']
    	);

    	$result = $this->db->update('tb_contact', $setData, $where);
    	return $result;
    }


}
