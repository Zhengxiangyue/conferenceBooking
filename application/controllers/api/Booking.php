<?php
/**
 * Created by PhpStorm.
 * User: zhengxiangyue
 * Date: 14/2/2017
 * Time: 3:07 PM
 */

class Booking extends Base{

    /**
     * Booking constructor.
     */
    public function __construct(){

        parent::__construct();
        $this->load->model('booking_model');

    }


    /**
     * @param string $action
     */
    public function add($action = ''){
        switch ($action){
            default : $this->book_room();
        }
    }

    /**
     * @param string $action
     */
    public function query($action = ''){
        switch ($action){
            case "table" : $this->get_book_table();
                break;
            case "user" : $this->get_user_book_list();
                break;
            case "user_unchecked" : $this->get_user_unchecked();
                break;
            case "user_checked" : $this->get_user_checked();
                break;
            case "admin" :$this->get_admin_book_list();
                break;
            case "admin_unchecked" : $this->get_admin_unchecked();
                break;
            case "admin_checked" : $this->get_admin_checked();
                break;
            case "user_future_meeting" : $this->get_user_future_meeting();
                break;
            case "user_meeting" : $this->get_user_meeting();
                break;
            case "admin_future_meeting" : $this->get_admin_future_meeting();
                break;
            case "admin_meeting" : $this->get_admin_meeting();
                break;
            case "one" : $this->get_one_book_detail();
                break;
            default : $this->show_custom_404();
        }
    }

    /**
     * 获取一个预约详情 /?/api/booking/query/one/
     *
     */
    private function get_one_book_detail()
    {
        $this->check_user();
        $data_array = $this->filter_post_data(array('bid'),true);
        $ret = $this->booking_model->get_one_book($data_array['bid']);
        $ret['success'] ? $this->request_success($ret['ret']) : $this->request_err(null,$ret['ret']);
    }

    /**
     * 预约新的会议室 /?/api/booking/add/
     *
     */
    private function book_room()
    {
        $this->check_user();

        if(empty($_POST['cid'])) $this->request_err(null,'未指定要预约的会议室');

        $white_list = array(
            'cid',
            'useDate',
            'department',
            'applicant',
            'useBeginTime',
            'useEndTime',
            'number',
            'introduction',
            'applicantMobile',
            'meetingName',
            'need',
            'specialNeed',
        );

        $db_array = array(
            'bookingTime' => date('Y-m-d H:i:s'),
            'lastEditTime' => date('Y-m-d H:i:s'),
            'weekDay' => date('w',strtotime($this->input->post('useDate'))),
        );
        // 0：星期日 1：星期一 2：星期二 ...

        foreach ($white_list as $item){
            if(isset($_POST[$item])) $db_array[$item] = $_POST[$item];
        }

        $db_array['uid'] = $this->user_id;

        $ret = $this->booking_model->book_room($db_array);

        if($ret['success']) $this->request_success($ret['ret'],'预约成功');
        $this->request_err(null,$ret['ret']);
    }

    /**
     * /?/api/book/query/table 获取预约时间表
     *
     */
    private function get_book_table()
    {

        $white_list = array(
            'cid',
            'start',
            'last',
            'limit',
            'page',
            'order'
        );

        $data_array = $this->filter_post_data($white_list);

        $ret = $this->booking_model->create_table($data_array);

        // 将data_array变成 5 x 8 的二维数组 [0][0] [0][1] [0][2]
        // 1:不能预约 2:可以预约 3:空闲


        if($ret['success']) $this->request_success($ret['ret'],'获取列表成功');
        $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取一个用户的全部预定 /?/api/booking/query/user/
     *
     */
    private function get_user_book_list()
    {
        $this->check_user();

        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_book_list($this->user_id,$data_arr['page'],$data_arr['order'],$data_arr['limit']);

        $ret['success'] ? $this->request_success($ret['ret'],'获取预约列表成功') : $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取一个用户待审核的预定 /?/api/booking/query/user_unchecked/
     *
     */
    private function get_user_unchecked()
    {
        $this->check_user();
        $white_list = array(
            'page',
            'order',
            'limit',
        );
        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_unchecked_list($this->user_id);

        $ret['success'] ? $this->request_success($ret['ret'],'获取预约列表成功') : $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取一个用户历史预约列表 /?/api/booking/query/user_checked/
     *
     */
    private function get_user_checked()
    {
        $this->check_user();
        $white_list = array(
            'page',
            'order',
            'limit',
        );
        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_history_book_list($this->user_id,$data_arr['page'],$data_arr['order'],$data_arr['limit']);

        $ret['success'] ? $this->request_success($ret['ret'],'获取预约列表成功') : $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取admin全部预约列表
     * /?/api/booking/query/admin
     *
     */
    private function get_admin_book_list()
    {
        $this->check_user();

        if($this->user_info['type'] != 1)
        {
            $this->request_err(null,'用户无权访问');
        }

        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_book_list(null,$data_arr['page'],$data_arr['order'],$data_arr['limit']);

        $ret['success'] ? $this->request_success($ret['ret'],'获取预约列表成功') : $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取admin待审核列表
     * /?/api/booking/query/admin_unchecked
     *
     */
    private function get_admin_unchecked()
    {
        $this->check_user();

        if($this->user_info['type'] != 1)
        {
            $this->request_err(null,'用户无权访问');
        }

        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_unchecked_list(null);

        $ret['success'] ? $this->request_success($ret['ret'],'获取admin预约列表成功') : $this->request_err(null,$ret['ret']);
    }

    /**
     * 获取admin历史预约
     *
     */
    private function get_admin_checked()
    {
        $this->check_user();
        if($this->user_info['type'] != 1)
        {
            $this->request_err(null,'用户无权访问');
        }

        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_history_book_list(null,$data_arr['page'],$data_arr['order'],$data_arr['limit']);
        $ret['success'] ? $this->request_success($ret['ret'],'获取待审核列表成功') : $this->request_err(null,$ret['ret']);
    }

    /**
     * 获取用户未来参加的会议 /?/api/booking/query/user_future_meeting
     *
     */
    private function get_user_future_meeting()
    {
        $this->check_user();
        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_user_futrue_meeting($this->user_id,$data_arr['page'],$data_arr['order'],$data_arr['limit']);

        $ret['success'] ? $this->request_success($ret['ret'],'获取会议列表成功') : $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取用户的全部会议 /?/api/booking/query/user_meeting
     *
     */
    private function get_user_meeting()
    {
        $this->check_user();
        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_user_meeting_history($this->user_id,$data_arr['page'],$data_arr['order'],$data_arr['limit']);
        $ret['success'] ? $this->request_success($ret['ret'],'获取会议列表成功') : $this->request_err(null,$ret['ret']);

    }

    /**
     * 获取admin未来的会议 /?/api/booking/query/admin_future_meeting
     *
     */
    private function get_admin_future_meeting()
    {
        $this->check_user();
        if($this->user_info['type'] != 1)
        {
            $this->request_err(null,'用户无权访问');
        }
        $white_list = array(
            'page',
            'order',
            'limit',
        );
        $data_arr = $this->filter_post_data($white_list);
        $ret = $this->booking_model->get_admin_future_meeting($data_arr['page'],$data_arr['order'],$data_arr['limit']);
        $ret['success'] ? $this->request_success($ret['ret'],'获取会议列表成功') : $this->request_err(null,$ret['ret']);
    }

    /**
     * 获取admin的全部会议 /?/api/booking/query/admin_meeting
     *
     */
    private function get_admin_meeting()
    {
        $this->check_user();
        if($this->user_info['type'] != 1)
        {
            $this->request_err(null,'用户无权访问');
        }
        $white_list = array(
            'page',
            'order',
            'limit',
        );
        $data_arr = $this->filter_post_data($white_list);
        $ret = $this->booking_model->get_admin_history_meeting($data_arr['page'],$data_arr['order'],$data_arr['limit']);
        $ret['success'] ? $this->request_success($ret['ret'],'获取会议列表成功') : $this->request_err(null,$ret['ret']);
    }

    /**
     *
     */
    private function get_book_data()
    {
        $white_list = array(
            'cid',
            'start',
            'last',
            'limit',
            'page',
            'order'
        );

        $data_array = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_book_table($data_array);

        // 将data_array变成 5 x 8 的二维数组 [0][0] [0][1] [0][2]
        // 1:不能预约 2:可以预约 3:空闲


        if($ret['success']) $this->request_success($ret['ret'],'获取列表成功');
        $this->request_err(null,$ret['ret']);

    }



    /**
     * 通过审核 /?/api/booking/pass/
     *
     */
    public function pass()
    {
        $this->check_user();
        if($this->user_info['type'] != 1) $this->request_err(null,'用户无权访问');
        $ret = $this->booking_model->pass_booking($this->user_id,$this->input->post('bid'));
        if($ret['success']) $this->request_success(null,'订单预约成功');
        $this->request_err(null,$ret['ret']);
    }

    /**
     *
     */
    public function refuse()
    {
        $this->check_user();
        if($this->user_info['type'] != 1) $this->request_err(null,'用户无权访问');
        $ret = $this->booking_model->refuse_booking($this->user_id,$this->input->post('bid'));
        if($ret['success']) $this->request_success(null,'预定拒绝成功');
        $this->request_err(null,$ret['ret']);
    }


    /**
     * 用户取消申请会议室
     *
     */
    public function cancel()
    {
        $this->check_user();
        $ret = $this->booking_model->cancel_booking($this->user_id, $this->input->post('bid'));
        if ($ret['success']) $this->request_success(null, '订单预约成功');
        $this->request_err(null, $ret['ret']);
    }

    public function get_meetings_for_calendar(){

        $white_list = array(
            'cid',
            // 开始时间 2013-02-04 included
            'start',
            'end',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->booking_model->get_meetings_for_calendar($data_arr['cid'],$data_arr['start'],$data_arr['end']);

        $ret['success'] ? $this->request_success($ret['ret']) : $this->request_err(null,$ret['ret']);

    }

}

