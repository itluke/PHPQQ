<?php
 
class http_no_cookie {
 
    private $curl;
    public $user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.29 Safari/525.13";
 
    public function get($url) {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($this->curl);
        curl_close($this->curl);
        return $data;
    }
 
    public function post($url, $params) {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($this->curl);
        curl_close($this->curl);
        return $data;
    }
 
}
 
?>