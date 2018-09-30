<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function is_admin($name, $password) {
        $sql = 'select id, name from administrator where name = "' . $name . '" and password = password("'. $password .'")';
        $result = $this->db->query($sql);
        if (!empty($result->row()->id)) {
            return $result->row();
        }else {
            return false;
        }
    }


}