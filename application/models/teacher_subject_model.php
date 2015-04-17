<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Teacher_subject_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
	//excel 上传的插入
	public function uploadInsert($arr){
		$num = 0;
		foreach($arr as $v){
			if($this->db->insert('teacher_subject',$v)){
				$num = $num + 1;
			}
		}
		return $num;
	}
	//插入信息
	public function tsinsert($teacher,$subject){
		if(! $this->db->query("select * from teacher_subject where teacherId = $teacher and subjectId = $subject")->result()){
			return $this->db->query("insert into teacher_subject (teacherId,subjectId) values ($teacher,$subject)");
		}
	}
	//通过老师ID获取学科ID
	public function getByTeacherId($id){
		return $this->db->query("select subjectId from teacher_subject where teacherId = '$id'")->result();
	}
	
    /**
     *description:插入一条数据
     *author:yanyalong
     *date:2014/11/06
     */
    public function insert($data){
        $this->db->insert('teacher_subject', $data);
        return $this->db->insert_id();
    }
    /**
     *description:删除指定老师学科信息
     *author:yanyalong
     *date:2014/11/25
     */
    public function delSubjectByTeacher($teacherId){
		return $this->db->query("delete from teacher_subject where teacherId='$teacherId'");
    }
}
