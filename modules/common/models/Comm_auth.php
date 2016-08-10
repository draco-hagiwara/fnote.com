<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comm_auth extends CI_Model
{

    private $_hash_passwd;
    private $_memType;
    private $_memSeq;
    private $_memSiteid;
    private $_memName;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ログイン・チェック：ログインID（メールアドレス）＆パスワード
     *
     * @param    varchar
     * @param    string
     * @return    string
     */
    public function check_Login($loginid, $password, $login_member)
    {

        $err_mess = NULL;
        switch ($login_member)
        {
            case 'client':
                $sql = 'SELECT cl_seq, cl_status, cl_siteid, cl_pw, cl_company, cl_login_cnt, cl_login_lock, cl_login_time '
                		. 'FROM mb_client '
                        . 'WHERE cl_id      = ? '
                        . 'AND ( cl_status  >= 2 AND cl_status  <= 9 )';

                $values = array(
                        $loginid
                );

                $query = $this->db->query($sql, $values);

                // レコードチェック
                if ($query->num_rows() == 0)
                {
                	// ログ書き込み
                	$set_data['lg_user_type'] = 3;
                	$set_data['lg_type']      = 'auth_check';
                	$set_data['lg_func']      = 'check_Login';
                	$set_data['lg_detail']    = 'ログインIDエラー：cl_id = ' . $loginid;
                	$this->insert_log($set_data);

                    $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    return $err_mess;
                }

                // 重複チェック
                if ($query->num_rows() >= 2)
                {

                	// ログ書き込み
                	$set_data['lg_user_type'] = 3;
                	$set_data['lg_type']      = 'auth_check';
                	$set_data['lg_func']      = 'check_Login';
                	$set_data['lg_detail']    = 'ログインID重複エラー：cl_id = ' . $loginid;
                	$this->insert_log($set_data);

                	$err_mess = '入力されたログインIDが重複しています。システム管理者にご連絡ください。';
                    return $err_mess;
                }

                // ログインID＆パスワード読み込み
                $arrData = $query->result('array');
                if (is_array($arrData))
                {

                	$this->config->load('config_comm');

                	// ログイン解除時間＆ロック有無のチェック
                	$tmp_lock_limit    = $this->config->item('LOGIN_LOCK_LIMITTIME');		// 制限時間(分)
                	$tmp_release_limit = $this->config->item('LOGIN_LOCK_RELEASETIME');		// 解除時間(分)
                	if (isset($arrData[0]['cl_login_time']))
                	{

                		$_lock_time    = new DateTime($arrData[0]['cl_login_time']);
                		$_release_time = new DateTime($arrData[0]['cl_login_time']);
                		$_now_time     = new DateTime();

                		$_mod_lock_limit = '+' . $tmp_lock_limit . 'minute';				// xx分後：$date->modify('+1 minute');
                		$_lock_time->modify($_mod_lock_limit);

                		$_mod_release_limit = '+' . $tmp_release_limit . 'minute';
                		$_release_time->modify($_mod_release_limit);

                		if ($_lock_time > $_now_time)
                		{

		                	if ($arrData[0]['cl_login_lock'] == 1)
		                	{
		                		if ($_release_time > $_now_time)
		                		{
			                		$err_mess = 'このログインIDは現在ロックされています。しばらくしてからログインしていただくかシステム管理者にご連絡ください。';
			                		return $err_mess;
		                		} else {
		                			// ログインロック情報をクリア
		                			$this->_login_lock_clear($login_member, $loginid);
		                			$arrData[0]['cl_login_cnt'] = 0;
		                		}
		                	}
		                } else {
		                	// ログインロック情報をクリア
		                	$this->_login_lock_clear($login_member, $loginid);
		                	$arrData[0]['cl_login_cnt'] = 0;
                		}
                	}

                    // パスワードのチェック
                    $this->_hash_passwd = $arrData[0]['cl_pw'];
                    $res = $this->_check_password($password);
                    if ($res == TRUE)
                    {

                    	// ログインエラーのカウント
                    	$this->_login_error_cnt($login_member, $loginid, $arrData[0]['cl_login_cnt'], $arrData[0]['cl_login_time']);

                    	// ログ書き込み
                    	$set_data['lg_user_type'] = 3;
                    	$set_data['lg_type']      = 'auth_check';
                    	$set_data['lg_func']      = 'check_Login';
                    	$set_data['lg_detail']    = 'パスワードエラー：cl_id = ' . $loginid;
                    	$this->insert_log($set_data);

                        $err_mess = '入力されたログインIDまたはパスワードが間違っています。';
                        return $err_mess;
                    } else {
                        $this->_hash_passwd = $arrData[0]['cl_pw'];
                    	$this->_memSeq      = $arrData[0]['cl_seq'];
                    	$this->_memSiteid   = $arrData[0]['cl_siteid'];
                    	$this->_memName     = $arrData[0]['cl_company'];

                        $this->_update_Session($login_member);

                        // ログインロック情報をクリア
                        $this->_login_lock_clear($login_member, $loginid);

                    }
                }

                break;
            case 'admin':

                $sql = 'SELECT ac_seq, ac_status, ac_type, ac_id, ac_pw, ac_login_cnt, ac_login_lock, ac_login_time '
                		. 'FROM mb_account '
                        . 'WHERE ac_id      = ? '
                        . 'AND   ac_status  = 1 ';

                $values = array(
                        $loginid
                );

                $query = $this->db->query($sql, $values);

                // レコードチェック
                if ($query->num_rows() == 0)
                {

                	// ログ書き込み
                	$set_data['lg_user_type'] = 2;
                	$set_data['lg_type']      = 'auth_check';
                	$set_data['lg_func']      = 'check_Login';
                	$set_data['lg_detail']    = 'ログインIDエラー：ac_id = ' . $loginid;
                	$this->insert_log($set_data);

                    $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    return $err_mess;
                }

                // 重複チェック
                if ($query->num_rows() >= 2)
                {

                	// ログ書き込み
                	$set_data['lg_user_type'] = 3;
                	$set_data['lg_type']      = 'auth_check';
                	$set_data['lg_func']      = 'check_Login';
                	$set_data['lg_detail']    = 'ログインID重複エラー：ac_id = ' . $loginid;
                	$this->insert_log($set_data);

                	$err_mess = '入力されたログインIDが重複しています。システム管理者に連絡してください。';
                    return $err_mess;
                }

                // ログインID＆パスワード読み込み
                $arrData = $query->result('array');
                if (is_array($arrData))
                {

                	$this->config->load('config_comm');

                	// ログイン解除時間＆ロック有無のチェック
                	$tmp_lock_limit    = $this->config->item('LOGIN_LOCK_LIMITTIME');		// 制限時間(分)
                	$tmp_release_limit = $this->config->item('LOGIN_LOCK_RELEASETIME');		// 解除時間(分)
                	if (isset($arrData[0]['ac_login_time']))
                	{

                		$_lock_time    = new DateTime($arrData[0]['ac_login_time']);
                		$_release_time = new DateTime($arrData[0]['ac_login_time']);
                		$_now_time     = new DateTime();

                		$_mod_lock_limit = '+' . $tmp_lock_limit . 'minute';				// xx分後：$date->modify('+1 minute');
                		$_lock_time->modify($_mod_lock_limit);

                		$_mod_release_limit = '+' . $tmp_release_limit . 'minute';
                		$_release_time->modify($_mod_release_limit);

                		if ($_lock_time > $_now_time)
                		{

                			if ($arrData[0]['ac_login_lock'] == 1)
                			{
                				if ($_release_time > $_now_time)
                				{
                					$err_mess = 'このログインIDは現在ロックされています。しばらくしてからログインしていただくかシステム管理者にご連絡ください。';
                					return $err_mess;
                				} else {
                					// ログインロック情報をクリア
                					$this->_login_lock_clear($login_member, $loginid);
                					$arrData[0]['ac_login_cnt'] = 0;
                				}
                			}
                		} else {
                			// ログインロック情報をクリア
                			$this->_login_lock_clear($login_member, $loginid);
                			$arrData[0]['ac_login_cnt'] = 0;
                		}
                	}

                	// パスワードのチェック
                    $this->_hash_passwd = $arrData[0]['ac_pw'];
                    $res = $this->_check_password($password);
                    if ($res == TRUE)
                    {

                    	// ログインエラーのカウント
                    	$this->_login_error_cnt($login_member, $loginid, $arrData[0]['ac_login_cnt'], $arrData[0]['ac_login_time']);

                    	// ログ書き込み
                    	$set_data['lg_user_type'] = 3;
                    	$set_data['lg_type']      = 'auth_check';
                    	$set_data['lg_func']      = 'check_Login';
                    	$set_data['lg_detail']    = 'パスワードエラー：ac_id = ' . $loginid;
                    	$this->insert_log($set_data);

                    	$err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    	//$err_mess = '入力されたパスワードが誤っています。';
                        return $err_mess;
                    } else {
                        $this->_hash_passwd = $arrData[0]['ac_pw'];
                        $this->_memType     = $arrData[0]['ac_type'];
                        $this->_memSeq      = $arrData[0]['ac_seq'];

                        $this->_update_Session($login_member);

                        // ログインロック情報をクリア
                        $this->_login_lock_clear($login_member, $loginid);

                    }
                } else {

                	// ログ書き込み
                	$set_data['lg_user_type'] = 3;
                	$set_data['lg_type']      = 'auth_check';
                	$set_data['lg_func']      = 'check_Login';
                	$set_data['lg_detail']    = 'ID & パスワードエラー：ac_id = ' . $loginid;
                	$this->insert_log($set_data);

                    $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    return $err_mess;
                }

                break;
            default:
        }

        return $err_mess;

    }

    /**
     * ログイン・ロックエラーのカウント
     *
     * @param    varchar
     * @param    varchar
     * @param    int
     * @param    timestamp
     */
    private function _login_error_cnt($login_member, $loginid, $login_cnt, $login_time)
    {

    	// 各メンバー毎にDB更新
    	if ($login_member == 'client')
    	{

    		if ($login_cnt == 0)
    		{
    			// ロック回数カウント(1)＆ロック制限時間セット
    			$set_data['cl_login_cnt']  = 1;
    			$set_data['cl_login_lock'] = 0;
    			$set_data['cl_login_time'] = date('Y-m-d H:i:s');

    		} elseif ($login_cnt == 9) {

    			// ロック回数カウント(10)＆ロックオン(1)＆ロック制限時間セット
    			$set_data['cl_login_cnt']  = 10;
    			$set_data['cl_login_lock'] = 1;
    			$set_data['cl_login_time'] = date('Y-m-d H:i:s');

    		} else {

    			// ロック回数カウントセット
    			$set_data['cl_login_cnt']  = $login_cnt + 1;
    			$set_data['cl_login_lock'] = 0;

    		}

    		$set_data['cl_id'] = $loginid;

    		$this->load->model('Client', 'cl', TRUE);
    		$this->cl->update_client_id($set_data, 3);

    	} elseif ($login_member == 'admin') {

    		if ($login_cnt == 0)
    		{
    			// ロック回数カウント(1)＆ロック制限時間セット
    			$set_data['ac_login_cnt']  = 1;
    			$set_data['ac_login_lock'] = 0;
    			$set_data['ac_login_time'] = date('Y-m-d H:i:s');

    		} elseif ($login_cnt == 9) {

    			// ロック回数カウント(10)＆ロックオン(1)＆ロック制限時間セット
    			$set_data['ac_login_cnt']  = 10;
    			$set_data['ac_login_lock'] = 1;
    			$set_data['ac_login_time'] = date('Y-m-d H:i:s');

    		} else {

    			// ロック回数カウントセット
    			$set_data['ac_login_cnt']  = $login_cnt + 1;
    			$set_data['ac_login_lock'] = 0;

    		}

    		$set_data['ac_id'] = $loginid;

    		$this->load->model('Account', 'ac', TRUE);
    		$this->ac->update_account_id($set_data, 2);

    	}

    }

    /**
     * ログイン・ロックの解除
     *
     * @param    varchar
     * @param    varchar
     */
    private function _login_lock_clear($login_member, $loginid)
    {

    	// 各メンバー毎にDB更新
    	if ($login_member == 'client')
    	{

    		$set_data['cl_id']         = $loginid;
    		$set_data['cl_login_cnt']  = 0;
    		$set_data['cl_login_lock'] = 0;
    		$set_data['cl_login_time'] = NULL;

    		$this->load->model('Client', 'cl', TRUE);
    		$this->cl->update_client_id($set_data, 3);

    	} elseif ($login_member == 'admin') {

    		$set_data['ac_id']         = $loginid;
    		$set_data['ac_login_cnt']  = 0;
    		$set_data['ac_login_lock'] = 0;
    		$set_data['ac_login_time'] = NULL;

    		$this->load->model('Account', 'ac', TRUE);
    		$this->ac->update_account_id($set_data, 2);

    	}

    }


    /**
     * LOGOUT ＆ SESSIONクリア
     *
     * @param    varchar
     * @return   bool
     */
    public function logout($login_member)
    {

        // 特定のセッションユーザデータを削除
        switch ($login_member)
        {
            case 'client':
                $seach_key = 'c';
                break;
            case 'admin':
                $seach_key = 'a';
                break;
            default:
        }

        $get_data = $this->session->all_userdata();

        $unset_data = array();
        foreach ($get_data as $key => $val)
        {
            if (substr($key, 0, 1) == $seach_key)
            {
                unset($_SESSION[$key]);
//                 $unset_data[$key] = '';
            }
        }

//         $this->session->unset_userdata($unset_data);                               // セッションデータ削除

        // ログイン解除
        switch ($login_member)
        {
            case 'client':
                $setData = array('c_login' => FALSE);
                break;
            case 'admin':
                $setData = array('a_login' => FALSE);
                break;
            default:
        }

        $this->session->set_userdata($setData);                                     // ログイン解除
        //$this->session->sess_destroy();                                           // 全セッションデータ削除

    }

    /**
     * SESSION 書き込み
     *
     * @param    varchar
     */
    private function _update_Session($login_member)
    {

        switch ($login_member)
        {
            case 'client':
                $_SESSION['c_login']     = TRUE;               // ログイン有無
                $_SESSION['c_memSeq']    = $this->_memSeq;     // メンバーseq
                $_SESSION['c_memSiteid'] = $this->_memSiteid;  // サイトID
                $_SESSION['c_memName']   = $this->_memName;    // 会社名

                break;
            case 'admin':
                $_SESSION['a_login']   = TRUE;                 // ログイン有無
                $_SESSION['a_memType'] = $this->_memType;      // 0:editor,1:sales,2:admin
                $_SESSION['a_memSeq']  = $this->_memSeq;       // メンバーseq

                break;
            default:
        }
    }

    /**
     * 不要なセッションデータの削除
     *
     * @param    string
     * @return    bool
     */
    public function delete_session($login_member)
    {

        switch ($login_member)
        {
            case 'client':
                $backup_c_login     = $_SESSION['c_login'];
                $backup_c_memSeq    = $_SESSION['c_memSeq'];
                $backup_c_memSiteid = $_SESSION['c_memSiteid'];
                $backup_c_memName   = $_SESSION['c_memName'];

                $get_data = $this->session->all_userdata();
                foreach ($get_data as $key => $val)
                {
                    if (substr($key, 0, 2) == 'c_')
                    {
                       $this->session->unset_userdata($key);
                    }
                }

                $_SESSION['c_login']     =  $backup_c_login;        // ログイン有無
                $_SESSION['c_memSeq']    = $backup_c_memSeq;        // メンバーID
                $_SESSION['c_memSiteid'] = $backup_c_memSiteid;     // メンバーID
                $_SESSION['c_memName']   = $backup_c_memName;       // メンバー名前

                break;
            case 'admin':
                $backup_a_login   = $_SESSION['a_login'];
                $backup_a_memType = $_SESSION['a_memType'];
                $backup_a_memSeq  = $_SESSION['a_memSeq'];

                $get_data = $this->session->all_userdata();
                foreach ($get_data as $key => $val)
                {
                    if (substr($key, 0, 2) == 'a_')
                    {
                       $this->session->unset_userdata($key);
                    }
                }

                $_SESSION['a_login']   = $backup_a_login;         // ログイン有無
                $_SESSION['a_memType'] = $backup_a_memType;       // メンバーID
                $_SESSION['a_memSeq']  = $backup_a_memSeq;        // メンバーID

                break;
            default:
        }

    }

    /**
     * パスワードチェック
     *
     * @param    varchar
     * @param    varchar
     * @return    string
     */
     private function _check_password($password)
    {
        // パスワードハッシュ認証チェック
        if (password_verify($password, $this->_hash_passwd)) {
            $result = FALSE;
        } else {
            $result = TRUE;
        }

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

   		$setData['lg_user_id']   = "";
    	$setData['lg_ip'] = $this->input->ip_address();

    	// データ追加
    	$query = $this->db->insert('tb_log', $setData);

    	//     	// 挿入した ID 番号を取得
    	//     	$row_id = $this->db->insert_id();
    	//     	return $row_id;
    }

}
