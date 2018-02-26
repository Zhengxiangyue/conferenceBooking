<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists(''))
{
    function ali_get_register_verify_code($mobile,$code){
        
        include_once dirname(__FILE__)."/ali_mobile/TopSdk.php";        
        
        $appkey='23358189';
        $secret='c7d2d82a3570d26d921009ebe52ec26a';
        $resp =  new ResultSet();
        $c=new TopClient;
        $c->appkey=$appkey;
        $c->secretKey=$secret;
        
        $req=new AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");//短信类型，传入值请填写normal
        $req->setSmsFreeSignName("注册验证");
        $req->setSmsTemplateCode("SMS_25670017");//短信模板ID
        
        $req->setSmsParam("{\"code\":\"".$code."\",\"product\":\"会议室预约系统\"}");
        $req->setRecNum($mobile);
        $resp = $c->execute($req);
        $respObj=json_decode($resp);
        
        $return_msg="{\"register_state\":\"register_code\",\"code\":\"".$code."\"}";
        return $resp;
    }
    
    function api_get_changepwd_verify_code($mobile,$code){
        
        include_once dirname(__FILE__)."/ali_mobile/TopSdk.php";
        
        $appkey='23358189';
        $secret='c7d2d82a3570d26d921009ebe52ec26a';
        $resp =  new ResultSet();
        $c=new TopClient;
        $c->appkey=$appkey;
        $c->secretKey=$secret;
        
        $req=new AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");//短信类型，传入值请填写normal
        $req->setSmsFreeSignName("变更验证");
        $req->setSmsTemplateCode("SMS_8745004");//短信模板ID
        
        $req->setSmsParam("{\"code\":\"".$code."\",\"product\":\"会议室预约系统\"}");
        $req->setRecNum($mobile);
        $resp = $c->execute($req);
        $respObj=json_decode($resp);
        
        $return_msg="{\"register_state\":\"register_code\",\"code\":\"".$code."\"}";
        return $resp;
    }
}

?>