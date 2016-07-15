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
    	return $row_id;
    }

}
