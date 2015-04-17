<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Schedule_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
    /**
     *description:插入一条数据
     *author:yanyalong
     *date:2014/11/08
     */
    public function insert($data){
        $this->db->insert('Schedule', $data);
        return $this->db->insert_id();
    }
    /**
     *description:查询班级某结课排课信息
     *author:yanyalong
     *date:2014/11/08
     */
    public function getInfoByClassId($classId,$lessonId){
        return $this->db->query("select * from Schedule where classId='$classId' and LessonId = '$lessonId'")->row();
    }
    /**
     *description:查询科目信息
     *author:yanyalong
     *date:2014/11/08
     */
    public function getSubject($scheduleId){
        return $this->db->query("select * from Schedule S left join Lesson L on L.id=S.LessonId left join ClassType CT on CT.id=L.classTypeId where S.id='$scheduleId'")->row();
    }
    /**
     *description:根据主键查询一条数据
     *author:yanyalong
     *date:2014/11/08
     */
    public function get($id){
        return $this->db->get_where('Schedule',array('id' => $id))->row();
    }
    /**
     *description:根据老师id和班级id获取相关未进行课程
     *author:yanyalong
     *date:2014/11/15
     */
    public function getListByClassTeacher($classId,$teacherId){
        return $this->db->query("select * from Schedule S where S.teacher='$teacherId' and classId='$classId' and unix_timestamp(beginTime)>unix_timestamp()")->result();
    }
    /**
     *description:更新指定班级下未开始课程的原讲课老师为新老师
     *author:yanyalong
     *date:2014/11/17
     */
    public function updateOldTeaToNew($classId,$teacherIdOld,$teacherIdNew){
        return $this->db->query("update Schedule set teacher='$teacherIdNew' where classId='$classId' and teacher='$teacherIdOld' and unix_timestamp(beginTime)>unix_timestamp()");
    }
}
