<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    /**
     *description:获取班级学员帐号列表
     *author:yanyalong
     *date:2014/11/05
     */
    public function getStudentListByClass($classId,$p="",$row=""){
        $limit = "";
        if($p!=""&&$row!=""){
            $limit = " limit ".($p-1)*$row.",".$row;
        }
        return $this->db->query("select S.studentName,S.password,S.truthName from Student S left join classRefStuTea cRS on cRS.userId=S.id and (cRS.leaveTime is null or unix_timestamp(cRS.leaveTime)=0) where cRS.classId=$classId  $limit")->result();
    }
	//插入学员 
	public function insert($data){
		return $this->db->insert("Student",$data);
	}

    /**
 	* Description : 获取学生列表 
 	* Author      : jishuai
 	* Created Time: 2014-12-19 16:06
	*/
	public function getStudent($institution,$grade='',$keywords= '',$hasclass = "",$order='',$p='',$row=''){
		if($grade == ''){
			$where_grade = "where 1"; 
		}else{
			$where_grade = "where grade = ".$grade; 
		}
        $limit = "";
        if($p!=""&&$row!=""){
            $limit = " limit ".($p-1)*$row.",".$row;
        }
		if($order == 'cd'){
			$order = "order by creatTime desc,islogin asc";
		}elseif($order == 'ca'){
			$order = "order by creatTime asc,islogin desc";
		}elseif($order == 'ld'){
			$order = 'order by islogin desc,creatTime desc';
		}elseif($order == 'la'){
			$order = 'order by islogin asc,creatTime asc';
		}else{
			$order = "order by creatTime desc,islogin desc";
		}

		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
					$where_keywords = " and (code='$keywords' or truthName like '%$keywords%' or studentCode = '$keywords') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}
		
		if($hasclass == '1'){
			$has_class = "having num > 0 ";
		}elseif($hasclass == '0'){
			$has_class = "having num = 0 ";
		}else{
			$has_class = "";
		}
		return $this->db->query("
			select SSS.*,G.name as gname from ( 
select SS.*,sum(currentClass) as num from(
 select S.*,CRS.leaveTime,C.id as cid,C.endTime, case when C.id is not null and CRS.leaveTime is null and (C.endTime > now() or C.endTime is null) then 1 else 0 end as currentClass ,
 case when S.loginTime = S.creatTime or S.loginTime is null then 0 else 1 end as islogin from (select * from Student where institution = $institution) S left join (
select * from classRefStuTea where type = 0) CRS on S.id = CRS.userId left join (select * from Class where status != '2') C on CRS.classId = C.id)
 SS $where_grade $where_keywords  group by id $has_class $order $limit) SSS left join Grade G on SSS.grade = G.id
	")->result();
	}
	public function getStudentNum($institution,$grade='',$keywords = '',$hasclass = "",$haslogin='2'){
		if($grade == ''){
			$where_grade = ' where 1';
		}else{
			$where_grade = " where grade = '$grade'"; 
		}

		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
					$where_keywords = " and (code='$keywords' or truthName like '%$keywords%' or studentCode='$keywords') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}

		if($haslogin == '1'){
			$where_login = " where islogin = 1 " ;
		}elseif($haslogin == '0'){
			$where_login = " where islogin = 0" ;
		}else{
			$where_login = ' where 1=1';
		}

		if($hasclass == 1){
			$has_class = "having num > 0 ";
		}elseif($hasclass == 0){
			$has_class = "having num = 0 ";
		}else{
			$has_class = "";
		}
		return $this->db->query("
			select count(*) as num from (
			select SSS.*,G.name as gname from ( 
select SS.*,sum(currentClass) as num from(
 select S.*,CRS.leaveTime,C.id as cid,C.endTime, case when C.id is not null and CRS.leaveTime is null and (C.endTime > now() or C.endTime is null) then 1 else 0 end as currentClass ,
 case when S.loginTime = S.creatTime or S.loginTime is null then 0 else 1 end as islogin from (select * from Student where institution = $institution) S left join (
select * from classRefStuTea where type = 0) CRS on S.id = CRS.userId left join (select * from Class where status != '2') C on CRS.classId = C.id)
 SS $where_grade $where_keywords  group by id $has_class) SSS left join Grade G on SSS.grade = G.id $where_login
 ) sss 
	")->row();
	}
	//重置密码
	public function resetpwd($institution,$userid,$password){
		return $this->db->query("update Student set password = '$password' where institution = $institution and id = $userid");
	}
	//获取班级
	public function getAllClass($userid,$type='1',$p='',$row=''){
		if($type=='1'){
			$where_time = ' having current = 1';
		}elseif($type == '0'){
			$where_time = ' having current = 0';
		}else{
			$where_time = '';
		}
		$limit = '';
		if($p != '' and $row != ''){
			$limit = 'limit '.($p - 1)*$row.','.$row;	
		}
		
		return $this->db->query("
			select * from(
select CRS.leaveTime,CRS.joinTime,C.id as classId,C.beginTime,C.endTime,C.className,
case when CRS.leaveTime is null and (C.endTime is null or C.endTime > now()) then 1 else 0 end current 
from( select * from classRefStuTea where userId = $userid and type = 0 ) CRS 
left join Class C on CRS.classId = C.id where C.status != '2' order by current desc) tt  group by classId  $where_time order by joinTime desc $limit
			")->result();
	}
	public function getClassNum($userid,$type=''){
		if($type=='1'){
			$where_time = ' having current = 1';
		}elseif($type == '0'){
			$where_time = ' having current = 0';
		}else{
			$where_time = '';
		}
		
		return $this->db->query("
			select count(*) as num from(
select C.id as cid,case when leaveTime < now() or endTime < now() then 0 else 1  end as current from 
classRefStuTea CRS left join Class C on CRS.classId = C.id where userId = $userid $where_time
) sc
			")->row();
	}
	//离开班级
	public function leaveClass($institution,$userid,$classid){
		$arr1 = $this->db->query("update classRefStuTea set leaveTime = NOW() where userId = $userid and classId = $classid and type = 0");
	
		$arr2 = $this->db->query("update Class set studentNumber = (studentNumber - 1) where id =  $classid and institution = $institution");
		if($arr1 && $arr2){
			return true;
		}else{
			return false;
		}
	}

    /**
 	* Description : 查询是否存在
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:29
	*/
	public function exist($name,$tel,$id='',$institution=''){
		$where_id = "";
		if($id != '') $where_id = " and id != '$id'";
		$where_institution = '';
		if($institution != '') $where_institution = " and institution =$institution";
		return $this->db->query("select * from Student where truthName = '$name' and parentTel1 ='$tel' $where_id $where_institution")->result();
	}

    /**
 	* Description : 查询是否有同名的
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:37
	*/
	public function existSameName($name,$institution=''){
		$where_institution = '';
		if($institution != '') $where_institution = " and institution =$institution";
		return $this->db->query("select * from Student where truthName = '$name' $where_institution")->result();
	}

    /**
 	* Description : 查询是否存在电话号码
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:51
	*/
	public function existTel($tel,$institution=''){
		$where_institution = '';
		if($institution != '') $where_institution = " and institution ='$institution'";
		return $this->db->query("select * from Student where parentTel1 = '$tel' $where_institution")->result();
	}

    /**
 	* Description : 是否是机构的学员
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:32
	*/
	public function existById($institution,$id){
		return $this->db->query("select * from Student where institution = $institution and id = $id")->row();
	}

    /**
 	* Description : 查询是否是班级的学员
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:32
	*/
	public function existByClassId($userId,$classId){
		return $this->db->query("select * from classRefStuTea where userId = $userId and classId = $classId and type = 0 and leaveTime is null")->row();
	}
    /**
 	* Description : excel 上传的插入
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:32
	*/
	public function uploadInsert($arr,$institution){
		loadlib('pin');
		$this->pin = new pin();
		$num = 0;
		foreach($arr as $v){
			if($this->db->insert('Student',$v)){
				$id = $this->db->insert_id();
				$code = objEncode($id,'S');
				$sort = $this->pin->pinyin($v['truthName'],'UTF8');
				$sortName = $this->getUniqueNameBySort($sort);
				$this->db->query("update Student set studentName = '$sortName' where id = $id and institution = $institution");
				$this->db->query("update Student set code = '$code' where id = $id and institution = $institution");
				$num = $num + 1;
			}
		}
		return $num;
	}

    /**
 	* Description : 获取基本信息
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:36
	*/
	public function getInfoById($id,$institution){
		return $this->db->query("select S.*,G.name as gname from Student S left join Grade G on S.grade = G.id where S.id = $id and institution = $institution")->row();
	}

    /**
 	* Description : 添加到班级
 	* Author      : jishuai
 	* Created Time: 2014-12-25 13:36
	*/
	public function addClass($institution,$userid,$classid){
		$res1 = $this->db->query("insert into classRefStuTea (classId,userId,joinTime,type) values ($classid,$userid,now(),0)");
		$res2 = $this->db->query("update Class set studentNumber = studentNumber + 1 where id = $classid");
		if($res1 && $res2) {
			return true;
		}else{
			return false;
		}
	}
	//判断原来学号是否存在
	public function isCodeExist($institution,$code){
		return $this->db->query("select * from Student where institution = $institution and studentCode = '$code'")->result();
	}
	
    /**
 	* Description : 判断已经存在的学员的双拼
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:21
	*/
	public function getSortNum($sort){
		return $this->db->query("
			select count(*) as num from Student where sort = '$sort'
			")->row();
	}

    /**
 	* Description : 判断已经存在的用户名的个数
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:21
	*/
	public function getUserNameNum($sort){
		return $this->db->query("
			select count(*) as num from Student where studentName like '%$sort%'
			")->row();
	}
    /**
 	* Description : 更新学员信息 
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:22
	*/
	public function updateStudent($data){
        $res = $this->db->update('student', array('status'=>'2'));
	}
	
    /**
 	* Description : 检查是否为机构的老师
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:21
	*/
	public function checkAuth($institution,$studentId){
		if( $this->db->query("select * from Student where institution = $institution and id = $studentId ")->result() ){
			return true;
		}else{
			return false;
		}
	}

    /**
 	* Description : 获取最后一次插入的ID
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:21
	*/
	public function getLastInsert($institution){
		return mysql_insert_id();
	}

    /**
 	* Description : 判读是否已有原学号
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:20
	*/
	public function existSameCode($code,$institution,$studentId = ''){
		$where_self = '';
		if($studentId != '') $where_self = "and id != '$studentId'";	
		return $this->db->query("select * from Student where studentCode = '$code' and institution = $institution $where_self")->result();
	}

    /**
 	* Description : 根据sort获取唯一用户名
 	* Author      : jishuai
 	* Created Time: 2014-12-01 14:19
	*/
	public function getUniqueNameBySort($sort){
		$res = preg_split('/([A-Za-z\s]+)([0-9]+)/',$sort,0,PREG_SPLIT_DELIM_CAPTURE);
		if(isset($res[2])){
			$name = $res[1];
		}else{
			$name = $sort;
		}
		if($this->getUserNameNum($sort)->num > 0){
			$randNum = rand(intval($this->getUserNameNum($sort)->num) + 1,intval($this->getUserNameNum($sort)->num)*2+10);
			$newName = $name.$randNum;
			return $this->getUniqueNameBySort($newName);
		}else{
			return $sort;
		}
	}

    /**
 	* Description : 获取有课学生ID
 	* Author      : jishuai
 	* Created Time: 2014-12-22 16:52
	*/
	public function getIdList($institution,$hasClass = '2',$grade = '',$p='1',$row='30',$order='',$keywords='',$isnum = ''){
		$where_grade = '';
		if($grade != '') $where_grade = " and grade = ".$grade; 
        $limit = "";
        if($p!=""&&$row!="") $limit = " limit ".($p-1)*$row.",".$row;
		if($order == 'cd'){
			$order = "order by creatTime desc,islogin asc";
		}elseif($order == 'ca'){
			$order = "order by creatTime asc,islogin desc";
		}elseif($order == 'ld'){
			$order = 'order by islogin desc,loginTime desc';
		}elseif($order == 'la'){
			$order = 'order by islogin asc,loginTime asc';
		}else{
			$order = "order by creatTime desc,islogin desc";
		}
		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
					$where_keywords = " and (code='$keywords' or truthName like '%$keywords%' or studentCode = '$keywords') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}

		if($hasClass == '1'){
			if($isnum == 'all'){
				$sql = "select count(S.id) as num from(
		select DISTINCT(cRS.userId) from classRefStuTea cRS left join Class C on cRS.classId = C.id 
		where cRS.leaveTime is null and (C.endTime > now() or C.endTime is null) and cRS.type = 0
		)SSID left join Student S on SSID.userId = S.id where S.institution = $institution $where_grade";
			}elseif($isnum == 'login'){
				$sql = "select count(S.id) as num from(
		select DISTINCT(cRS.userId) from classRefStuTea cRS left join Class C on cRS.classId = C.id 
		where cRS.leaveTime is null and (C.endTime > now() or C.endTime is null) and cRS.type = 0
		)SSID left join Student S on SSID.userId = S.id where S.institution = $institution $where_grade";
			}else{
				$sql = " select S.id,case when S.loginTime is not null then 1 else 0 end as islogin from(
		select DISTINCT(cRS.userId) from classRefStuTea cRS left join Class C on cRS.classId = C.id 
		where cRS.leaveTime is null and (C.endTime > now() or C.endTime is null) and cRS.type = 0
		)SSID left join Student S on SSID.userId = S.id where S.institution = $institution $where_grade $order $limit"; 
			}
	} elseif($hasClass = '2'){
		$sql = " select id,case when loginTime is not null then 1 else 0 end as islogin from Student
		   	where institution = $institution $where_grade $where_keywords $order $limit";
	}	
		return	$this->db->query($sql)->result();
	}

    /**
 	* Description : 根据ID列表获取学生信息
 	* Author      : jishuai
 	* Created Time: 2014-12-22 17:05
	*/
	public function getInfoBYIdList($str = '',$order = '',$hasClass = ''){
		if($order == 'cd'){
			$order = "order by creatTime desc,islogin asc";
		}elseif($order == 'ca'){
			$order = "order by creatTime asc,islogin desc";
		}elseif($order == 'ld'){
			$order = 'order by islogin desc,loginTime desc';
		}elseif($order == 'la'){
			$order = 'order by islogin asc,loginTime asc';
		}else{
			$order = "order by creatTime desc,islogin desc";
		}
		if($str == '') return false;
		if($hasClass == '0'){
			$sql = "select S.*,G.name gname,case when S.loginTime is not null then 1 else 0 end as islogin from Student S left join Grade G on
				S.grade = G.id where S.id in ($str) $order";
		}else{
			$sql = "
			select SS.*,sum(curr) cNum from(
 select S.*,C.id cid,G.name gname,cRS.type,
case when cRS.id is not null and cRS.type = 0 and cRS.leaveTime is null and (C.endTime is null or C.endTime > now()) 
then 1 else 0 end as curr,case when S.loginTime is not null then 1 else 0 end as islogin from
 Student S left join classRefStuTea cRS on S.id = cRS.userId left join Class C on cRS.classId = C.id left join Grade G on S.grade = G.id
 where S.id in ($str)) SS group by SS.id $order";
		}
		return	$this->db->query($sql)->result();
	}

    /**
 	* Description : 根据发送条件获取所有学生的ID
 	* Author      : jishuai
 	* Created Time: 2014-12-23 16:32
	*/
	public function getAllID($institution,$hasClass,$type = '',$grade='',$keywords=''){
		$where_grade = '';
		if($grade != '') $where_grade = "and grade = ".$grade; 
		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
					$where_keywords = " and (S.code='$keywords' or S.truthName like '%$keywords%' or S.studentCode = '$keywords') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " S.truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}
		if($hasClass == '1'){
			if($type == ''){
				$sql = "select S.id from(
		select DISTINCT(cRS.userId) from classRefStuTea cRS left join Class C on cRS.classId = C.id 
		where cRS.leaveTime is null and (C.endTime > now() or C.endTime is null) and cRS.type = 0
		)SSID left join Student S on SSID.userId = S.id where S.institution = $institution $where_keywords $where_grade";
			}elseif($type == 'login'){
				$sql = "select S.id from(
		select DISTINCT(cRS.userId) from classRefStuTea cRS left join Class C on cRS.classId = C.id 
		where cRS.leaveTime is null and (C.endTime > now() or C.endTime is null) and cRS.type = 0
		)SSID left join Student S on SSID.userId = S.id where S.institution = $institution $where_keywords $where_grade and S.loginTime is not null";
			}elseif($type == 'allgrade'){
				$sql = "select distinct(S.grade),G.name gname from( 
select DISTINCT(cRS.userId) from classRefStuTea cRS left join Class C on cRS.classId = C.id 
where cRS.leaveTime is null and (C.endTime > now() or C.endTime is null) and cRS.type = 0 )
SSID left join Student S on SSID.userId = S.id left join Grade G on S.grade = G.id where S.institution = $institution $where_keywords";
			}
		}elseif($hasClass == '2'){
			if($type == 'login'){
				$sql = "select S.id from Student S where S.institution = $institution $where_keywords $where_grade and S.loginTime is not null";
			}elseif($type == 'allgrade'){
				$sql = "select SG.grade,G.name gname from (
select DISTINCT(grade) from Student S where institution = $institution $where_keywords
) SG left join Grade G on SG.grade = G.id";
			}else{ 
				$sql = "select S.id from Student S where S.institution = $institution $where_keywords $where_grade";
			}
		}
			return $this->db->query($sql)->result();
	}

    /**
 	* Description : 过滤无课学生列表order、limit
 	* Author      : jishuai
 	* Created Time: 2014-12-24 09:42
	*/
	public function filterIdOfNoClass($IdStr,$order,$grade = '',$p = '1',$row = '30'){
		$where_grade = '';
		if($grade != '') $where_grade = " grade = ".$grade.' and '; 
		if($order == 'cd'){
			$order = "order by creatTime desc,islogin asc";
		}elseif($order == 'ca'){
			$order = "order by creatTime asc,islogin desc";
		}elseif($order == 'ld'){
			$order = 'order by islogin desc,creatTime desc';
		}elseif($order == 'la'){
			$order = 'order by islogin asc,creatTime asc';
		}else{
			$order = "order by creatTime desc,islogin desc";
		}
        $limit = "";
        if($p!=""&&$row!="") $limit = " limit ".($p-1)*$row.",".$row;
		$sql = "select id,case when loginTime is not null then 1 else 0 end islogin,grade from Student where $where_grade id in ($IdStr) $order $limit";
		return $this->db->query($sql)->result();
	}

    /**
 	* Description : 获取所有无课班级的信息
 	* Author      : jishuai
 	* Created Time: 2014-12-24 10:40
	*/
	public function getInfoOfNoClass($IdStr,$type="grade",$grade = ''){
		$where_grade = '';
		if($grade != '') $where_grade = " grade = ".$grade.' and '; 
		if($type == 'grade'){
			$sql = "select distinct(S.grade),G.name gname from Student S left join Grade G on S.grade = G.id where S.id in($IdStr)";
		}elseif($type == 'login'){
			$sql = "select id,case when loginTime is not null then 1 else 0 end islogin,grade from Student where $where_grade id in ($IdStr) having islogin = 1";
		}
		return $this->db->query($sql)->result();
	}

    /**
 	* Description : 将学生加入班级
 	* Author      : jishuai
 	* Created Time: 2014-12-26 13:54
	*/
	public function addTOClass($studentIds,$classId){
		$num = 0;
		if(is_array($studentIds)){
			foreach ($studentIds as $v){
				if($this->db->query("insert into classRefStuTea (classId,userId,joinTime,leaveTime,type) values ($classId,$v,now(),null,0)")) $num++;
			}
			$this->db->query("update Class set studentNumber = studentNumber + $num where id = $classId");
		}else{
			if($this->db->query("insert into classRefStuTea (classId,userId,joinTime,leaveTime,type) values ($classId,$studentIds,now(),null,0)")) $num++;
			$this->db->query("update Class set studentNumber = studentNumber + $num where id = $classId");
		}
		return $num;
	}

    /**
 	* Description : 根据信息获取Id
 	* Author      : jishuai
 	* Created Time: 2015-02-27 11:01
	*/
	public function getIdByInfo($name,$telephone){
		return $this->db->query("select * from Student where truthName='$name' and parentTel1 = $telephone")->row();
	}
}

