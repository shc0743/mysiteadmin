<?php
require_once("base.php");
require_once("base-session.php");
require_once("base-user.php");
$is_logon=isset($_COOKIE["SiteAdminSession"])&&isset($_COOKIE["SiteAdminUser"]);
if($is_logon) $is_logon=CheckSession($_COOKIE["SiteAdminUser"],$_COOKIE["SiteAdminSession"]);
if($is_logon) {
$user_name=$_COOKIE["SiteAdminUser"];
$SessionId=GetSessionId();
$AuthorLevel=GetUserAuthor($user_name);
}
