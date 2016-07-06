<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comm_auth extends CI_Model
{

    private $_hash_passwd;
    private $_memType;
    private $_memSeq;
//     private $_memberRANK;
//     private $_memberNAME;
//     private $_personalID;
//     private $_authorityCD;

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
                $sql = 'SELECT T1.cm_mem_id, T1.cm_cl_id, T1.cm_status, T1.cm_login, T1.cm_password, T1.cm_authority, T1.cm_del_flg, T2.cl_company '
                        . 'FROM tb_client_mem AS T1 INNER JOIN tb_client AS T2 ON T1.cm_cl_id = T2.cl_id '
                        . 'WHERE T1.cm_login   = ? '
                        . 'AND   T1.cm_status  = 1 '
                        . 'AND   T1.cm_del_flg = 0 '
                        . 'AND   T2.cl_status  = 1 ';

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
                    $this->_hash_passwd = $arrData[0]['cm_password'];
                    $res = $this->_check_password($password);
                    if ($res == TRUE)
                    {
                        $err_mess = '入力されたログインID（メールアドレス）またはパスワードが間違っています。';
                        return $err_mess;
                    } else {
                        $this->_memberID    = $arrData[0]['cm_cl_id'];
                        //$this->_memberRANK  = '';
                        //$this->_memberRATE  = ''];
                        $this->_memberNAME  = $arrData[0]['cl_company'];
                        $this->_personalID  = $arrData[0]['cm_mem_id'];
                        $this->_authorityCD = $arrData[0]['cm_authority'];

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

        //$err_mess = $this->_check_password($password);
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
                $this->session->set_userdata('c_login',      TRUE);                 // ログイン有無
                $this->session->set_userdata('c_memID',      $this->_memberID);     // メンバーID
                //$this->session->set_userdata('c_memRANK', $this->_memberRANK);    // メンバーランキング(writerのみ)
                $this->session->set_userdata('c_memNAME',    $this->_memberNAME);   // メンバー名前(writerはニックネーム)
                $this->session->set_userdata('c_personalID', $this->_personalID);   // 個人メンバーpersonalID
                $this->session->set_userdata('c_authCD',     $this->_authorityCD);  // 個人メンバーauthorityCD

                break;
            case 'admin':
                $_SESSION['a_login']   = TRUE;                 // ログイン有無
                $_SESSION['a_memType'] = $this->_memType;      // 0:editor,1:sales,2:admin
                $_SESSION['a_memSeq']  = $this->_memSeq;       // メンバーseq
                //$this->session->set_userdata('a_memRANK', $this->_memberRANK);    // メンバーランキング(writerのみ)
                //$this->session->set_userdata('a_memNAME',    $this->_memberNAME);   // メンバー名前(writerはニックネーム)
                //$this->session->set_userdata('a_personalID', $this->_personalID);   // 個人メンバーpersonalID
                //$this->session->set_userdata('a_authCD',     $this->_authorityCD);  // 個人メンバーauthorityCD

                break;
            default:
        }

        //$this->session->set_userdata('login_mem' , $login_member);                // ログインメンバー(writer/client/admin)
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
                $backup_c_login   = $this->session->userdata('c_login');
                $backup_c_memID   = $this->session->userdata('c_memID');
                $backup_c_memNAME = $this->session->userdata('c_memNAME');
                $backup_c_personalID = $this->session->userdata('c_personalID');
                $backup_c_authCD  = $this->session->userdata('c_authCD');

                $get_data = $this->session->all_userdata();
                foreach ($get_data as $key => $val)
                {
                    if (substr($key, 0, 2) == 'c_')
                    {
                       $this->session->unset_userdata($key);
                    }
                }

                $this->session->set_userdata('c_login',   $backup_c_login);         // ログイン有無
                $this->session->set_userdata('c_memID',   $backup_c_memID);         // メンバーID
                $this->session->set_userdata('c_memNAME', $backup_c_memNAME);       // メンバー名前
                $this->session->set_userdata('c_personalID', $backup_c_personalID);         // 個人メンバーpersonalID
                $this->session->set_userdata('c_authCD', $backup_c_authCD);         // 個人メンバーauthorityCD

                break;
            case 'admin':
                $backup_a_login   = $_SESSION['a_login'];
                $backup_a_memType = $_SESSION['a_memType'];
                $backup_a_memSeq  = $_SESSION['a_memSeq'];
//                 $backup_a_memNAME = $this->session->userdata('a_memNAME');
//                 $backup_a_personalID = $this->session->userdata('a_personalID');
//                 $backup_a_authCD  = $this->session->userdata('a_authCD');

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
//                 $this->session->set_userdata('a_memNAME', $backup_a_memNAME);       // メンバー名前
//                 $this->session->set_userdata('a_personalID', $backup_a_personalID);         // 個人メンバーpersonalID
//                 $this->session->set_userdata('a_authCD',  $backup_a_authCD);        // 個人メンバーauthorityCD

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


//    private $_hash_passwd;
//    private $_memberID;
//    private $_memberRANK;
//    private $_memberNAME;
//
//    public function __construct()
//    {
//        parent::__construct();
//    }
//
//
//    /**
//     * ログイン・チェック：ログインID（メールアドレス）＆パスワード
//     *
//     * @param    varchar
//     * @param    string
//     * @return    string
//     */
//    public function check_Login($loginid, $password, $login_member)
//    {
//
//        switch ($login_member){
//            case 'writer':
//                $sql = 'SELECT * FROM `tb_writer` '
//                        . 'WHERE `wr_email` = ? ';
//
//                $values = array(
//                        $loginid
//                );
//
//                $query = $this->db->query($sql, $values);
//
//                // 重複チェック
//                   if ($query->num_rows() >= 2) {
//                       $err_mess = '入力されたログインIDが重複しています。システム管理者に連絡してください。';
//                       return $err_mess;
//                   }
//
//                   // ログインID＆パスワード読み込み
//                   $arrData = $query->result('array');
//                if (is_array($arrData)) {
//
//                    $this->_hash_passwd = $arrData[0]['wr_password'];
//                    $this->_memberID    = $arrData[0]['wr_id'];
//                    $this->_memberRANK  = $arrData[0]['wr_mm_rank_id'];
//                    $this->_memberNAME  = $arrData[0]['wr_nickname'];
//
//                    $this->_update_Session($login_member);
//                } else {
//                    $err_mess = '入力されたログインID（メールアドレス）は登録されていません。';
//                    return $err_mess;
//                }
//
//                break;
//            case 'client':
//                break;
//            case 'admin':
//                break;
//            default:
//        }
//
//        $err_mess = $this->_check_password($password);
//        return $err_mess;
//
//    }
//
//    /**
//     * LOGOUT ＆ SESSIONクリア
//     *
//     * @return    bool
//     */
//    public function logout($login_member)
//    {
//
//
//        switch ($login_member)
//        {
//            case 'writer':
//                $setData = array('w_login' => FALSE);
//                break;
//            case 'client':
//                $setData = array('c_login' => FALSE);
//                break;
//            case 'admin':
//                $setData = array('a_login' => FALSE);
//                break;
//            default:
//        }
//
//        $this->session->set_userdata($setData);                                        // ログイン解除
//
//        //$this->session->sess_destroy();                                            // セッションデータ削除
//
//    }
//
//    /**
//     * SESSION 書き込み
//     *
//     * @param    varchar
//     */
//    private function _update_Session($login_member)
//    {
//
//        switch ($login_member)
//        {
//            case 'writer':
//                $this->session->set_userdata('w_login',   TRUE);                    // ログイン有無
//                $this->session->set_userdata('w_memID',   $this->_memberID);        // メンバーID
//                $this->session->set_userdata('w_memRANK', $this->_memberRANK);        // メンバーランキング(writerのみ)
//                $this->session->set_userdata('w_memNAME', $this->_memberNAME);        // メンバー名前(writerはニックネーム)
//
//                break;
//            case 'client':
//                $this->session->set_userdata('c_login',   TRUE);                    // ログイン有無
//                $this->session->set_userdata('c_memID',   $this->_memberID);        // メンバーID
//                //$this->session->set_userdata('c_memRANK', $this->_memberRANK);        // メンバーランキング(writerのみ)
//                $this->session->set_userdata('c_memNAME', $this->_memberNAME);        // メンバー名前(writerはニックネーム)
//
//                break;
//            case 'admin':
//                $this->session->set_userdata('a_login',   TRUE);                    // ログイン有無
//                $this->session->set_userdata('a_memID',   $this->_memberID);        // メンバーID
//                //$this->session->set_userdata('a_memRANK', $this->_memberRANK);        // メンバーランキング(writerのみ)
//                $this->session->set_userdata('a_memNAME', $this->_memberNAME);        // メンバー名前(writerはニックネーム)
//
//                break;
//            default:
//        }
//
//        //$this->session->set_userdata('login_mem' , $login_member);            // ログインメンバー(writer/client/admin)
//    }
//
//    /**
//     * パスワードチェック
//     *
//     * @param    varchar
//     * @param    varchar
//     * @return    string
//     */
//    private function _check_password($password)
//    {
//        // パスワードハッシュ認証チェック
//        if (!password_verify($password, $this->_hash_passwd)) {
//            $err_mess = '入力されたパスワードが一致しません。';
//            return $err_mess;
//        }
//    }
//
//
//
//
//
//
//
//
//    /**
//     * LOGOUT ＆ SESSIONクリア
//     *
//     * @return    bool
//     */
//    //public function logout()
//    //{
//    //
//    //    $setData = array(
//    //            'login_chk' => FALSE,
//    //    );
//    //    $this->session->set_userdata($setData);                                    // ログイン解除
//    //
//    //    $this->session->sess_destroy();                                            // セッションデータ削除
//    //
//    //}
//
//    /**
//     * SESSION 書き込み
//     *
//     * @param    varchar
//     */
//    //private function _update_Session($login_member)
//    //{
//    //    $this->session->set_userdata('login_chk' , TRUE);                        // ログイン有無
//    //    $this->session->set_userdata('login_mem' , $login_member);                // ログインメンバー
//    //    $this->session->set_userdata('memberID'  , $this->_memberID);            // ログインメンバーID
//    //    $this->session->set_userdata('memberRANK', $this->_memberRANK);            // ログインメンバーランキング
//    //}
//

}
