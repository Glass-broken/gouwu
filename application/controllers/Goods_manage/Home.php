<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
        $this->load->model('goods');

        $list = $this->goods->show_goods();
        $data['list'] = $list;
        $this->load->view('goods_manage/index', $data);
    }
    public function add() {
        $this->load->model('goods');

        $add_type = $this->input->post('add_type');
        if ($add_type == 'book') {
            $data['goods_id'] = $this->input->post('goods_id');
            $data['name'] = $this->input->post('name');
            $data['author'] = $this->input->post('author');
            $data['price'] = $this->input->post('price');
            $data['pub_house'] = $this->input->post('pub_house');
            $data['pub_time'] = $this->input->post('pub_time');
            $data['type'] = $this->input->post('type');
            $result = $this->goods->add_book($data);
            unset($data);
            if ($result) {
                $list = $this->goods->show_goods();
                $data['list'] = $list;
                $data['info'] = true;
                $this->load->view('goods_manage/index', $data);
            }
            else {
                $list = $this->goods->show_goods();
                $data['list'] = $list;
                $data['info'] = false;
                $this->load->view('goods_manage/index', $data);
            }
        }
        else if ($add_type == 'phone') {
            $data['goods_id'] = $this->input->post('goods_id');
            $data['brand'] = $this->input->post('brand');
            $data['model'] = $this->input->post('model');
            $data['s_size'] = $this->input->post('screen_size');
            $data['cpu'] = $this->input->post('cpu');
            $data['ram'] = $this->input->post('ram');
            $data['rom'] = $this->input->post('rom');
            $data['description'] = $this->input->post('description');
            $data['type'] = $this->input->post('type');
            $data['price'] = $this->input->post('price');
            $result = $this->goods->add_phone($data);
            unset($data);
            if ($result) {
                $list = $this->goods->show_goods();
                $data['list'] = $list;
                $data['info'] = true;
                $this->load->view('goods_manage/index', $data);
            }
            else {
                $list = $this->goods->show_goods();
                $data['list'] = $list;
                $data['info'] = false;
                $this->load->view('goods_manage/index', $data);
            }
        }
        else if ($add_type == 'computer') {
            $data['goods_id'] = $this->input->post('goods_id');
            $data['brand'] = $this->input->post('brand');
            $data['model'] = $this->input->post('model');
            $data['s_size'] = $this->input->post('screen_size');
            $data['cpu'] = $this->input->post('cpu');
            $data['ram'] = $this->input->post('ram');
            $data['disk_capacity'] = $this->input->post('disk_capacity');
            $data['gpu'] = $this->input->post('gpu');
            $data['description'] = $this->input->post('description');
            $data['price'] = $this->input->post('price');
            $data['type'] = $this->input->post('type');
            $result = $this->goods->add_computer($data);
            unset($data);
            if ($result) {
                $list = $this->goods->show_goods();
                $data['list'] = $list;
                $data['info'] = true;
                $this->load->view('goods_manage/index', $data);
            }
            else {
                $list = $this->goods->show_goods();
                $data['list'] = $list;
                $data['info'] = false;
                $this->load->view('goods_manage/index', $data);
            }
        }
    }
}
