<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Wxstatistics_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}

    /**
     *description:插入一条数据
     *author:yanyalong
     *date:2014/11/06
     */
    public function insert($data){
        $this->db->insert('Wxstatistics', $data);
        return $this->db->insert_id();
    }
    /**
     *description:获取微信版本号统计数据
     *author:yanyalong
     *date:2015/02/12
     */
    public function getStatistics($startTime,$endTime){
        return $this->db->query("select  count(id) count,version from Wxstatistics where unix_timestamp(date)>$startTime and unix_timestamp(date)<$endTime group by version order by version")->result();
    }
    /**
     *description:判断今日是否插入过相同数据
     *author:yanyalong
     *date:2015/02/12
     */
    public function getTodayData($version,$stuId){
        $todayTime = date('Y-m-d');
        return $this->db->query("select * from Wxstatistics where version='$version' and stuId =$stuId and date>'$todayTime'")->result();
    }
}
