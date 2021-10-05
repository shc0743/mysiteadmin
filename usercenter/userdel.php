<?php
require_once("base-values.php");
if(GetUserAuthor($user_name)<5){
    header("HTTP/1.1 403 Forbidden");die();
}
if(empty($_GET['u'])){
    header("HTTP/1.1 400 Bad Request");die();
}
unlink("../userdata/".$_GET['u'].'.php');
header("Location: ../?finish=删除".$_GET['u']);
exit(0);
