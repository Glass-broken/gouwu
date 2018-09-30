<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>    <!--使用微软的JQUERY-->
    <title>用户登陆</title>
    <style type="text/css">
        input[type="text"],input[type="password"]{
            padding-left:26px;
        }
        input {
            margin: 5px;
        }
        img {
            width: 80px;
            height: 30px;
        }
        td#code {
            text-align: center;
        }
        #login-form {
            height:100%;
            width:100%;
        }
        table {
            margin: auto;
            margin-top:250px;
            width: 500px;
            border: solid 3px;
        }
        #bg-image {
            width: 100%;
            height: 100%;
            /*filter: url(blur.svg#blur);*/
           /* -webkit-filter: blur(10px); /* Chrome, Opera */
           /* -moz-filter: blur(10px);*/
            /*-ms-filter: blur(10px);*/
            filter: blur(10px);
        }
        body {
            background-image: url(<?php echo base_url('public/image/53.jpg'); ?>);
            background-repeat: no-repeat;
            background-size: 100%;
        }
    </style>
    <script type="application/javascript">
        $(document).ready(function() {

        });
        function name_change(name){
            //reg = /^[\u4E00-\u9FA5a-zA-Z_0-9]{3,16}/;
            reg = /[\w]{3,16}/;
            if(!reg.test(name)) {
                alert("只能输入中文字母数字以及下划线");
            }
        }

        function pw_change(password) {
           // alert(password);
        }

        function vc_change(code) {
            //alert(code);
        }
    </script>
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo site_url('Home/index'); ?>">首页</a></li>
    <li role="presentation"><a href="<?php echo site_url('Classification/classification/index'); ?>">分类</a></li>
    <li role="presentation"><a href="<?php echo site_url('Shopping_Cart/Shopping_Cart/index'); ?>">购物车</a></li>
    <li role="presentation"><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">个人中心</a></li>
    <li role="presentation" class="active"><a href="#">登陆</a></li>
</ul>
<div id="login-form">
    <form action="<?php echo site_url("Login/Login_user/validation"); ?>" method="post">
        <table>
            <tr>
                <td align="right">用户名：</td>
                <td><input id="name" name="username" type="text" onchange=name_change(this.value); placeholder="请输入昵称" value="<?php if (isset($_COOKIE['username_cookie'])) echo $_COOKIE['username_cookie']; else echo '';?>"/></td>
            </tr>
            <tr>
                <td align="right">密码：</td>
                <td><input id="pw" name="password" type="password" onchange=pw_change(this.value); placeholder="请输入6-16位密码" value="<?php if (isset($_COOKIE['password_cookie'])) echo $_COOKIE['password_cookie']; else echo '';?>" /></td>
            </tr>
            <tr>
                <td align="right">验证码：</td>
                <td><input id="vc" name="validate_code" type="text" onchange=vc_change(this.value); placeholder="" value="" /></td>
            </tr>
            <tr>
                <td></td>
                <td id="code"><img src="<?php echo site_url("Login/Validate_code/create"); ?>" title="单击图片刷新" onclick="this.src='<?php echo site_url("Login/Validate_code/create"); ?>?d='+Math.random();"> </td>
            </tr>
            <tr>
                <td>记住密码</td>
                <td><input type='checkbox' name='auto_login' value='on' checked="checked"/></td>
            </tr>
            <tr>
                <td align="right">类型</td>
                <td><input name="type" type="radio" checked="checked" value="0" >用户
                    <input name="type" type="radio" value="1">管理员
                </td>

            </tr>
            <tr>
                <td><input name="submit" type="submit" value="登陆" /></td>
            </tr>

            <?php if (isset($_SESSION['error'])) {
                echo '<tr><td colspan="2" id="error_info"><p><font color="red">*错误：' . $_SESSION['error'] . '</font></p></td></tr>';
                $_SESSION['error'] = '';
            }
            ?>
            <tr><td><a href="<?php echo site_url('Login/Register/index'); ?>">马上注册</a></td></tr>
        </table>
    </form>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
</body>
</html>
