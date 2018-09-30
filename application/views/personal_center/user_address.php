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
        .tb-title {
            font-weight: bold;
        }
        td, th{
            width:100px;
            margin: 10px;
        }
        tr {
            margin: 20px;
        }
        #add-address {
            float: right;
        }
        #extra {
            text-align: center;
        }
        #title {
            text-align: center;
        }
        input {
            margin: 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#add-address").click(function() {
                var url = "<?php echo base_url('application/views/personal_center/add_address.php'); ?>";
                $.post(url, '', function(data) {
                   $("#content").html(data);
                });
            });
            $(".delete_address").click(function() {
                var url = "<?php echo site_url('Personal_Center/Personal_info/delete_address'); ?>"
                var data = {
                    'address_id' : $(this).attr("value"),
                };
                var success = function (response) {
                    alert("删除成功");
                    window.location.reload();
                }
                if(confirm("确定删除？"))
                    $.post(url, data, success, 'json');
                else
                    return false;
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
                    <li><a href="<?php echo site_url('Personal_Center/Personal_info/update_page') ?>">个人信息修改</a></li>
                    <li>我的收货地址</li>
                </ul>
            </details>
        </div>
        <div id="content">
            <div id="top-menu">
                <div id="add-address"><a>新增收货地址</a></div>
            </div>
            <div id="address-info">
                <table id="address-info-tb">
                    <tr>
                        <th>收件人</th>
                        <th>联系电话</th>
                        <th>收货地址</th>
                        <th>操作</th>
                    </tr>
                    <?php
                    if (!empty($list)) {
                        foreach($list as $e) {
                            echo '
                    <tr>
                        <td>' . $e->contactor . '</td>
                        <td>' . $e->phone . '</td>
                        <td>' . $e->address . '</td>
                        <td><a href="">修改</a><a class="delete_address" value="'.$e->id.'">删除</a></td>
                    </tr>';}
                        if (!empty($info)) {
                            echo '
                    <tr>
                        <td colspan="3">'.$info.'</td>
                    </tr>';
                        }
                    }else {
                        echo '<tr><td colspan="3" id="extra">收货地址为空</td></tr>';
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
