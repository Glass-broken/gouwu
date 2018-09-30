<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function is_user($name, $password) {
        $sql = 'select `id`, `password` from user where name = "' .$name. '"';
        $result = $this->db->query($sql);
        $true_password = $result->row()->password;
        if (password_verify($password, $true_password)) {
            return $result->row()->id;
        }else {
            return false;
        }
    }

    public function add_user($name, $sex, $password, $age, $phone, $email) {
        $id = time()+rand();
        $sql = "insert into `user` (`id`, `name`, `sex`, `password`, `age`, `phone`, `email`) values('gw_" . $id . "' ,'" . $name . "'," . $sex . ", '" . $password . "'," . $age .", '" . $phone . "', '" . $email . "')";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function show_user_info($user_id) {
        $sql = 'select `name`, sex, age, phone, email from user where id = "'.$user_id.'"';
        $result = $this->db->query($sql);
        if (!empty($result->row()->name)) {
            return $result->row();
        }else {
            return false;
        }
    }

    public function update($data) {
        $sql = 'update user set name = "'.$data['name'].'", sex = '. $data['sex'].', age = '.$data['age'].', phone = "'.$data['phone'].'", email = "'.$data['email'].'" where id = "'.$data['user_id'].'"';
        $this->db->query($sql);
        if($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }
}