<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
        $this->load->model('goods');
        $this->load->model('favorites');
        $page_lines = 20;  //每页显示的条数
        if(!empty($_REQUEST['page_num'])) {
            $page_num = $_REQUEST['page_num']; //获得页数
        }else {
            $page_num = 1;
        }
        $data['page_num'] = $page_num;
        $result = $this->goods->show_goods_limit(($page_num - 1) * $page_lines, $page_lines);
        $data['list'] = $result;
        $number = $this->goods->goods_number()->num;
        $data['number'] =  ceil($number / $page_lines);
        $this->load->view('home/home', $data);
    }
}
