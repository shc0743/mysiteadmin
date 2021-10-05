<?php
require_once("base-values.php");
if(GetUserAuthor($user_name)<5){
    header("HTTP/1.1 403 Forbidden");die();
}
if(empty($_POST["add_n"])||empty($_POST["add_p"])||empty($_POST["add_l"])){
    header("Location: userbase.php");die();
}
if(file_exists("../userdata/".$_POST["add_n"].".php")){
    header("Location: ../?error=用户已存在");die();
}
$fp=fopen("../userdata/".$_POST["add_n"].".php","w");
fwrite($fp,"<?php \ndie(); ?>\n");
fwrite($fp,hash("sha256",$_POST["add_p"])."\n");
fwrite($fp,$_POST["add_l"]."\n");
fclose($fp);
header("Location: userbase.php");die();
