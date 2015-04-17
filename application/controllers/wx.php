<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: text/html; charset=utf-8");
class Wx extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('wxstatistics_model');
    }
    /**
     *description:统计微信版本号接口(临时)
     *author:yanyalong
     *date:2015/02/12
     */
    public function index(){
        $startTime = (isset($_REQUEST['startTime']) and $_REQUEST['startTime'] != '')?$_REQUEST['startTime']:'';
        $endTime = (isset($_REQUEST['endTime']) and $_REQUEST['endTime'] != '')?$_REQUEST['endTime']:'';
        if($startTime!=""&&$endTime!=""){
            $startTime = strtotime(date('Y-m-d',strtotime($startTime)));
            $endTime = strtotime(date('Y-m-d',strtotime($endTime)))+3600*24;
        }else{
            $startTime = strtotime(date('Y-m-d'))-3600*24*9;
            $endTime = strtotime(date('Y-m-d'))+3600*24;
        }
        $res = $this->wxstatistics_model->getStatistics($startTime,$endTime);
        if($res!=false) {
            echo "统计数据为：".date('Y-m-d',$startTime)."到".(date('Y-m-d',$endTime-24*3600))."微信交作业微信版本号信息<br><br>";
                echo "<table border=1>";
                echo "<tr style='height:40px;'><th width=300>版本号</th><th  width=100>统计次数</th></tr>";
            foreach ($res as $key => $val) {
                echo "<tr style='height:40px;'><td>$val->version</td><td style='text-align:center'>$val->count</td></tr>";
            }
                echo "</table><br><br>";
            echo "注:默认查询十天内统计数据，在地址后面添加   <font size=6>?startTime=2015-1-1&endTime=2015-4-1</font>   即可进行指定日期查询";
        }
    }
    /**
     *description:导出微信版本号统计基本信息excel
     *author:yanyalong
     *date:2015/02/12
     */
    public function statistics(){
        $version = (isset($_REQUEST['version']) and $_REQUEST['version'] != '')?$_REQUEST['version']:'';
        $stuId = (isset($_REQUEST['stuId']) and $_REQUEST['stuId'] != '')?$_REQUEST['stuId']:'';
        if($version!=""&&$stuId!=""){
            //判断今日是否进行过统计插入
            $res = $this->wxstatistics_model->getTodayData($version,$stuId);
            if($res==false){
                $data = array(
                    'version' => $version,
                    'stuId' => $stuId,
                    'date' => date('Y-m-d H:i:s')
                );
                $this->wxstatistics_model->insert($data);
            }
        }
    }
}

