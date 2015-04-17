<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class ClassRefStuTea_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
    /**
     *hescription:插入一条数据
     *author:yanyalong
     *date:2014/11/06
     */
	public function insert($data){
		$this->db->insert('classRefStuTea', $data);
		return $this->db->insert_id();
	}
    /**
     *description:根据学员、教师id和班级id查询关系
     *author:yanyalong
     *date:2014/11/07
     */

    public function getInfoByStuClass($classId,$objId,$type){
        return $this->db->query("select * from classRefStuTea cRS where cRS.userId='$objId' and classId='$classId' and type='$type' order by cRS.id desc limit 1")->row();
    }
    /**
     *description:根据学员列表、教师列表与班级id查询在班的对象
     *author:yanyalong
     *date:2014/11/12
     */
    public function getListByObjClass($classId,$objIdList,$type){
        return $this->db->query("select * from classRefStuTea cRS where cRS.userId in($objIdList) and classId='$classId' and type='$type' and (cRS.leaveTime is null or unix_timestamp(cRS.leaveTime)=0)")->result();
    }
	//根据学员ID获取班级
	public function getClassByUser($userid,$type = 0){   
		return $this->db->query("select * from classRefStuTea where userId = $userid and type = $type")->result();
	}
    /**
     *description:老师退出班级
     *author:yanyalong
     *date:2014/12/02
     */
	public function teacherLeaveClass($userid,$classId,$type){
		return $this->db->query("update classRefStuTea set leaveTime=now() where userId = $userid and classId='$classId' and type = $type");
	}
}
