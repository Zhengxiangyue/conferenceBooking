<?php

/**
 * Class Admin
 */
class Admin extends Base {


    /**
     * /?/admin/ 后台主界面
     *
     */
    public function index(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
            redirect(base_url()."?/user");
        $data = array('dest' => isset($_GET['dest']) ? $_GET['dest'] : '');
        $this->load->view('admin/index',$data);
    }

    public function room(){
        $this->load->view('admin/room');
    }


    /**
     * /?/admin/login/ 用户登录页面
     *
     */
    public function login(){
        if($this->check_token()){
            if($this->user_info['type'] != 1){
                redirect(base_url()."/?/user");
            }
            redirect(base_url('?/admin/'));
        }
        $this->load->view('admin/login');
    }

    /**
     * /?/admin/register/ 用户注册界面
     *
     */
    public function register(){
        $this->load->view('admin/register');
    }

    /**
     * /?/admin/room_detail/ 会议室详情页面
     *
     */
    public function room_detail(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
            redirect(base_url()."?/user");
        $this->load->view('admin/room_detail');
    }

    public function booking_history(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
            redirect(base_url()."?/user");

        $this->load->view('admin/booking_history');
    }

    public function administrator(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
            redirect(base_url()."?/user");

        $this->load->view('admin/administrator');
    }

    public function meeting(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
            redirect(base_url()."?/user");

        $this->load->view('admin/meeting');
    }


    public function meeting_history(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
            redirect(base_url()."?/user");

        $this->load->view('admin/meeting_history');
    }

    public function setting(){
        $user = $this->check_token();
        if(empty($user) OR $this->user_info['type'] != 1)
        {
            redirect(base_url()."?/user");
        }

        $this->load->view('admin/setting');

    }

}
?>