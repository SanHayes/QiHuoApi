<?php
namespace App;

function curlGetData($url) {
    $config = array();
    $arr = array(
        'file'=>'',
        'postname'=>'',
        'post' => false,
        'referer' => $url,
        'cookie' => '', 
        'useragent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 
        'connectout'=>3, 
        'timeout' => 10, 
        'return' => 1, 
        'proxy' => '', 
        'userpwd' => '', 
        'nobody' => false,
        'header'=>array(),
        'gzip'=>true,
        'ssl'=>false,
        'isupfile'=>false,
        'returnheader'=>false
    );
    $arr = array_merge($arr, $config);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,  $url);
    //参数为1表示传输数据，为0表示直接输出显示
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $arr['return']);
    curl_setopt($ch, CURLOPT_NOBODY, $arr['nobody']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $arr['useragent']);
    curl_setopt($ch, CURLOPT_REFERER, $arr['referer']);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $arr['connectout']);
    curl_setopt($ch, CURLOPT_TIMEOUT, $arr['timeout']);
    curl_setopt($ch, CURLOPT_HEADER, $arr['returnheader']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // 跳过检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 跳过检查
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/json; charset=utf-8',
    ));
    $output = curl_exec($ch);
    curl_close($ch); 
    return $output;
}
