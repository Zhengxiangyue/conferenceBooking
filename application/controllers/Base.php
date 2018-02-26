<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 14/2/2017
 * Time: 3:05 PM
 */

/**
 * Class Base 所有控制器继承的基类
 *
 * @property CI_Encryption $encryption
 * @property CI_DB_query_builder $db
 */
class Base extends CI_Controller
{

    /**
     * uid
     * @var
     */
    protected $user_id = null;

    /**
     * @var
     */
    protected $user_info;

    /**
     * Base constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 接口检查用户，检查失效直接response
     *
     */
    protected function check_user()
    {
        if (!$this->check_token()) $this->request_err(null, lang('hint_user_not_login'), -10);
        return 1;
    }

    /**
     * 检查用户，跳转到login页面
     *
     */
    protected function check_toekn_front()
    {
        if ($this->check_token())
            return 1;

        if (strstr(current_url(), 'admin'))
            redirect(base_url('?/admin/login/?url=' . base64_current_path()));

        redirect(base_url('?/user/login/?url=' . base64_current_path()));
    }

    /**
     * @return bool
     */
    protected function check_token()
    {
        $this->user_info = $this->check_user_login_cookie();
        if (!$this->user_info) return false;
        $this->user_id = $this->user_info['uid'];
        return true;
    }


    /**
     * 检查登陆token
     * @return array | bool 检查失败返回false 成功返回用户信息
     */
    protected function check_user_login_cookie()
    {
        if (!isset($_COOKIE['sid'])) return false;
        session_start();
        if (!isset($_SESSION['shrapen_conference_expire']) OR $_SESSION['shrapen_conference_expire'] < time()) return false;
        session_write_close();
        $content_str = $this->encryption->decrypt($_COOKIE['sid']);
        if (!$content_str) return false;
        $content_arr = unserialize($content_str);
        if (!isset($content_arr['uid']) OR !isset($content_arr['mobile'])) return false;
        return $content_arr;
    }

    /**
     * @param $user_data_array
     */
    protected function set_user_login_cookie($user_data_array, $expire = 86400)
    {
        $user_data_array['expire'] = time() + $expire;
        setcookie('sid', $this->encryption->encrypt(serialize($user_data_array)), $user_data_array['expire']);
        setcookie('sharpen', 'copyright2017', $user_data_array['expire']);
        setcookie('mstoken', md5(date('Y-m-d H:i:s')), $user_data_array['expire']);
        session_start();
        $_SESSION['shrapen_conference_expire'] = $user_data_array['expire'];
        session_write_close();
        return;
    }

    /**
     * 销毁客户端cookie凭证
     *
     */
    protected function destry_user_login_cookie()
    {
        setcookie('sid', '', time() - 5);
        setcookie('sharpen', '', time() - 5);
        setcookie('mstoken', '', time() - 5);
        session_start();
        $_SESSION['shrapen_conference_expire'] = time();
        session_write_close();
        return;
    }

    /**
     * @param $data
     * @param string $msg
     * @param int $code
     */
    public function request_success($data, $msg = '', $code = 1)
    {

        // 杜绝接口返回null值
        if ($data === null) $data = (object)$data;

        $array = array(
            'data' => $data,
            'msg' => $msg,
            'code' => $code,

        );

        echo str_replace(array("\r", "\n", "\t"), '', json_encode($array));
        exit;

    }

    /**
     * @param $data
     * @param string $msg
     * @param int $code
     */
    public function request_err($data, $msg = '', $code = -1)
    {

        // 杜绝接口返回null值
        if ($data === null) $data = (object)$data;

        $array = array(
            'data' => $data,
            'msg' => $msg,
            'code' => $code,
        );

        echo str_replace(array("\r", "\n", "\t"), '', json_encode($array));
        exit;

    }

    /**
     * 过滤white_list中的数据到返回数组
     * @param $white_list
     * @return array|bool
     */
    public function filter_post_data($white_list, $must = false)
    {
        if (!is_array($white_list)) return false;
        $data_array = array();
        foreach ($white_list as $item) {
            if (isset($_POST[$item])) {
                $data_array[$item] = $_POST[$item];
            } else {
                if ($must) $this->request_err(null, lang('hint_illegal_request'));
                $data_array[$item] = NULL;
            }
        }
        return $data_array;
    }

    /**
     * 不是post方法展示404页面
     *
     */
    public function check_post()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') show_error('Your request is not found ' . lang('hint_page_not_found'));
    }

    public function show_custom_404()
    {
        show_error('Your request is not found ' . lang('hint_page_not_found'));
    }

}
