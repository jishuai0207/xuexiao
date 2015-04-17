<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description : 考勤模块
 * Author      : jishuai
 * Created Time: 2015-02-27 18:12
 */
class Sign_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	/**
	 * Description : 考勤信息查询
	 * Author      : jishuai
	 * Created Time: 2015-02-27 18:13
	 */
	public function getSignInfo($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId,$page,$row){
		$where_class_code = '';
		if($classCode) $where_class_code = " and C.classCode = '$classCode' ";
		$where_class_name = '';
		if($className) $where_class_name = " and C.classname like '%$className%' ";
		$where_truth_name = '';
		if($truthName) $where_truth_name = " and S.truthName  like '%$truthName%' ";
		$where_student_id = '';
		if($studentId) $where_student_id = " and S.id = '$studentId' ";
		$having_sign = '';
		if($issign == '1') $having_sign = ' and issign = 1'; 
		if($issign == '0') $having_sign = ' and issign = 0'; 
		$top = ($page-1)*$row;
		$limit = " limit $top,$row";
		return $this->db->query("
			select SI.id siid,CI.lesson_id,SI.student_id,CI.class_id cid,S.school,S.truthName,C.classCode,C.className,CI.submit_time,SI.sign_time,C.institution,
			case when SI.sign_time is null then 0 else 1 end as issign,S.parent1ref,S.parentTel1,H.id hid,
				SH.objectiveScore,SH.subjectiveScore,SC.replaceTeacher
				from shouke.class_info CI left join manageSystem.Class C on CI.class_id = C.id 
				left join shouke.sign_info SI on C.id = SI.class_id and CI.lesson_id = SI.lesson_id
				left join manageSystem.Student S on SI.student_id = S.id
				left join manageSystem.HomeWork H on CI.lesson_id = H.num
				left join manageSystem.student_homework SH on H.id = SH.homeWorkId and S.id = SH.studentId and C.id = SH.classid
				left join manageSystem.Schedule SC on C.id = SC.classId and SC.lessonId = CI.lesson_id
				where CI.submit_time > '$start' and CI.submit_time < '$end' and C.institution = $institution
				$where_class_code $where_class_name $where_truth_name $where_student_id having SI.student_id is not null
			   	$having_sign order by cid asc , SI.student_id asc $limit
				")->result();
	}

	/**
	 * Description : 考勤信息查询
	 * Author      : jishuai
	 * Created Time: 2015-02-27 18:13
	 */
	public function getDownloadInfo($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId){
		$where_class_code = '';
		if($classCode) $where_class_code = " and C.classCode = '$classCode' ";
		$where_class_name = '';
		if($className) $where_class_name = " and C.classname like '%$className%' ";
		$where_truth_name = '';
		if($truthName) $where_truth_name = " and S.truthName  like '%$truthName%' ";
		$where_student_id = '';
		if($studentId) $where_student_id = " and S.id = '$studentId' ";
		$having_sign = '';
		if($issign == '1') $having_sign = ' and issign = 1'; 
		if($issign == '0') $having_sign = ' and issign = 0'; 
		return $this->db->query("
			select CI.lesson_id,SI.student_id,CI.class_id cid,S.school,S.truthName,C.classCode,C.className,CI.submit_time,SI.sign_time,C.institution,
			case when SI.sign_time is null then 0 else 1 end as issign,S.parent1ref,S.parentTel1,H.id hid,
				SH.objectiveScore,SH.subjectiveScore,SC.replaceTeacher
				from shouke.class_info CI left join manageSystem.Class C on CI.class_id = C.id 
				left join shouke.sign_info SI on C.id = SI.class_id and CI.lesson_id = SI.lesson_id
				left join manageSystem.Student S on SI.student_id = S.id
				left join manageSystem.HomeWork H on CI.lesson_id = H.num
				left join manageSystem.student_homework SH on H.id = SH.homeWorkId and S.id = SH.studentId and C.id = SH.classid
				left join manageSystem.Schedule SC on C.id = SC.classId and SC.lessonId = CI.lesson_id
				where CI.submit_time > '$start' and CI.submit_time < '$end' and C.institution = $institution
				$where_class_code $where_class_name $where_truth_name $where_student_id having SI.student_id is not null
			   	$having_sign order by cid asc , SI.student_id asc
				")->result();
	}

	/**
	 * Description : 计算考勤的个数
	 * Author      : jishuai
	 * Created Time: 2015-02-28 19:04
	 */
	public function getSignNum($start,$end,$issign,$institution,$classCode,$className,$truthName,$studentId,$page,$row){
		$where_class_code = '';
		if($classCode) $where_class_code = " and C.classCode = '$classCode' ";
		$where_class_name = '';
		if($className) $where_class_name = " and C.classname like '%$className%' ";
		$where_truth_name = '';
		if($truthName) $where_truth_name = " and S.truthName  like '%$truthName%' ";
		$where_student_id = '';
		if($studentId) $where_student_id = " and S.id = '$studentId' ";
		$having_sign = '';
		if($issign == '1') $having_sign = ' having issign = 1'; 
		if($issign == '0') $having_sign = ' having issign = 0'; 
		$top = ($page-1)*$row;
		$limit = " limit $top,$row";
		if($issign == '1') $having_sign = ' and issign = 1'; 
		if($issign == '0') $having_sign = ' and issign = 0'; 
		return $this->db->query("
			select count(*) as num from (
				select CI.lesson_id,SI.student_id,CI.class_id cid,
				case when SI.sign_time is null then 0 else 1 end as issign
					from shouke.class_info CI left join manageSystem.Class C on CI.class_id = C.id 
					left join shouke.sign_info SI on C.id = SI.class_id and CI.lesson_id = SI.lesson_id
					left join manageSystem.Student S on SI.student_id = S.id
					left join manageSystem.HomeWork H on CI.lesson_id = H.num
					left join manageSystem.student_homework SH on H.id = SH.homeWorkId and S.id = SH.studentId and C.id = SH.classid
					where CI.submit_time > '$start' and CI.submit_time < '$end' and C.institution = $institution
					$where_class_code $where_class_name $where_truth_name $where_student_id having SI.student_id is not null $having_sign 
				) SS
				")->row()->num;
		//and C.classCode = 'BJ14Q0668' and C.className like '%三年级%' and S.truthName like '%米%' and SI.student_id = '44204' having issign = 0

	}

	/**
	 * Description : 根据班级列表获取老师名字
	 * Author      : jishuai
	 * Created Time: 2015-02-27 19:31
	 */
	public function getTeaByClassList($list){
		return $this->db->query("
			select classId,userId,T.truthName from manageSystem.classRefStuTea CRS left join 
			manageSystem.Teacher T on CRS.userId = T.id where classId in $list
			and type = 1 and leaveTime is null	
			")->result();
	}

	/**
	 * Description : 处理获取到的考勤的原始数据
	 * Author      : jishuai
	 * Created Time: 2015-02-28 09:45
	 */
	public function dataProcess($res){
		$info = array();
		$classList = array();
		if($res){
			foreach($res as $v){
				$classList[] = $v->cid;
			}
			$listStr = implode($classList,',');
			$listStr = '('.$listStr.')';
			$teacherArr = array();
			$teachers = array();
			$teacherArr = $this->sign->getTeaByClassList($listStr);

			foreach($teacherArr as $v){
				$teachersA[$v->classId][] = $v->truthName;
				if(isset($teachersInfo[$v->classId])){
					$teachersInfo[$v->classId] .= ','.$v->truthName;
				}else{
					$teachersInfo[$v->classId] = $v->truthName;
				}
			}

			foreach($res as $k => $v){
				$info[$k] = $v;
				$cid = $v->cid;
				if(array_key_exists($cid,$teachersInfo)){
					$info[$k]->teacherInfo = $teachersInfo[$cid]; 
				}
				if(array_key_exists($cid,$teachersA)){
					$info[$k]->teacher = $teachersA[$cid];
				}
				if(! isset($info[$k]->teacher[1])) $info[$k]->teacher[1] = '';
				$info[$k]->school = $v->student_id;
				$info[$k]->subDate = substr($v->submit_time,0,10);
				$info[$k]->subTime = substr($v->submit_time,11,5);
				$info[$k]->signInfo = $v->issign?'出勤':'缺勤';
				$info[$k]->scoreInfo = ($v->subjectiveScore === null and $v->objectiveScore === null)?'--':$v->subjectiveScore+$v->objectiveScore;
				$info[$k]->replaceInfo = $v->replaceTeacher === null?'--':$v->replaceTeacher;
				$info[$k]->refInfo = $v->parent1ref === null?'--':$v->parent1ref;

			}
		}
		return $info;
	}


	/**
	 * Description : 将数据处理成为excel数据
	 * Author      : jishuai
	 * Created Time: 2015-02-28 11:45
	 */
	public function dataExcel($info){
		if(! $info) return false;
		foreach($info as $k => $v){
			$data[$k][0] = $v->school; 
			$data[$k][1] = $v->truthName; 
			$data[$k][2] = $v->classCode; 
			$data[$k][3] = $v->className; 
			$data[$k][4] = $v->subDate; 
			$data[$k][5] = $v->subTime; 
			$data[$k][6] = $v->signInfo; 
			$data[$k][7] = $v->scoreInfo; 
			$data[$k][8] = $v->teacherInfo; 
			$data[$k][9] = $v->replaceInfo; 
			$data[$k][10] = $v->refInfo; 
			$data[$k][11] = $v->parentTel1; 
		}
		return $data;
	}

}









