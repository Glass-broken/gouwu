<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_ extends CI_Controller {
    public function index() {
        $this->load->model('inventory');
        $list = $this->inventory->show_inventory();
        $data['list'] = $list;
        $this->load->view('goods_manage/inventory', $data);


    }

    public function show_add_inventory() {
        $this->load->view('goods_manage/add_inventory');
    }

    public function add() {
        $this->load->model('inventory');
        $data['goods_id'] = $this->input->post('goods_id');
        $data['inventory'] = $this->input->post('inventory');
        $result = $this->inventory->add_inventory($data);
        if ($result) {
            $list = $this->inventory->show_inventory();
            $data['list'] = $list;
            $data['info'] = '添加成功';
            $this->load->view('goods_manage/inventory', $data);
        } else {
            $list = $this->inventory->show_inventory();
            $data['list'] = $list;
            $data['info'] = '添加失败，请重试';
            $this->load->view('goods_manage/inventory');
        }
    }

    public function update() {
        $this->load->model('inventory');
        $goods_id = $_REQUEST['goods_id'];
        $inventory = $_REQUEST['inventory'];
        $result = $this->inventory->update_inventory($goods_id, $inventory);
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
