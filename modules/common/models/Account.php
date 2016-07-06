<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 管理者SEQから管理者アカウント情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_ac_seq($seq_no)
    {


    	$set_where["ac_seq"] = $seq_no;

    	$query = $this->db->get_where('mb_account', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 重複データのチェック：ログインID（メールアドレス）
     *
     * @param    varchar
     * @param    bool         :: FALSE => 新規登録時。 TRUE => 更新時使用。
     * @return   bool
     */
    public function check_loginid($loginid, $update = FALSE)
    {

    	$sql = 'SELECT * FROM `mb_account` '
    			. 'WHERE `ac_id` = ? ';

    	$values = array(
    			$loginid,
    	);

    	$query = $this->db->query($sql, $values);

    	if ($update == FALSE)
    	{
    		$count = 0;
    	} else {
    		$count = 1;
    	}

    	if ($query->num_rows() > $count) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    /**
     * 管理者新規会員登録
     *
     * @param    array()
     * @param    bool : パスワード設定有無(空PWは危険なので一応初期登録でも入れておく)
     * @return   int
     */
    public function insert_account($setData, $pw = FALSE)
    {

    	// パスワード入力有無
    	if ($pw == TRUE)
    	{
    		$_hash_pw = password_hash($setData["ac_pw"], PASSWORD_DEFAULT);
    		$setData["ac_pw"] = $_hash_pw;
    	} else {
    		unset($setData["ac_pw"]) ;
    	}

        // データ追加
        $query = $this->db->insert('mb_account', $setData);

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
    public function update_account($setData, $pw = FALSE)
    {

        // パスワード更新有無
    	if ($pw == TRUE)
    	{
    		$_hash_pw = password_hash($setData["ac_pw"], PASSWORD_DEFAULT);
    		$setData["ac_pw"] = $_hash_pw;
    	} else {
    		unset($setData["ac_pw"]) ;
    	}

    	$where = array(
    			'ac_seq' => $setData['ac_seq']
    	);

    	$result = $this->db->update('mb_account', $setData, $where);
    	return $result;
    }

    /**
     * ログイン日時の更新
     *
     * @param    int
     * @return   bool
     */
    public function update_Logindate($ac_seq)
    {

    	$time = time();
    	$setData = array(
    			'ac_lastlogin' => date("Y-m-d H:i:s", $time)
    	);
    	$where = array(
    			'ac_seq' => $ac_seq
    	);
    	$result = $this->db->update('mb_account', $setData, $where);
    	return $result;
    }


}