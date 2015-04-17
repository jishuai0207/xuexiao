<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Institution_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
    /**
     *description:根据主键获取机构信息
     *author:yanyalong
     *date:2014/11/06
     */
	public function get($id){
	    return $this->db->get_where('Institution',array('id' => $id))->row();
	}
}
