<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Class_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	/**
	 *description:根据id获取一条信息
	 *author:yanyalong
	 *date:2014/11/05
	 */
	public function get($id){
		return $this->db->get_where('Class',array('id' => $id))->row();
	}
	/**
	 *description:查询班级排课信息
	 *author:yanyalong
	 *date:2014/11/05
	 */
	public function getScheduleListByClass($classId){
		return $this->db->query("select L.num,T.id teacherId,T.truthName,T.nickName,date(S.beginTime) date,S.beginTime,S.endTime from Schedule S  
			left join Lesson L on L.id=S.lessonId
			left join Teacher T on T.id=S.teacher
			where S.classId=$classId order by L.num")->result_array();
	}
	/**
	 *description:查询班级今日课程
	 *author:yanyalong
	 *date:2014/11/06
	 */
	public function classTodayLesson($institution,$p="",$row=""){
		$limit = "";
		if($p!=""&&$row!=""){
			$limit = " limit ".($p-1)*$row.",".$row;
		}
		$dateStart = date('Y-m-d');
		$dateEnd = date('Y-m-d',strtotime("+1 days"));
		$res = $this->db->query("select C.className,C.id classId,S.beginTime,S.endTime,
			T1.id teacherId,T1.truthName teacherTruethName,T1.nickName TeacherNickname,
			T2.id treplaceTeacherId,T2.truthName replaceTeacherTruthName,T2.nickname replaceTeacherNickname
			from Class C
			left join Schedule S on S.classId=C.id
			left join Teacher T1 on T1.id=S.teacher
			left join Teacher T2 on T2.id=S.replaceTeacher
			where C.status=1 and S.beginTime > '1970-01-01' and S.endTime > '1970-01-01' and S.beginTime>'$dateStart'
			and S.endTime<'$dateEnd' and C.institution=$institution
			order by S.beginTime
			$limit ")->result();
		if($res==false) return false;
		$res['list'] = $res;
		$res['count'] = $this->db->query("select count(C.id) count from Class C
			left join Schedule S on S.classId=C.id
			where C.status=1 and S.beginTime > '1970-01-01' and S.endTime > '1970-01-01' and S.beginTime>'$dateStart'
			and S.endTime<'$dateEnd' and C.institution=$institution
			")->row()->count;
		return $res;

	}
	/**
	 *description:获取机构在职老师
	 *author:yanyalong
	 *date:2014/11/06
	 */
	public function getTeacherListByInstitution($institution,$subjectId="",$keywords="",$inJob='',$status=""){
		$where_inJob = "";
		if($inJob!=""){
			$where_inJob= "  and T.inJob=$inJob ";
		}
		$where_status = "";
		if($status!=""){
			$where_status = "  and T.status=$status ";
		}
		$where_subject = "";
		if($subjectId!=""){
			$where_subject = "  and ts.subjectId=$subjectId  ";
		}
		$where_keyword = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
				$where_keyword = " and (T.teacherCode='$keywords' or T.truthName like '%$keywords%' or T.nickname like '%$keywords%') ";
			}else{
				$where_keyword .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keyword.= " T.truthName like '%$val%' and";
				}
				$where_keyword = trim($where_keyword,'and');
				$where_keyword.=") or (";
				foreach ($keywordsArr as $key => $val) {
					$where_keyword.= " T.nickname like '%$val%' and";
				}
				$where_keyword = trim($where_keyword,'and');
				$where_keyword.="))";
			}
		}
		return $this->db->query(" SELECT T.id,T.truthName,T.nickname,T.teacherCode,T.path,UPPER(left(T.sort,1)) sortHead from Teacher T left join `teacher_subject` ts on T.id=ts.teacherId
			where
			T.institution='$institution'
			$where_inJob
			$where_status
			$where_keyword
			$where_subject group by T.id order by sortHead;")->result();
	}
	/**
	 *description:根据年级和学科查询班型信息
	 *author:yanyalong
	 *date:2014/11/06 */
	public function getCTByGradeSubject($gradeId="",$subjectId=""){
		$where_subject = "";
		if($subjectId!=""){
			$where_subject = " and subject= $subjectId ";
		}
		$where_grade = "";
		if($subjectId!=""){
			$where_grade= " and grade= $gradeId ";
		}
		return $this->db->query("select name from ClassType where status = 1 $where_subject $where_grade  group by name")->result();
	}
	/**
	 *description:插入一条班级数据
	 *author:yanyalong
	 *date:2014/11/06
	 */
	public function insert($data){
		$this->db->insert('Class', $data);
		return $this->db->insert_id();
	}
	/**
	 *description:获取机构班级列表
	 *author:yanyalong
	 *date:2014/11/06
	 */
	public function getlistByInstitution($institution,$teacherId="",$gradeId="",$classTypeCode="",$classTypePeriod="",$subjectId="",$isEnd="",$keywords="",$p="",$row=""){
		$limit = "";
		if($p!=""&&$row!=""){
			$limit = " limit ".($p-1)*$row.",".$row;
		}
		$leave_where = "";
		$cRS_where= "";
		if($keywords!=""||$teacherId!=""){
			$cRS_where = " left join classRefStuTea cRS on cRS.classId=C.id 
				left join Teacher T on T.id=cRS.userId ";
			$leave_where = " and cRS.type=1 and cRS.leaveTime is null ";
		}
		$where_teacherId = "";
		if($teacherId!="")
			$where_teacherId = " and cRS.userId='$teacherId' $leave_where ";
		$where_gradeId= "";
		if($gradeId!="")
			$where_gradeId = " and G.id='$gradeId' ";
		$where_classTypeCode= "";
		if($classTypeCode!="")
			$where_classTypeCode = " and CT.code='$classTypeCode' ";
		$where_classTypePeriod= "";
		if($classTypePeriod!="")
			$where_classTypePeriod = " and CT.period='$classTypePeriod' ";
		$where_subject= "";
		if($subjectId!="")
			$where_subject= " and S.id=$subjectId ";
		$where_isEnd = "";
		if($isEnd=="1")
			$where_isEnd = " and ( C.endTime is not null and C.endTime < now()) ";
		elseif($isEnd=="0")
			$where_isEnd = " and (C.endTime is null or C.endTime > now()) ";
		else $where_isEnd = "";
		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
				$where_keywords = " and (C.classCode='$keywords' or C.className like '%$keywords%' or T.truthName like '%$keywords%' or T.nickname like '%$keywords%') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " T.truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.=") or (";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " T.nickname like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.=") or (";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " C.className like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}
		$res['classlist'] = $this->db->query("select * from (select C.place,IC.classTypeName customName,C.classCode,case when (C.endTime is not null and unix_timestamp()>unix_timestamp(C.endTime)) 
			then '1' else '0' end ClassStatus,C.className,C.id classId,G.name gradeName,G.id gradeId,S.name Subject,
			CT.classNumber allLessonNum,C.studentNumber,case when sLN.stuLogNum is null then '0' end stuLogNum,createTime, 
			CT.name classTypeName,CT.code classTypeCode,CT.id classTypeId,CT.period 
			from Class C left join institution_classType IC on C.classTypeId = IC.classTypeId left join ClassType CT on CT.id=C.classTypeId left join 
			Subject S on S.id=CT.subject left join Grade G on G.id=CT.grade 
			left join (select count(cRT.userId) stuLogNum,cRT.classId from Student Stu 
			left join classRefStuTea cRT on cRT.userId=Stu.id where cRT.type=0 and Stu.loginTime is not null 
			and unix_timestamp(Stu.loginTime)<>0 and Stu.institution='$institution' group by cRT.classId) sLN on sLN.classId=C.id 
			$cRS_where
			where C.institution='$institution' and IC.institutionId='$institution' and C.status<2
			$leave_where
			$where_teacherId
			$where_gradeId
			$where_classTypeCode
			$where_classTypePeriod
			$where_subject
			$where_isEnd
			$where_keywords
			group by C.id order by C.createTime desc
			$limit) C order by C.createTime desc")->result_array();
		//echo $this->db->last_query();exit;
		if($res['classlist']==false) return false;
		$res['count'] = $this->db->query("select count(classId) count from (select C.id classId from Class C left join ClassType CT on CT.id=C.classTypeId left join Subject S on S.id=CT.subject 
			left join Grade G on G.id=CT.grade 
			$cRS_where
			where C.institution='$institution' and C.status<2
			$leave_where
			$where_teacherId
			$where_gradeId
			$where_classTypeCode
			$where_classTypePeriod
			$where_subject
			$where_isEnd
			$where_keywords
			group by C.id) C2")->row()->count;
		return $res;
	}
	/**
	 *description:根据班级id列表获取老师列表
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getTeacherbyClassList($classIdList){
		return $this->db->query("select case when S2.secheduleNum is null then 0 else S2.secheduleNum end secheduleNum,cRS.classId classId,T.truthName,T.nickname,
			T.id teacherId from classRefStuTea cRS 
			left join Teacher T on T.id=cRS.userId 
			left join (select count(*) secheduleNum,teacher from `Schedule` where classId  in ($classIdList) and UNIX_TIMESTAMP()<UNIX_TIMESTAMP(endTime) group by teacher) S2
			on S2.teacher=T.id
			where cRS.classId in($classIdList) 
			and (cRS.leaveTime is null or unix_timestamp(cRS.leaveTime)=0) and cRS.type=1 
			order by cRS.joinTime")->result();
	}
	/**
	 *description:根据班级id列表获取学员列表
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getStudentbyClassList($classIdList){
		return $this->db->query("select S.code,cRS.classId classId,S.truthName,S.id studentId from classRefStuTea cRS left join Student S on S.id=cRS.userId where cRS.classId in($classIdList) and (cRS.leaveTime is null or unix_timestamp(cRS.leaveTime)=0) and cRS.type=0 order by cRS.joinTime")->result();
	}
	/**
	 *description:根据机构id和班级id获取班级详情
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getClassInfoByInst($classId,$institution){
		return $this->db->query("
			select C.institution,S2.readyScheduleNum,C.classCode,C.status,case when cRT2.stuLogNum is null then 0 else cRT2.stuLogNum end stuLogNum,
			C.id classId,C.className, CT.classNumber,C.studentNumber,C.semester,C.shoukeDay,C.beginTimeSlot,C.endTimeSlot, 
			case when (C.beginTime is null or UNIX_TIMESTAMP(C.beginTime)=0) then '未知' else date(C.beginTime) end beginTime, 
				case when (C.endTime is null or UNIX_TIMESTAMP(C.endTime)=0) then '未知' else date(C.endTime) end endTime,
					G.name gradeName, S.name subjectName,DATE_FORMAT(C.createTime,'%Y-%m-%d') createTime,CT.name classTypeName,CT.period, 
					case when (C.endTime is not null and unix_timestamp()>unix_timestamp(C.endTime)) then '1' else '0' end ClassStatus,C.place ,IC.classTypeName customName
						from Class C left join institution_classType IC on C.classTypeId = IC.classTypeId left join ClassType CT on CT.id=C.classTypeId left join Grade G on G.id=CT.grade left join Subject S on 
						S.id=CT.subject left join (select count(cRT.userId) stuLogNum,cRT.classId from Student Stu left join 
						classRefStuTea cRT on cRT.userId=Stu.id where cRT.type=0 and 
						Stu.loginTime is not null and unix_timestamp(Stu.loginTime)<>0 and cRT.classId='$classId') cRT2 on 
						cRT2.classId=C.id left join (select count(*)readyScheduleNum,classId from Schedule where classId='$classId') S2 on
						S2.classId=C.id where C.id='$classId' and C.institution='$institution' and IC.institutionId = '$institution'")->row();
	}
	public function delete($classId){
		return $this->db->delete('Class',array('id' => $classId));
	}
	/**
	 *description:获取班级学员列表
	 *author:yanyalong
	 *date:2014/11/05
	 */
	public function getStudentListByClassId($classId,$p="",$row=""){
		$limit = "";
		if($p!=""&&$row!=""){
			$limit = " limit ".($p-1)*$row.",".$row;
		}
		$res = $this->db->query("select S.id studentId,S.path avatar,S.studentName,S.truthName,case when S.sex=0 then '女' when S.sex=1 then '男' else '-' end sex,date(cRS.joinTime) joinTime,
			case when (S.loginTime is null or UNIX_TIMESTAMP(S.loginTime)=0) then '未登陆过' else date(S.loginTime) end lastLogin,
				case when (S.loginTime is null or UNIX_TIMESTAMP(S.loginTime)=0) then 0 else 1 end isLogin,
					case when (S.loginTime is null or UNIX_TIMESTAMP(S.loginTime)=0) then joinTime else S.loginTime end loginTime,
						case when (S.loginTime is null or UNIX_TIMESTAMP(S.loginTime)=0) then '未登陆过' else date(S.loginTime) end lastLogin
							from classRefStuTea cRS
							left join Student S on S.id=cRS.userId 
							where cRS.classId='$classId' and cRS.type=0 and (cRS.leaveTime is null or UNIX_TIMESTAMP(cRS.leaveTime)=0) group by cRS.userId
							order by isLogin,loginTime desc,cRS.joinTime desc $limit")->result();
		if($res==false) return false;
		$data['list'] = $res;
		$data['count'] = $this->db->query("select count(*) count from (select cRS.userId from classRefStuTea cRS left join Student S on S.id=cRS.userId where cRS.classId='$classId' and cRS.type=0 and (cRS.leaveTime is null or UNIX_TIMESTAMP(cRS.leaveTime)=0) group by cRS.userId) C2 ")->row()->count;
		return $data;
	}
	/**
	 *description:获取班级学员统计信息
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getStudentStatByClassId($classId){
		return $this->db->query("
			select count(userId) as studentNum ,sum(islogin) as loginNum from (
				select SC.*,S.loginTime,case when loginTime is not null then 1 else 0 end as islogin from (
				select * from classRefStuTea where classId = '$classId' and type = 0 and leaveTime is null
				) SC left join Student S on SC.userId = S.id
			) SS
			")->row();
	}
	/**
	 *description:获取机构学员列表，并按首字母排序，同时判断是否加入过指定班级
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getStudentListinstitution($institution,$classId="",$gradeIds="",$keywords=""){
		$where_grade = "";
		if($gradeIds!="")
			$where_grade = " and G.id in($gradeIds) ";
		$where_keywords = "";
		if($keywords!="") {
			$keywordsArr = explode(' ',$keywords);
			$keyCount = count($keywordsArr);
			if($keyCount==1){
				$where_keywords = " and (S.code='$keywords' or S.truthName like '%$keywords%') ";
			}else{
				$where_keywords .= " and ((";
				foreach ($keywordsArr as $key => $val) {
					$where_keywords.= " S.truthName like '%$val%' and";
				}
				$where_keywords = trim($where_keywords,'and');
				$where_keywords.="))";
			}
		}
		return $this->db->query("
			select 
			S.code,S.id studentId,S.truthName studentName,UPPER(left(S.sort,1)) sortHead,
				G.name gradeName from Student S left join Grade G on G.id=S.grade where S.institution='$institution' $where_keywords 
				$where_grade 
				order by 
				sortHead")->result();

	}
	/**
	 *description:获取指定班级的排课列表
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getScheduleListByClassId($classId,$p="",$row=""){
		$limit = "";
		if($p!=""&&$row!=""){
			$limit = " limit ".($p-1)*$row.",".$row;
		}
		$res = $this->db->query("select L.id lessonId,L.lessonName,L.num,case when S2.replaceTruthName is null then 0 else 1 end replaceStatus,case when S2.lid is not null then 1 else 0 end SecheduleReadyStatus,S2.* from Lesson L 
			left join (select S.lessonId lid,date(S.beginTime) ScheduleDate,DATE_FORMAT(S.beginTime,'%H:%i') 
			beginTime,DATE_FORMAT(S.endTime,'%H:%i') endTime,
				T.truthName,T.nickname,T2.truthName replaceTruthName,T2.nickname replaceNickname
				from Schedule S  
				left join Lesson L on L.id=S.lessonId
				left join Teacher T on T.id=S.teacher
				left join Teacher T2 on T2.id=S.replaceTeacher
				where S.classId='$classId') S2 on S2.lid=L.id where L.id in(select L.id from Class C left join Lesson L on L.classTypeId=C.classTypeId where C.id='$classId')
				$limit")->result();
		if($res==false) return false;
		$data['list'] = $res;
		$data['count'] = $this->db->query("select count(*) count from Lesson L
			left join ClassType CT on L.classTypeId=CT.id
			left join Class C on C.classTypeId=CT.id
			where C.id='$classId'")->row()->count;
		return $data;
	}
	/**
	 *description:获取班级课表统计信息
	 *author:yanyalong
	 *date:2014/11/07
	 */
	public function getScheduleStatByClassId($classId){
		return $this->db->query("select C.id classId,count(Sc.id) readyLessonNum,CT.classNumber from Schedule Sc
			left join Class C on C.id=Sc.classId
			left join ClassType CT on CT.id=C.classTypeId
			where Sc.beginTime is not null and unix_timestamp(Sc.beginTime)<>0 and Sc.endTime is not null and unix_timestamp(Sc.endTime)<>0 
			and  Sc.classId='$classId'")->row();
	}
	/**
	 *description:根据班级id获取任课老师列表
	 *author:yanyalong
	 *date:2014/11/08
	 */
	public function getTeacherByClassId($classId){
		return $this->db->query("select T.* from classRefStuTea cRS left join Teacher T on T.id=cRS.userId where cRS.classId=$classId and cRS.type=1 and (cRS.leaveTime is null or UNIX_TIMESTAMP(cRS.leaveTime)=0) group by T.id")->result();
	}
	/**
	 *description:获取指定班级的科目
	 *author:yanyalong
	 *date:2014/11/09
	 */
	public function getSubjectByClass($classId){
		return $this->db->query("select * from  Class C left join ClassType CT on CT.id=C.classTypeId where C.id='$classId'")->row();
	}
	/**
	 *description:查询班级课程
	 *author:yanyalong
	 *date:2014/11/10
	 */
	public function getLessonByClass($classId){
		return $this->db->query("select L.* from Lesson L left join ClassType CT on CT.id=L.classTypeId left join Class C on C.classTypeId=CT.id where C.id='$classId'")->result();
	}

    /**
 	* Description : 获取班级列表，学员添加班级用
 	* Author      : jishuai
 	* Created Time: 2015-03-01 14:01
	*/
	public function studentAddClassList($institution,$search,$grade,$subject){
		if($search == ''){
			$where_search = '';
		}else{
			$where_search = " and ( c.id = '$search' or truthName like '%$search%' or nickname like '%$search%') ";
		}
		if($grade == ''){
			$where_grade = '';
		}else{
			$where_grade = " and grade = $grade ";
		}
		if($subject == ''){
			$where_subject = '';
		}else{
			$where_subject = " and subject = $subject ";
		}
		return $this->db->query("select c.id,c.className,c.studentNumber,c.classTypeId,c.endTime,ct.subject,ct.grade,
			g.name as gname ,s.name as sname ,trc.userId,t.truthName,t.nickname
			from Class c left join ClassType ct on c.classTypeId  = ct.id left join Grade g on ct.grade = g.id 
			left join Subject s on ct.subject = s.id
			left join (select * from classRefStuTea where type = 1) trc on c.id = trc.classId 
			left join Teacher t on trc.userId = t.id  
			where c.institution = $institution and c.status = 1 $where_search $where_grade $where_subject
			and endTime > now()")->result();
	}

    /**
 	* Description : 判断是否是此机构的班级
 	* Author      : jishuai
 	* Created Time: 2015-03-01 14:01
	*/
	public function existById($institution,$classid){
		return $this->db->query("select * from Class where institution = $institution and id = $classid")->result();
	}

	/**
	 *description:获取班级基本信息(包含课节数)
	 *author:yanyalong
	 *date:2014/11/22
	 */
	public function getClassInfo($classId,$institution){
		return $this->db->query("select * from Class C left join ClassType CT on CT.id=C.classTypeId where C.institution = $institution and C.id = $classId")->row();
	}
	/**
	 *description:跟均班级列表获取已排课节数
	 *author:yanyalong
	 *date:2014/12/19
	 */
	public function getReadyLessonNumByClass($classIds){
		return $this->db->query("select count(Sc.id) readyLessonNum,classId from Schedule Sc where Sc.classId in ($classIds) group by Sc.classId")->result();
	}

	/**
	 * Description : 根据classIDlist获取已登录的学生数
	 * Author      : jishuai
	 * Created Time: 2015-01-15 17:20
	 */
	public function getloginNumByClassList($str){
		return $this->db->query("select classId,count(userId) loginNum from classRefStuTea cRS left join Student S on cRS.userId = S.id 
			where classId in ($str) and leaveTime is null and type = 0 and loginTime is not null
			group by classId")->result_array();
	}

	/**
	 * Description : 查询当前班级是否有人交作业
	 * Author      : jishuai
	 * Created Time: 2015-02-09 13:26
	 */
	public function existHomework($classId){
		return $this->db->query("select count(*) num from student_homework where classId = $classId")->row()->num;
	}

	/**
	 * Description : 查询是否是当前机构的班级
	 * Author      : jishuai
	 * Created Time: 2015-02-09 13:32
	 */
	public function existByInsID($classId){
		$institution = $_SESSION['institution'];
		return $this->db->query("select * from Class where id = $classId and institution = $institution ")->result();
	}

	/**
	 * Description : 将所有课节添加到课节表上
	 * Author      : jishuai
	 * Created Time: 2015-02-10 16:32
	 */
	public function insertSchedule($classId,$classTypeId){
		$ids = $this->db->query("select id from Lesson where classTypeId = $classTypeId")->result();
		if(!$ids) return false;
		$num = 0;
		foreach($ids as $v){
			$res = $this->db->query("insert into Schedule (classId,lessonId) values ($classId,$v->id)");
			if($res) $num ++;
		}
		return $num;
	}
}

