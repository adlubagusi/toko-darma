<?php
class Rajaongkir{
    private $api_url      = "https://api.rajaongkir.com/";
    private $api_key      = "22046e247c6404880324f7667c668bd6";
    private $account_type = "starter";
    
    function post($params,$api_key,$endpoint) {
        $curl = curl_init();
        $header[] = "Content-Type: application/x-www-form-urlencoded";
        $header[] = "key: $api_key";
        $query = http_build_query($params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $this->api_url . "" . $this->account_type . "/" . $endpoint);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $request = curl_exec($curl);
        $return = ($request === FALSE) ? curl_error($curl) : $request;
        curl_close($curl);
        return $return;
    }
    function get($params,$api_key,$endpoint) {
        $curl = curl_init();
        $header[] = "key: $api_key";
        $query = http_build_query($params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $this->api_url . "" . $this->account_type . "/" . $endpoint . "?" . $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $request = curl_exec($curl);
        $return = ($request === FALSE) ? curl_error($curl) : $request;
        curl_close($curl);
        return $return;
    }
    function province($province_id = NULL) {
        $params = (is_null($province_id)) ? array() : array('id' => $province_id);
        return $this->get($params,$this->api_key,'province');
    }
    function city($province_id = NULL, $city_id = NULL) {
        $params = (is_null($province_id)) ? array() : array('province' => $province_id);
        if (!is_null($city_id)) {
            $params['id'] = $city_id;
        }
        return $this->get($params,$this->api_key,'city');
    }
    function cost($origin, $destination, $weight, $courier) {
        $params = array(
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        );
        return $this->post($params,$this->api_key,'cost');
    }
}
