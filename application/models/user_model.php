<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class User_model extends CI_Model{

    public function __construct(){
		parent::__construct();
        $this->load->database();
	}
    /**
     *description:chasdlkfsdfklsd
     *author:yanyalong
     *date:2014/10/30
     */
    public function get($id){
        return $this->db->get_where('User',array('id' => $id))->row();
    }
    /**
     *description:
     *author:yanyalong
     *date:2014/10/31
     */
    public function getlistById($p="",$row=""){
        $limit = "";
        if($p!=""&&$row!=""){
        $limit = " limit ".($p-1)*$row.",".$row;
        }
        return $this->db->query("select * from User $limit")->result();
    }
     /**
      *description:根据用户邮箱或用户手机号以及密码获取用户信息
      *author:yanyalong
      *date:2014/11/04
      */
    public function getUserInfoByLogin($user_code,$password=""){
        $where_password = "";
        if($password!="") $where_password = " and U.passWord='$password' ";
        return $this->db->query("select T.status teacherStatus,U.realName,T.institution,U.id,U.status from User U left join Teacher T on T.email=U.userName where (U.telephone = '$user_code') $where_password and T.isAdmin=1")->row();
    }
	//获取全部用户表
	public function getAllUser($institution,$p='1',$row=''){
		$limit = '';
		if($p && $row){
			$limit = " limit ".($p-1)*$row.",".$row;
		}
        return $this->db->query("select st.truthName,u.userName,u.createTime from(
select * from Teacher where institution =$institution  and isAdmin = 1 and status = 1
) st left join (select * from User where status = 1) u on st.telphone = u.telephone order by u.createTime desc $limit")->result();
	}
	//获取全部用户表数量
	public function getUserNum($institution){
        return $this->db->query("select count(*) as num from(
select * from Teacher where institution =$institution  and isAdmin = 1 and status = 1
) st left join User u
on st.telphone = u.telephone")->row();
	}
	//excel上传插入
	public function uploadInsert($arr){
		$num = 0;
		foreach($arr as $v){
			if($this->db->insert('User',$v)){
				$num ++;
			}
		}
		return $num;
	}
    /**
     *description:插入一条数据
     *author:yanyalong
     *date:2014/11/20
     */
    public function insert($data){
        $this->db->insert('User', $data);
        return $this->db->insert_id();
    }
    /**
     *description:判断老师手机号是否已存在
     *author:yanyalong
     *date:2014/11/21
     */
    public function getInfoBytel($telephone){
        return $this->db->query("select * from User where telephone='$telephone'")->row();
    }
    /**
     *description:判断老师邮箱是否已存在
     *author:yanyalong
     *date:2014/11/21
     */
    public function getInfoByEmail($email){
        return $this->db->query("select * from User where userName='$email'")->row();
    }
}
