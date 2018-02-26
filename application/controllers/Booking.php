<?php
/**
 * Class User
 */
class Booking extends Base
{
    /**
     *
     */
    public function detail($bid = 0){
        if(empty($bid))
            $this->show_custom_404();
        $this->load->view('booking/detail',array('bid'=>$bid));
    }
}