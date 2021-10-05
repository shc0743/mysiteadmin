<?php
function WriteLog($data){
    $fp=fopen("runtime.log.php","a");
    fwrite($fp,$data."\n");
    fclose($fp);
}
function deny(){
    header("HTTP/1.1 403 Forbidden");die();
}
function CatFileLine($filename,$lines){
    if(!file_exists($filename)) return false;
    $fp=fopen($filename,"r");//$fpc=fopen($filename.".change","r");
    for($i=0;$i<$lines;$i++){
        if(!fgets($fp)) break;
    }
    fclose($fp);
    return true;
}
function randStr($len,$hex = false){
    $str="0123456789abcdef";$res="";
    if(!$hex) $str=$str."ghijklmnopqrstuvwxyz";
    $l = strlen($str);
    for($i = 0;$i < $len;$i++)
        $res = $res . $str[rand()%$l];
    return $res;
}
define("SESSION_MAX",32767);
define("SESSION_LENGTH",63);
