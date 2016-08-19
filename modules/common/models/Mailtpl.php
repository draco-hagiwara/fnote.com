<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailtpl extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('email');                                        // メール送信クラス読み込み
    }

    // メールテンプレートの取得
    public function get_mailtpl_list($mt_id=NULL)
    {

    	$set_where["mt_del_flg"] = 0;

    	if (isset($mt_id))
    	{
    		$set_where["mt_id"] = $mt_id;
    	}

    	$query = $this->db->get_where('tb_mail_tpl', $set_where);

    	$get_data = $query->result('array');

    	return $get_data;

    }

    /**
     * 1レコード更新
     *
     * @param    array()
     * @return   bool
     */
    public function update_mailtpl_id($setdata)
    {

    	$where = array(
    			'mt_id' => $setdata['mt_id'],
    	);

    	$result = $this->db->update('tb_mail_tpl', $setdata, $where);

    	// ログ書き込み
    	$set_data['lg_user_type'] = 2;
    	$set_data['lg_type']      = 'mailtpl_update';
    	$set_data['lg_func']      = 'update_mailtpl_id';
    	$set_data['lg_detail']    = 'mt_id = ' . $setdata['mt_id'];
    	$this->insert_log($set_data);

    	return $result;
    }

    // メールテンプレートの取得からメール送信
    public function get_mail_tpl($mail, $arrRepList = NULL, $mail_tpl, $user_type=2)
    {

        $where = array('mt_id' => $mail_tpl);
        $query = $this->db->get_where('tb_mail_tpl', $where);
        foreach ($query->result_array() as $row)
        {
            if ($mail['from'] == "") {
                $mail['from']      = $row['mt_from'];
            } else {
                $mail['from']      = $mail['from'];
            }
            if ($mail['from_name'] == "") {
                $mail['from_name'] = $row['mt_from_name'];
            } else {
                $mail['from_name'] = $mail['from_name'];
            }
            if ($mail['subject'] == "") {
                $mail['subject']   = $row['mt_subject'];
            } else {
                $mail['subject']   = $mail['subject'];
            }
            if ($mail['to'] == "") {
                $mail['to']        = $row['mt_to'];
            } else {
                $mail['to']        = $mail['to'];
            }
            if ($mail['cc'] == "") {
                $mail['cc']        = $row['mt_cc'];
            } else {
                $mail['cc']        = $mail['cc'];
            }
            if ($mail['bcc'] == "") {
                $mail['bcc']       = $row['mt_bcc'];
            } else {
                $mail['bcc']       = $mail['bcc'];
            }

            // Body部のtag項目置き換え
            if ($arrRepList) {
                $strResult = $this->_rep_mail_body($arrRepList, $row['mt_body']);
            } else {
                $strResult = $row['mt_body'];
            }

            $mail['body'] = $strResult;
        }

        // メール送信
        $result = $this->_sendmail($mail);

        // ログ書き込み
        $set_data['lg_user_type'] = $user_type;
        $set_data['lg_type']      = 'mailtpl_sendmil';
        $set_data['lg_func']      = 'get_mail_tpl';
        $set_data['lg_detail']    = 'res = ' . $result . ' / mail_to = ' . $mail['to'];
        $this->insert_log($set_data);

        return $result;

    }

    // メール送信処理
    private function _sendmail($mail)
    {

        $from_name = mb_encode_mimeheader($mail['from_name'], 'ISO-2022-JP', 'UTF-8');
        $subject   = mb_convert_encoding ($mail['subject'],   'SJIS-win',    'UTF-8');
        $body      = mb_convert_encoding ($mail['body'],      'SJIS-win',    'UTF-8');
        //$subject   = mb_convert_encoding ($mail['subject'], 'ISO-2022-JP-MS', 'UTF-8');        // 一部で文字化けが発生！
        //$body      = mb_convert_encoding ($mail['body'],    'ISO-2022-JP-MS', 'UTF-8');

        $this->email->clear();
        $this->email->reply_to('autoreply@fnote.com.dev', 'Platform');
        $this->email->from($mail['from'] , $from_name);
        $this->email->to($mail['to']);
        $this->email->cc($mail['cc']);
        $this->email->bcc($mail['bcc']);
        $this->email->subject($subject);
        $this->email->message($body);

        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }

        echo $this->email->print_debugger();

    }

    // 置き換え文字列の処理
    private function _rep_mail_body($arrRepList, $row)
    {

        $arrRepPattern = array();
        $arrRepTag     = array();
        foreach( $arrRepList as $strKey => $strValue )
        {
            $arrRepPattern[] = '/\[' . $strKey . '\]/';
            $arrRepTag[]     = $strValue;
        }

        $strResult = preg_replace( $arrRepPattern, $arrRepTag, $row );

        return $strResult;
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

