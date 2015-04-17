<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @description CI上传类库扩展类，用以实现实际业务逻辑
 * @author		yanyl
 */
class MY_Upload extends CI_Upload{
	public function __construct(){
		parent::__construct();
	}
    /**
     *description:文件上传通用函数
     *author:yanyalong
     *date:2014/11/04
     */
	public function upload_file($config){
		$this->initialize($config);
		if (!$this->do_upload()){
			return false;
		}else{
			$data = array('upload_data' => $this->data());
			return $data;
		}
	}
}


