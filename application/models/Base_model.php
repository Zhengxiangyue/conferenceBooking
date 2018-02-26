<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 14/2/2017
 * Time: 3:30 PM
 */

class Base_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public function model_success($ret){
        return array('success'=>true,'ret'=>$ret);
    }

    /**
     * @param $ret
     * @return array
     */
    public function model_err($ret,$code = -1){
        return array('success'=>false,'ret'=>$ret,'code'=>$code);
    }

}