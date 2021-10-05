<?php
function WriteLog($data){
    $fp=fopen("runtime.log.php","a");
    fwrite($fp,$data."\n");
    fclose($fp);
}
function deny(){
    header("HTTP/1.1 403 Forbidden");die();
}
