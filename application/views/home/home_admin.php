<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (empty($_SESSION['admin_id'])) {
    echo 'PLEASE <a href="' . site_url('Login/Login_user/index') .'">LOGIN</a>!';
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>首页</title>
    <style type="text/css">
    div.table {

    }
    th {
        width: 90px;
    }
    div h4 {
        margin: 20px 10px;
    }
    div {
        margin: 10px;
    }

    </style>
</head>
<body>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">首页</a></li>
        <li role="presentation"><a href="<?php echo site_url('Goods_manage/Home/index'); ?>">商品管理</a></li>
        <li role="presentation"><a href="<?php echo site_url('User_manage/Home/index'); ?>">用户管理</a></li>
        <li role="presentation"><a href="<?php echo site_url('Sales_manage/Home/index'); ?>">活动管理</a></li>
        <li role="presentation"><a href="<?php echo site_url('Login/Login_out/index'); ?>">登出</a></li>
    </ul>
    <?php //echo $_SESSION['user_name']; ?>
    <div id="total_money" style="background-color: #E13300">
        <h4>今日销售额</h4>
        <h4>本月销售额</h4>
    </div>

    <div id="money_today" style="background-color: #229955">
        <h3>今日销售金额前十</h3>
        <div id="money_today_table" class="table">
            <table>
                <tr>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>今日销售额</th>
                    <th>今日销量</th>
                </tr>

            </table>
        </div>
    </div>

    <div id="number_today" style="background-color: #4e4a4a">
        <h3>今日销量前十</h3>
        <div id="number_today_table" class="table">
            <table>
                <tr>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>今日销售额</th>
                    <th>今日销量</th>
                </tr>

            </table>
        </div>
    </div>

    <div id="money_month" style="background-color: #00CC00">
        <h3>本月销售金额前十</h3>
        <div id="money_month_table" class="table">
            <table>
                <tr>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>本月销售额</th>
                    <th>本月销量</th>
                </tr>

            </table>
        </div>
    </div>

    <div id="number_month" style="background-color: #98dbcc">
        <h3>本月销量前十</h3>
        <div id="number_month_table" class="table">
            <table>
                <tr>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>本月销售额</th>
                    <th>本月销量</th>
                </tr>

            </table>
        </div>
    </div>
    <hr>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
