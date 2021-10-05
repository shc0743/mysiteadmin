<?php
require_once("base.php");
function CheckSession($user_name,$id){
    if(!file_exists("../../sessions/".$user_name.".php")) return false;
    $fp=fopen("../../sessions/".$user_name.".php","r");
    fgets($fp);fgets($fp);
    $sesid=fgets($fp);
    fclose($fp);
    //WriteLog("function=CheckSession name=".$user_name." sesid=".$sesid." id=".$id."");
    if($sesid==$id) return true;
    return false;
}
function GetSessionId(){
    if(!isset($_COOKIE["SiteAdminSession"])) return 0;
    return $_COOKIE["SiteAdminSession"];
}
