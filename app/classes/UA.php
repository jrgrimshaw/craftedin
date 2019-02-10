<?php
class UA {
    protected $api = 'http://useragentstring.com/?getJSON=all&uas=%s';
    protected $properties = [];

    public function __get($key) {
        if(isset($this->properties[$key])) {
            return $this->properties[$key];
        }

        return null;
    }

    public function request($ua = null) {
        $ua = urlencode($ua); // took me 45 mins to know i needed to add this
        $url = sprintf($this->api, $ua);
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
