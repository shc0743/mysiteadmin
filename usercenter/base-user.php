<?php
require_once("base.php");
require_once("base-session.php");
function GetUserAuthor($n){
    if(!file_exists("../userdata/".$n.".php")) return 0;
    $fp=fopen("../userdata/".$n.".php","r");
    fgets($fp);fgets($fp);fgets($fp);
    $au=fgets($fp);
    fclose($fp);
    return $au;
}
function GetUserEnable($u){
    if(!file_exists("../userdata/".$u.".php")) return false;
    $fp=fopen("../userdata/".$u.".php","r");
    fgets($fp);fgets($fp);fgets($fp);fgets($fp);
    $r = fgets($fp);
    $r=str_replace("\r","",$r);
    $r=str_replace("\n","",$r);
    fclose($fp);
    WriteLog("function=GetUserEnable u=$u r=".$r);
    return !($r == "disabled" || $r == "0" || $r == "false");
}
