<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classification extends CI_Controller {
    public function index() {
        $this->load->view('classification/index');
    }
}
?>