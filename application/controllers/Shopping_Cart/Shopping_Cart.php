<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_Cart extends CI_Controller {
    public function index() {
        $this->load->model('cart');
        @$list = $this->cart->show_cart($_SESSION['user_id']);
        $data['list'] = $list;
        $this->load->view('shopping_cart/shopping_cart', $data);
    }

    public function add_goods() {
        $this->load->model('cart');
        $data['goods_id'] = $_REQUEST['goods_id'];
        $data['user_id'] = $_REQUEST['user_id'];
        $result = $this->cart->add_goods($data);
        if ($result) {
            $response = array(
                'errno' => 0,
                'errmsg' => 'success',
                'data' => true,
            );
        }else {
            $response = array(
                'errno' => -1,
                'errmsg' => 'fail',
                'data' => false,
            );
        }
        echo json_encode($response);
    }

    public function change_num() {
        $this->load->model('cart');
        $goods_id = $_REQUEST['goods_id'];
        $user_id = $_REQUEST['user_id'];
        $num = $_REQUEST['num'];
        $result = $this->cart->change_num($goods_id, $user_id, $num);
        if ($result) {
            $response = array(
                'errno' => 0,
                'errmsg' => 'success',
                'data' => true,
            );
        }else {
            $response = array(
                'errno' => -1,
                'errmsg' => 'fail',
                'data' => false,
            );
        }
        echo json_encode($response);
    }
}
