<?php
if(!empty($_GET["create"])) {header("Location:create.php");die();}
require_once("../../base-values.php");
if(!empty($_GET["access"])&&$_GET["access"]=="o5"){
    header("Location:pass.php");die();
}
?>