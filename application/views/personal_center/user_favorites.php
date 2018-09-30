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
            font-size: larger;
        }

        td, th{
            width:100px;
            margin: 10px;
        }
        tr {
            margin: 20px;
        }

        #extra {
            text-align: center;
        }
        input {
            margin: 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".add-cart").click(function(){
                var url = "<?php echo site_url('Shopping_Cart/Shopping_Cart/add_goods'); ?>";
                var data = {
                    'goods_id': $(this).attr("id"),
                    'user_id': "<?php echo $_SESSION['user_id']; ?>",
                };
                var success = function (response) {
                    var url1 = "<?php echo site_url('Personal_Center/User_Favorites/delete'); ?>";
                    $.post(url1, data);
                    alert("加入购物车成功");
                    window.location.reload();
                };
                $.post(url, data, success, "json");
            });

            $(".delete").click(function(){
                var url = "<?php echo site_url('Personal_Center/User_Favorites/delete'); ?>";
                var data = {
                    'goods_id': $(this).attr("value"),
                    'user_id': "<?php echo $_SESSION['user_id']; ?>",
                };
                var success = function (response) {
                    alert("删除成功");
                    window.location.reload()
                };
                $.post(url, data, success, "json");
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
                <summary><a href="<?php echo site_url('Personal_Center/User_Orders/index') ?>">我的订单</a></summary>
            </details>
            <details class="menu" open>
                <summary>我的收藏夹</summary>
            </details>
            <details class="menu" >
                <summary><a href="<?php echo site_url('Personal_Center/Personal_info/index'); ?>">个人信息</a></summary>
            </details>
        </div>
        <div id="content">
            <div id="favorites-info">
                <table id="favorites-info-tb">
                    <tr>
                        <th>商品编号</th>
                        <th>商品名称</th>
                        <th>价格</th>
                        <th>操作</th>
                    </tr>
                    <?php
                    if (!empty($list)) {
                        foreach($list as $e) {
                            echo '
                    <tr>
                        <td>' . $e->goods_id . '</td>
                        <td>' . $e->name . '</td>
                        <td>' . $e->price . '</td>
                        <td><a class="add-cart" id="'.$e->goods_id.'">加入购物车</a><a class="delete" value="'.$e->goods_id.'">删除</a></td>
                    </tr>';}
                        if (!empty($info)) {
                            echo '
                    <tr>
                        <td colspan="3">'.$info.'</td>
                    </tr>';
                        }
                    }else {
                        echo '<tr><td colspan="3" id="extra">收藏夹为空</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

</body>
</html>
