<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Lesson_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}

    /**
     *description:查询课程信息
     *author:yanyalong
     *date:2014/11/08
     */
    public function getSubject($lessonId){
        return $this->db->query("select * from Lesson L left join ClassType CT on CT.id=L.classTypeId where L.id='$lessonId'")->row();
    }
}
