<?php
require_once("base-access.php");
if(!empty($_REQUEST["unlink"])){
    if(GetUserAuthor($user_name)!=5){
        header("HTTP/1.1 403 Forbidden");die();
    };
    $fp=fopen("runtime.log.php","w");
    fwrite($fp,"<?php\ndie();\n?>\n");
    fclose($fp);
    header("HTTP/1.1 204 No Content");
    exit(0);
}
if(GetUserAuthor($user_name)<3){
    header("HTTP/1.1 403 Forbidden");die();
};
header("Content-Type: text/plain");
$fp=fopen("runtime.log.php","r");
fgets($fp);fgets($fp);fgets($fp);
while($str=fgets($fp)){
    echo $str;
}
fclose($fp);
