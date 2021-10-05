<?php
    require_once("base-values.php");
    if(!CheckSession($_COOKIE["SiteAdminUser"],GetSessionId())||!isset($_COOKIE["SiteAdminUser"])) deny();
    if(!(empty($_POST["n"])||empty($_POST["ct"]))){
        srand(rand());
        $fp=fopen("info/".$_COOKIE["SiteAdminUser"].time()%rand().".php","w");
        fwrite($fp,"<?php die(); ?>\n");
        fwrite($fp,$_COOKIE["SiteAdminUser"]."\n");
        fwrite($fp,date("Y-m-d H:m:s")."\n");
        fwrite($fp,$_POST["n"]."\n");
        fwrite($fp,$_POST["ct"]);
        fclose($fp);
        header("Location: ../../index.php?finish=submit");die();
    }
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <title>创建请求</title>
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
    <form name=logbox action method=POST>
        <h1>创建请求</h1>
        在此创建您对站点进行更改的请求。如果LV4同意，将被LV5实施。<br>
        <label for=n>主题 <input required id=n name=n></label><br>
        <label for=ct>描述<br><textarea required style="width: 80%;margin-left: 10%;" rows=12 id=ct name=ct></textarea></label><br>
        <button type=submit style="background:orange;font-size:20px">提交</button> 
    </form>
</body>

</html>