<?php
require_once("base-values.php");
if(!(isset($_COOKIE["SiteAdminSession"])&&isset($_COOKIE["SiteAdminUser"]))){
    header("Location: logon.php");die();
}
if(!CheckSession($_COOKIE["SiteAdminUser"],$_COOKIE["SiteAdminSession"])){
    header("Location: logon.php");die();
}
if($user_name=="guest") deny();
if(!empty($_POST["old"])){
    if(empty($_POST["pwd"])||empty($_POST["pw2"])||$_POST["pwd"]!=$_POST["pw2"]){
        header("Location: changepwd.php?err_pwd=e");die();
    }
    if(!CanItLogIn($user_name,$_POST["old"])){
        header("Location: changepwd.php?failbit=t");die();
    }
    ChangePwd($user_name,$_POST["pwd"]);
    header("Location: ./?finish=更改密码");die();
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
    </style>
</head>

<body>
    <form name=logbox action="" method=POST>
        <h1>更改密码</h1>
        <label for=u>用户名 <input value="<?php echo $user_name; ?>" id=u name=u readonly></label><br>
        <label for=old>旧密码   <input type=password id=old name=old></label><br>
        <label for=pwd>新密码   <input type=password id=pwd name=pwd></label><br>
        <label for=pw2>确认密码 <input type=password id=pw2 name=pw2></label><br>
        <div style="color:white;background:red;margin:5px;border-radius:5px;"><?php
         if(!empty($_REQUEST["failbit"])) echo "密码错误。"; if(!empty($_REQUEST["err_pwd"])) echo "密码不一致。";
         ?></div>
        <button type=submit style="background:orange;font-size:20px">确认更改</button>
    </form>
    <?php
        if(!empty($_REQUEST["failbit"])||!empty($_REQUEST["err_pwd"])) echo "<script>history.replaceState('','','changepwd.php')</script>"; 
    ?>
</body>

</html>