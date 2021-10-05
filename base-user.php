<?php
require_once("base.php");
require_once("base-session.php");
function CanItLogIn($n,$p){
    $p=hash("sha256", $p);
    if(!file_exists("userdata/".$n.".php")) return false;
    $fp=fopen("userdata/".$n.".php","r");
    fgets($fp);fgets($fp);
    $sesid=fgets($fp);
    $sesid=str_replace("\r","",$sesid);
    $sesid=str_replace("\n","",$sesid);
    fgets($fp);$enable=fgets($fp);
    $enable=str_replace("\r","",$enable);
    $enable=str_replace("\n","",$enable);
    fclose($fp);
    WriteLog("function=CanItLogIn name=".$n." sesid=".$sesid." enable=".$enable." p=".$p);
    if ($sesid == $p && (!($enable == "disabled" || $enable == "0" || $enable == "false"))) {
        return true;
    }
    return false;
}
function LogIn($n,$p){
    if(CanItLogIn($n,$p)){
        srand(rand());
        UpdateSession($n,randStr(SESSION_LENGTH));
        return true;
    }
    return false;
}
function LogOut($n){
    RemoveSession($n);
    return true;
}
function GetUserAuthor($n){
    if(!file_exists("userdata/".$n.".php")) return 0;
    $fp=fopen("userdata/".$n.".php","r");
    fgets($fp);fgets($fp);fgets($fp);
    $au=(int)fgets($fp);
    //WriteLog("function=GetUserAuthor au=".$au);
    fclose($fp);
    return (int)$au;
}
function GetUserEnable($u){
    if(!file_exists("userdata/".$u.".php")) return 0;
    $fp=fopen("userdata/".$u.".php","r");
    fgets($fp);fgets($fp);fgets($fp);fgets($fp);
    $r = fgets($fp);
    $r=str_replace("\r","",$r);
    $r=str_replace("\n","",$r);
    fclose($fp);
    WriteLog("function=GetUserEnable $r=".$r);
    return !($r == "disabled" || $r == "0" || $r == "false");
}
function ChangePwd($n,$p){
    $p=hash("sha256", $p);
    if(!file_exists("userdata/".$n.".php")) return false;
    $auth=GetUserAuthor($n);
    WriteLog("function=ChangePwd auth=".$auth." p=$p");
    LogOut($n);
    //return;
    $fp=fopen("userdata/".$n.".php","r+");
    fgets($fp);fgets($fp);
    fwrite($fp,$p."\n");
    fwrite($fp,$auth."\n");
    fclose($fp);
    // CatFileLine("userdata/".$n.".php",5);
    return true;
}
