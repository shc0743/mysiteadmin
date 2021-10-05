<?php
require_once("base.php");
require_once("base-session.php");
require_once("base-user.php");
require_once("base-values.php");
if(!(isset($_COOKIE["SiteAdminSession"])&&isset($_COOKIE["SiteAdminUser"]))){
    header("Location: logon.php");die();
}
if(!CheckSession($_COOKIE["SiteAdminUser"],$_COOKIE["SiteAdminSession"])){
    header("Location: logon.php");die();
}
