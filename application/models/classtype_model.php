<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class ClassType_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    /**
     *description:根据班级id获取班型信息
     *author:yanyalong
     *date:2014/11/06
     */
    public function getCTByClassId($classId){
        return  $this->db->query("select CT.*,C.*,Tc.TeacherName from ClassType CT left join Class C on C.classTypeId=CT.id left join (select cRS.userId,cRS.classId,T.truthName TeacherName from classRefStuTea cRS left join Teacher T on T.id=cRS.userId where cRS.classId='$classId' and cRS.type=1 and cRS.leaveTime is null order by cRS.joinTime limit 1) Tc on Tc.classId=C.id where C.id='$classId'")->row();
    }
    /**
     *description:根据班型编码和学期获取班型信息
     *author:yanyalong
     *date:2014/11/06
     */
    public function getinfo($code,$period){
        return  $this->db->query("select * from ClassType where code='$code' and period='$period'")->row();
    }
    /**
     *description:获取所有正常状态的班型
     *author:yanyalong
     *date:2014/11/06
     */
    public function getlist($institution){
        return  $this->db->query("select * from ClassType CT  left join institution_classType ic on ic.classTypeId=CT.id where ic.institutionId='$institution' and status=1 group by CT.code order by CT.id desc")->result();
    }

    /**
     *description:根据id获取一条信息
     *author:yanyalong
     *date:2014/11/05
     */
    public function get($id){
        return $this->db->get_where('ClassType',array('id' => $id))->row();
    }
	
    /**
 	* Description : 获取limit的classTypeID的列表
 	* Author      : jishuai
 	* Created Time: 2015-01-15 11:41
	*/
	public function getClassTypeList($institution,$grade='',$p,$row){
        $limit = '';
        if($p != '' && $row != ''){
            $limit = " limit ".($p-1)*$row.','.$row;
        }
        if($grade){
            $where_grade = " and CT.grade = $grade"; 
        }else{
            $where_grade = '';
        }

        return $this->db->query("
			select CT.id ctid from (
select DISTINCT(code) from institution_classType IC left join ClassType CT on IC.classTYpeId = CT.id 
where CT.status < 2 $where_grade and institutionId = $institution order by subject asc,grade asc $limit 
) SC left join ClassType CT on SC.code = CT.code left join institution_classType IC2 on CT.id = IC2.classTypeID
where IC2.institutionId = $institution ")->result();
	}

    /**
 	* Description : 根据list获取信息
 	* Author      : jishuai
 	* Created Time: 2015-01-15 13:49
	*/
	public function getInfoByList($institution,$str){
		if($str == '') return false;
		return $this->db->query("
			select SCT.*,SCN.*,G.name gname,S.name sname from(
select id,code,name,grade,subject,period,status from ClassType where id in $str
) SCT left join (
select ctid,sum(cur) currNum,sum(his) hisNum from (
select id cid,ClassTypeId ctid,endTime,
case when endTime > now() or endTime is null then 1 else 0 end as cur,
case when endTime < now() then 1 else 0 end as his
 from Class where  classTypeId in $str and institution = $institution and status < 2
)SCI group by ctid order by null
) SCN on SCT.id = SCN.ctid left join Grade G on SCT.grade = G.id left join Subject S on SCT.subject = S.id order by subject asc,grade asc
			")->result();
	}

    /**
 	* Description : 获取所有版型个数
 	* Author      : jishuai
 	* Created Time: 2015-01-15 13:56
	*/
	public function getNumOfCT($institution,$grade=''){
        if($grade){
            $where_grade = " and CT.grade = $grade"; 
        }else{
            $where_grade = '';
        }
        return $this->db->query("select count(*) count from (select CT.code from institution_classType ic 
            left join ClassType CT on CT.id=ic.classTypeId
            where ic.institutionId='$institution' $where_grade
            group by code) CT2")->row()->count;
	}

    /**
 	* Description : 获取所有班型列表及信息
 	* Author      : jishuai
 	* Created Time: 2015-02-10 14:27
	*/
    public function getAllInfo($institution,$grade='',$p,$row){
        $limit = '';
        if($p != '' && $row != ''){
            $limit = " limit ".($p-1)*$row.','.$row;
        }
        if($grade){
            $where_grade = " and CT.grade = $grade"; 
        }else{
            $where_grade = '';
        }

        $res = $this->db->query("
			select SC2.*,SC2.id ctid,sum(cur) as currNum,sum(his) as hisNum from ( 
select CT.id,CT.name,CT.code,CT.status,S.name as sname,G.name as gname,CT.period,C.institution,
case when C.id is not null and ( endTime > now() or endTime is null ) then 1 else 0 end as cur, 
case when C.id is not null and endTime is not null and endTime < now() then 1 else 0 end as his from ( 
select DISTINCT(code) Ccode from institution_classType IC left join ClassType CT on IC.classTYpeId = CT.id 
where CT.status < 2 $where_grade and institutionId = $institution order by subject asc,grade asc $limit ) SC left join ClassType CT on SC.Ccode = CT.code 
left join  Class C on CT.id = C.classTypeId left join Grade G on CT.grade = G.id left join Subject S on CT.subject = S.id 
where C.institution is null or C.institution = $institution
) SC2 group by id order by null
                    ")->result();
        if($res==false) return false;
        $data['list'] = $res;
        $data['count'] = $this->db->query("select count(*) count from (select CT.code from institution_classType ic 
            left join ClassType CT on CT.id=ic.classTypeId
            where ic.institutionId='$institution' $where_grade
            group by code) CT2")->row()->count;
        return $data;

    }
    public function getAllNum($institution,$grade =''){
        if($grade !=''){
            $where_grade = "where CT.grade = $grade"; 
        }else{
            $where_grade = '';
        }
        return $this->db->query("
            select count(*) as ctnum from(
                select code,count(*) as num from(
                    select DISTINCT(ClassTypeId) from Class where institution = $institution
                ) C left join ClassType CT on C.ClassTypeId = CT.id $where_grade group by code 
            ) sss
            ")->row();

    }
    //获取所有年级
    public function getAllGrade(){
        return $this->db->query(
            "select DISTINCT(grade),g.name from ClassType ct left join Grade g on ct.grade = g.id"
        )->result();
    }
    //
    //
    /**
     *description:根据年级id和学科id查询班型
     *author:yanyalong
     *date:2014/11/19
     */
    public function getClassTypeBySubectGrade($institution,$subjectId="",$gradeId=""){
        $where_subject = "";
        if($subjectId!="")
            $where_subject = " and CT.subject=$subjectId "; 
        $where_grade = "";
        if($gradeId!="")
            $where_grade = " and CT.grade=$gradeId"; 
		return $this->db->query("select * from ClassType CT left join institution_classType ic on ic.classTypeId=CT.id 
			where ic.institutionId='$institution' and CT.status = 1 $where_subject $where_grade group by CT.code")->result();
    }

    /**
 	* Description : 根据typeid列表获取自定义名称
 	* Author      : jishuai
 	* Created Time: 2015-02-10 14:39
	*/
	public function getCustomByList($List,$institution){
		return $this->db->query("select code,classTypeName from institution_classType IC left join ClassType CT on IC.classTypeId = CT.id where classTypeId in $List and institutionId = $institution")->result();
	}












}
