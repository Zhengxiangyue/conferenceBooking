<?php
/**
 * Created by PhpStorm.
 * User: zhengxiangyue
 * Date: 14/2/2017
 * Time: 3:10 PM
 */
require_once "Base_model.php";

/**
 * Class Booking_model
 *
 * 预约两大类：待审核预约 和 历史预约
 * 待审核预约是booking.status为0 且 会议还没有结束的预约; 历史预约约包括已经过期的预约(booking.status为0，但会议时间已经过了) 和 booking.status为 1 2 3 的预约
 *
 *
 *
 */
class Booking_model extends Base_model
{

    /**
     * Booking_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $data_arr
     * @return array
     */
    public function book_room($data_arr){

        if (empty($data_arr)) return $this->model_err(lang('hint_booking_failed_one'));

        $res = $this->db->insert('booking', $data_arr);
        if ($res) {
            return $this->model_success($this->db->insert_id());
        }
        return $this->model_err(lang('hint_booking_failed_two'));
    }

    /**
     * 获取预约时间表 只查出 可能造成冲突的预约 status = 0 或 1
     * @param $start
     * @param $end
     */
    public function get_book_table($data_arr = null){

        $query = $this->db->select();

        if (isset($data_arr['cid'])) $query->where('cid', $data_arr['cid']);
        if (isset($data_arr['start'])) $query->where('useDate >= ', date('Y-m-d', strtotime($data_arr['start'])));
        if (isset($data_arr['last'])) $query->where('useDate < ', date('Y-m-d', strtotime($data_arr['start']) + $data_arr['last'] * 24 * 3600));

        $result = $query->where_in('status', array(0, 1))->get('booking')->result_array();

        return $this->model_success($result);
    }

    /**
     * 根据数据库查询结果制作前端表格
     * @param $data
     * @return array
     */
    public function create_table($data_arr = null){

        $data_arr['start'] = empty($data_arr['start']) ? date('Y-m-d') : date('Y-m-d', strtotime($data_arr['start']));

//        var_dump(date('Y-m-d',strtotime($data_arr['start']) + $data_arr['last'] * 24 * 3600));

        $result = $this->get_book_table($data_arr)['ret'];

        $week_table = array(
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 0,
                    'html' => '上午(8:00-12:00)',
                ),
                array( //
                    'type' => 0,
                    'html' => '下午(12:00-18:00)',
                ),
                array( //
                    'type' => 0,
                    'html' => '晚上(18:00-22:00)',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),
            array(
                array(
                    'type' => 0,
                    'html' => '日期',
                ),
                array( //
                    'type' => 0,
                    'html' => '星期',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
                array( //
                    'type' => 3,
                    'html' => '可预约',
                ),
            ),


        );

        // type 3 可预约 0 info 2 已经预约过了

        foreach ($week_table as $row => $rows) {
            foreach ($rows as $column => $item) {
                if ($row == 0 OR $column == 0 OR $column == 1) $week_table[$row][$column]['type'] = 0;
                if ($column == 0 AND $row != 0) $week_table[$row][$column]['html'] = date('Y-m-d', strtotime($data_arr['start']) + 3600 * 24 * ($row - 1));
                if ($column == 1 AND $row != 0) {
                    $week_day = date('w', strtotime($data_arr['start']) + 3600 * 24 * ($row - 1));
                    switch ($week_day) {
                        case 0 :
                            $week_str = '星期日';
                            break;
                        case 1 :
                            $week_str = '星期一';
                            break;
                        case 2 :
                            $week_str = '星期二';
                            break;
                        case 3 :
                            $week_str = '星期三';
                            break;
                        case 4 :
                            $week_str = '星期四';
                            break;
                        case 5 :
                            $week_str = '星期五';
                            break;
                        case 6 :
                            $week_str = '星期六';
                            break;
                        default :
                            $week_str = "";
                    }
                    $week_table[$row][$column]['html'] = $week_str;
                }
            }
        }

        // 计算每个预约在哪一个位置
        foreach ($result as $booking) {
            $index = $this->calculate_position($data_arr['start'], $booking['useDate'], $booking['useBeginTime'], $booking['useEndTime']);
            $week_table[$index[0]][$index[1]]['html'] = "<p>" . $booking['department'] . "</p>" . "<p>" . $booking['applicant'] . "</p><p>时间：" . $booking['useBeginTime'] . "-" . $booking['useEndTime'] . "</p>";
            $week_table[$index[0]][$index[1]]['type'] = 2;
        }


        return $this->model_success($week_table);
    }

    /**
     * 根据起始日期和时间
     * @param string $start
     * @param $data_arr
     */
    public function calculate_position($start = '1970-01-01', $use_date = '1970-01-01', $begin_time = '08:00', $end_time = '18:00'){
        //根据start和 use_date确定 纵坐标
        $diff = (strtotime($use_date) - strtotime($start)) / (3600 * 24);
        $row = 1 + $diff;
        //根据begin_time 和 end_time 技术算横坐标
        if ($begin_time < '12:00') {
            $column = 2;
        } else if ($begin_time < '18:00') {
            $column = 3;
        } else if ($begin_time < '22:00') {
            $column = 4;
        }

        return array($row, $column);

    }

    /**
     * 处理booking 和 conferenceRoom 的数据
     * @param $booking
     * @return mixed
     */
    private function handle_booking_detail($booking)
    {

        // 处理bookingStatus
        // 如果 等待审核 已经过了开会时间 status = 4
        if ((int)$booking['bookingStatus'] === 0 AND time() > strtotime($booking['useDate'] . " " . $booking['useEndTime'])) {
            $booking['bookingStatus'] = '4';
        }
        // 如果现在正在开会 status = 5
        if ((int)$booking['bookingStatus'] === 1 AND time() > strtotime($booking['useDate'] . " " . $booking['useBeginTime']) AND time() < strtotime($booking['useDate'] . " " . $booking['useEndTime'])) {
            $booking['bookingStatus'] = '5';
        }
        // 如果已经开完会了 status = 6
        if ((int)$booking['bookingStatus'] === 1 AND time() > strtotime($booking['useDate'] . " " . $booking['useEndTime'])) {
            $booking['bookingStatus'] = '6';
        }

        $booking['serialNumber'] = left_stuff($booking['bid'], 9, '0');

        // 开会时间开始友好显示
        $booking['meetingBeginTimeFriendly'] = date_friendly(strtotime($booking['useDate'] . " " . $booking['useBeginTime']));

        // 开会结束时间友好显示
        $booking['meetingEndTimeFriendly'] = date_friendly(strtotime($booking['useDate'] . " " . $booking['useEndTime']));


        $booking['simpleBookingDate'] = date('m-d', strtotime($booking['bookingTime']));
        $booking['bookingTimeFriendly'] = date_friendly(strtotime($booking['bookingTime']));

        $booking['lastEditTimeFriendly'] = date_friendly(strtotime($booking['lastEditTime']));

        // 会议开始 Y-M-D H:M:I
        $booking['meetStartTime'] = $booking['useDate'] . " " . $booking['useBeginTime'];
        $booking['meetEndTime'] = $booking['useDate'] . " " . $booking['useEndTime'];


        //审核（通过或拒绝）时间
        $booking['checkTimeFriendly'] = date_friendly(strtotime($booking['checkTime']));
        $booking['useDateFriendly'] = date_friendly(strtotime($booking['useDate']));

        // bookingTime 到现在的秒数
        $last_secont = time() - strtotime($booking['bookingTime']);
        // bookingTime 到现在的时间
        $booking['bookingLastHour'] = floor($last_secont / 3600);
        $booking['bookingLastMinute'] = floor(($last_secont - $booking['bookingLastHour'] * 3600) / 60);
        $booking['bookingLastSecond'] = $last_secont - $booking['bookingLastHour'] * 3600 - $booking['bookingLastMinute'] * 60;

        // 成功预约的在左边显示
        if (in_array($booking['bookingStatus'], array(1, 6))) {
            $booking['badge'] = 'success';
            $booking['inverted'] = false;
        } else {
            $booking['badge'] = 'warning';
            $booking['inverted'] = true;
        }

        // 去除多与数据
        unset($booking['status']);

        return $booking;
    }

    /**
     * 获取预约列表，用户 + admin
     * @param null $uid
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_book_list($uid = null, $page = 1, $order = 'bookingTime DESC,useDate DESC', $limit = 100)
    {

        $page = empty($page) ? 1 : $page;
        $limit = empty($limit) ? 100 : $limit;
        $order = empty($order) ? 'bookingTime DESC,useDate DESC' : $order;

        $query = $this->db->select("*,conference_room.status AS conferenceRoomStatus,booking.status AS bookingStatus");

        if($uid) $query->where('uid',$uid);

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $each)
        {
            $result[$index] = $this->handle_booking_detail($each);
        }

        return $this->model_success(
            array(
                'bookingList' => $result,
                'total' => $row_num,
            )
        );


    }

    /**
     * 获取待审核的预约列表,用户 + admin 待审核预约 比较少，不分页了
     * @param $uid 若uid为null 则获取全部用户的列表 否则获取uid的列表
     * @return array
     */
    public function get_unchecked_list($uid = null)
    {

        $now = time();
        $query = $this->db->select("*,booking.status AS bookingStatus, conference_room.status AS conferenceRoomStatus");

        // 有 uid 的话则获取单个用户的待预约列表，没有的话获取全部的待预约列表

        if($uid) $query->where('uid',$uid);

        // status 为 0 并且 ( useDate > 今天 或 ( useDate = 今天 并且 useEndTime > 现在 ) )

        $query->where('booking.status',0)
            ->group_start()
                ->where('useDate >',date('Y-m-d',$now))
                ->or_group_start()
                    ->where('useDate',date('Y-m-d',$now))
                    ->where('useEndTime >',date('H:i',$now))
                ->group_end()
            ->group_end()
        ;

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->get('booking')->result_array();

        foreach ($result as $index => $each) {
            $result[$index] = $this->handle_booking_detail($each);
        }

        return $this->model_success(array('uncheckedList'=>$result,'total'=>$row_num));

    }

    /**
     * 获取历史预约,用户 + admin 历史预约
     * @param $uid
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_history_book_list($uid = null, $page = 1, $order = 'bookingTime DESC', $limit = 20)
    {

        $page = empty($page) ? 1 : $page;
        $order = empty($order) ? 'bookingTime DESC' : $order;
        $limit = empty($limit) ? 20 : $limit;

        $now = time();

        $query = $this->db->select("*,booking.status AS bookingStatus,conference_room.status AS conferenceRoomStatus");

        // 如果没有uid就是admin 查询所有用户的

        if($uid) $query->where('uid',$uid);

        // 历史预约是 还没有审核的预约 status 为 1 或 2 或 3 或
        // status 不为0 或 ( status 为 0 并且 (  useDate < now 或 ( useDate = now 且 useEndTime <= now )  ))

        $query->where('booking.status !=',0)
            ->or_group_start()
                ->where('booking.status',0)
                ->group_start()
                    ->where('useDate <',date('Y-m-d',$now))
                    ->or_group_start()
                        ->where('useDate',date('Y-m-d',$now))
                        ->where('useEndTime <=',date('H:i',$now))
                    ->group_end()
                ->group_end()
            ->group_end()
        ;

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();


        foreach ($result as $index => $item) {
            $result[$index] = $this->handle_booking_detail($item);
        }
        return $this->model_success(array('historyList' => $result, 'total' => $row_num));
    }


    /**
     * 获取用户全部预约列表,用户全部预约
     * @param $uid
     * @param int $page
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function get_user_book_list($uid, $page = 1, $order = 'bookingTime DESC,useDate DESC', $limit = 100)
    {

        if (empty($uid)) return $this->model_err('未指定用户');

        $page = empty($page) ? 1 : $page;
        $limit = empty($limit) ? 100 : $limit;
        $order = empty($order) ? 'bookingTime DESC,useDate DESC' : $order;

        $query = $this->db->select("*,conference_room.status AS conferenceRoomStatus,booking.status AS bookingStatus")->where('uid', $uid);
        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $each)
        {
            $result[$index] = $this->handle_booking_detail($each);
        }

        if (empty($result)) return $this->model_err(lang('hint_no_booking_record'));

        return $this->model_success(
            array(
                'bookingList' => $result,
                'total' => $row_num,
            )
        );


    }

    /**
     * 获取管理员全部预约列表,admin全部预约
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function get_admin_book_list($page = 1, $order = 'bookingTime DESC', $limit = 100)
    {
        $page = empty($page) ? 1 : $page;
        $limit = empty($limit) ? 100 : $limit;
        $order = empty($order) ? 'bookingTime DESC' : $order;

        $query = $this->db->
        select("*,
        booking.status AS bookingStatus, 
        conference_room.status AS conferenceRoomStatus");
        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();
        if (empty($result)) return $this->model_err('没有预约记录');

        $index_obj = array();

        foreach ($result as $index => $each) {

            $result[$index] = $this->handle_booking_detail($each);

            $index_obj[$each['bid']] = $each;
        }

        // 查询等待审核的预约
        $unchecked_array = $this->get_unchecked_list();

        return $this->model_success(
            array(
                'bookListTotal' => $row_num,
                'bookList' => $result,
                'uncheckedList' => $unchecked_array['ret'],
                'index' => (object)$index_obj)
        );

    }



    /**
     * 获取uid的最新的预约，用户待审核预约
     * @param $uid
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_newest_book_list($uid, $page = 1, $order = 'bookingTime DESC', $limit = 20){
        if (empty($uid)) return $this->model_err('错误的用户组');

        $page = empty($page) ? 1 : $page;
        $order = empty($order) ? 'bookingTime DESC' : $order;
        $limit = empty($limit) ? 20 : $limit;

        // 待审核的预约是 : bookingStatus为 0 并且 会议结束时间还没到
        // 会议结束时间还没到 :
        // useDate 在 今天之后 或
        // useDate 是今天 并且 useEndTime > now

        $now = time();

        $query = $this->db
            ->select("*,booking.status AS bookingStatus, conference_room.status AS conferenceRoomStatus")
            ->where('uid',$uid)
            ->where('booking.status',0)
            ->group_start()
                ->where('useDate >',date('Y-m-d',$now))
                ->or_group_start()
                    ->where('useDate',date('Y-m-d',$now))
                    ->where('useEndTime >',date('H:i',$now))
                ->group_end()
            ->group_end()
        ;

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $item) {
            $result[$index] = $this->handle_booking_detail($item);
        }
        return $this->model_success(array('newestList' => $result, 'total' => $row_num));
    }



    /**
     * 获取用户将来的会议, 用户将来的会议
     * @param $uid
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_user_futrue_meeting($uid, $page = 1, $order = 'bookingTime DESC', $limit = 20){
        if (empty($uid)) return $this->model_err('错误的用户组');

        $page = empty($page) ? 1 : $page;
        $order = empty($order) ? 'bookingTime DESC' : $order;
        $limit = empty($limit) ? 20 : $limit;

        $query = $this->db->select("*,booking.status AS bookingStatus,conference_room.status AS conferenceRoomStatus")
            ->where('uid', $uid)
            ->where('booking.status', 1)
            ->group_start()
                ->where('booking.useDate >', date('Y-m-d'))
                ->or_group_start()
                    ->where('booking.useDate', date('Y-m-d'))
                    ->where('booking.useEndTime >', date('H:i'))
                ->group_end()
            ->group_end();

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $item) {
            $result[$index] = $this->handle_booking_detail($item);
        }

        return $this->model_success(array('myMeeting' => $result, 'meeingNum' => $row_num));
    }

    /**
     * 获取用户的会议历史 ,用户会议历史
     * @param $uid
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_user_meeting_history($uid, $page = 1, $order = 'bookingTime DESC', $limit = 20){
        if (empty($uid)) return $this->model_err('错误的用户组');

        $page = empty($page) ? 1 : $page;
        $order = empty($order) ? 'bookingTime DESC' : $order;
        $limit = empty($limit) ? 20 : $limit;

        $query = $this->db->
        select("*,
        booking.status AS bookingStatus, 
        conference_room.status AS conferenceRoomStatus")
            ->where('uid', $uid)
            ->where('booking.status', 1);

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $item) {
            $result[$index] = $this->handle_booking_detail($item);
        }

        return $this->model_success(array('historyMeeting' => $result, 'meeingNum' => $row_num));


    }

    /**
     * 获取全部将要进行的会议, admin将来会议
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_admin_future_meeting($page = 1, $order = 'bookingTime DESC', $limit = 20){

        $page = empty($page) ? 1 : $page;
        $order = empty($order) ? 'bookingTime DESC' : $order;
        $limit = empty($limit) ? 20 : $limit;

        $query = $this->db->
        select("*,
        booking.status AS bookingStatus, 
        conference_room.status AS conferenceRoomStatus")
            ->where('booking.status', 1)
            ->group_start()
            ->where('booking.useDate >', date('Y-m-d'))
            ->or_group_start()
            ->where('booking.useDate', date('Y-m-d'))
            ->where('booking.useEndTime >', date('H:i'))
            ->group_end()
            ->group_end();

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $item) {
            $result[$index] = $this->handle_booking_detail($item);
        }

        return $this->model_success(array('myMeeting' => $result, 'meeingNum' => $row_num));
    }

    /**
     * 获取全部会议历史 admin 历史会议
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_admin_history_meeting($page = 1, $order = 'bookingTime DESC', $limit = 20){

        $page = empty($page) ? 1 : $page;
        $order = empty($order) ? 'bookingTime DESC' : $order;
        $limit = empty($limit) ? 20 : $limit;

        $query = $this->db->
        select("*,
        booking.status AS bookingStatus, 
        conference_room.status AS conferenceRoomStatus")
            ->where('booking.status', 1);

        $query->join('conference_room', 'conference_room.cid = booking.cid');

        $row_num = $query->get_results_num('booking');

        $result = $query->limit($limit)->offset(($page - 1) * $limit)->order_by($order)->get('booking')->result_array();

        foreach ($result as $index => $item) {
            $result[$index] = $this->handle_booking_detail($item);
        }

        return $this->model_success(array('historyMeeting' => $result, 'meeingNum' => $row_num));
    }

    /**
     * 获取一个预约的详情
     * @param $bid
     * @return array
     */
    public function get_one_book($bid)
    {
        $result = $this->db->select("*,
        booking.status AS bookingStatus, 
        conference_room.status AS conferenceRoomStatus")
            ->where('booking.bid', $bid)->join('conference_room', 'conference_room.cid = booking.cid')->get('booking')->row_array();
        if (!empty($result)) {
            $result = $this->handle_booking_detail($result);
            return $this->model_success($result);
        }
        return $this->model_err('订单不存在');
    }

    /**
     * 通过审核
     * @param $cid
     */
    public function pass_booking($admin_id = 0, $bid){
        // 获取此订单的状态
        $bookingStatus = $this->db->select('status,checkTime')->where('bid', $bid)->get('booking')->row_array();
        if ($bookingStatus['status'] === null) return $this->model_err('预定异常');
        if ((int)$bookingStatus['status'] === 1) return $this->model_err('该订单已经于' . date_friendly(strtotime($bookingStatus['checkTime'])) . '通过了审核');
        if ((int)$bookingStatus['status'] === 2) return $this->model_err('该订单已经于' . date_friendly(strtotime($bookingStatus['checkTime'])) . '被驳回了');
        if ((int)$bookingStatus['status'] === 3) return $this->model_err('该订单已经于' . date_friendly(strtotime($bookingStatus['lastEditTime'])) . '被申请人取消了');
        if ((int)$bookingStatus['status'] === 4) return $this->model_err('该订单已经过期了');

        if ((int)$bookingStatus['status'] === 0) {
            // 订单正在等待审核
            $ret = $this->db->update('booking', array('status' => 1, 'checkTime' => date('Y-m-d H:i:s'), 'checkUid' => $admin_id), array('bid' => $bid));
            if ($ret) return $this->model_success('预约申请成功');
        }
        return $this->model_err('订单异常');

    }

    /**
     * 取消预约
     * @param $uid
     * @param $bid
     * @return array
     */
    public function cancel_booking($uid, $bid){
        // 获取订单状态
        $status = $this->db->select('status,bid')->where('bid', $bid)->where('uid', $uid)->get('booking')->row_array();
        if (empty($status)) return $this->model_err('您无权操作此订单');
        if ((int)$status['status'] === 2) return $this->model_err('该预约已经被拒绝,不用取消了');
        if ((int)$status['status'] === 3) return $this->model_err('该订单已经处于取消状态');
        if ((int)$status['status'] === 4) return $this->model_err('改预约已经过期');

        $ret = $this->db->update('booking', array('status' => 3, 'lastEditTime' => date('Y-m-d H:i:s')), array('bid' => $bid));
        if ($ret) return $this->model_success('预约取消申请成功');

        // 更新订单的状态

    }

    /**
     * 拒绝预约
     * @param $uid
     * @param $bid
     */
    public function refuse_booking($uid, $bid){

        // 获取此订单的状态
        $bookingStatus = $this->db->select('status,checkTime')->where('bid', $bid)->get('booking')->row_array();
        if ($bookingStatus['status'] === null) return $this->model_err('预定异常');
        if ((int)$bookingStatus['status'] === 1) return $this->model_err('该订单已经于' . date_friendly(strtotime($bookingStatus['checkTime'])) . '通过了审核');
        if ((int)$bookingStatus['status'] === 2) return $this->model_err('该订单已经于' . date_friendly(strtotime($bookingStatus['checkTime'])) . '被驳回了');
        if ((int)$bookingStatus['status'] === 3) return $this->model_err('该订单已经于' . date_friendly(strtotime($bookingStatus['lastEditTime'])) . '被申请人取消了');
        if ((int)$bookingStatus['status'] === 4) return $this->model_err('该订单已经过期了');

        if ((int)$bookingStatus['status'] === 0) {
            // 订单正在等待审核
            $ret = $this->db->update('booking', array('status' => 2, 'checkTime' => date('Y-m-d H:i:s'), 'checkUid' => $uid), array('bid' => $bid));
            if ($ret) return $this->model_success('预约拒绝成功');
        }
        return $this->model_err('订单异常');

    }

    /**
     * 获取fullcalendar的数据
     * @param $cid
     * @param $start
     * @param $end
     * @return array
     */
    public function get_meetings_for_calendar($cid, $start, $end)
    {
        if(!strtotime($start) OR !strtotime($end))
        {
            return $this->model_err(lang('hint_please_input_valid_time'));
        }

        $query = $this->db->select("*,booking.status AS bookingStatus,conference_room.status AS conferenceRoomStatus");

        if($cid) $query->where('booking.cid',$cid);

        $result = $query
            ->where('booking.useDate >=',date('Y-m-d',strtotime($start)))
            ->where('booking.useDate <=',date('Y-m-d',strtotime($end)))
            ->where('booking.status',1)
            ->join('conference_room', 'conference_room.cid = booking.cid')
            ->get('booking')->result_array();

        foreach ($result as $index=>$meeting)
        {
            $result[$index] = $this->handle_booking_detail_for_calendar($meeting);
        }

        return $this->model_success($result);

    }

    private function handle_booking_detail_for_calendar($booking)
    {
        // 处理bookingStatus

        // 如果现在正在开会 status = 5
        if ((int)$booking['bookingStatus'] === 1 AND time() > strtotime($booking['useDate'] . " " . $booking['useBeginTime']) AND time() < strtotime($booking['useDate'] . " " . $booking['useEndTime'])) {
            $booking['bookingStatus'] = '5';
        }
        // 如果已经开完会了 status = 6
        if ((int)$booking['bookingStatus'] === 1 AND time() > strtotime($booking['useDate'] . " " . $booking['useEndTime'])) {
            $booking['bookingStatus'] = '6';
        }

        $booking['serialNumber'] = left_stuff($booking['bid'], 9, '0');

        // 开会时间开始友好显示
        $booking['meetingBeginTimeFriendly'] = date_friendly(strtotime($booking['useDate'] . " " . $booking['useBeginTime']));

        // 开会结束时间友好显示
        $booking['meetingEndTimeFriendly'] = date_friendly(strtotime($booking['useDate'] . " " . $booking['useEndTime']));


        $booking['simpleBookingDate'] = date('m-d', strtotime($booking['bookingTime']));
        $booking['bookingTimeFriendly'] = date_friendly(strtotime($booking['bookingTime']));

        $booking['lastEditTimeFriendly'] = date_friendly(strtotime($booking['lastEditTime']));

        // 会议开始 Y-M-D H:M:I
        $booking['meetStartTime'] = $booking['useDate'] . " " . $booking['useBeginTime'];
        $booking['meetEndTime'] = $booking['useDate'] . " " . $booking['useEndTime'];


        //审核（通过或拒绝）时间
        $booking['checkTimeFriendly'] = date_friendly(strtotime($booking['checkTime']));
        $booking['useDateFriendly'] = date_friendly(strtotime($booking['useDate']));

        // bookingTime 到现在的秒数
        $last_secont = time() - strtotime($booking['bookingTime']);
        // bookingTime 到现在的时间
        $booking['bookingLastHour'] = floor($last_secont / 3600);
        $booking['bookingLastMinute'] = floor(($last_secont - $booking['bookingLastHour'] * 3600) / 60);
        $booking['bookingLastSecond'] = $last_secont - $booking['bookingLastHour'] * 3600 - $booking['bookingLastMinute'] * 60;

        // 成功预约的在左边显示
        if (in_array($booking['bookingStatus'], array(1, 6))) {
            $booking['badge'] = 'success';
            $booking['inverted'] = false;
        } else {
            $booking['badge'] = 'warning';
            $booking['inverted'] = true;
        }

        // 去除多与数据
        unset($booking['status']);

        return $booking;
    }

}