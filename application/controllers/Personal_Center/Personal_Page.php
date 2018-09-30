<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal_Page extends CI_Controller {
    public function index() {
        $this->load->view('personal_center/personal_page');
    }
}
