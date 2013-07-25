<?php
 
include "q2.php";
 
class qq {
 
    public $sid;
    public $http;
    public $qq_num;
 
    function __construct() {
        $this->http = new http_no_cookie;
    }
 
    function login($qq_num, $qq_pwd) {
       echo  $data = $this->http->get("http://pt.3g.qq.com/");
        $action = preg_match("/action=\"(.+)?\"/", $data, $matches);
        $action = $matches[1];
        $params = array();
        $params["login_url"] = "http://pt.3g.qq.com/s?aid=nLogin";
        $params["sidtype"] = 1;
        $params["loginTitle"] = "手机腾讯网";
        $params["bid"] = 0;
        $params["qq"] = $qq_num;
        $params["pwd"] = $qq_pwd;
        $params["loginType"] =1;
        echo $data = $this->http->post($action, http_build_query($params));
        if(preg_match("/http:\/\/vc.gtimg.com\//",$data,$matches)){
            echo "需要输入验证码";
            return 0;
            exit;
        }
 
        if(preg_match("/密码错误/",$data,$matches)){
            echo "密码错误";
            return 1;
            exit;
        }
        $action = preg_match("/sid=(.+?)&/", $data, $matches);
        $this->sid = $matches[1];
        return $this->sid;
    }
 
    function sendMsg($to_num, $msg, $sid = 0) {
        $sid = $sid ? $sid : $this->sid;
        if (!$sid)
            exit("sid值未传入进去");
        $params = array();
        $params["msg"] = $msg;
        $params["u"] = $to_num;
        $params["saveURL"] = 0;
        $params["do"] = "send";
        $params["on"] = 1;
        $params["aid"] = "发送";
        $url = "http://q16.3g.qq.com/g/s?sid=" . $sid;
        echo $data = $this->http->post($url, http_build_query($params));
        return $data;
    }
 
    function getMsg($qq_num = 0, $sid = 0) {
        $qq_num = $qq_num ? $qq_num : $this->qq_num;
        if (!$qq_num)
            exit("qq_num值未传入进去");
        $sid = $sid ? $sid : $this->sid;
        if (!$sid)
            exit("sid值未传入进去");
        $url = "http://q16.3g.qq.com/g/s?sid=" . $sid . "&3G_UIN=" . $qq_num . "&saveURL=0&aid=nqqChat";
        $data = $this->http->get($url);
        preg_match("/name=\"u\" value=\"(\d+)\"/", $data, $matches);
        $result["qq"] = $matches[1];
        $data = explode("<form", $data);
        $data = $data[0];
        preg_match_all("/<p>(.+)?<\/p>/", $data, $matches);
        unset($matches[1][0]);
        $result["content"] = $matches[1];
        return $result;
    }
    function logout($sid){
        $url="http://pt.3g.qq.com/s?sid=".$sid."&aid=nLogout";
        echo $url;
        echo $this->http->get($url);
    }
    function getFriendsList($qq_num = 0, $sid = 0){
        $result=array();
 
        $qq_num = $qq_num ? $qq_num : $this->qq_num;
        if (!$qq_num)
            exit("qq_num值未传入进去");
        $sid = $sid ? $sid : $this->sid;
        if (!$sid)
            exit("sid值未传入进去");
        $url="http://q16.3g.qq.com/g/s?aid=nqqchatMain&sid=".$sid."&myqq=".$qq_num;
        while(true){
        $i=1;
        $url.="&p=".$i;
        $data=$this->http->get($url);
        preg_match_all("/u=(.+?)&/",$data,$matches);
        foreach($matches[1] as $key=>$value){
            $result[]=$value;
        }
        if(count($matches[1])<13)
            break;
        $i++;
       }
       return $result;
    }
}

?>