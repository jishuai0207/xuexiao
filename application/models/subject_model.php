<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Subject_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
	public function getSubjectByName($name){
		return $this->db->query("select * from Subject where name = '$name'")->row();
	}
    /**
     *description:获取学科列表
     *author:yanyalong
     *date:2014/11/06
     */
    public function getlist(){
        return $this->db->query("select * from Subject where status=1")->result();              
    }
}
