<?php
require_once("base-values.php");
if(!(isset($_COOKIE["SiteAdminSession"])&&isset($_COOKIE["SiteAdminUser"]))){
    header("Location: logon.php");die();
}
if(!CheckSession($_COOKIE["SiteAdminUser"],$_COOKIE["SiteAdminSession"])){
    header("Location: logon.php");die();
}
if(GetUserAuthor($user_name)<5) deny();
if(empty($_GET["auth"])||$_GET["auth"]!="o5") {
    header("Location: changepwd.php");die();
}
if(!(empty($_POST["pwd"])||empty($_POST["u"]))){
    $n=$_POST["u"];$p=$_POST["pwd"];
    // $p=md5($_POST["pwd"]);
    // if(!file_exists("userdata/".$n.".php")) die("用户不存在");
    // $auth=GetUserAuthor($n);
    // unlink("sessions/".$n.".php");
    // $fp=fopen("userdata/".$n.".php","r+");
    // fgets($fp);fgets($fp);
    // fwrite($fp,$p."\n");
    // fwrite($fp,$auth."\n");
    // fclose($fp);
    // CatFileLine("userdata/".$n.".php",5);
    if(ChangePwd($n,$p)){
        header("Location: ./?finish=将".$n."的密码更改为:(SHA256)".hash("sha256", $p));
        die();
    } else {
        header("Location: ./?error=无法更改".$n."的密码");
        die();
    }
}
if(empty($_GET["user"])) {
    header("Location: ./");die();
}
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <title>更改密码</title>
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
    a{
        text-decoration: none;
        color: blue;
    }
    </style>
</head>

<body>
    <form name=logbox action="" method=POST>
        <h1>更改密码</h1><a href="usercenter/userbase.php">&lt;返回</a><br>
        <label for=u>用户名 <input value="<?php echo $_GET["user"]; ?>" id=u name=u readonly></label><br>
        <label for=pwd>新密码 <input type=password id=pwd name=pwd></label><br>
        <button type=submit style="background:orange;font-size:20px">确认更改</button>
    </form>
    <?php
        if(!empty($_REQUEST["failbit"])||!empty($_REQUEST["err_pwd"])) echo "<script>history.replaceState('','','changepwd.php')</script>"; 
    ?>
</body>

</html>