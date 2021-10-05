<?php
require_once("base-session.php");
require_once("base-values.php");
if($is_logon) {
    $res=LogOut($user_name,$SessionId);
    $fp=fopen("runtime.log.php",'a');
    fwrite($fp, "function=LogOut name=".$user_name." result=".(string)$res."\n");
    fclose($fp);
}
header("Location: index.php");