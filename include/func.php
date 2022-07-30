<?php
function textToLink($text='') {
    $text = trim($text);
    if (empty($text)) return '';
    $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
    $text = strtolower(trim($text));
    $text = str_replace(' ', '-', $text);
    $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
    return $text;
}

function string2Number($cString){
    return str_replace(",","",$cString) ;
}
  
function number2String($nNumber,$nDecimals=0){
    $nNumber = floatval(string2Number($nNumber)) ;
    return number_format($nNumber,$nDecimals,",",".") ;
}
function clean($char){
    $char = str_replace("'","`",$char);
    return $char;
}
