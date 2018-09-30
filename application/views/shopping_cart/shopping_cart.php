<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (empty($_SESSION['user_id'])) {
    echo 'PLEASE <a href="' . site_url('Login/Login_user/index') .'">LOGIN</a>!';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>
    <title>购物车</title>
    <style>
        #content-area {
            width: 90%;
            background-color: #229955;
            margin: 0 auto;
        }
        #cart-table {
            width: 80%;
            margin: 0 auto;
            background-color: #98dbcc;
        }
        #shopping-cart {
            margin: auto;
            width: 80%;
        }
        td, th {
            border: 2px solid;
            text-align: center;
        }
        .img {
            width:60px;
        }
        .checked {
            width:10px;
        }
        input {
            width: 50px;
            text-align: center;
        }
        td.total-price, #buy-now {
            text-align: right;
        }
    </style>
    <script>
        $(document).ready(function (){
            $("#buy-now").click(function() {
                if($("#total-price").text() == "0") {
                    alert("请先选择您需要购买的商品");
                    return;
                }
                var goods_id = new Array(16);
                var goods_num = new Array(16);
                var checkbox = $("input[name='checked']");
                var index = 0;
                if(checkbox.length > 16) {
                    alert('单个订单最大商品数量不得超过16！');
                    return;
                }
                for (var i = 0; i < checkbox.length; i++) {
                    if(checkbox[i].checked == true) {
                        goods_id[index] = checkbox[i].value;
                        goods_num[index] = $("#num-"+goods_id[index]).val();
                        index++;
                    }
                }
                var data = {
                    'goods_id' : goods_id,
                    'goods_num' : goods_num,
                    'total_price' : $("#total-price").text(),
                };
                var url = '<?php echo site_url('Buy_goods/Buy_goods/buy_multiple_page'); ?>';
                var success = function(response) {
                    $("body").html(response);

                };
                $.post(url, data, success);
            });

            $(".selected").click(function() {
                if(this.checked == true) {
                    var goods_id = this.value;
                    var pre_total_price = $("#total-price").text();
                    var add_price = $("#sub-price-"+goods_id).text();
                    var new_total_price = parseFloat(pre_total_price) + parseFloat(add_price);
                    $("#total-price").text(new_total_price.toFixed(2));
                }
                else {
                    var goods_id = this.value;
                    var pre_total_price = $("#total-price").text();
                    var subtract_price = $("#sub-price-"+goods_id).text();
                    var new_total_price = parseFloat(pre_total_price) - parseFloat(subtract_price);
                    $("#total-price").text(new_total_price.toFixed(2));
                }
            });
        });
        function changeNum(goods_id, num) {
            if (num <= 0) {
                alert('数量必须大于0！');
                window.location.reload();
                return;
            }
            var user_id = "<?php echo $_SESSION['user_id']; ?>";
            var url = "<?php echo site_url('Shopping_Cart/Shopping_Cart/change_num'); ?>";
            var data = {
                'goods_id':goods_id,
                'num': num,
                'user_id': user_id,
            };
            var success = function(response) {
                if (response.errno == 0) {
                    var pre_price = $("#price-"+goods_id).text();
                    pre_price = parseFloat(pre_price);
                    var price = pre_price * num;
                    price = price.toFixed(2);
                    //alert(price);
                    $("#sub-price-"+goods_id).text(price);
                    $("#num-"+goods_id).val(num);
                    alert("修改商品数量成功");
                    total_price();
                }
            };
            $.post(url, data, success, "json");
        }

        function total_price() {
            var all_elem = $(".selected");
            var total_price = 0;
            var goods_id;
            var add_price;
            for (var i = 0; i < all_elem.length; i++) {
                if(all_elem[i].checked == true) {
                    goods_id = all_elem[i].value;
                    add_price = $("#sub-price-"+goods_id).text();
                    total_price += parseFloat(add_price);
                }
            }
            $("#total-price").text(total_price.toFixed(2));
        }
    </script>
</head>
<body>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="<?php echo site_url('Home/index'); ?>">首页</a></li>
        <li role="presentation"><a href="<?php echo site_url('Classification/Classification/index'); ?>">分类</a></li>
        <li role="presentation" class="active"><a href="#">购物车</a></li>
        <li role="presentation"><a href="<?php echo site_url('Personal_Center/Personal_Page/index'); ?>">个人中心</a></li>
        <?php
        if (!empty($_SESSION['user_id'])) { ?>
            <li role="presentation"><a href="<?php echo site_url('Login/Login_out/index'); ?>">登出</a></li>
        <?php    }else { ?>
            <li role="presentation"><a href="<?php echo site_url('Login/Login_user/index'); ?>">登陆</a></li>
        <?php }?>
    </ul>

    <div id="content-area">
        <div id="cart-table">

            <table id="shopping-cart">
                <tr>
                    <th class="checked"></th>
                    <th class="img"></th>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>商品价格</th>
                    <th>数量</th>
                    <th>小计</th>
                </tr>
                <?php
                    $total_price = 0;
                    foreach($list['result1'] as $e) {
                        echo '
                <tr >
                    <td><input class="selected" type="checkbox" name="checked" value="'.$e->goods_id.'"/></td>
                    <td class="img" ><img src = "'.base_url('public/image/default.jpg').'" width = "60px" height = "60px" ></td >
                    <td >'.$e->goods_id.'<input type="hidden" value="'.$e->goods_id.'" name="goods_id" /></td >
                    <td >'.$e->name.'</td >
                    <td >¥<span id="price-'.$e->goods_id.'">'.$e->price.'</span></td >
                    <td ><input type="text" name="goods_num" id="num-'.$e->goods_id.'" value="'.$e->number.'" onblur=changeNum("'.$e->goods_id.'",this.value);></td >
                    <td >¥<span id="sub-price-'.$e->goods_id.'" class="sub-price">'.$e->price * $e->number.'</span></td >
                </tr >';
                        $total_price += $e->price * $e->number;
                    }
                ?>
                <tr>
                    <td colspan="7" class="total-price">总计：¥<span id="total-price"><?php echo 0; ?></span></td>
                </tr>
                <tr>
                    <td colspan="7" id="buy-now"><button id="buy-now">立即购买</button></td>
                </tr>
            </table>
            </form>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

</body>
</html>
