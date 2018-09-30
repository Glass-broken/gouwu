<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_goods extends CI_Controller {
    /*
     * 确认订单页面
     * 需要展示的信息有商品编号，商品价格，商品数量，以及最后的订单总额
     * 让用户选择收货地址
     */

    public function index(){
        $this->load->model('goods');
        $this->load->model('address');
        $goods_id = $_REQUEST['goods_id'];
        $data['goods_id'] = $goods_id;
        $data['user_id'] = $_SESSION['user_id'];
        $data['number'] = 1;
        $result = $this->goods->show_goods($data['goods_id']);
        $data['name'] = $result[0]->name;
        $data['price'] = $result[0]->price;
        $data['address'] = $this->address->show_address($data['user_id']);
        $this->load->view('buy_goods/buy_page', $data);
     }

    public function buy_single() {
        $this->load->model('orders');
        $data['goods_id'] = $_REQUEST['goods_id'];
        $data['user_id'] = $_SESSION['user_id'];
        $data['address_id'] = $_REQUEST['address_id'];
        $data['number'] = $_REQUEST['number'];
        $data['price'] = $_REQUEST['price'];
        $data['total_price'] = $_REQUEST['total_price'];
        $result = $this->orders->add_orders_single($data);
        if ($result) {
            $response = array(
                'errno' => 0,
                'errmsg' => 'success',
                'data' => true,
            );
        }else {
            $response = array(
                'errno' => 1,
                'errmsg' => 'fail',
                'data' => false,
            );
        }
        echo json_encode($response);
    }

    public function buy_multiple_page() {
        $this->load->model('orders');
        $this->load->model('goods');
        $this->load->model('address');
        $goods_id = $_REQUEST['goods_id'];
        $goods_num = $_REQUEST['goods_num'];
        $data['total_price'] = $_REQUEST['total_price'];
        $data['user_id'] = $_SESSION['user_id'];
        for ($i = 0; $i < count($goods_id); $i++) {
            $result = $this->goods->show_goods_by_id($goods_id[$i]);
            $data['name'][$i] = $result[0]->name;
            $data['price'][$i] = $result[0]->price;
            $data['goods_id'][$i] = $goods_id[$i];
            $data['number'][$i] = $goods_num[$i];
        }
        $data['address'] = $this->address->show_address($data['user_id']);
        $this->load->view('buy_goods/buy_page',$data);
    }

    public function buy_multiple() {
        $this->load->model('orders');
        $user_id = $_SESSION['user_id'];
        $data['goods_id'] = $_REQUEST['goods_id'];
        $data['number'] = $_REQUEST['number'];
        $data['total_price'] = $_REQUEST['total_price'];
        $data['address_id'] = $_REQUEST['address_id'];
        $result = $this->orders->buy_orders_multiple($data, $user_id);
        if ($result) {
            $response = array(
                'errno' => 0,
                'errmsg' => 'success',
                'data' => true,
            );
        }else {
            $response = array(
                'errno' => 1,
                'errmsg' => 'fail',
                'data' => false,
            );
        }
        echo json_encode($response);
    }

    public function success() {
        $this->load->view('buy_goods/order_success');
    }

    public function fail() {
        $this->load->view('buy_goods/order_fail');
    }
}