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
        th {
            width: 70px;
        }
        .order-table {
            margin: 50px 0;
            width: 700px;
            border:solid 2px;
        }
        td {
            border: solid 2px;
            text-align: center;
        }
        .order-id {
            text-align: left;
        }
        .create-time {
            text-align: right;
        }
        .total-money {
            text-align: right;
        }
        #page-nav{
            bottom:0;
            width:100%;
            text-align: center;
        }
        .page-num {
            margin: 10px;
        }
        .goods_name {
            width: 200px;
        }
        .goods_price {
            width: 90px;
        }
        .goods_number {
            width: 30px;
        }
        .orders_status {
            width: 80px;
        }
        .img {
            width: 100px;
        }
        .orders_option {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".confirm").click(function () {
               var url = '<?php echo site_url('Personal_Center/User_Orders/change_status'); ?>';
               var data = {
                   'order_id' : $(this).attr("value"),
                   'goods_id' : $(this).attr("name"),
                };
               var success = function(response) {

                };
               if(confirm("确认收货？"))
                    $.post(url, data, success, "json");
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
            <p><a id="change-img" href="<?php echo site_url('Personal_Center/Personal_info/change_img_page') ?>">更换头像</a></p>
        </div>
    </div>
    <div id="content-area">
        <div id="left-navigate">
            <details class="menu" open>
                <summary><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">主页</a></summary>
            </details>
            <details class="menu" open>
                <summary>我的订单</summary>
                <ul>
                    <li><a href="<?php echo site_url('Personal_Center/User_Orders/index'); ?>">全部订单</a></li>
                    <li><a href="<?php echo site_url('Personal_Center/User_Orders/index?status=0'); ?>">待收货</a></li>
                    <li><a href="<?php echo site_url('Personal_Center/User_Orders/index?status=1'); ?>">已收货</a></li>
                    <li><a href="<?php echo site_url('Personal_Center/User_Orders/index?status=2'); ?>">退换货</a></li>
                </ul>
            </details>
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/User_Favorites/index') ?>">我的收藏夹</a></summary>
            </details>
            <details class="menu">
                <summary><a href="<?php echo site_url('Personal_Center/Personal_info/index'); ?>">个人信息</a></summary>
            </details>
        </div>
        <div id="content">
            <div id="order-table">
                    <?php
                    if(!empty($list)) {
                        $max = count($list); //用户的订单数量
                        for ($k = 0; $k < $max; $k++) {
                            foreach ($list[$k]['order_info'] as $f){
                                echo '
                <table class="order-table" >
                    <div class="order-block">
                    <tr>
                        <td class="order-id" colspan="3">订单编号：'.$f->order_id.'</td>
                        <td class="create-time" colspan="3">创建时间：'.$f->create_time.'</td>
                    </tr>
                                ';
                                foreach ($list[$k]['goods_info'] as $e) {
                                    switch($e->status) {
                                        case 0:
                                            $status = "待收货";
                                            break;
                                        case 1:
                                            $status = "已收货";
                                            break;
                                        case 2:
                                            $status = "退换货";
                                            break;
                                        case 3:
                                            $status = "已取消";
                                            break;
                                        default:
                                            $status = "待收货";
                                            break;
                                    }
                                    if ($e->status == 0) {
                                        $option = '确认收货';
                                    }
                                    else
                                        $option = NULL;
                                    echo '
                    <tr >
                        <td class="img" ><img src = "' . base_url('public/image/default.jpg') . '" width = "60px" height = "60px" ><p>' . $e->goods_id . '</p></td >
                        <td class="goods_name">' . $e->name . '</td >
                        <td class="goods_price">¥<span id="price-' . $e->goods_id . '">' . $e->price . '</span></td >
                        <td class="goods_number">' . $e->number . '</td >
                        <td class="orders_status">'.$status.'</td>
                        <td class="orders_option">';
                                    if ($option){
                                        echo '<button class="confirm" value="'.$f->order_id.'" name="'.$e->goods_id.'">'.$option.'</button>';
                                    }
                                    echo '<a href="">退换货</a></td >
                    </tr >';
                                }
                                echo '
                    <tr>
                        <td class="total-money" colspan="6">共支付¥'.$f->actual_price.'</td>
                    </tr>
                    </div>
                </table>
                                ';
                            }

                        }

                    }else {
                        echo '<td colspan="7">'.$info.'</td>';
                    }
                    ?>

            </div>
            <div id="page-nav">
                <?php
                if($page_num > 5) {
                    $start_page = $page_num - 5;
                }else {
                    $start_page = 1;
                }
                if($page_num >= $number - 5) {
                    $end_page = $number;
                }else {
                    if($page_num <= 5){
                        $end_page = 10;
                    }else
                        $end_page = $page_num + 4;
                }
                echo '<a class="page-num" href="'.site_url('Personal_Center/User_Orders/index').'?page_num=1">首页</a>';
                echo '<a class="page-num" href="'.site_url('Personal_Center/User_Orders/index').'?page_num='.(($page_num>1) ? ($page_num - 1) : 1) .'">上一页</a>';
                for($i = $start_page; $i <= $end_page; $i++) {
                    echo '<a class="page-num" href="'.site_url('Personal_Center/User_Orders/index').'?page_num='.($i).'">';
                    if($i == $page_num)
                        echo '<b>'.$i.'</b></a>';
                    else
                        echo $i.'</a>';
                }
                echo '<a class="page-num" href="'.site_url('Personal_Center/User_Orders/index').'?page_num='.(($page_num<$number) ? ($page_num + 1) : $number) .'">下一页</a>';
                ?>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

</body>
</html>
