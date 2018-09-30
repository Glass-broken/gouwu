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
        #all-orders, #transport, #complete {
            float:left;
            width:33%;
            text-align: center;
        }
        .word {
            float:left;
            width:33%;
            text-align: center;
        }
        #anews {
            margin: 60px;
        }
    </style>
    <script>
        $(document).ready(function() {

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
            <p><a id="change-img" href="<?php echo site_url('Personal_Center/Personal_info/change_img_page') ?>">更换头像</a></p>
        </div>
    </div>
    <div id="content-area">
        <div id="left-navigate">
            <details class="menu" open>
                <summary><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">主页</a></summary>
            </details>
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/User_Orders/index') ?>">我的订单</a></summary>
            </details>
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/User_Favorites/index') ?>">我的收藏夹</a></summary>
            </details>
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/Personal_info/index'); ?>">个人信息</a></summary>
            </details>
        </div>
        <div id="content">
            <div id="option_bar">
                <div id="all-orders">
                    <a href="<?php echo site_url('Personal_Center/User_Orders/index') ?>"><img title="全部订单" src="<?php echo base_url('public/image/font-399.png'); ?>"width="64" height="64"/></a>
                </div>
                <div id="transport">
                    <a href="<?php echo site_url('Personal_Center/User_Orders/index?status=0') ?>"><img title="待收货" src="<?php echo base_url('public/image/font-345.png'); ?>"width="64" height="64"/></a>
                </div>
                <div id="complete">
                    <a href="<?php echo site_url('Personal_Center/User_Orders/index?status=1') ?>"><img title="已收货" src="<?php echo base_url('public/image/font-508.png'); ?>"width="64" height="64"/></a>
                </div>
            </div>
            <div id="option-word">
                <span class="word"><a href="<?php echo site_url('Personal_Center/User_Orders/index') ?>">全部订单</a></span>
                <span class="word"><a href="<?php echo site_url('Personal_Center/User_Orders/index?status=0') ?>">待收货</a></span>
                <span class="word"><a href="<?php echo site_url('Personal_Center/User_Orders/index?status=1') ?>">已收货</a></span>
            </div>
            <div id="news">
                <h3>最新资讯</h3>
                <h6>来自<a href="https://readhub.me" target="3">readhub.me</a></h6>
                <hr>
                <?php
                $result = exec('python /Users/hpf/web/gouwu/python/test.py 2>/Users/hpf/web/gouwu/python/error.txt', $output, $return_var);
//                echo 'result='.$result;
//                var_dump($output);
                //echo 'return='.$return_var;
                $url = '/Users/hpf/web/gouwu/python/news.txt';
                $file = fopen($url, 'r') or die("unable to open file");
                $a = true;
                while(!feof($file)) {
                    if($a)
                        echo '<div class="anews">';
                    echo $a ? '<div class="news-title">' : '<div class="news-content">';
                    echo $a ? '<h4>'.fgets($file).'</h4>' : '<p>'.fgets($file).'</p>';
                    echo '</div>';
                    if(!$a)
                        echo '</div><hr>';
                    $a = !$a;
                }
                fclose($file);
                ?>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

</body>
</html>
