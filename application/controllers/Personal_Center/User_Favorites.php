<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Favorites extends CI_Controller {
    public function index() {
        $this->load->model('favorites');
        @$user_id = $_SESSION['user_id'];
        $result = $this->favorites->show_favorites($user_id);
        $data['list'] = $result;
        $this->load->view('personal_center/user_favorites', $data);
    }

    public function add_favorites() {
        $this->load->model('favorites');
        $goods_id = $_REQUEST['goods_id'];
        $user_id = $_REQUEST['user_id'];
        $result = $this->favorites->add_favorites($goods_id, $user_id);
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

    public function delete() {
        $this->load->model('favorites');
        $goods_id = $_REQUEST['goods_id'];
        $user_id = $_REQUEST['user_id'];
        $result = $this->favorites->delete($user_id, $goods_id);
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
}
