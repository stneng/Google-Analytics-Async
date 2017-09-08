<?php
    if(!$_SERVER['HTTP_USER_AGENT']) {
        header("Content-type: text/html; charset=utf-8");
        die('UA Error');
    }
    if(!isset($_SERVER['HTTP_REFERER']) || !strstr($_SERVER['HTTP_REFERER'], '')){
    // You can set whitelist domain here.
        header("Content-type: text/html; charset=utf-8");
        die('Referrer Error');
    }

    $tid='';  //Your Google Analytics tid here,like UA-XXXX-Y
    
    function create_uuid(){
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $uuid;
    }
    
    if (!isset($_COOKIE["uuid"])) {
        $uuid=create_uuid();
        setcookie("uuid", $uuid , time()+368400000);
    }else{
        $uuid=$_COOKIE["uuid"];
    }
    
    if (function_exists("fastcgi_finish_request")) {
        fastcgi_finish_request();
    }
    
    $url='v=1&t=pageview&';
    $url.='tid='.$tid.'&';
    $url.='cid='.$uuid.'&';
    $url.='dl='.rawurlencode(rawurldecode($_SERVER['HTTP_REFERER'])).'&';
    $url.='uip='.rawurlencode(rawurldecode($_SERVER['REMOTE_ADDR'])).'&';
    $url.='ua='.rawurlencode(rawurldecode($_SERVER['HTTP_USER_AGENT'])).'&';
    $url.='dt='.rawurlencode(rawurldecode($_GET['dt'])).'&';
    $url.='dr='.rawurlencode(rawurldecode($_GET['dr'])).'&';
    $url.='ul='.rawurlencode(rawurldecode($_GET['ul'])).'&';
    $url.='sd='.rawurlencode(rawurldecode($_GET['sd'])).'&';
    $url.='sr='.rawurlencode(rawurldecode($_GET['sr'])).'&';
    $url.='vp='.rawurlencode(rawurldecode($_GET['vp'])).'&';
    $url.='z='.$_GET['z'];
    $url='https://www.google-analytics.com/collect?'.$url;
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    
?>