<?php
require_once("base.php");
require_once("base-session.php");
function GetUserAuthor($n){
    if(!file_exists("../../userdata/".$n.".php")) return 0;
    if(!CheckSession($n,GetSessionId())) return 0;
    $fp=fopen("../../userdata/".$n.".php","r");
    fgets($fp);fgets($fp);fgets($fp);
    $au=(int)fgets($fp);
    //WriteLog("function=GetUserAuthor au=".$au);
    fclose($fp);
    return (int)$au;
}
