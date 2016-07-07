<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comm_auth extends CI_Model
{

    private $_hash_passwd;
    private $_memType;
    private $_memSeq;
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
                $sql = 'SELECT cl_seq, cl_status, cl_id, cl_pw, cl_company FROM mb_client '
                        . 'WHERE cl_id      = ? '
                        . 'AND ( cl_status  != 0 OR cl_status  != 9 )';

                $values = array(
                        $loginid
                );

                $query = $this->db->query($sql, $values);

                // レコードチェック
                if ($query->num_rows() == 0)
                {
                    $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    return $err_mess;
                }

                // 重複チェック
                   if ($query->num_rows() >= 2)
                   {
                       $err_mess = '入力されたログインIDが重複しています。システム管理者に連絡してください。';
                       return $err_mess;
                   }

                   // ログインID＆パスワード読み込み
                   $arrData = $query->result('array');
                   if (is_array($arrData))
                {
                    // パスワードのチェック
                    $this->_hash_passwd = $arrData[0]['cl_pw'];
                    $res = $this->_check_password($password);
                    if ($res == TRUE)
                    {
                        $err_mess = '入力されたログインIDまたはパスワードが間違っています。';
                        return $err_mess;
                    } else {
                        $this->_hash_passwd = $arrData[0]['cl_pw'];
                    	$this->_memSeq      = $arrData[0]['cl_seq'];
                        $this->_memName     = $arrData[0]['cl_company'];

                        $this->_update_Session($login_member);
                    }
                }

                break;
            case 'admin':

                $sql = 'SELECT ac_seq, ac_status, ac_type, ac_id, ac_pw FROM mb_account '
                        . 'WHERE ac_id      = ? '
                        . 'AND   ac_status  = 1 ';

                $values = array(
                        $loginid
                );

                $query = $this->db->query($sql, $values);

                // レコードチェック
                if ($query->num_rows() == 0)
                {
                    $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    return $err_mess;
                }

                // 重複チェック
                if ($query->num_rows() >= 2)
                {
                	$err_mess = '入力されたログインIDが重複しています。システム管理者に連絡してください。';
                    return $err_mess;
                }

                // ログインID＆パスワード読み込み
                $arrData = $query->result('array');
                if (is_array($arrData))
                {
                	// パスワードのチェック
                    $this->_hash_passwd = $arrData[0]['ac_pw'];
                    $res = $this->_check_password($password);
                    if ($res == TRUE)
                    {
                    	$err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    	//$err_mess = '入力されたパスワードが誤っています。';
                        return $err_mess;
                    } else {
                        $this->_hash_passwd = $arrData[0]['ac_pw'];
                        $this->_memType     = $arrData[0]['ac_type'];
                        $this->_memSeq      = $arrData[0]['ac_seq'];

                        $this->_update_Session($login_member);
                    }
                } else {
                    $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                    return $err_mess;
                }

                break;
            default:
        }

        return $err_mess;

    }

    /**
     * LOGOUT ＆ SESSIONクリア
     *
     * @param    varchar
     * @return   bool
     */
    public function logout($login_member)
    {

    	$this->session->sess_destroy();


//         // 特定のセッションユーザデータを削除
//         switch ($login_member)
//         {
//             case 'client':
//                 $seach_key = 'c';
//                 break;
//             case 'admin':
//                 $seach_key = 'a';
//                 break;
//             default:
//         }

//         $get_data = $this->session->all_userdata();
//         $unset_data = array();
//         foreach ($get_data as $key => $val)
//         {
//             if (substr($key, 0, 1) == $seach_key)
//             {
//                 $unset_data[$key] = '';
//             }
//         }

//         $this->session->unset_userdata($unset_data);                               // セッションデータ削除

//         // ログイン解除
//         switch ($login_member)
//         {
//             case 'writer':
//                 $setData = array('w_login' => FALSE);
//                 break;
//             case 'client':
//                 $setData = array('c_login' => FALSE);
//                 break;
//             case 'admin':
//                 $setData = array('a_login' => FALSE);
//                 break;
//             default:
//         }

//         $this->session->set_userdata($setData);                                     // ログイン解除
//         //$this->session->sess_destroy();                                           // 全セッションデータ削除

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
                $_SESSION['c_login']   = TRUE;                 // ログイン有無
                $_SESSION['c_memSeq']  = $this->_memSeq;       // メンバーseq
                $_SESSION['c_memName'] = $this->_memName;      // 会社名

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
                $backup_c_login   = $_SESSION['c_login'];
                $backup_c_memSeq  = $_SESSION['c_memSeq'];
                $backup_c_memName = $_SESSION['c_memName'];

                $get_data = $this->session->all_userdata();
                foreach ($get_data as $key => $val)
                {
                    if (substr($key, 0, 2) == 'c_')
                    {
                       $this->session->unset_userdata($key);
                    }
                }

                $_SESSION['c_login'] =   $backup_c_login;         // ログイン有無
                $_SESSION['c_memSeq'] =  $backup_c_memSeq;        // メンバーID
                $_SESSION['c_memName'] = $backup_c_memName;       // メンバー名前

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

}
