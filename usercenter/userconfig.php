<?php
require_once("base-values.php");
if (GetUserAuthor($user_name) < 5) {
    header("HTTP/1.1 403 Forbidden");
    die();
}
if (empty($_GET["name"])) {
    header("Location: userbase.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="utf-8" />
    <script src="../vue.js"></script>
    <title><?php echo $_GET["name"]; ?> - 用户管理中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    </script>
    <style>
        *[disabled] {
            cursor: not-allowed !important;
        }

        li {
            margin: 10px;
            border: 1px solid #cccccc;
        }

        .pwd {
            cursor: not-allowed;
        }

        .pwd:hover::after {
            content: "In order to protect the user's privacy, it has been encrypted.";
            background: orange;
            color: red;
            cursor: help;
        }

        .pwd::selection {
            color: #fff;
            background: rgb(254, 254, 254);
        }

        button {
            cursor: pointer;
        }

        .conf::after {
            content: "以管理员身份管理";
        }

        .conf:hover::after {
            content: "去管理!";
            color: blue;
        }

        body div {
            border: 1px solid #cccccc;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        #msges {
            position: fixed;
            left: 50%;
            top: 10px;
            transform: translate(-50%, -50%);
            z-index: 233;
            width: 50%;
        }

        #success_msg,
        #error_msg {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0.95;
            margin: 0 auto;
        }

        #success_msg {
            background: #00cc00;
        }

        #error_msg {
            background: #cc0000;
        }

        label {
            cursor: pointer;
        }

        @keyframes msg_text_move {
            0% {
                top: -10000px;
            }

            5% {
                top: 0;
            }

            90% {
                top: 0;
            }

            100% {
                top: -10000px;
            }
        }

        .msg_text {
            position: fixed;
            top: -10000px;
            animation: msg_text_move 4s 1;
        }
    </style>
</head>

<body>
    <div id=app style="border: 0">
        <span id=msges>
            <span id=success_msg></span>
            <span id=error_msg></span>
        </span>
        <h1><?php echo $_GET["name"]; ?> - 用户管理中心</h1>
        <a href="userbase.php">&lt; 返回</a>
        <div><?php echo $_GET["name"]; ?>的基本信息<br>
            用户名: <input value=<?php echo $_GET["name"]; ?> id=user_name><br>
            密码: <a href="../force_change_passwd.php?user=<?php echo $_GET["name"]; ?>&auth=o5">更改</a><br>
            权限等级: <input value=<?php echo GetUserAuthor($_GET["name"]); ?> id=auth_val type=number min=0 max=5><br>
            <button id=sch>确认更改</button> <button onclick='location.reload()'>撤销更改</button><br>
            <div id=result style="margin:10px">在此显示结果。</div>
        </div><br>
        <div>
            <?php echo $_GET["name"]; ?>的高级操作<br>
            <label for=dis_><input type=checkbox id=dis_ name=dis_ <?php
            if (GetUserEnable($_GET["name"])) echo 'checked';
            ?>> 启用此账号</label><br>
        </div><br>
        <div><span style="color:red"><?php echo $_GET["name"]; ?>的危险操作</span><br>
            <button style="color:red" onclick="if(confirm('真的要删除<?php echo $_GET['name']; ?>?此操作不可逆!!!')) 
        location.href='userdel.php?u=<?php echo $_GET['name']; ?>';">删除此账号</button>
        </div>
    </div>

    <script>
        var Main = {
            methods: {
                background(type, content) {
                    this.$Message[type]({
                        background: true,
                        content: content
                    });
                }
            }
        }

        Vue.createApp(Main).mount('#app')

        function showMessage(msg, ok = true, timeout = 5000) {
            var e = document.createElement('p');
            e.append(document.createTextNode(msg));
            var cb = document.createElement('button');
            cb.style.background = "#ffffffff";
            cb.style.position = "absolute";
            cb.style.right = "0";
            cb.innerHTML = 'x';
            cb.onclick = function() {
                e.remove();
            }
            e.appendChild(cb);
            e.classList.add('msg_text');
            e.style.marginBottom = "5px";
            e.style.background = ok ? "#3fd23fcc" : "#ff0000cc";
            e.style.width = document.documentElement.clientWidth / 2 + 'px';
            ok ? success_msg.appendChild(e) : error_msg.appendChild(e);
            setTimeout(function() {
                e.remove()
            }, timeout);
        }
        sch.onclick = function() {
            sch.innerHTML = sch.disabled = "请稍候...";
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "userchange.php");
            var fd = new FormData();
            fd.append("old_name", "<?php echo $_GET["name"]; ?>");
            fd.append("new_name", user_name.value);
            fd.append("auth_val", auth_val.value);
            xhr.onload = function() {
                sch.disabled = !(sch.innerHTML = "确认更改");
                if (xhr.status != 204 && xhr.status != 200) {
                    return result.innerHTML = "HTTP错误: " + xhr.status;
                }
                if (xhr.response.indexOf("err") + 1) {
                    return result.innerHTML = "错误: " + xhr.response;
                }
                showMessage("成功更改了 " + user_name.value + " 的信息。");
            }
            xhr.send(fd);
        }
        dis_.oninput = function() {
            var el = document.createElement("span");
            el.setAttribute('style', 'position:absolute;left:0;top:0;width:100%;height:100%;' +
                'background:#00000077;z-index:2334;cursor:not-allowed;');
            document.body.appendChild(el);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "userenable.php");
            var fd = new FormData();
            fd.append("name", user_name.value);
            fd.append("enable", dis_.checked);
            xhr.onload = function() {
                el.remove();
                if (xhr.status != 204 && xhr.status != 200) {
                    return Main.methods.background('error', "HTTP错误: " + xhr.status);
                }
                if (xhr.response.indexOf("err") + 1) {
                    return Main.methods.background('error', "错误: " + xhr.response);
                }
                Main.methods.background('info', "操作成功完成。");
            }
            xhr.send(fd);
        }
    </script>

</body>

</html>