<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * クライアントSEQから登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_cl_seq($seq_no, $status = FALSE)
    {

    	if ($status == FALSE)
    	{
    		$set_where["cl_status"] = 0;						// ステータス=登録中
    	}
    	$set_where["cl_seq"]    = $seq_no;

    	$query = $this->db->get_where('mb_client', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * クライアントIDから登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_cl_id($cl_id)
    {

    	$set_where["cl_id"]    = $cl_id;

    	$query = $this->db->get_where('mb_client', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * クライアントサイトIDから登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_cl_siteid($cl_siteid)
    {

    	$set_where["cl_siteid"]    = $cl_siteid;

    	$query = $this->db->get_where('mb_client', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * クライアントSEQから営業＆編集者情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_clac_seq($cl_seq, $cl_id)
    {

    	if (isset($cl_seq))
    	{
    		$set_where["cl_seq"]    = $cl_seq;
    	} else {
    		$set_where["cl_id"]    = $cl_id;
    	}

    	$query = $this->db->get_where('vw_a_clientlist', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * クライアントメンバーの取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_clientlist($arr_post, $tmp_per_page, $tmp_offset=0)
    {

    	// 各SQL項目へセット
    	// WHERE
    	$set_select["cl_siteid"]  = $arr_post['cl_siteid'];
    	$set_select["cl_company"] = $arr_post['cl_company'];

    	if ($arr_post['ac_type'] == 0)
    	{
    		$set_select["cl_editor_id"] = $arr_post['ac_seq'];
    	} elseif ($arr_post['ac_type'] == 1) {
    		$set_select["cl_sales_id"] = $arr_post['ac_seq'];
    	} else {

    	}

    	// ORDER BY
    	if ($arr_post['orderid'] == 'ASC')
    	{
    		$set_orderby["cl_seq"] = $arr_post['orderid'];
    	}else {
    		$set_orderby["cl_seq"] = 'DESC';
    	}

    	// 対象クアカウントメンバーの取得
    	$client_list = $this->_select_clientlist($set_select, $set_orderby, $tmp_per_page, $tmp_offset);

    	return $client_list;

    }

    /**
     * 対象クライアントメンバーの取得
     *
     * @param    array() : WHERE句項目
     * @param    array() : ORDER BY句項目
     * @param    int     : 1ページ当たりの表示件数
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function _select_clientlist($set_select, $set_orderby, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT
    			  cl_seq,
    			  cl_status,
    			  cl_sales_id,
    			  salsename01,
    			  salsename02,
    			  cl_editor_id,
    			  editorname01,
    			  editorname02,
    			  adminname01,
    			  adminname02,
    			  cl_siteid,
    			  cl_company,
    			  cl_mail
    			FROM vw_a_clientlist ';

    	// WHERE文 作成
    	$sql .= ' WHERE
    				cl_siteid LIKE \'%' .        $this->db->escape_like_str($set_select['cl_siteid'] ) . '%\'' .
        			' AND cl_company LIKE \'%' . $this->db->escape_like_str($set_select['cl_company']) . '%\'';

    	// アクセス制限
    	if (isset($set_select["cl_editor_id"]))
    	{
    		$sql .= ' AND cl_editor_id = ' . $set_select["cl_editor_id"] ;
    	} elseif(isset($set_select["cl_sales_id"]))
    	{
    		$sql .= ' AND cl_sales_id = ' . $set_select["cl_sales_id"] ;
    	}

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
    	$client_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$client_list = $query->result('array');

    	return array($client_list, $client_countall);
    }

    /**
     * 重複データのチェック：サイトID(URL名)
     *
     * @param    char
     * @param    bool         :: FALSE => 新規登録時。 TRUE => 更新時使用。
     * @return   bool
     */
    public function check_siteid($seq = FALSE, $cl_siteid)
    {

    	if ($seq == FALSE)
    	{
    		$sql = 'SELECT * FROM `mb_client` '
    				. 'WHERE `cl_siteid` = ? ';

    		$values = array(
    				$cl_siteid,
    		);
    	} else {
	    	$sql = 'SELECT * FROM `mb_client` '
	    			. 'WHERE `cl_seq` != ? AND `cl_siteid` = ? ';

	    	$values = array(
	    			$seq,
	    			$cl_siteid,
	    	);
    	}

    	$query = $this->db->query($sql, $values);

    	if ($query->num_rows() > 0) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 重複データのチェック：ログインID
     *
     * @param    char
     * @param    bool         :: FALSE => 新規登録時。 TRUE => 更新時使用。
     * @return   bool
     */
    public function check_loginid($seq = FALSE, $cl_id)
    {

    	if ($seq == FALSE)
    	{
    		$sql = 'SELECT * FROM `mb_client` '
    				. 'WHERE `cl_id` = ? ';

    		$values = array(
    				$cl_id,
    		);
    	} else {
	    	$sql = 'SELECT * FROM `mb_client` '
	    			. 'WHERE `cl_seq` != ? AND `cl_id` = ? ';

	    	$values = array(
	    			$seq,
	    			$cl_id,
	    	);
    	}

    	$query = $this->db->query($sql, $values);


    	print($cl_id);
    	print("count :: ");
    	print($query->num_rows());


    	if ($query->num_rows() > 0) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 重複データのチェック：メールアドレス
     *
     * @param    int
     * @param    varchar
     * @return   bool
     */
    public function check_mailaddr($seq, $mail)
    {

    	$sql = 'SELECT * FROM `mb_client` '
    			. 'WHERE `cl_seq` != ? AND `cl_mail` = ? ';

    	$values = array(
    			$seq,
    			$mail,
    	);

    	$query = $this->db->query($sql, $values);

    	if ($query->num_rows() > 0) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * クライアント新規会員登録
     *
     * @param    array()
     * @param    bool : パスワード設定有無(空PWは危険なので一応初期登録でも入れておく)
     * @return   int
     */
    public function insert_client($setData, $pw = FALSE)
    {

    	// パスワード入力有無
    	if ($pw == TRUE)
    	{
    		$_hash_pw = password_hash($setData["cl_pw"], PASSWORD_DEFAULT);
    		$setData["cl_pw"] = $_hash_pw;
    	} else {
    		unset($setData["cl_pw"]) ;
    	}

    	// データ追加
    	$query = $this->db->insert('mb_client', $setData);

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
    public function update_client($setData, $pw = FALSE)
    {

    	// パスワード更新有無
    	if ($pw == TRUE)
    	{
    		$_hash_pw = password_hash($setData["cl_pw"], PASSWORD_DEFAULT);
    		$setData["cl_pw"] = $_hash_pw;
    	} else {
    		unset($setData["cl_pw"]) ;
    	}

    	$where = array(
    			'cl_seq' => $setData['cl_seq']
    	);

    	$result = $this->db->update('mb_client', $setData, $where);
    	return $result;
    }

    /**
     * ログイン日時の更新
     *
     * @param    int
     * @return   bool
     */
    public function update_Logindate($cl_seq)
    {

    	$time = time();
    	$setData = array(
    			'cl_lastlogin' => date("Y-m-d H:i:s", $time)
    	);
    	$where = array(
    			'cl_seq' => $cl_seq
    	);
    	$result = $this->db->update('mb_client', $setData, $where);
    	return $result;
    }

}