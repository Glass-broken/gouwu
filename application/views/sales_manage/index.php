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
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php echo site_url('Home_admin/index'); ?>">首页</a></li>
    <li role="presentation"><a href="<?php echo site_url('Goods_manage/Home/index'); ?>">商品管理</a></li>
    <li role="presentation"><a href="<?php echo site_url('User_manage/Home/index'); ?>">用户管理</a></li>
    <li role="presentation" class="active"><a href="#">活动管理</a></li>
    <li role="presentation"><a href="<?php echo site_url('Login/Login_out/index'); ?>">登出</a></li>
</ul>
