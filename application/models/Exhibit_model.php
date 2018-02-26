<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 27/2/2017
 * Time: 7:05 PM
 */

require_once "Base_model.php";

/**
 * Class Exhibit_model
 */
class Exhibit_model extends Base_model
{
    public function get_room_detail($cid){

        if(empty($cid)) return $this->model_err('请输入会议室id');

        $now = time();

        $result_data = array();

        $data = array(
            'roomName'=>'',
            'status'=>0,
            'meetingName'=>'',
            'useBeginTime'=>'',
            'useEndTime'=>'',
            'department'=>'',
            'number'=>'',
        );

        // 获取当前所有会议室
        $rooms = $this->db->select('cid,name')->where('status',1)->get('conference_room')->result_array();

        $room_id_arr = array();

        // 初始化每个会议室的状态
        foreach ($rooms as $index=>$room){
            $result_data[$room['cid']] = $data;
            $result_data[$room['cid']]['roomName'] = $room['name'];
            $room_id_arr[] = $room['cid'];
        }



        $sql = "
        SELECT cid,meetingName,department,applicant,number,applicantMobile,introduction,useBeginTime,useEndTime FROM mrbs_booking t
        INNER JOIN (
                SELECT 
                    cid as newcid ,MIN(useBeginTime) as maxusebegintime 
                FROM 
                    `mrbs_booking` 
                WHERE 
                    useDate = '".date('Y-m-d')."'
                    AND status = 1
                    AND (
		                (useBeginTime >= '".date('H:i',$now)."' AND useBeginTime <= '23:59') 
		                OR 
		                (useBeginTime <= '".date('H:i',$now)."' AND useEndTime >= '".date('H:i',$now)."')
	                )
                GROUP BY newcid
            ) AS newtable
        ON newcid = t.cid AND newtable.maxusebegintime = t.useBeginTime
        WHERE t.useDate = '".date('Y-m-d')."' AND t.status = 1";

        $result = $this->db->query($sql)->result_array();

//        return $this->model_success($result);


        foreach ($result as $index=>$meeting){

            if(!in_array($meeting['cid'],$room_id_arr))
            {
                continue;
            }

            $result_data[$meeting['cid']]['meetingName'] = $meeting['meetingName'];
            $result_data[$meeting['cid']]['useBeginTime'] = $meeting['useBeginTime'];
            $result_data[$meeting['cid']]['useEndTime'] = $meeting['useEndTime'];
            $result_data[$meeting['cid']]['department'] = $meeting['department'];
            $result_data[$meeting['cid']]['number'] = $meeting['number'];
            $result_data[$meeting['cid']]['applicant'] = $meeting['applicant'];
            $result_data[$meeting['cid']]['mobile'] = $meeting['applicantMobile'];

            if($meeting['useBeginTime'] <= date('H:i',$now)){
                // 会议正在进行
                $result_data[$meeting['cid']]['status'] = 1;
            }else{
                // 会议将在一个小时之内进行
                $result_data[$meeting['cid']]['status'] = 2;
            }

        }



        return $this->model_success(array('allRooms'=>$result_data,'currentRoom'=>$result_data[$cid]));

    }
}
