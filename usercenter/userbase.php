<?php
require_once("base-values.php");
if(GetUserAuthor($user_name)<5){
    header("HTTP/1.1 403 Forbidden");die();
}
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <title>用户管理中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>
    <style>
    *[disabled]{
        cursor: not-allowed !important;
    }
    li{
        margin: 10px;
        border: 1px solid #cccccc;
    }
    .pwd{
        cursor: not-allowed;
    }
    .pwd:hover::after{
        content: "In order to protect the user's privacy, it has been encrypted.";
        background: orange;
        color: red;
        cursor: help;
    }
    .pwd::selection{
        color: #fff;
        background: rgb(254,254,254);
    }
    button{
        cursor: pointer;
    }
    .conf::after{
        content: "以管理员身份管理";
    }
    .conf:hover::after{
        content: "去管理!";
        color: blue;
    }
    a[href]{
        color: blue;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <h1>用户管理中心</h1>
    <a href="../?finish=返回">&lt; 返回</a>
    <div>用户列表<br>
    <ul>
    <?php
{
    $tmp=scandir("../userdata/");
    foreach($tmp as $i){
        if(is_dir($i)) continue;
        $n="../userdata/".$i;
        $fp=fopen($n,"r");
        fgets($fp);fgets($fp);
        echo "        <li>用户名: ".str_replace(".php","",$i).
        "<br>密码: <span class=pwd>********</span><div>".
        "SHA256: <span class=pwd>".fgets($fp)."</span>"
        ."</div>\n权限等级: ";echo fgets($fp),"<br>管理: <button class=conf onclick=\"".
        "location.href='userconfig.php?name=".str_replace(".php","",$i),"'\"></button></li>";
        fclose($fp);
    }
}
    ?>
        <li>
            <form action="useradd.php" method=POST>
                <label for=add_n>用户名: <input type=text name=add_n id=add_n required></label><br>
                <label for=add_p>密码: <input type=password name=add_p id=add_p required></label><br>
                <label for=add_l>权限等级: <input type=number name=add_l id=add_l required min=0 max=5 step=1></label><br>
                <button type=submit>添加用户</button>
            </form>
        </li>
    </ul></div>
</body>

</html>