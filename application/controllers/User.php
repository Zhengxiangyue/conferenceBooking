<?php

/**
 * Class User
 */
class User extends Base
{

    /**
     * /?/user/ 用户主界面
     *
     */
    public function index(){
        $this->check_toekn_front();
        $this->load->view('user/index');
    }

    /**
     * /?/user/login/ 用户登录
     *
     */
    public function login()
    {
        if ($this->check_token())
            redirect(base_url("?/user/"));

        $data = array();
        if (isset($_GET['url']))
            $data['toUrl'] = $_GET['url'];

        $this->load->view('user/login', $data);
    }



    /**
     * /?/user/register/ 用户注册界面
     * @param string $reg_status
     * @param string $url_user_name
     * @param string $url_department
     */
    public function register()
    {
        if ($this->check_token())
            redirect(base_url("?/user/"));

         $this->load->view('user/register');
    }

    /**
     * /?/user/booking_detail/ 预约详情
     * @param int $cid
     */
    public function booking_detail($cid = 0)
    {
        $this->check_toekn_front();
        if (empty($cid)) $this->show_custom_404();

        $this->load->model('room_model');
        $room_data = $this->room_model->get_room_detail_by_cid($cid);

        $this->load->view('booking_deal', array('room' => $room_data['ret']));
    }

    /**
     * /?/user/add_new_booking/ 添加新的预约
     *
     */
    public function add_new_booking(){
        $this->check_toekn_front();
        $this->load->view('user/new_booking');
    }

    /**
     * /?/user/room_detail/ 会议室详情
     *
     */
    public function room_detail(){
        $this->check_toekn_front();
        $this->load->view('user/room_detail');
    }

    /**
     *
     */
    public function find_password(){
        $this->load->view('user/find_password');
    }

    /**
     * 我的会议页面
     *
     */
    public function meeting(){
        $this->check_toekn_front();
        $this->load->view('user/meeting');
    }

    public function history_meeting(){
        $this->check_toekn_front();
        $this->load->view('user/history_meeting');
    }

    public function info(){
        $this->check_toekn_front();
        $this->load->view('user/info');
    }

    /**
     *
     */
    public function get_register_verify_code()
    {
        $mobile = $this->input->post("mobile");

        $this->load->database();
        $sql = " SELECT uid FROM mrbs_users WHERE mobile=?";
        $row = $this->db->query($sql, array($mobile))->row();
        if (!empty($row)) {
            $this->output->response_json(array(
                "code" => "-1",
                "msg" => "mobile_already_register"
            ));
        }

        $this->load->helper("string");
        $code = random_string("numeric", 6);
        $this->load->helper('shortmsg');
        ali_get_register_verify_code($mobile, $code);

        $this->db->insert("mrbs_mobile_code", array(
            "mobile" => $mobile,
            "code" => $code,
            "send_time" => time()
        ));

        $this->output->response_json(array(
            "code" => 1,
            "msg" => "msg_already_send"
        ));
    }

    /**
     *
     */
    public function agreement()
    {
        $this->check_toekn_front();
        $this->load->view('user_agreement');
    }

    /**
     *
     */
    public function findpassword()
    {
        $this->load->view('findpwd');
    }

    public function booking_history(){
        $this->check_toekn_front();
        $this->load->view('user/booking_history');
    }


    /**
     *
     */
    public function get_changepwd_verify_code()
    {
        $mobile = $this->input->post("mobile");

        $this->load->database();
        $sql = " SELECT uid FROM mrbs_users WHERE mobile=?";
        $row = $this->db->query($sql, array($mobile))->row();
        if (empty($row)) {
            $this->output->response_json(array(
                "code" => -1,
                "msg" => "mobile_not_register"
            ));
        }

        $this->load->helper("string");
        $code = random_string("numeric", 6);
        $this->load->helper('shortmsg');
        api_get_changepwd_verify_code($mobile, $code);

        $sql = " SELECT id FROM mrbs_mobile_code WHERE mobile=?";
        $row = $this->db->query($sql, array($mobile))->row();
        if (empty($row)) {
            $this->db->insert("mrbs_mobile_code", array(
                "mobile" => $mobile,
                "code" => $code,
                "send_time" => time()
            ));
        } else {
            $this->db->update("mrbs_mobile_code", array(
                "code" => $code,
                "send_time" => time()
            ), "id=" . $row->id);
        }

        $this->output->response_json(array(
            "code" => 1,
            "msg" => "msg_already_send"
        ));
    }

    /**
     *
     */
    public function change_pwd()
    {
        $mobile = $this->input->post("mobile");
        $mobile_code = $this->input->post("mobile_code");
        $newpwd = $this->input->post("newpwd");

        $this->load->database();
        $sql = " SELECT uid,salt FROM mrbs_users WHERE mobile=?";
        $user_row = $this->db->query($sql, array($mobile))->row();
        if (empty($user_row)) {
            $this->output->response_json(array(
                "code" => -1,
                "msg" => "mobile_not_register"
            ));
        }

        $sql = " SELECT id,send_time FROM mrbs_mobile_code WHERE mobile=? AND code=?";
        $row = $this->db->query($sql, array($mobile, $mobile_code))->row();

        //验证码有效时间15分钟
        if (empty($row) || time() - intval($row->send_time) > 15 * 60) {
            $this->output->response_json(array(
                "code" => -2,
                "msg" => "invalid_mobile_code"
            ));
        }

        $this->db->update("mrbs_users", array(
            "password" => md5(md5($newpwd) . $user_row->salt)
        ), "uid=" . $user_row->uid);

        $this->output->response_json(array(
            "code" => 1,
            "msg" => "change_pwd_success"
        ));
    }


    /**
     * @param int $length
     * @return string
     */
    private function get_rand_str($length = 6)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $str;
    }
}

?>