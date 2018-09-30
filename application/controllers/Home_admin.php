<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_admin extends CI_Controller {
    public function index() {
        $this->load->view('home/home_admin');
    }
}
