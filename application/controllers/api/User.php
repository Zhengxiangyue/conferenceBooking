<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 17/2/2017
 * Time: 9:36 AM
 */
class User extends Base
{

    /**
     * Booking constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    /**
     * api/user/admin/
     *
     */
    public function admin($action = ''){
        switch ($action) {
            case 'register' : $this->admin_register();
                break;
            case 'login' : $this->admin_login();
                break;
            case 'logout' : $this->admin_logout();
                break;
            case 'status' :$this->status();
                break;
            case 'list' :$this->get_admin_list();
                break;
            default : $this->request_err(null,'未定义动作');
        }
    }

    /**
     * 管理员注册 api/user/admin/register/
     */
    private function admin_register(){

        if($this->check_token()) $this->request_err(null,'用户已经处于登陆状态');


    }

    /**
     *
     */
    public function create_key(){
        $key = bin2hex($this->encryption->create_key(16));
        echo $key;
    }

    /**
     * /?/api/user/admin_logout/ 管理员退出登录
     *
     */
    public function admin_logout(){
        if(!$this->check_token())
            $this->request_err(null,'用户已经处于退出状态');
        $this->destry_user_login_cookie();
        $this->request_success(null,'用户退出成功');
    }

    /**
     * /?/api/user/admin_login/ 管理员登陆
     *
     */
    public function admin_login(){

        $white_list = array('mobile','password');
        $data_arr = $this->filter_post_data($white_list);
        if(empty($data_arr)) $this->request_err('请输入用户名和密码');
        $ssl = load_class('ssl');
        $ssl->set_key($this->config->item('ssl_private'),$this->config->item('ssl_public'));
        $data_arr['password'] = $ssl->decrypt($data_arr['password']);
        $ret = $this->user_model->user_login($data_arr);


        if(!$ret['success'])
            $this->request_err(null,$ret['ret']);

        if ((int)$ret['ret']['type'] != 1)
            $this->request_err($ret['ret']['type'],'您的账户不是管理员账户，无法登陆管理系统');


        $this->set_user_login_cookie($ret['ret']);
        $this->request_success(null,'用户登录成功');

    }

    private function get_admin_list(){
        if(!$this->check_token()) return $this->request_err(null,'用户未登录',-10);

        if($this->user_info['type'] != 1) return $this->request_err(null,'用户权限不足');

        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->user_model->get_admin_list($data_arr['page'],$data_arr['order'],$data_arr['limit']);

        $this->request_success($ret['ret']);

    }

    public function all_list(){
        if(!$this->check_token()) return $this->request_err(null,'用户未登录',-10);

        if($this->user_info['type'] != 1) return $this->request_err(null,'用户权限不足');

        $white_list = array(
            'page',
            'order',
            'limit',
        );

        $data_arr = $this->filter_post_data($white_list);

        $ret = $this->user_model->get_user_list($data_arr['page'],$data_arr['order'],$data_arr['limit']);

        $this->request_success($ret['ret']);
    }

    /**
     * /?/api/user/login 用户登录
     *
     */
    public function login(){
        $white_list = array('mobile','password');
        $data_arr = $this->filter_post_data($white_list);
        if(empty($data_arr)) $this->request_err('请输入用户名和密码');
        $ssl = load_class('ssl');
        $ssl->set_key($this->config->item('ssl_private'),$this->config->item('ssl_public'));
        $data_arr['password'] = $ssl->decrypt($data_arr['password']);
        $ret = $this->user_model->user_login($data_arr);

        if(!$ret['success'])
            $this->request_err(null,$ret['ret']);

        $this->set_user_login_cookie($ret['ret']);

        if(!empty($_POST['toUrl']))
            $return['url'] = base_url().base64_decode($_POST['toUrl']);

        $this->request_success($return,'用户登录成功');
    }

    /**
     * /?/api/user/register
     *
     */
    public function register(){
        $white_list = array(
            'mobile',
            'password',
            'code',
            'user_name',
            'department',
        );

        $data_array = $this->filter_post_data($white_list,true);

        $ssl = load_class('ssl');
        $ssl->set_key($this->config->item('ssl_private'),$this->config->item('ssl_public'));

        $data_array['password'] = $ssl->decrypt($data_array['password']);
        $data_array['code'] = $ssl->decrypt($data_array['code']);

        if($data_array['password'] === false OR $data_array['code'] === false) $this->request_err(null,lang('hint_illegal_request'));

        $ret = $this->user_model->register($data_array);
        $ret['success'] ? $this->request_success(null,'注册成功') : $this->request_err(null,$ret['ret']);
    }


    /**
     * /?/api/user/logout/ 用户退出登录
     *
     */
    public function logout(){
        if(!$this->check_token())
            $this->request_err(null,'用户已经处于退出状态');
        $this->destry_user_login_cookie();
        $this->request_success(null,'用户退出成功');
    }

    /**
     * /?/api/user/get_register_code 获取手机验证码
     *
     */
    public function get_register_code(){
        $mobile = $this->input->post("mobile");
        if(strlen($mobile) != 11) $this->request_err('请输入正确的手机号');
        $ret = $this->user_model->get_register_code($mobile);
        if(!$ret['success']) $this->request_err(null,$ret['ret']);
        $this->request_success(null,$ret['ret']);
    }

    /**
     * /?/api/user/get_find_password_code/
     *
     */
    public function get_find_password_code(){
        $mobile = $this->input->post("mobile");
        if(strlen($mobile) != 11) $this->request_err('请输入正确的手机号');

        $ret = $this->user_model->get_find_password_code($mobile);

        $ret['success'] ? $this->request_success(null,'密码重置成功') : $this->request_err(null,$ret['ret']);
    }

    /**
     * /?/api/user/find_password
     *
     */
    public function find_password(){
        $white_list = array(
            'mobile','code','password'
        );
        $data_array = $this->filter_post_data($white_list,true);

        $ssl = load_class('ssl');
        $ssl->set_key($this->config->item('ssl_private'),$this->config->item('ssl_public'));

        $data_array['code'] = $ssl->decrypt($data_array['code']);
        $data_array['password'] = $ssl->decrypt($data_array['password']);

        if($data_array['code'] === false OR $data_array['password'] === false) $this->request_err(null,'密文揭秘失败,非法请求');

        $ret = $this->user_model->find_password($data_array);

        $ret['success'] ? $this->request_success(null,'密码重置成功') : $this->request_err(null,$ret['ret']);
    }

    public function info(){
        $this->check_user();

        $now_hour = date('H');

        $regards = $now_hour < 5 ? '深夜好' : ($now_hour < 7 ? '清晨好' : ($now_hour < 11 ? '早上好' : ($now_hour < 14 ? '中午好' : ($now_hour < 18 ? '下午好' : '晚上好'))));

        $this->request_success(array(
            'regards'=>$regards,
            'user_name'=>$this->user_info['user_name'],
            'department'=>$this->user_info['department'],
            'mobile'=>$this->user_info['mobile'],
            'admin'=> (int)$this->user_info['type'] === 1,
        ));
    }

    public function status()
    {
        sleep(5);
        $this->request_success('完成');
    }


}
