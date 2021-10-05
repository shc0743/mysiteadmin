<?php
require_once("base-values.php");
function UserRename($old,$new){
    if($old==$new) return;
    rename("../userdata/".$old.".php","../userdata/".$new.".php");
}
function UserChangeAuthor($n,$auth){
    if($auth>5) $auth=5;
    if($auth<0) $auth=0;
    $fp=fopen("../userdata/".$n.".php",'r+');
    fgets($fp);fgets($fp);fgets($fp);
    fwrite($fp,((int)$auth).'');
    fwrite($fp,"\n");
    fclose($fp);
}
if(GetUserAuthor($user_name)<5){
    header("HTTP/1.1 403 Forbidden");die();
}
if(empty($_POST['old_name'])||empty($_POST['new_name'])){
    header("HTTP/1.1 400 Bad Request");die();
}
$old_name=$_POST['old_name'];$name=$_POST['new_name'];
if($old_name!=$name) UserRename($old_name,$name);
UserChangeAuthor($name,(int)$_POST['auth_val']);
header("HTTP/1.1 204 No Content");
exit(0);
