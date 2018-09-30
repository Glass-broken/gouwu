<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class address extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function show_address($user_id) {
        $sql = 'select id, address, phone, contactor from address where user_id = "'.$user_id .'"';
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function add_address($user_id, $contactor, $phone, $address) {
        $sql = 'insert into address (user_id, contactor, phone, address) values ("'.$user_id.'", "'.$contactor.'", "'.$phone.'", "'.$address.'")';
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function delete_address($user_id, $address_id){
        $sql = 'delete from address where user_id = "'.$user_id.'" and id = '.$address_id;
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }
}
