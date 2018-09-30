<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorites extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function show_favorites($user_id) {
        $sql = 'select f.goods_id, `name`, price from favorites as f left join goods as g on f.goods_id = g.goods_id where user_id = "'.$user_id.'"';
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function add_favorites($goods_id, $user_id) {
        $sql = 'insert into favorites (goods_id, user_id) values ("'.$goods_id.'", "'.$user_id.'")';
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function delete($user_id, $goods_id) {
        $sql = 'delete from favorites where user_id = "'.$user_id.'" and goods_id = "'.$goods_id.'"';
        $result = $this->db->query($sql);
        if ($this->db->affected_rows() > 0 ) {
            return true;
        }else {
            return false;
        }
    }

    public function is_favorite($goods_id, $user_id) {
        $sql = "select id from favorites where goods_id = '".$goods_id."' and user_id = '".$user_id."'";
        $result = $this->db->query($sql);
        if(!empty($result->row()->id)) {
            return true;
        }else {
            return false;
        }
    }
}