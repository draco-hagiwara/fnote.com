<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_article extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * ブログ : SEQから登録情報を取得する
     *
     * @param    int
     * @return   bool
     */
    public function get_blog_seq($seq_no)
    {

    	$set_where["bar_seq"]    = $seq_no;

    	$query = $this->db->get_where('tb_blog_article', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * ブログ : siteidから登録情報を取得する
     *
     * @param    char
     * @return   array
     */
    public function get_blog_siteid($bar_cl_siteid)
    {

        $this->db->from('tb_blog_article');
    	$this->db->where("bar_cl_siteid", $bar_cl_siteid);
    	$this->db->order_by("bar_seq",    "desc");

    	$query = $this->db->get();

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
    public function get_bloglist($cl_seq, $tmp_per_page, $tmp_offset=0)
    {

    	// 対象クアカウントメンバーの取得
    	$blog_list = $this->_select_bloglist($cl_seq, $tmp_per_page, $tmp_offset);

    	return $blog_list;

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
    public function _select_bloglist($cl_seq, $tmp_per_page, $tmp_offset=0)
    {

    	$sql = 'SELECT
    			  bar_seq,
    			  bar_status,
    			  bar_comment,
    			  bar_trackback,
    			  bar_date,
    			  bar_subject,
    			  bar_text,
    			  bar_tag,
    			  bar_cl_seq,
    			  bar_create_date
    			FROM tb_blog_article ';

    	// WHERE文 作成
    	$sql .= ' WHERE bar_cl_seq = ' . $cl_seq;
    	$sql .= ' ORDER BY bar_seq DESC';

    	// 対象全件数を取得
    	$query = $this->db->query($sql);
    	$blog_countall = $query->num_rows();

    	// LIMIT ＆ OFFSET 値をセット
    	$sql .= ' LIMIT ' . $tmp_per_page . ' OFFSET ' . $tmp_offset;

    	// クエリー実行
    	$query = $this->db->query($sql);
    	$blog_list = $query->result('array');

    	return array($blog_list, $blog_countall);
    }

    /**
     * ブログ新規登録
     *
     * @param    array()
     * @return   int
     */
    public function insert_blog($setData)
    {

    	// データ追加
    	$query = $this->db->insert('tb_blog_article', $setData);

    	// 挿入した ID 番号を取得
    	$row_id = $this->db->insert_id();

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'blog_insert';
    	$set_data['lg_func']      = 'insert_blog';
    	$set_data['lg_detail']    = 'bar_seq = ' . $row_id;
    	$this->insert_log($set_data);

    	return $row_id;
    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_blog($setData)
    {

    	$where = array(
    			'bar_seq' => $setData['bar_seq']
    	);

    	$result = $this->db->update('tb_blog_article', $setData, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'blog_update';
    	$set_data['lg_func']      = 'update_blog';
    	$set_data['lg_detail']    = 'bar_seq = ' . $setData['bar_seq'];
    	$this->insert_log($set_data);

    	return $result;
    }

    /**
     * 1レコード削除
     *
     * @param    int
     * @return   bool
     */
    public function delete_blog($bar_seq)
    {

    	$where = array(
    			'bar_seq' => $bar_seq
    	);

    	$result = $this->db->delete('tb_blog_article', $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 3;
    	$set_data['lg_type']      = 'blog_delete';
    	$set_data['lg_func']      = 'delete_blog';
    	$set_data['lg_detail']    = 'bar_seq = ' . $bar_seq;
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