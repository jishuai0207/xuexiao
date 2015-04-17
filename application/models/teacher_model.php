<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Teacher_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
	public function getList($institution,$keywords='',$inJob='',$p='',$row=''){
		if($p != '' && $row != ''){
			$limit = 'limit '.($p - 1)*$row.','.$row;
		}else{
			$limit = '';
		}

		$isinJob = '';
		if($inJob == '1') $isinJob = ' and inJob = 1';
		if($inJob == '0') $isinJob = ' and inJob = 0';

		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
					$where_keywords = " and (teacherCode='$keywords' or truthName like '%$keywords%' or nickname like '%$keywords%') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.=") or (";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " nickname like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}

		 return $this->db->query("
			 select SST.*,S.name as sname from (
 select TC.*,sum(current) as classNum from( select ST.*,cRS.type,cRS.classId as cid,cRS.leaveTime,C.endTime,C.status  Cstatus,
case when C.id is not null and leaveTime is null and (endTime is null or endTime > now()) then 1 else 0 end as current from( 
select T.*,U.createTime from Teacher T left join User U on T.telphone = U.telephone where institution = $institution $isinJob $where_keywords order by U.createTime desc $limit )ST 
left join classRefStuTea cRS on ST.id = cRS.userId left join Class C 
on cRS.classId = C.id having (cRS.type = '1' or cRS.type is null) and (Cstatus != '2' or Cstatus is null) order by current desc ) TC group by TC.id order by createTime desc )
 SST left join teacher_subject TS on SST.id = TS.teacherId 
left join Subject S on TS.subjectId = S.id
			")->result();
	}
	//获取教师列表总数
	public function getListNum($institution,$keywords='',$inJob=''){
		$isinJob = '';
		if($inJob === '1') $isinJob = ' and inJob = 1';
		if($inJob === '0') $isinJob = ' and inJob = 0';

		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
					$where_keywords = " and (teacherCode='$keywords' or truthName like '%$keywords%' or nickname like '%$keywords%') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.=") or (";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " nickname like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}

		 return $this->db->query("
			select count(*) as num from Teacher where institution = $institution $isinJob  $where_keywords
			")->row();
	}
	//获取教师下的科目
	public function getSubject($id){
		return $this->db->query("
			select * from (
select * from teacher_subject where teacherId = $id
) st left join Subject s 
on st.subjectId = s.id
			")->result();
	}
	//获取目前任课班级数
	public function getCurrentClass($userid){
		return $this->db->query("
			select * from (
select userId,classId,joinTime,leaveTime from classRefStuTea where userId = $userid and type = 1 and leaveTime is null)scs 
left join Class C on scs.classId = C.id where (now() < endTime or endTime is null or endTime = 0)
			")->result();
	}
	//查询老师是否有代课
	public function hasReplaceClass($userid,$institution){
		return $this->db->query("
					select sse.*,c.institution from (
select * from Schedule where replaceTeacher = $userid
) sse left join Class c
on sse.classId = c.id
where institution = $institution and NOW() < sse.endTime
			")->result();
	}
	//查看老师基本信息
	public function getInfoById($userid,$institution ){
		return $this->db->query("
			select t.*,u.userName,u.createTime from(
select * from Teacher where institution = $institution  and id = $userid 
) t left join User u 
on t.telphone = u.telephone
			")->row();
	}
	//离职
	public function leaveJob($userid){
		$arr1 = $this->db->query("update Teacher set inJob = 0 where id = $userid");
		$arr2 = $this->db->query("update User set status = 0 where telephone = (select telphone from Teacher where id = $userid)");
		if($arr1 && $arr2){
			return true;
		}else{
			return false;
		}
	}
	//入职
	public function onJob($userid,$institution){
		$arr1 = $this->db->query("update Teacher set inJob = 1 where institution = $institution and id =  $userid");
		$arr2 = $this->db->query("update User set status = 1 where telephone = (select telphone from Teacher where id = $userid)");
		if($arr1 && $arr2){
			return true;
		}else{
			return false;
		}
	}

    /**
 	* Description : 获取老师班级
 	* Author      : jishuai
 	* Created Time: 2014-12-02 14:12
	*/
	public function getAllClass($userid,$type='c',$p='',$row=''){
		if($p != '' and $row != ''){
			$limit = 'limit '.($p - 1)*$row.','.$row;
		}else{
			$limit = '';
		}
		if($type == 'c'){
			$current = ' having current = 1';
		}elseif($type == 'h'){
			$current = ' having current = 0';
		}else{
			$current = '';
		}
		return $this->db->query("
			select * from(
select C.id as cid,cRS.leaveTime,C.endTime,C.studentNumber,C.className,C.beginTime,cRS.joinTime,case when leaveTime is null and (endTime > now() or endTime is null ) then 1 else 0 end as current 
from classRefStuTea cRS left join Class C on cRS.classId = C.id where userId = $userid and type = 1 and C.status != '2'
order by current desc
) TS group by cid $current order by joinTime desc $limit
			")->result();
	}
	//是否存在老师
	public function exist($telphone){
	return $this->db->query("select * from Teacher where telphone = '$telphone'")->result();
	}
	//excel 上传的插入
	public function uploadInsert($arr){
		$num = 0;
		foreach($arr as $v){
			if($this->db->insert('Teacher',$v)){
				$num = $num + 1;
			}
		}
		return $num;
	}
	//根据电话得到ID
	public function getIdByTelphone($tel){
		return $this->db->query("select id from Teacher where telphone = '$tel'")->row();
	}
	//获取所有老师总数
	public function getAllNum($institution){
		return $this->db->query("select count(*) as num from Teacher where institution = $institution")->row();
	}
	//获取单个老师
	public function getById($institution,$userid){
		return $this->db->query("select * from Teacher where institution = '$institution' and id = '$userid'")->row();

	}
	//更新老师code
	public function updateTeacherCode($id,$institution){
		$code = objEncode($id,'T');
		return $this->db->query("update Teacher set teacherCode = '$code' where id = $id and institution = $institution");

	}
    /**
     *description:录入老师
     *author:yanyalong
     *date:2014/11/20
     */
    public function insert($data){
        $this->db->insert('Teacher', $data);
        return $this->db->insert_id();
    }
    /**
     *description:根据主键获取老师基本信息
     *author:yanyalong
     *date:2014/11/21
     */
    public function get($id){
        return $this->db->get_where('Teacher',array('id' => $id))->row();
    }

    /**
 	* Description : 根据电话号码获取信息
 	* Author      : jishuai
 	* Created Time: 2015-02-06 15:59
	*/
	public function getAdminByTel($tel){
		return $this->db->query('select T.id,truthName,institution,I.insName,I.insCode from Teacher T left join Institution I on T.institution = I.id where isAdmin = 1 and telphone = '.$tel)->row();
	}

    /**
 	* Description : 根据电话号码获取老师信息
 	* Author      : jishuai
 	* Created Time: 2015-02-06 15:59
	*/
	public function getTeaByTel($tel){
		return $this->db->query('select T.id,truthName,institution,I.insName,I.insCode from Teacher T left join Institution I on T.institution = I.id where telphone = '.$tel)->row();
	}


}
