<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Orders extends CI_Controller {
    public function index() {
        $this->load->model('orders');
        $user_id = $_SESSION['user_id'];
        if(!empty($_REQUEST['page_num'])) {
            $page_number = $_REQUEST['page_num'];
        }else {
            $page_number = 1;
        }
        $data['page_num'] = $page_number;
        $number = 5;
        if(!isset($_REQUEST['status'])) {
            @$max = $this->orders->count_orders($user_id);
            @$result = $this->orders->show_orders($user_id, ($page_number-1)*$number, $number);
        }
        else {
            $max = $this->orders->count_orders($user_id, $_REQUEST['status']);
            $result = $this->orders->show_orders($user_id, ($page_number-1)*$number, $number, $_REQUEST['status']);
            unset($_REQUEST['status']);
        }
        if ($result != false) {
            $data['list'] = $result;
        }else {
            $data['info'] = '您还没有此类订单哦';
        }
        $data['number'] = ceil($max/$number);
        $this->load->view('personal_center/user_orders',$data);
    }

    public function change_status() {
        $this->load->model('orders');
        $order_id = $_REQUEST['order_id'];
        $goods_id = $_REQUEST['goods_id'];
        $result = $this->orders->change_goods_status($order_id, $goods_id);
        if($result) {
            $response = array(
                'errno' => 0,
                'errmsg' => 'success',
                'data' => true,
            );
        }
        else {
            $response = array(
                'errno' => 1,
                'errmsg' => 'fail',
                'data' => false,
            );
        }
        echo json_encode($response);
    }
}
