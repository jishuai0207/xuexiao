<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Grade_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}

    /**
 	* Description : 根据年级名称获取ID
 	* Author      : jishuai
 	* Created Time: 2014-12-04 14:06
	*/
	public function getIdByName($name){
		return $this->db->query("select id from Grade where name = '$name'")->row();
	}
    /**
     *description:获取年级列表
     *author:yanyalong
     *date:2014/11/06
     */
    public function getlist(){
        return $this->db->query("select * from Grade where status=1")->result();              
    }
}
