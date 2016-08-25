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
    public function update_mailtpl_id($set_data)
    {

    	$where = array(
    			'mt_id' => $set_data['mt_id'],
    	);

    	// 更新日時をセット
    	$time = time();
    	$set_data['mt_update_date'] = date("Y-m-d H:i:s", $time);

    	$result = $this->db->update('tb_mail_tpl', $set_data, $where);
    	return $result;
    }

    // メールテンプレートの取得からメール送信
    public function get_mail_tpl($mail, $arrRepList = NULL, $mail_tpl)
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
        return $result;

    }

    // メール送信処理
    private function _sendmail($mail)
    {


    	// ---------------------------------------------------
    	// 以下のPGを修正する。
    	//
    	// /var/www/fnote.com/vendor/codeigniter/framework/system/libraries/Email.php
    	//

//         $from_name = mb_encode_mimeheader($mail['from_name'], 'ISO-2022-JP', 'UTF-8');
// //      $subject   = mb_convert_encoding ($mail['subject'],   'ISO-2022-JP',    'UTF-8');
// //      $subject   = mb_convert_encoding ($mail['subject'],   'SJIS-win',    'UTF-8');
//         $subject   = mb_convert_encoding ($mail['subject'],   'ISO-2022-JP-MS', 'UTF-8');        // 一部で文字化けが発生！
//         $body      = mb_convert_encoding ($mail['body'],      'SJIS-win',    'UTF-8');
// //      $body      = mb_convert_encoding ($mail['body'],      'ISO-2022-JP-MS', 'UTF-8');

        $from_name = $mail['from_name'];
        $subject   = $mail['subject'];
        $body      = $mail['body'];

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
}

