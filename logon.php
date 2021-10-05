<?php
require_once("base-session.php");
require_once("base-values.php");
if($is_logon) {header("Location: index.php");die();}
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>
    <style>
    form[name=logbox]{
        margin-top: 40px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        position: absolute;
        padding: 0;
        z-index: 3;
        margin: 0 auto;
        border: 1px solid #ccc;
        width: 50%;
        box-shadow: 10px 10px 0px 0px rgba(0,0,0,0.3);
    }
    form[name=logbox] button{
        margin-top: 10px;
        margin-bottom: 8px;
        margin-left: 2%;
        width: 96%;
    }
    form[name=logbox] input{
        width: 60%;
    }
    *[disabled]{
        cursor: not-allowed !important;
    }
    </style>
</head>

<body>
    <form name=logbox action="logchk.php" method=POST>
        <h1>登录</h1>
        <label for=user>账号 <input id=user name=user autofocus></label><br>
        <label for=pwd>密码 <input type=password id=pwd name=pwd></label><br>
        <div style="color:white;background:red;margin:5px;border-radius:5px;"><?php if(!empty($_REQUEST["failbit"])) echo "账号或密码错误。"; ?></div>
        <button type=submit style="background:orange;font-size:20px">登录</button> 
        <button type=submit onclick="user.value=pwd.value='guest'">Guest登录</button> 
    </form>
    <?php if(!empty($_REQUEST["failbit"])) echo "<script>history.replaceState('','','logon.php')</script>"; ?>
</body>

</html>