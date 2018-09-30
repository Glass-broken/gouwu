<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (empty($_SESSION['user_id'])) {
    echo 'PLEASE <a href="' . site_url('Login/Login_user/index') . '">LOGIN</a>!';
    exit();
}

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>创建订单</title>
    <style type="text/css">
        #head-title {
            text-align: center;
        }
        table {
            margin: 0px auto;
            width: 600px;
        }
        selector option {
            width: 300px;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>
    <script>
        $(document).ready(function (){
            $("#buy").click(function(){
                if(confirm("确认下单？")){
                    if($(".name").length < 2) {
                        var goods_id = $("#name").attr("content");
                        var number = Number($("#number").val());
                        var price = parseFloat($("#price").text());
                        var address_id = Number($("#address").find("option:selected").attr("value"));
                        var total_price = Number($("#total-price").text());
                        total_price = total_price.toFixed(2);
                        var url = '<?php echo site_url('Buy_goods/Buy_goods/buy_single'); ?>';
                        var data = {
                            'goods_id': goods_id,
                            'number': number,
                            'price': price,
                            'total_price': total_price,
                            'address_id': address_id,
                        };
                        var success = function (response) {
                            if (response.errno == 0) {
                                window.location.href = "<?php echo site_url('Buy_goods/Buy_goods/success') ?>";
                            }
                            else
                                window.location.replace("<?php echo site_url('Buy_goods/Buy_goods/fail') ?>");
                        };
                        $.post(url, data, success, 'json');
                    }else {
                        var goods_id = new Array(16);
                        var number = new Array(16);
                        for(var i = 0; i < $(".name").length; i++) {
                            goods_id[i] = $(".name").eq(i).attr("content");
                            number[i] = $(".number").eq(i).text();
                        }
                        var total_price = $("#total-price").text();
                        var address_id = Number($("#address").find("option:selected").attr("value"));
                        var data = {
                            'goods_id' : goods_id,
                            'number' : number,
                            'total_price' : total_price,
                            'address_id': address_id,
                        }
                        var url = "<?php echo site_url('Buy_goods/Buy_goods/buy_multiple') ?>";
                        var success = function (response) {
                            if (response.errno == 0) {
                                window.location.href = "<?php echo site_url('Buy_goods/Buy_goods/success') ?>";
                            }
                            else
                                window.location.replace("<?php echo site_url('Buy_goods/Buy_goods/fail') ?>");
                        };
                        $.post(url, data, success, "json");
                    }
                }else {
                    return false;
                }
            });
        });

        function change_total_price() {
            var number = $("#number").val();
            var aprice = parseFloat($("#price").text());
            var total_price = (number*aprice);
            total_price = total_price.toFixed(2);
            $("#total-price").text(total_price);
        }
    </script>
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo site_url('Home/index'); ?>">首页</a></li>
    <li role="presentation"><a href="<?php echo site_url('Classification/Classification/index'); ?>">分类</a></li>
    <li role="presentation"><a href="<?php echo site_url('Shopping_Cart/Shopping_Cart/index'); ?>">购物车</a></li>
    <li role="presentation"><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">个人中心</a></li>
    <?php
    if (!empty($_SESSION['user_id'])) { ?>
        <li role="presentation"><a href="<?php echo site_url('Login/Login_out/index'); ?>">登出</a></li>
    <?php    }else { ?>
        <li role="presentation"><a href="<?php echo site_url('Login/Login_user/index'); ?>">登陆</a></li>
    <?php }?>
</ul>
<div id="head-title">
    <h2>创建订单</h2>
</div>

<div id="content-area">
    <div id="order-form">
        <?php
        if(!is_array($goods_id)) {
            echo '
        <table>
            <tr>
                <td>商品名称</td>
                <td id="name" content="'.$goods_id.'">'.$name.'</td>
            </tr>
            <tr>
                <td>数量</td>
                <td><input id="number" name="number" type="text" value="'.$number.'" onblur="change_total_price()"/></td>
            </tr>
            <tr>
                <td>单价</td>
                <td>¥<span id="price">'.$price.'</span></td>
            </tr>
        </table>';
        }else {
            echo '
            <table>
                <tr>
                    <td>商品名称</td>
                    <td>单价</td>
                    <td>数量</td>
                    <td>小计</td>
                </tr>
            ';
            for($i = 0; $i < count($goods_id); $i++) {
                echo '
            <tr>
                <td class="name" content="'.$goods_id[$i].'">'.$name[$i].'</td>
                <td>¥<span class="price">'.$price[$i].'</span></td>
                <td class="number">'.$number[$i].'</td>
                <td>¥<span class="sub-price">'.$price[$i]*$number[$i].'</span></td>
            </tr>
                ';
            }
            echo '</table>';
        }
        ?>
        <table>
            <tr>
                <td>收货地址</td>
                <td>
                        <?php
                        if(empty($address))
                            echo '未找到收货地址，<a href="'.site_url('Personal_Center/Personal_info/user_address').'">添加</a>';
                        else {
                            echo '<select id="address">';
                            foreach ($address as $a) {
                                echo '<option value="' . $a->id . '">' . $a->address . ',' . $a->contactor . ', ' . $a->phone . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                </td>
            </tr>
            <tr>
                <td>总计</td>
                <td>¥<span id="total-price"><?php echo isset($total_price)?$total_price :($number* $price); ?></span></td>
            </tr>
            <tr>
                <td>操作</td>
                <td><button id="buy">确认订单</button></td>
            </tr>
        </table>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

</body>
</html>
