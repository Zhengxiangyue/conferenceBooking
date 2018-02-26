<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 17/2/2017
 * Time: 9:37 AM
 */
require_once "Base_model.php";

/**
 * Class User_model
 */
class User_model extends Base_model
{

    /**
     * User_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $password
     * @param $salt
     * @return string
     */
    private function encrypt_password($password, $salt)
    {
        return md5(md5($password) . $salt);
    }

    /**
     * 用户登录
     * @param $data_arr
     * @return array
     */
    public function user_login($data_arr)
    {
        if (!isset($data_arr['mobile']) OR !isset($data_arr['password']))
            return $this->model_err('请输入用户名或密码');
        $user_data = $this->db->select()->where('mobile', $data_arr['mobile'])->get('users')->row_array();

        if (empty($user_data))
            return $this->model_err('这个手机号还没有注册');
        if ($this->encrypt_password($data_arr['password'], $user_data['salt']) !== $user_data['password'])
            return $this->model_err('密码错误');

        return $this->model_success($user_data);
    }


    /**
     * 获取注册手机验证码
     *
     */
    public function get_register_code($mobile)
    {

        // 检查手机号码是否已经注册过

        $query = $this->db->select('uid')->where('mobile', $mobile)->get('users');
        $result = $query->result_array();

        if ($result)
            return $this->model_err('手机号码已经注册过，请直接登陆');

        $this->load->helper("string");
        $code = random_string("numeric", 4);

        $this->load->helper('shortmsg');
        ali_get_register_verify_code($mobile, $code);

        $data = $this->db->select()->where('mobile', $mobile)->get('mobile_code')->result_array();

        if (empty($data)) {
            $ret = $this->db->insert('mobile_code',
                array(
                    'mobile' => $mobile,
                    'code' => $code,
                    'send_time' => time()
                )
            );
        } else {
            $ret = $this->db->update('mobile_code', array(
                'mobile' => $mobile,
                'code' => $code,
                'send_time' => time()), array('mobile' => $mobile));
        }

        return $ret ? $this->model_success('验证码发送成功') : $this->model_err('网络异常，请稍后再试');

    }

    /**
     * 获取找回密码时的验证码
     * @param $mobile
     */
    public function get_find_password_code($mobile)
    {
        $user_data = $this->db->select()->where('mobile', $mobile)->get('users')->result_array();
        if (empty($user_data)) return $this->model_err('该手机号码还没有注册过');
        $this->load->helper('shortmsg');
        $code = randomCode(4, 3);
        api_get_changepwd_verify_code($mobile, $code);
        $this->update_mobile_code($mobile, $code);
        return $this->model_success('验证码发送成功');
    }


    /**
     * 更新手机验证码
     *
     */
    public function update_mobile_code($mobile, $code)
    {

        $code_data = $this->db->select()->where('mobile', $mobile)->get('mobile_code')->result_array();
        if (empty($code_data)) {
            $this->db->insert('mobile_code', array('mobile' => $mobile, 'code' => $code, 'send_time' => time()));
        } else {
            $this->db->update('mobile_code', array('code' => $code, 'send_time' => time()), array('mobile' => $mobile));
        }


    }

    /**
     * 检查手机验证码是否正确
     * @param $mobile
     * @param $code
     */
    public function check_mobile_code($mobile, $code, $valid = 180)
    {
        $result = $this->db->select()->where(array('code' => $code, 'mobile' => $mobile))->get('mobile_code')->row_array();
        if (empty($result)) return $this->model_err('验证码错误');
        if (time() > $result['send_time'] + $valid) return $this->model_err('验证码已失效');
        $this->update_mobile_code($mobile, '-1');
        return $this->model_success('验证通过');
    }

    /**
     * 注册
     * @param $data_array
     * @return array
     */
    public function register($data_array)
    {
        $code_ret = $this->check_mobile_code($data_array['mobile'], $data_array['code']);
        if (!$code_ret['success']) return $code_ret;
        $check = $this->db->select()->where('mobile', $data_array['mobile'])->get('users')->result_array();
        if ($check) return $this->model_err('该手机号码已经注册过');

        // 是否是第一个用户注册 如果是将他设置为管理员
        $user_type = $this->db->select()->limit(1)->get('users')->row_array() ? 2 : 1;

        $this->load->helper("string");
        $salt = random_string("alpha", 4);
        $ret = $this->db->insert('users',
            array(
                'mobile' => $data_array['mobile'],
                'password' => $this->encrypt_password($data_array['password'], $salt),
                'salt' => $salt,
                'type' => $user_type,
                'user_name' => $data_array['user_name'],
                'department' => $data_array['department'],
                'reg_time' => time(),
            )
        );
        return $ret ? $this->model_success('注册成功') : $this->model_err('网络异常，请稍后再试');

    }


    /**
     * 重置密码
     *
     */
    public function find_password($data_array)
    {
        $code_ret = $this->check_mobile_code($data_array['mobile'], $data_array['code']);
        if (!$code_ret['success']) return $code_ret;
        $salt = randomCode(4, false);
        $res = $this->db->update('users', array('password' => $this->encrypt_password($data_array['password'], $salt), 'salt' => $salt), array('mobile' => $data_array['mobile']));
        return $res ? $this->model_success('密码修改成功') : $this->model_err('网络异常，请稍后再试');
    }

    /**
     * 获取管理员列表
     *
     */
    public function get_admin_list($page = 1,$order = 'reg_time DESC',$limit = 20){

        $page = $page ? $page : 1;
        $order = $order ? $order : 'reg_time DESC';
        $limit = $limit ? $limit : 20;

        // 获取管理员列表

        $admin_query = $this->db->select('uid,user_name,type')->where_in('type',array(1,3));
        $admin_num = $this->db->get_results_num('users');
        $admin_result = $admin_query->offset(($page-1)*$limit)->limit($limit)->get('users')->result_array();

        if(empty($admin_result)) return $this->model_err('当前没有用户');
        return $this->model_success(array('admin_num'=>$admin_num,'admin'=>$admin_result));
    }

    /**
     * @param int $page
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function get_user_list($page = 1, $order = 'reg_time DESC', $limit = 20){
        $page = $page ? $page : 1;
        $order = $order ? $order : 'reg_time DESC';
        $limit = $limit ? $limit : 20;

//         获取全部用户列表

        $user_query = $this->db->select('uid,user_name,type,department,mobile,reg_time');
        $user_num = $this->db->get_results_num('users');
        $user_result = $user_query->offset(($page-1)*$limit)->limit($limit)->get('users')->result_array();

        if(empty($user_result)) return $this->model_err('当前没有用户');
        foreach ($user_result as $index => $user){
            $user_result[$index]['reg_time'] = date('Y-m-d H:i:s',$user['reg_time']);
        }
        return $this->model_success(array('user_num'=>$user_num,'user'=>$user_result));
    }

    /**
     * @param $data_array
     * @return array
     */
    public function add_admin($data_array){

        $user = $this->db->select()->where('mobile',$data_array['mobile'])->get('users')->row_array();
        if(!$user) $this->model_err('该用户不存在');

        $this->db->update('users',array('type'=>$data_array['type']),array('mobile'=>$data_array['mobile']));

        return $this->model_success('管理员添加成功');

    }

    /**
     * @param $data_array
     * @return array
     */
    public function delete_admin($data_array){

        $user = $this->db->select()->where('mobile',$data_array['mobile'])->get('users')->row_array();
        if(!$user) $this->model_err('该用户不存在');

        $this->db->update('users',array('type'=>2),array('mobile'=>$data_array['mobile']));
        return $this->model_success('管理员身份移除成功');
    }

}