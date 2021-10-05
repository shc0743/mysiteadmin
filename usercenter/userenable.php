<?php
require_once("base-values.php");
if(GetUserAuthor($user_name)<5){
    header("HTTP/1.1 403 Forbidden");die();
}
if(empty($_POST['name'])||empty($_POST['enable'])){
    header("HTTP/1.1 400 Bad Request");die();
}
function UserEnable($u,$enable){
    $fp=fopen("../userdata/".$u.".php",'r+');
    fgets($fp);fgets($fp);fgets($fp);fgets($fp);
    fwrite($fp,$enable?"1":"0");
    fclose($fp);
}
UserEnable($_POST['name'],$_POST['enable']!='false');
header("HTTP/1.1 204 No Content");
exit(0);