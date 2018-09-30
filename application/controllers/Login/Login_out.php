<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_out extends CI_Controller {
    public function index() {
        $this->load->helper('url');
        if (!empty($_SESSION['user_id'])) {
            session_destroy();
            redirect(site_url('Home/index'));
        } else {
            session_destroy();
            redirect(site_url('Login/Login_user/index'));
        }
    }
}