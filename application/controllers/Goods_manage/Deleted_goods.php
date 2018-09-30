<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deleted_goods extends CI_Controller {
    public function index() {
        $this->load->model('goods');
        $list = $this->goods->show_goods_deleted();
        $data['list'] = $list;
        $this->load->view('goods_manage/deleted_goods', $data);
    }

    public function delete() {
        $this->load->model('goods');
        $goods_id = $_REQUEST['goods_id'];
        $result = $this->goods->delete_goods($goods_id);
        if ($result) {
            $list = $this->goods->show_goods();
            $data['list'] = $list;
            $data['info'] = '下架成功';
            $this->load->view('goods_manage/index', $data);
        }else{
            $list = $this->goods->show_goods();
            $data['list'] = $list;
            $data['info'] = '下架失败';
            $this->load->view('goods_manage/index', $data);
        }
    }

    public function readd() {
        $this->load->model('goods');
        $goods_id = $_REQUEST['goods_id'];
        $result = $this->goods->readd($goods_id);
        if ($result) {
            $this->load->model('goods');
            $list = $this->goods->show_goods_deleted();
            $data['list'] = $list;
            $data['info'] = '重新上架成功';
            $this->load->view('goods_manage/deleted_goods', $data);
        }else {
            $this->load->model('goods');
            $list = $this->goods->show_goods_deleted();
            $data['list'] = $list;
            $data['info'] = '重新上架失败';
            $this->load->view('goods_manage/deleted_goods', $data);
        }
    }
}
