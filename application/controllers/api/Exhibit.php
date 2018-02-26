<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 27/2/2017
 * Time: 7:54 PM
 */

class Exhibit extends Base
{

    /**
     * Booking constructor.
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('exhibit_model');

    }

    public function index(){
        $ret = $this->exhibit_model->get_room_detail($this->input->post('cid'));

        $this->request_success($ret['ret']);

    }

}