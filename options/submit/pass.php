<?php
    require_once("base-values.php");
    if(!CheckSession($_COOKIE["SiteAdminUser"],GetSessionId())||GetUserAuthor($_COOKIE["SiteAdminUser"])<4) deny();
    if(!empty($_GET["unlink"])){
        unlink("info/".$_GET["unlink"]);header("Location: ../../?finish=删除请求");die();
    }
    if(!empty($_GET["agree"])){
        rename("info/".$_GET["agree"],"info/pass/".$_GET["agree"]);header("Location: ../../?finish=同意请求");die();
    }
    if(!empty($_GET["deny"])){
        rename("info/".$_GET["deny"],"info/trunc/".$_GET["deny"]);header("Location: ../../?finish=拒绝请求");die();
    }
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <script src="../../dialog.js"></script>
    <title>查看请求</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>
    <style>
    [name=logbox]{
        margin-top: 40px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        position: absolute;
        padding: 0;
        z-index: 3;
        margin: 0 auto;
        border: 1px solid #ccc;
        width: 90%;
        box-shadow: 10px 10px 0px 0px rgba(0,0,0,0.3);
        height: 90%;
        overflow: auto;
    }
    [name=logbox] button{
        margin-top: 10px;
        margin-bottom: 8px;
        margin-left: 2%;
        width: 96%;
    }
    [name=logbox] input{
        width: 60%;
    }
    *[disabled]{
        cursor: not-allowed !important;
    }
    li{
        margin: 10px;
        border: 1px solid #ccc;
    }
    a{
        color: blue;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div name=logbox id=logbox style="border: 1px solid #ccc;" action method=POST>
        <h1>查看请求</h1>
        在此查看其他人对站点进行更改的请求。如果LV4同意，将被LV5实施。<br>
        <div>
        <a href="pass.php">未操作的请求</a> &nbsp; 
        <a href="pass.php?view=a">已通过的请求</a> &nbsp; 
        <a href="pass.php?view=d">已拒绝的请求</a>
        </div>
        <ul>
            <?php
                $temp=scandir("info");
                $nflag=true;
                if($_GET['view']){
                    $nflag=false;
                    if($_GET['view']=="a") $temp=scandir("info/pass");
                    if($_GET['view']=="d") $temp=scandir("info/trunc");
                }
                foreach($temp as $v){
                    $a='info/'.$v;
                    if($_GET['view']=="a") $a='info/pass/'.$v;
                    if($_GET['view']=="d") $a='info/trunc/'.$v;
                    if(is_dir($a)) continue;
                    echo "<li>请求文件名: ",$v,"<br>申请人: ";
                    $fp=fopen($a,"r");
                    fgets($fp);echo fgets($fp);
                    echo "<br>时间: ".fgets($fp)."<br>主题: ".fgets($fp)."<br>内容:\n<div style='white-space: pre'>";
                    while( $str=fgets($fp) ) {
                        echo $str;
                    }
                    if($nflag) echo "</div><br>
                    操作: <a href='pass.php?agree=".$v."'>同意</a> 
                    <a href='pass.php?deny=".$v."'>拒绝</a> 
                    <a href='pass.php?unlink=".$v."'>删除</a>";
                    else { 
                        if($_GET['view']=="a")echo "</div><a href='pass.php?unlink=pass/".$v."'>删除</a>";
                        if($_GET['view']=='d')echo "</div><a href='pass.php?unlink=trunc/".$v."'>删除</a>";
                    }
                    fclose($fp);
                }
            ?>

        </ul>
        <a href="../../?finish=返回">返回</a>
    </div>
    <script>
        //addEventListener('load',()=>{CreateDialog(logbox);logbox.style.left=logbox.style.top="50%"})
    </script>
</body>

</html>