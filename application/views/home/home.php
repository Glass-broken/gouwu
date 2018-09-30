<?php
defined('BASEPATH') OR exit('No direct script access allowed')

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>首页</title>
    <style type="text/css">
        #search_bar {
            width: 90%;
            margin-left:auto;
            margin-right:auto;
        }
        #search_form {
            text-align: center;
        }
        input {
            width: 300px;
            height: 36px;
        }
        #content-area {
            width: 90%;
            margin: 0 auto;
        }
        #left-navigate {
            width:20%;
            float: left;
            background-color: #98dbcc;
        }
        #content {
            width: 70%;
            float: right;
        }
        .goods-info {
            display:inline-block;
            margin: 15px;
            width: 130px;
        }
        #page-nav{
            bottom:0;
            width:100%;
            text-align: center;
        }
        .page-num {
            margin: 10px;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.4.4.min.js'); ?>"></script>    <!--使用微软的JQUERY-->
    <script>
        $(document).ready(function (){
            $(".add_cart").click(function(){
                var url = "<?php echo site_url('Shopping_Cart/Shopping_Cart/add_goods'); ?>";
                var data = {
                    'goods_id': $(this).attr("id"),
                    'user_id': "<?php echo $_SESSION['user_id']; ?>",
                };
                var success = function (response) {
                    alert("加入购物车成功");
                };
                $.post(url, data, success, "json");
            });

            $(".add-favorites").click(function(){
                var image_name = $(this).children("img").attr("src");
                var preg_str = /font-361.1.png/;
                var flag = 0;
                if(preg_str.test(image_name)) {
                    flag = 1;
                }else
                    flag = 0;
                //alert(flag);
                var url1 = "<?php echo site_url('Personal_Center/User_Favorites/add_favorites'); ?>";
                var url2 = "<?php echo site_url('Personal_Center/User_Favorites/delete'); ?>";
                var str1 = '<img src="<?php echo base_url('public/image/font-361.png?'.mt_rand()); ?>" alt="未收藏" title="未收藏" width="32" height="32" />';
                var str2 = '<img src="<?php echo base_url('public/image/font-361.1.png?'.mt_rand()); ?>" alt="已收藏" title="已收藏" width="32" height="32" />'
                var data = {
                    'goods_id': $(this).attr("value"),
                    'user_id': "<?php echo $_SESSION['user_id']; ?>",
                };
                var success = function (response) {

                    if(flag) {
                        $(this).children("img").attr("src",str1);
                        alert("取消成功");
                    }else {
                        $(this).children("img").attr("src",str2);
                        alert("收藏成功");
                    }
                };
                $.post(flag ? url2 : url1, data, success, "json");
            });
            $("#search").click(function() {
                var option = $("#filter-option").find("option:selected").text();
                    //alert(option);
                var search_content = $("#search-content").val();
                    //alert(search_content);
                var url = '<?php echo site_url('Search/index'); ?>';
                var data = {
                    'type' : option,
                    'content' : search_content,
                };
                var success = function(response) {
                    $("body").html(response);
                }
                $.post(url, data, success);
            });
        });
    </script>
</head>
<body>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">首页</a></li>
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
<?php //echo $_SESSION['user_name'];?>
    <div id="search_bar">
        <div id="search_form">
            <span id="filter">
                <select id="filter-option" name="filter_option">
                    <option value="goods_id">商品编号</option>
                    <option value="goods_name">商品名称</option>
                </select>
            </span>
            <span id="form_input">
                <input id="search-content" name="search_mes" type="text" value="" placeholder="请输入要搜索的商品">
                <button id="search"><img src="<?php echo base_url('public/image/font-337.png'); ?>" width="32" height="32"></button>
            </span>
        </div>
    </div>
    <div id="content-area">
        <div id="left-navigate">
            <p>left navigate</p>
        </div>
        <div id="content">
            <div id="goods-area">
                <?php
                    $flag = false;
                    foreach($list as $e) {
                        echo '
                <div class="goods-info">
                    <img src="'.base_url('public/image/default.jpg').'" width="100px" height="100px">';
                    echo '<p>' . $e->name . '</p>';
                    echo '<p>¥' . $e->price . '</p>';
                    if(!empty($_SESSION['user_id'])) {
                        $flag = $this->favorites->is_favorite($e->goods_id, $_SESSION['user_id']);
                    }
                    $image_name = $flag ? 'font-361.1.png' : 'font-361.png';
                    echo '<p><a class="add-favorites" value="'.$e->goods_id.'">
                                <img src="'.base_url('public/image/'.$image_name.'?'.mt_rand()).'" width="32" height="32" />
                             <a/>
                             <a class="add_cart" id="'.$e->goods_id.'">
                                <img src="'.base_url('public/image/font-365.png').'" width="32" height="32" />
                             </a></p>
                             <p><a id="buy" href="'. site_url('Buy_goods/Buy_goods/index') .'?goods_id='.$e->goods_id.'">立即购买</a></p>
                </div>';
                    } ?>
            </div>
            <hr>
            <div id="page-nav">
                <?php
                if($_SERVER['PHP_SELF'] !== '/gouwu/index.php/Search/index') {
                    if ($page_num > 5) {
                        $start_page = $page_num - 5;
                    } else {
                        $start_page = 1;
                    }
                    if ($page_num >= $number - 5) {
                        $end_page = $number;
                    } else {
                        if ($page_num <= 5) {
                            $end_page = 10;
                        } else
                            $end_page = $page_num + 4;
                    }
                    echo '<a class="page-num" href="' . site_url('Home') . '?page_num=1">首页</a>';
                    echo '<a class="page-num" href="' . site_url('Home') . '?page_num=' . (($page_num > 1) ? ($page_num - 1) : 1) . '">上一页</a>';
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        echo '<a class="page-num" href="' . site_url('Home') . '?page_num=' . ($i) . '">';
                        if ($i == $page_num)
                            echo '<b>' . $i . '</b></a>';
                        else
                            echo $i . '</a>';
                    }
                    echo '<a class="page-num" href="' . site_url('Home') . '?page_num=' . (($page_num < $number) ? ($page_num + 1) : $number) . '">下一页</a>';
                }else {
                    echo '<p>只显示搜索结果前20条</p>';
                }
                ?>
            </div>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->


</body>
</html>
