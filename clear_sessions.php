<?php
require_once("base-values.php");
if( (!(isset($_COOKIE["SiteAdminSession"]))) || ( !isset($_COOKIE["SiteAdminSession"]) ) ){
    header("Location: ./"); die();
}
if(!CheckSession($user_name,GetSessionId())||GetUserAuthor($user_name)<5){
    deny();
}
$temp=scandir("sessions/");
foreach($temp as $v){
    unlink("sessions/".$v);
}
header("Location: ./?finish=ClearSessions");
