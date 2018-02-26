<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 27/2/2017
 * Time: 6:59 PM
 */

class Exhibit extends Base
{
    /**
     *
     */
    public function index($cid = 0){
        $this->load->view('exhibit/index',array('cid'=>16));
    }


    public function show($cid = 0){
        if(empty($cid)) $this->show_custom_404();
        $this->load->view('exhibit/index',array('cid'=>$cid));
    }

    public function language()
    {
//        $this->load->helper('language');
//

        var_dump(lang('hint_no_more_message'));
    }
}