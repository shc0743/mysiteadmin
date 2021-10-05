<?php
require_once("base.php");
function CheckSession($user_name,$id){
    if(!file_exists("sessions/".$user_name.".php")) return false;
    $fp=fopen("sessions/".$user_name.".php","r");
    fgets($fp);fgets($fp);
    $sesid=fgets($fp);
    fclose($fp);
    //WriteLog("function=CheckSession name=".$user_name." sesid=".$sesid." id=".$id."");
    if($sesid==$id) return true;
    return false;
}
function UpdateSession($user_name,$id){
    $fp=fopen("sessions/".$user_name.".php","w");
    fwrite($fp,"<?php\ndie(0);\n");
    fwrite($fp,$id);
    fclose($fp);
    setcookie("SiteAdminSession",$id,time()+60*60*24*15,"/","",false,true);
    setcookie("SiteAdminUser",$user_name,time()+60*60*24*15,"/","",false,true);
}
function RemoveSession($user_name){
    unlink("sessions/".$user_name.".php");
    if($user_name==$_COOKIE["SiteAdminUser"]){
        setcookie("SiteAdminSession",'',-1,"/","",false,true);
        setcookie("SiteAdminUser",'',-1,"/","",false,true);
    }
}
function GetSessionId(){
    if(!isset($_COOKIE["SiteAdminSession"])) return 0;
    return $_COOKIE["SiteAdminSession"];
}
