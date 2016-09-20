<?php

class Blog_nic extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // ブログ管理 初期表示
    public function index()
    {

    	// セッションデータをクリア
    	$this->load->model('comm_auth', 'comm_auth', TRUE);
    	if (isset($_SESSION['c_adminSeq']))
    	{
    		$this->comm_auth->delete_session('a_client');
    	} else {
    		$this->comm_auth->delete_session('client');
    	}

		$config = array(
				'upload_path' => '../images/fnote/b/',
				'allowed_types' => "jpg",
				'overwrite' => TRUE,
				'max_size' => "2560",
				'file_name' => md5(date('YmdHis')) . '.jpg'
		);

		$this->load->library('upload', $config);
		$this->upload->do_upload('image');

		$data = array(
				'width'=>$this->upload->data('image_width'),
				'height'=>$this->upload->data('image_height'),
				'file_name'=>$this->upload->data('file_name')
		);

		$link = base_url() . 'images/fnote/b/' . $data['file_name'];

		$res = array("data" => array(
				'link' => $link,
				'width' => $data['width'],
				'height' => $data['height'])
		);

		echo json_encode($res);


    }

}
