<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Generator By "Auto Codeigniter" At 2014/10/30 17:40:48 
 *Author:高思小数
 */
class Institution_classType_model extends CI_Model{

    public function __construct(){
		parent::__construct();
	}
    /**
     *description:根据班型id和机构id获取班型信息
     *author:yanyalong
     *date:2014/11/14
     */
    public function getInfoByCTIns($institutionId,$classTypeId){
       return  $this->db->query("select * from institution_classType ic  left join  ClassType CT on  ic.classTypeId=CT.id where ic.institutionId='$institutionId' and CT.id=$classTypeId")->row();
    }
    /**
     *description:根据班型code获取学期列表
     *author:yanyalong
     *date:2014/12/02
     */
    public function getPeriodByCTCode($institutionId,$classTypeCode){
       return  $this->db->query("select CT.* from institution_classType ic  left join  ClassType CT on  ic.classTypeId=CT.id where ic.institutionId='$institutionId' and CT.code='$classTypeCode' group by CT.period")->result();
    }

    /**
 	* Description : 根据编码来设置自定义名称
 	* Author      : jishuai
 	* Created Time: 2015-02-10 14:04
	*/
	public function setNameByCode($classTypeName,$typeCode,$institution){
		$ids = $this->db->query("select id from institution_classType where classTypeId in ( select id from ClassType where code = '$typeCode') and institutionId = $institution")->result();
		if(!$ids) return false;
		foreach($ids as $v){
			$idArr[] = $v->id;
		}
		$idStr = implode(',',$idArr);
		$res = $this->db->query("update institution_classType set classTypeName = '$classTypeName' where id in ($idStr)");
		return $res;
	}
	














}
