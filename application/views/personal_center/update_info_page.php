<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>
    <title>个人中心</title>
    <style>
        #page {
            background-color: #8ba8af;
            width:80%;
            margin: 0 auto;
        }
        #head-area {
            background-color: #98dbcc;
            text-align: center;
        }
        #left-navigate {
            background-color: #229955;
            float: left;
            width:20%;
        }
        #content {
            background-color: #2cc36b;
            float: right;
            width: 75%;
        }
        table {
            margin: 0 auto;
        }
    </style>
    <script>
        $(document).ready(function(){
            $("#give-up").click(function(){
                window.location.replace("<?php echo site_url('Personal_Center/Personal_info/index'); ?>")
            });
        });
    </script>
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo site_url('Home/index'); ?>">首页</a></li>
    <li role="presentation"><a href="<?php echo site_url('Classification/Classification/index'); ?>">分类</a></li>
    <li role="presentation"><a href="<?php echo site_url('Shopping_Cart/Shopping_Cart/index'); ?>">购物车</a></li>
    <li role="presentation" class="active"><a href="#">个人中心</a></li>
    <?php
    if (!empty($_SESSION['user_id'])) { ?>
        <li role="presentation"><a href="<?php echo site_url('Login/Login_out/index'); ?>">登出</a></li>
    <?php    }else { ?>
        <li role="presentation"><a href="<?php echo site_url('Login/Login_user/index'); ?>">登陆</a></li>
    <?php }?>
</ul>
<?php if (empty($_SESSION['user_id'])) {
    echo 'PLEASE <a href="' . site_url('Login/Login_user/index') .'">LOGIN</a>!';
    exit();
} ?>

<div id="page">
    <div id="head-area">
        <div id="user-img">
            <img src="<?php echo base_url('public/image/'.$_SESSION['user_id'].'.jpg'); ?>?rand='<?php echo mt_rand(); ?>'" width="80px" height="80px" onerror="this.src='<?php echo base_url('public/image/user_default.jpg'); ?>'">
        </div>
        <div id="user-name">
            <p><?php echo $_SESSION['user_name']; ?></p>
        </div>
    </div>
    <div id="content-area">
        <div id="left-navigate">
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">主页</a></summary>
            </details>
            <details class="menu">
                <summary>我的订单</summary>
            </details>
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/User_Favorites/index') ?>">我的收藏夹</a></summary>
            </details>
            <details class="menu" open>
                <summary><a href="<?php echo site_url('Personal_Center/Personal_info/index'); ?>">个人信息</a></summary>
                <ul>
                    <li>个人信息修改</li>
                    <li><a href="<?php echo site_url('Personal_Center/Personal_info/user_address') ?>">我的收货地址</a></li>
                </ul>
            </details>
        </div>
        <div id="content">
            <div id="top-menu">
                <button id="give-up">返回</button>
            </div>
            <div id="user-info-form">
                <form action="<?php echo site_url('Personal_Center/Personal_info/update'); ?>" name="update-form" method="post">
                    <table id="user-info-tb">
                        <tr>
                            <td class="tb-title">用户名</td>
                            <td class="tb-info"><input type="text" name="name" value="<?php echo $list->name;?>"/></td>
                        </tr>
                        <td class="tb-title">性别</td>
                        <td class="tb-info"><input type="radio" value="0" <?php if ($list->sex == 0) echo ' checked="checked"'; ?> name="sex">保密
                            <input type="radio" value="1" name="sex" <?php if ($list->sex == 1) echo ' checked="checked"'; ?>/>男
                            <input type="radio" value="2" name="sex" <?php if ($list->sex == 2) echo ' checked="checked"'; ?>/>女</td>
                        </tr>
                            <td class="tb-title">年龄</td>
                            <td class="tb-info"><input type="text" name="age" value="<?php echo $list->age;?>"/></td>
                        </tr>
                            <td class="tb-title">联系电话</td>
                            <td class="tb-info"><input type="text" name="phone" value="<?php echo $list->phone;?>"/></td>
                        </tr>
                            <td class="tb-title">电子邮件</td>
                            <td class="tb-info"><input type="text" name="email" value="<?php echo $list->email;?>"/></td>
                        </tr>
                        <tr>
                            <td>操作</td>
                            <td><input type="submit" name="submit" value="保存"/></td>
                        </tr>
                    </table>
                    <?php if (!empty($info)) echo $info; ?>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

</body>
</html>
