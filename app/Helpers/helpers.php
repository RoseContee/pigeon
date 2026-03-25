<?php

if (!function_exists('getIP')) {
    /**
     * @return string
     */
    function getIP() {
        $ipaddress = null;
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
    }
}

if (!function_exists('getTimezone')) {
    function getTimezone() {
        $ip = getIP();
        try {
            $ch = curl_init("http://www.geoplugin.net/json.gp?ip=" . $ip);
            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER => [
                    "Accept: */*",
                    "X-Requested-With: XMLHttpRequest",
                ],
            ]);
            $content = curl_exec($ch);
            curl_close($ch);
            $geo_info = json_decode($content, true);
            return $geo_info['geoplugin_timezone'] ? $geo_info['geoplugin_timezone'] : 'Unknown';
        } catch (\Exception $e) {
        }
        return 'Unknown';
    }
}

if (!function_exists('convertTimezone')) {
    function convertTimezone($from, $to, $time, $date = null) {
        try {
            $new_time = date_create(($date ? $date.' ' : '').$time, ($from != 'Unknown' ? timezone_open($from) : null));
            date_timezone_set($new_time, ($to != 'Unknown' ? timezone_open($to) : null));
            return $new_time->format('Y-m-d h:i A');
        } catch (\Exception $e) {
            return ($date ? $date.' ' : '').$time;
        }
    }
}

if (!function_exists('timecmp')) {
    function timecmp($time1, $time2) {
        return strtotime($time1) - strtotime($time2);
    }
}