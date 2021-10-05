<?php
require_once("base-access.php");
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <title>站点管理器</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>
    <script src="dialog.js"></script>
    <style>
        a{
            color: blue;
            text-decoration: none;
        }
        a.lnk::after{
            content: attr(href);
        }
        #author_info{
            position: absolute;
            left: 0;
            top: 0;
            border: 1px solid #ccc;
            background-color: #fff;
            z-index: 2;
            cursor: help;
        }
        *[disabled]{
            cursor: not-allowed !important;
            color: #cccccc;
        }
        .msgs{
            background-color: green;
            opacity: 0.5;
            color: #fff;
        }
        .errs{
            background-color: red;
            opacity: 0.5;
            color: #fff;
        }
        #tos{
            width: 50%;
            height: 50%;
            overflow: auto;
        }
        .server_user_file_status_bar pre{
            <?php
            if(GetUserAuthor($user_name)<5) echo "color: #cccccc;\ncursor: not-allowed;";
            else echo "cursor: pointer;";
            ?>
        }
        .server_user_file_status_bar pre:hover{
            /*background-color: blue;*/
            <?php
            if(GetUserAuthor($user_name)==5) echo "background-color: #abcdef;\ncolor:#000;\ncursor: pointer;";
            ?>
        }
        .server_user_file_status_bar pre::after{
            content: ">>";
        }
    </style>
</head>

<body>
    <div class=msgs><?php if(!empty($_REQUEST["finish"])){
        echo "<script>history.replaceState('','','./')</script>";
        echo $_REQUEST["finish"]." 操作已完成。";
    } ?></div>
    <div class=errs><?php if(!empty($_REQUEST["error"])){
        echo "<script>history.replaceState('','','./')</script>";
        echo $_REQUEST["error"];
    } ?></div>
    <div id=not_allow_page style="position:fixed;left:0;top:0;width:100%;height:100%;
    cursor:not-allowed;z-index:6595652;background:#000;opacity:0;" 
    oncontextmenu="return false;" 
    onmousedown="this.style.opacity=parseFloat(this.style.opacity)+0.01;
    if(parseFloat(this.style.opacity)>1) this.style.opacity=0;" 
    ondblclick="this.style.opacity=parseFloat(this.style.opacity)+0.1;"
    onwheel="this.onmousedown()"
    hidden></div>
    <div id=tos hidden>
            <script>
            if(!localStorage.site_admin_agree_tos) {
                addEventListener('load',()=>{
                    CreateDialog(tos,1);
                    fetch("termsofservice.html")
                    .then((r)=>{return r.text()},()=>{3
                        document.getElementById("tos_cont").style.whiteSpace='pre';
                        fetch("termsofservice.txt")
                        .then((r)=>{return r.text()},(e)=>{
                            document.getElementById("tos_cont").innerHTML = '加载失败: '+String(e);
                        })
                        .then((r)=>{document.getElementById("tos_cont").innerHTML = r});
                    })
                    .then((r)=>{document.getElementById("tos_cont").innerHTML = r});
                });
            }
            if(localStorage.site_admin_agree_tos=='not') not_allow_page.hidden=0;
            </script>
            <span class=dialogtitle>服务条款</span>
            请认真阅读服务条款。<br>
            <div id=tos_cont style="width: 96%;margin: 2%;height: 60%;border: 1px solid #ccc;overflow: auto;">Loading...</div>
            <button onclick="localStorage.site_admin_agree_tos='accept';EndDialog(tos);">同意</button>
            <button onclick="localStorage.site_admin_agree_tos='not';EndDialog(tos);not_allow_page.hidden=0;" style="position:absolute;right:0;">拒绝</button>
    </div>
    <div>
        <h1>站点管理</h1>
        <div class=server_user_file_status_bar>服务器: <a href="http://<?php echo $_SERVER['SERVER_ADDR']; ?>" class=lnk></a> 
        <pre style="display:inline" class=server_user_file_status_user <?php
            if(GetUserAuthor($user_name)<5) echo "disabled";
            else echo 'onclick="location.href=\'changeinfo.php?change=user\'"';
        ?>></pre> 
        用户: <?php echo $_COOKIE["SiteAdminUser"] ?> 
        <pre style="display:inline" onclick="not_allow_page.hidden=0;"></pre>
        文件名: <?php if(GetUserAuthor($user_name)>3)echo __FILE__;else echo "***"; ?> 
        <a href='logout.php'>退出</a></div>
        <div id=author style="display:inline;cursor:help;"><br><small><?php
            echo $user_name.",您当前的<a href='help/level/'>权限等级</a>是: ".$AuthorLevel;
        ?></small><br></div>
        <div id=author_info hidden>作为LV<?php echo $AuthorLevel; ?>,你可以: <ul><?php
            $fp=fopen("help/level/".$AuthorLevel,"r");
            while($cnt=fgets($fp)) echo "<li>".$cnt."</li>";
            fclose($fp);
        ?></ul></div>
        <div style="border:1px solid #ccc;">
        主菜单
        <ul>
            <li><a href="/">主页</a></li>
            <li><a href="options/file.php?op=src" <?php if(GetUserAuthor($user_name)<2) echo "disabled"; ?>>查看文件源码</a></li>
            <li><a href="options/file.php?op=rwx" <?php if(GetUserAuthor($user_name)<4) echo "disabled"; ?>>文件操作</a></li>
            <li><a href="changeinfo.php?change=user" <?php if(GetUserAuthor($user_name)<5) echo "disabled"; ?>>账号管理...</a></li>
            <li><a href="view_log.php" <?php if(GetUserAuthor($user_name)<3) echo "disabled"; ?>>查看日志</a></li>
            <li><a href="view_log.php?unlink=lnk" <?php if(GetUserAuthor($user_name)<5) echo "disabled"; ?>>清除日志</a></li>
            <li><a href="options/sysinfo/?create=lv4" <?php if(GetUserAuthor($user_name)<4) echo "disabled"; ?>>发布系统通知</a></li>
            <li><a href="options/submit/?create=o0">提交操作申请</a></li>
            <li><a href="options/submit/?access=o5" <?php if(GetUserAuthor($user_name)<4) echo "disabled"; ?>>授权操作申请</a></li>
            <li><a href="clear_sessions.php?o=5" onclick="if(!confirm('确定吗?此操作将导致所有用户退出登录!!!')) return false;" 
            <?php if(GetUserAuthor($user_name)<5) echo "disabled"; ?>>清除站点session</a></li>
        </ul>
        </div><br>
        <div style="border:1px solid #ccc;">
        用户菜单
        <ul>
            <li><a href="changepwd.php">更改密码</a></li>
            <li><a href="logout.php">退出登录</a></li>
        </ul>
        </div>
    </div>
    <script>
        author.onmousemove=function(e){
            author_info.hidden=0;
        }
        document.documentElement.addEventListener("mousemove",(e)=>{
            if(author_info.hidden) return;
            var ai=document.querySelector("#author_info");
            ai.style.left=e.clientX+10+"px";
            ai.style.top =e.clientY+10+"px";
        });
        author.onmouseout=function(){
            author_info.hidden=1;
        }
        {
            let a=document.querySelectorAll("a");
            let al=a.length;
            for(let i=0;i<al;++i){
                if(a[i].getAttribute('disabled')) a[i].addEventListener('click',(e)=>{e.preventDefault()});
            }
        }
    </script>
</body>

</html>