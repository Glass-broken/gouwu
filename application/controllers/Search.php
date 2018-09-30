<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    public function index() {
        $this->load->model('goods');
        $this->load->model('favorites');
        $option = $_REQUEST['type'];
        $content = $_REQUEST['content'];
        $page_lines = 20;  //每页显示的条数
        if(!empty($_REQUEST['page_num'])) {
            $page_num = $_REQUEST['page_num']; //获得页数
        }else {
            $page_num = 1;
        }
        if($option == '商品编号') {
            $result = $this->goods->search_by_id($content,($page_num - 1) * $page_lines, $page_lines);
        }else if($option == '商品名称') {
            $result = $this->goods->search_by_name($content,($page_num - 1) * $page_lines, $page_lines);
        }
        $data['page_num'] = $page_num;
        $data['list'] = $result;
        $number = count($result);
        $data['number'] =  ceil($number / $page_lines);
        echo $_SERVER['HTTP_REFERER'];
        $this->load->view('home/home', $data);
    }
}
