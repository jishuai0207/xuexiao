<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class User_role_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
	//管理员列表
	public function getlist($institution){
		return $this->db->query("select st.truthName,u.userName,u.createTime from(
select * from Teacher where institution = $institution and isAdmin = 1 and status = 1
) st left join User u
on st.telphone = u.telephone")->result();
	}
}
