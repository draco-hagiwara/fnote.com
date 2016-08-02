<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 新着・お知らせ : SEQから登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_news_seq($seq_no)
    {

    	$set_where["nw_seq"]    = $seq_no;

    	$query = $this->db->get_where('tb_news', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 新着・お知らせ : cl_seq から登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_news_clseq($seq_no)
    {

    	$set_where["nw_cl_seq"]    = $seq_no;

    	$query = $this->db->get_where('tb_news', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * データ全件の取得
     *
     * @param    array() : 検索項目値
     * @param    int     : 1ページ当たりの表示件数(LIMIT値)
     * @param    int     : オフセット値(ページ番号)
     * @return   array()
     */
    public function get_newslist($nw_cl_seq, $tmp_per_page, $tmp_offset=0)
    {

    	// 対象クアカウントメンバーの取得
    	$news_list = $this->_select_newslist($nw_cl_seq, $tmp_per_page, $tmp_offset);

    	return $news_list;

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
    public function _select_newslist($nw_cl_seq, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT
    			  nw_seq,
    			  nw_status,
    			  nw_type,
    			  nw_title,
    			  nw_start_date,
    			  nw_end_date
    			FROM tb_news ';

    	// WHERE文 作成
    	$sql .= ' WHERE nw_cl_seq = ' . $nw_cl_seq;
    	$sql .= ' ORDER BY nw_seq DESC';

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$news_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
//     	$query = $this->db->query($sql);
    	$news_list = $query->result('array');

    	return array($news_list, $news_countall);
    }

    /**
     * 新着・お知らせ : 新規会員登録
     *
     * @param    array()
     * @param    bool : パスワード設定有無(空PWは危険なので一応初期登録でも入れておく)
     * @return   int
     */
    public function insert_news($setData)
    {

        // データ追加
        $query = $this->db->insert('tb_news', $setData);

        // 挿入した ID 番号を取得
        $row_id = $this->db->insert_id();

        // ログ書き込み
        $set_data['lg_user_type'] = 3;
        $set_data['lg_type']      = 'news_insert';
        $set_data['lg_func']      = 'insert_news';
        $set_data['lg_detail']    = 'nw_seq = ' . $row_id;
        $this->insert_log($set_data);

        return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_news($setData)
    {

    	$where = array(
    			'nw_seq' => $setData['nw_seq']
    	);

    	$result = $this->db->update('tb_news', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'news_update';
    	$set_data['lg_func']      = 'update_news';
    	$set_data['lg_detail']    = 'nw_seq = ' . $setData['nw_seq'];
    	$this->insert_log($set_data);

    	return $result;
    }

    /**
     * 1レコード削除
     *
     * @param    int
     * @return   bool
     */
    public function delete_news($nw_seq)
    {

    	$where = array(
    			'nw_seq' => $nw_seq
    	);

    	$result = $this->db->delete('tb_news', $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'news_delete';
    	$set_data['lg_func']      = 'delete_news';
    	$set_data['lg_detail']    = 'nw_seq = ' . $setData['nw_seq'];
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