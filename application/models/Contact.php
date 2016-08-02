<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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

    	// ログ書き込み
    	$set_data['lg_user_type'] = 5;
    	$set_data['lg_type']      = 'contact_insert';
    	$set_data['lg_func']      = 'insert_contact';
    	$set_data['lg_detail']    = 'co_seq = ' . $row_id;
    	$this->insert_log($set_data);

    	return $row_id;
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
