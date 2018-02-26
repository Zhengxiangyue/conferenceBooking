<?php
/**
 * Created by PhpStorm.
 * User: zhengxiangyue
 * Date: 14/2/2017
 * Time: 3:14 PM
 */

require_once "Base_model.php";

/**
 * Class Room_model
 * @property $room_model
 */
class Room_model extends Base_model
{

    /**
     * Room_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data_arr
     * @return array
     */
    public function create_conference_room($data_arr)
    {

        if (empty($data_arr)) return $this->model_err('请填写会议室的相关信息，然后再保存');
        $ret = $this->db->insert('conference_room', $data_arr);
        $insert_id = $this->db->insert_id();
        return $ret ? $this->model_success(array('cid' => $insert_id)) : $this->model_err('网络异常，请稍后再试');

    }

    /**
     * @param $limit
     * @param $page
     * @param $order
     * @param $open 0 不开放 1 开放 2 全部
     * @return array
     */
    public function get_rooms($limit = NULL, $page = NULL, $order = NULL, $open = '1')
    {
        $limit = $limit === NULL ? 10 : $limit;
        $page = $page === NULL ? 1 : $page;
        $order = $order === NULL ? 'addTime DESC' : $order;

        $where = $open === 0 ? "open = 0" : ($open === 1 ? "open = 1" : "");
        $query = $this->db->select()->where('status', 1)->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('conference_room');
        if (!empty($where)) $query->where($where);

        $result = $query->result_array();
        $index_array = array();
        foreach ($result as $index => $room) {

            $needList_string = implode(',',json_decode($result[$index]['needList']));

            $result[$index]['needList'] =  $needList_string ? $needList_string : "";

            $index_array[$room['cid']] = $result[$index];

            // 把会议室设施变成一个数组
//            $result[$index]['needList'] = unserialize($result[$index]['needList']);

        }
        return $this->model_success(array('room' => $result, 'index' => $index_array));


    }

    /**
     * 更新会议室详情
     * @param $cid 会议室id
     * @param $db_arr 更新数据
     */
    public function update_conference_room($cid, $db_arr)
    {
        if (empty($cid)) return $this->model_err('未选择会议室');

        $res = $this->db->update('conference_room', $db_arr, array('cid' => $cid));
        if ($res) return $this->model_success('会议室内容更新成功');
        return $this->model_err('会议室内容没有做出修改');

    }

    /**
     * 删除会议室
     * @param $cid
     */
    public function delete_room($cid)
    {

        if (empty($cid)) $this->model_err('没有选择要删除的会议室');

        $res = $this->db->update('conference_room', array('status' => 0), array('cid' => $cid));

        if ($res) return $this->model_success('会议室删除成功');
        return $this->model_err('网络异常请稍后再试');

    }

    /**
     * 查询指定时间段的可用会议室
     * @param $data_array array('useBeginTime','useEndTime','useDate','endDate','limit','page','order')
     */
    public function query_available_room($data_array)
    {

        if (empty($data_array['useDate']) OR empty($data_array['useEndTime']) OR empty($data_array['useBeginTime'])) return $this->model_err('请输入查询条件');

        // 查询出未beginDate这一天 与 useBeginTime 到 useEndTime 有冲突的预约
        $query = $this->db->select('cid,bid')
            ->where('useDate', $data_array['useDate'])
            ->where('useEndTime >', $data_array['useBeginTime'])
            ->where('useBeginTime < ', $data_array['useEndTime'])
            // 只有 通过审核或处于审核阶段 的预约才可能发生冲突
            ->where_in('status', array(1, 0))
            ->get('booking');


        // 将有冲突的会议室放在一个数组里面
        $unavailable_room_arr = $query->result_array();
        $unavailable_rooms = array();
        foreach ($unavailable_room_arr as $unavailable_room) {
            $unavailable_rooms[] = $unavailable_room['cid'];
        }

        // 查询条件
        $limit = isset($data_array['limit']) ? $data_array['limit'] : 6;
        $page = isset($data_array['page']) ? $data_array['page'] : 1;
        $order = isset($data_array['order']) ? $data_array['order'] : 'addTime DESC';

        // 查询出所有可用的会议室
        $room_query = $this->db->select()->where('status', 1);
        if (!empty($unavailable_rooms))
            $room_query->where_not_in('cid', $unavailable_rooms);
        // 计算总数目和页数
        $all_counts = $room_query->get_results_num('conference_room');
        $pages = ceil($all_counts / $limit);
        // 分页 查询
        $room_result = $room_query->limit($limit, ($page - 1) * $limit)->order_by($order)->get('conference_room')->result_array();

        // 生成索引对象
        $room_obj = array();
        foreach ($room_result as $index => $room) {
            $room_obj[$room['cid']] = $room;
        }
        $room_obj = (object)$room_obj;

        return $this->model_success(array('total' => $all_counts, 'room' => $room_result, 'index' => $room_obj, 'pages' => $pages));

    }

    public function get_room_detail_by_cid($cid)
    {

        if (empty($cid)) return $this->model_err('请输入会议室id');
        $result = $this->db->select()->where('cid', $cid)->get('conference_room')->row_array();
        if (empty($result)) return $this->model_err('不存在该会议室');
        return $this->model_success($result);
    }

}