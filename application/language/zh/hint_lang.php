<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 1/3/2017
 * Time: 9:18 PM
 */

$hint_lang = array(
    'hint_' => '',
    'hint_no_more_message'              => '没有更多信息了',
    'hint_booking_failed_one'           => '预约失败，请添加预约数据',
    'hint_booking_failed_two'           => '预约失败',
    'hint_illegal_request'              => '非法请求',
    'hint_no_booking_record'            => '没有预约记录',
    'hint_page_not_found'               => '您要访问的页面不存在',
    'hint_user_not_login'               => '用户未登录',
    'hint_please_input_valid_time'      => '请输入正确的时间',
    'hint_network_unavaliable'          => '网络异常，请稍后再试',
    'hint_need_list_is_not_an_array'    => '数据库中的needlist不是一个数组，请检查',
    'hint_enter_new_need'               => '请输入新的设施',
    'hint_new_need_update_successfully' => '新的设施添加成功',
    'hint_enter_delete_need'            => '请输入要删除的设施',
    'hint_no_such_need'                 => '没有找到该项设施',
    'hint_need_delete_successfully'     => '成功删除了设施',
);



if(!is_array($lang))
{
    $lang = array();
}
$lang = array_merge($hint_lang,$lang);
