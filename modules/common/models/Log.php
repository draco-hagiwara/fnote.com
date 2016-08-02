<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ログ書き込み
     *
     * @param    array()
     * @return   int
     */
    public function insert_log($setData)
    {

    	$setData['lg_ip'] = $this->input->ip_address();

        // データ追加
        $query = $this->db->insert('tb_log', $setData);

        // 挿入した ID 番号を取得
        $row_id = $this->db->insert_id();
        return $row_id;
    }

}