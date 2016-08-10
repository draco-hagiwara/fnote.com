<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ci_sessions extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * セッションデータの削除
     *
     * @param    timestamp
     * @return   int
     */
    public function destroy_session($del_time)
    {

//     	// 対象データの表示
//     	$sql = 'SELECT
//     			  id,
//     			  ip_address,
//     			  timestamp
//     			FROM ci_sessions
//     			WHERE timestamp <= ?';

//     	$values = array(
//     			$del_time,
//     	);

//     	$query = $this->db->query($sql, $values);
//     	$list = $query->result('array');

//     	print($del_time);
//     	print("<br>");
//     	print_r($list);
//     	print("<br>");
//     	print(date('Y年m月d日 H時i分s秒' , '1470636772'));
//     	print("<br>");
//     	print(date('Y年m月d日 H時i分s秒' , '1470651509'));
//     	print("<br>");

    	// 対象データの削除処理
    	$sql = 'DELETE FROM ci_sessions WHERE timestamp <= ?';

    	$values = array(
    			$del_time,
    	);

    	$result = $this->db->query($sql, $values);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 1;
    	$set_data['lg_type']      = 'session_delete';
    	$set_data['lg_func']      = 'destroy_session';
    	$set_data['lg_detail']    = NULL;
    	$this->insert_log($set_data);

        return;
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