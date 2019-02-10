<?php
class Geo {
    protected $api = 'http://api.ipinfodb.com/v3/ip-city/?key=YOUR_KEY_HERE&format=json&ip=%s';
    protected $properties = [];

    public function __get($key) {
        if(isset($this->properties[$key])) {
            return ucwords(strtolower($this->properties[$key]));
        }

        return null;
    }

    public function request($ip = null) {
        $url = sprintf($this->api, $ip);
        $data = $this->sendRequest($url);

        $this->properties = json_decode($data, true);
    }

    public function sendRequest($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        return curl_exec($curl);
    }
}
