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
    <title>商品管理</title>
    <style type="text/css">
        #search_form1 {
            text-align: center;
            margin: 5px;
        }
        input.search {
            width: 300px;
            height: 40px;
        }
        button {
            height: 40px;
        }
        div#content {
            width:90%;
            margin: 0 auto;
        }
        div#left_nav {
            background-color: #f29f97;
            float:left;
            width:20%;
        }
        div#content_area {
            background-color: #229955;
            float: right;
            width:75%;

        }
        input {
            margin: 5px;
        }
        table{
            border: 2px solid;
            margin: auto;
        }
        td, th {
            border: 2px solid;
            width: 120px;
            text-align: center;
        }
    </style>

    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>
    <script>
        $(document).ready(function(){


            $("#show_goods").click(function(){
                window.location.replace('/gouwu/index.php/Goods_manage/Home/index');
            });



//            var info = $("#info").val();
//            if (info == true) {
//                alert("添加成功");
//            }
//            else if(info == false) {
//                alert("添加失败");
//            }
        });
    </script>
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo site_url('Home_admin/index'); ?>">首页</a></li>
    <li role="presentation" class="active"><a href="#">商品管理</a></li>
    <li role="presentation"><a href="<?php echo site_url('User_manage/Home/index'); ?>">用户管理</a></li>
    <li role="presentation"><a href="<?php echo site_url('Sales_manage/Home/index'); ?>">活动管理</a></li>
    <li role="presentation"><a href="<?php echo site_url('Login/Login_out/index'); ?>">登出</a></li>
</ul>
<p id="info"><?php if (isset($info)) {echo $info; unset($info);} ?></p>
<form id="search_form1" action="#" method="post" name="search">
                <span id="filter">
                    <select name="filter_option">
                        <option value="goods_id">商品编号</option>
                        <option value="goods_name">商品名称</option>
                    </select>
                </span>
    <span id="form_input">
                    <input class="search" name="search_mes" type="text" value="" placeholder="请输入要搜索的商品">
                    <button>search</button>
                </span>
</form>
<div id="content">
    <div id="left_nav">
        <h4>导航栏</h4>
        <a id="show_goods">浏览商品</a>
        <details class="menu" open>
            <summary><a href="<?php echo site_url('Goods_manage/Home/index'); ?>">商品上架</a></summary>
        </details>
        <details class="menu" open>
            <summary><a href="<?php echo site_url('Goods_manage/Inventory_/index'); ?>">商品库存</a></summary>

        </details>
        <details class="menu" open>
            <summary><a href="<?php echo site_url('Goods_manage/Deleted_goods/index'); ?>">下架商品</a></summary>
                <ul>
                    <li><a id="show_deleted_goods">已下架商品</a></li>
                </ul>
        </details>
    </div>
    <div id="content_area">
        <form action="<?php echo site_url('Goods_manage/Home/add'); ?>" method="post">
            <div id="add_goods_area">
                <table>
                    <tr>
                        <th>商品编号</th>
                        <th>商品名称</th>
                        <th>上架时间</th>
                        <th>价格</th>
                        <th>类型</th>
                        <th>库存</th>
                        <th>下架时间</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach($list as $e){
                        echo '<tr>
                                    <td>' . $e->goods_id . '</td>
                                    <td>' . $e->name . '</td>
                                    <td>' . $e->get_date . '</td>
                                    <td>' . $e->price . '</td>
                                    <td>';
                        if ($e->type == 'b') {
                            echo '图书';
                        }else if ($e->type == 'p') {
                            echo '手机';
                        }else if ($e->type == 'c') {
                            echo '电脑';
                        }
                        echo '
                            <td>' . $e->inventory . '</td>
                            <td>' . $e->deleted_time . '</td>
                            </td><td><a href="'.site_url('Goods_manage/Deleted_goods/readd?goods_id='.$e->goods_id).'">重新上架</a></td>
                        </tr>';
                    } ?>
                </table>
            </div>
        </form>
    </div>
</div>
</body>
</html>