<?php
require_once("base-session.php");
require_once("base-user.php");
if(empty($_POST["user"])||empty($_POST["pwd"])){header("Location: logon.php");die();}
if(LogIn($_POST["user"],$_POST["pwd"])){
    header("Location: ./");die();
} else {
    header("Location: logon.php?failbit=1");die();
}
?>
