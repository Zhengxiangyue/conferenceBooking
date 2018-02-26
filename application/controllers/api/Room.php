<?php
/**
 * Created by PhpStorm.
 * User: zhengxiangyue
 * Date: 14/2/2017
 * Time: 3:07 PM
 */

class Room extends Base{

    /**
     * Room constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->check_post();
        $this->load->model('room_model');
    }

    /**
     * 创建一个新的会议室
     *
     */
    public function add($action = ''){
        switch ($action){
            default : $this->create_conference_room();
        }

    }

    /**
     * 更新一个会议室
     *
     */
    public function update($action = ''){
        switch ($action){
            default : $this->update_conference_room();
        }
    }

    /**
     * 获取会议室 /?/api/room/query/
     *
     */
    public function query($action = ''){
        switch ($action){
            case 'available' :
                $this->query_available_room();
                break;
            default : $this->get_rooms();
        }
    }

    public function delete($action = ''){
        switch ($action){
            default : $this->delete_room();
        }
    }

    /**
     *
     */
    private function get_rooms(){
        $this->check_user();
        $ret = $this->room_model->get_rooms($this->input->post('limit'),$this->input->post('page'),$this->input->post('order'),$this->input->post('open'));
        if($ret['success']) $this->request_success($ret['ret']);
        $this->request_err(null,$ret['ret']);
    }

    /**
     * /?/api/room/add/ 创建一个会议室
     *
     */
    private function create_conference_room(){

        $white_list = array(
            'name',
            'position',
            'open',
            'openBeginTime',
            'capacity',
            'openEndTime',
            'personInCharge',
            'mobile',
            'remark',
            'images'
        );

        $db_array = array(
            'addTime' => date('Y-m-d H:i:s'),
        );

        foreach ($white_list as $item){
            if(isset($_POST[$item])) $db_array[$item] = $_POST[$item];
        }

        $ret = $this->room_model->create_conference_room($db_array);

        if($ret['success']) $this->request_success($ret['ret'],'成功创建了新的会议室');
        $this->request_err(null,$ret['ret']);

    }

    /**
     * /?/api/room/update/ 更新一个会议室信息
     *
     */
    private function update_conference_room(){
        if(!($cid = $this->input->post('cid'))) $this->request_err(null,'未指定要更新的会议室');
        $white_list = array(
            'name',
            'position',
            'open',
            'openBeginTime',
            'capacity',
            'openEndTime',
            'personInCharge',
            'mobile',
            'remark',
            'images',
            'needList',
        );

        $db_array = array();

        foreach ($white_list as $item){
            if(isset($_POST[$item])) $db_array[$item] = $_POST[$item];
        }

        $ret = $this->room_model->update_conference_room($cid,$db_array);

        if($ret['success']) $this->request_success(null,$ret['ret']);
        $this->request_err(null,$ret['ret']);
    }

    /**
     * /?/api/room/delete/
     *
     */
    private function delete_room(){
        if(!($cid = $this->input->post('cid'))) $this->request_err(null,'未指定要删除的会议室');

        $ret = $this->room_model->delete_room($cid);

        if($ret['success']) $this->request_success(null,$ret['ret']);
        $this->request_err(null,$ret['ret']);

    }

    /**
     * 上传会议室图片
     *
     */
    public function upload_conference_room_image(){

        // 会议室图片文件夹地址 : upload/room/20171213/au9ljf.jpg

        $upload_library = load_class('Upload');

        // 从新调整files的格式

        $files = array();

        $ret_arr = array('error'=>array(),'url'=>array());

        for ($i = 0;$i<sizeof($_FILES['conference_room_image']['name']);$i++){
            $each_file = array('name'=>'','type'=>'','tmp_name'=>'','error'=>'','size'=>'');
            $each_file['name'] = $_FILES['conference_room_image']['name'][$i];
            $each_file['type'] = $_FILES['conference_room_image']['type'][$i];
            $each_file['tmp_name'] = $_FILES['conference_room_image']['tmp_name'][$i];
            $each_file['size'] = $_FILES['conference_room_image']['size'][$i];
            $files[] = $each_file;
        }

        // 将每个图片上传

        foreach ($files as $upload_file){
            $_FILES['conference_room_image'] = $upload_file;

            $name_arr = explode('.',$upload_file['name']);
            $suffix = ".".$name_arr[sizeof($name_arr)-1];
            $to_path = UPLOAD_PATH."room/".date('Y')."/".date('m')."/".date('d')."/";
            $file_name = randomCode(8);

            $upload_library->initialize(array(
                'allowed_types' => 'jpg,jpeg,png,gif',
                'upload_path' => $to_path,
                'is_image' => TRUE,
                'max_size' => '512',
                'file_name' => $file_name,
                'encrypt_name' => FALSE
            ))->do_upload('conference_room_image');

            if ($upload_library->get_error()) $ret_arr['error'][] = $upload_library->get_error();

            // 如果文件上传成功 剪切图片
            if(file_exists($to_path.$file_name.$suffix)){
                $image_helper = load_class('Image');
                $img_size = getimagesize($to_path.$file_name.$suffix);
                // 存储图片的宽和高
                $to_size = array();

                // 首先将截取3：4的图片
                if($img_size[0]/$img_size[1] > 3/4){
                    $to_size[1] = $img_size[1];
                    $to_size[0] = $to_size[1]*3/4;
                }else{
                    $to_size[0] = $img_size[0];
                    $to_size[1] = $to_size[0]*4/3;
                }

                $resize_path = UPLOAD_PATH."room/300x400/".date('Y')."/".date('m')."/".date('d')."/";

                if(!is_dir($resize_path)) make_dir($resize_path);

                $image_helper->initialize(array(
                    'quality' => 100,
                    'source_image' => $to_path.$file_name.$suffix,
                    'new_image' => $resize_path.$file_name.$suffix,
                    'width' => 300,
                    'height' => 400
                ))->resize(0,0,$to_size[0],$to_size[1]);

                // 再先截取 3:2 的图片 如果 宽 ：高 > 3：2 按高截取，覆盖原图
                if($img_size[0]/$img_size[1] > 1.5){
                    $to_size[1] = $img_size[1];
                    $to_size[0] = $to_size[1] * 1.5;
                }else{
                    $to_size[0] = $img_size[0];
                    $to_size[1] = $to_size[0]*2/3;
                }

                //覆盖原图
                $image_helper->initialize(array(
                    'quality' => 100,
                    'source_image' => $to_path.$file_name.$suffix,
                    'new_image' => $to_path.$file_name.$suffix,
                    'width' => 300,
                    'height' => 200,
                ))->resize(0,0,$to_size[0],$to_size[1]);
            }

            $ret_arr['url'][] = base_url()."/upload/room/300x400/".date('Y')."/".date('m')."/".date('d')."/".$file_name.$suffix;
            $ret_arr['image'][] = date('Y')."/".date('m')."/".date('d')."/".$file_name.$suffix;
            $ret_arr['file'][] = date('Y')."/".date('m')."/".date('d')."/".$file_name;
            $ret_arr['suffix'][] = $suffix;
        }

        if($ret_arr['error']) {
            foreach ($ret_arr['error'] as $index=>$error){
                switch ($error)
                {
                    case 'upload_invalid_filetype':
                        $ret_arr['error'][$index] = '文件类型无效';
                        break;
                    case 'upload_invalid_filesize':
                        $ret_arr['error'][$index] = '文件尺寸过大, 最大允许尺寸为512k';
                        break;

                }
            }
            $this->request_err(null,$ret_arr['error'][0]);
        }

        $this->request_success($ret_arr,'图片上传成功');

    }

    /**
     * api/room/query/available
     *
     */
    private function query_available_room()
    {
        $this->check_user();
        $white_list = array(
            'useDate',
            'useBeginTime',
            'useEndTime',
            'limit',
            'page',
            'order',
        );
        $data_array = $this->filter_post_data($white_list);

        $this->check_date_format($data_array);

        $ret = $this->room_model->query_available_room($data_array);
        if($ret['success']) $this->request_success($ret['ret'],'获取列表成功');
        $this->request_err(null,$ret['ret']);
    }

    /**
     * @param $data_array
     */
    private function  check_date_format($data_array){
        if(!strtotime($data_array['useDate']." ".$data_array['useBeginTime']) OR !strtotime($data_array['useDate']." ".$data_array['useEndTime']))
            $this->request_err(null,'日期格式错误');

        if(strtotime($data_array['useDate']." ".$data_array['useBeginTime']) > strtotime($data_array['useDate']." ".$data_array['useEndTime']))
            $this->request_err(null,'会议开始时间不能大于结束时间');

        if(strlen($data_array['useDate']) != 10)
            $this->request_err(null,'年月日格式错误 YY-mm-dd');
        if(strlen($data_array['useBeginTime']) != 5)
            $this->request_err(null,'开始时间格式错误');
        if(strlen($data_array['useEndTime']) != 5)
            $this->request_err(null,'结束时间格式错误');
        if(time() > strtotime($data_array['useDate']." ".$data_array['useBeginTime']))
            $this->request_err(null,'不能查询以前的时间');
    }


    /**
     * 获取需求列表
     *
     */
    public function get_need_list(){
        $this->check_user();

        if($cid = $this->input->post('cid'))
        {
            $result = $this->db->select('needList')->where('cid',$cid)->get('conference_room')->row_array();

            $this->request_success(json_decode($result['needList']));
        }else{
            $result = $this->db->select('value')->where('configKey','needList')->get('config')->row_array();
            $this->request_success(unserialize($result['value']));
        }

    }

    /**
     * 添加一项新的会议室设备
     *
     */
    public function add_need()
    {
        $this->check_user();

        $new_need = $this->input->post('need');

        if(empty($new_need)) $this->request_err(null,lang('hint_enter_new_need'));

        $new_need = str_replace(',',"，",str_replace(' ','',$new_need));

        $result = $this->db->select('value')->where('configKey','needList')->get('config')->row_array();

        $need_list_array = unserialize($result['value']);

        if(!is_array($need_list_array))
        {
            $this->request_err(null,lang('hint_need_list_is_not_an_array'));
        }
        $need_list_array[] = $new_need;

        $update_result = $this->db->update('config',array('value'=>serialize($need_list_array)),array('configKey'=>'needList'));

        if(!$update_result)
        {
            $this->request_err(null,lang('hint_network_unavaliable'));
        }

        $this->request_success($need_list_array,lang('hint_new_need_update_successfully'));

    }

    public function delete_need()
    {
        $need = $this->input->post('need');

        if(empty($need)) $this->request_err(null,lang('hint_enter_delete_need'));

        $result = $this->db->select('value')->where('configKey','needList')->get('config')->row_array();

        $need_list_array = unserialize($result['value']);

        $find_sth_to_delete = false;

        foreach ($need_list_array as $index=>$each_need)
        {
            if($each_need === $need)
            {
                $find_sth_to_delete = true;
                array_splice($need_list_array,$index,1);
                break;
            }
        }

        if(!$find_sth_to_delete)
        {
            $this->request_err(null,lang('hint_no_such_need'));
        }

        $retult = $this->db->update('config',array('value'=>serialize($need_list_array)),array('configKey'=>'needList'));

        if(!$result)
        {
            $this->request_err(null,lang('hint_network_unavaliable'));
        }

        $this->request_success($need_list_array,lang('hint_need_delete_successfully'));
    }
}