<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--font-awesome 核心我CSS 文件-->
    <link href="https://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>
    <title>用户登陆</title>
    <style type="text/css">
        body{
            background-size:cover;
            font-size: 16px;
        }
        .form{
            background: rgba(255,255,255,0.2);
            width:400px;
            margin:100px auto;
        }
        #login_form{
            display: block;
        }
        #register_form{
            display: none;
        }
        .fa{
            display: inline-block;
            top: 27px;
            left: 6px;
            position: relative;
            color: #ccc;
        }
        input[type="text"],input[type="password"]{
            padding-left:26px;
        }
        .checkbox{
            padding-left:21px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(
            $("input").blur(function check_null() {
                if(this.val().length <= 0 || this.val() == null) {
                    alert(" 输入不允许为空");
                }
            });

            $("input#register_btn").click(function check() {
                if($("input#password").val() != $("input#rpassword").val()) {
                    alert("两次输入的密码不一致");
                }
            });
        );
    </script>
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo site_url('Home/index'); ?>">首页</a></li>
    <li role="presentation" class="active"><a href="#">分类</a></li>
    <li role="presentation"><a href="<?php echo site_url('Shopping_Cart/Shopping_Cart/index'); ?>">购物车</a></li>
    <li role="presentation"><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">个人中心</a></li>
</ul>

<div class="container">


    <div class="form row">
        <form class="form-horizontal col-sm-offset-3 col-md-offset-3" id="login_form" action="registers" method="post">
            <h3 class="form-title">注册账号</h3>
            <div class="col-sm-9 col-md-9">
                <div class="form-group">
                    <i class="fa fa-user fa-lg"></i>
                    <input id="username" type="text" placeholder="用户名" name="username" value=""/>
                </div>
                <div class="form-group">
                    <i class="fa fa-lock fa-lg"></i>
                    <input id="password" type="password" placeholder="密码" id="register_password" name="password"/>
                </div>
                <div class="form-group">
                    <i class="fa fa-check fa-lg"></i>
                    <input id="rpassword" type="password" placeholder="确认密码" name="rpassword"/>
                </div>
                <div class="form-group">
                    性别：<input type="radio" value="0" checked="checked" name="sex">保密
                    <input type="radio" value="1" name="sex"/>男
                    <input type="radio" value="2" name="sex"/>女
                </div>
                <div class="form-group">
                    <i class="fa fa-check fa-lg"></i>
                    <input id="age" type="text" name="age" value="" placeholder="年龄"/>
                </div>
                <div class="form-group">
                    <i class="fa fa-check fa-lg"></i>
                    <input id="phone" type="text" placeholder="手机号码" name="phone" value=""/>
                </div>
                <div class="form-group">
                    <i class="fa fa-envelope fa-lg"></i>
                    <input id="email" type="text" placeholder="电子邮箱" name="email"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success pull-right" id="register_btn" value="注册" />
                    <input type="submit" class="btn btn-info pull-left" id="back_btn" value="返回"/>
                </div>
                <div class="form-group">
                    <?php echo @$_SESSION['error'];?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
