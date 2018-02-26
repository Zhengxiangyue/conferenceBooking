<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 17/2/2017
 * Time: 11:32 PM
 */

class Develop extends Base{
    public function delete_template_room_image(){


        $room_path = UPLOAD_PATH."room/";

        var_dump(rmdir($room_path));die;

        $db_data = $this->db->select('images')->get('conference_room')->result_array();
        $using_img =array();
        foreach ($db_data as $images_str){
            $images = explode(',',$images_str['images']);
            foreach ($images as $image){
                $file_name_arr = explode('/',$image);
                $using_img[] = $file_name_arr[sizeof($file_name_arr)-1];
            }
        }

        var_dump($using_img);die;

        foreach (scandir($room_path) as $room_child){
            if(is_dir($room_path.$room_child)){

            }else{
                var_dump(unlink($room_path.$room_child));
            }
        }
    }

    public function scan_and_delete($dir,$file_name){

    }

    public function show_environment(){
        phpinfo();
    }

    public function setting()
    {
        echo serialize(array('投影仪','激光笔'));
    }
}