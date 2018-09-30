<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_goods($data) {
        $this->db->trans_start();
        $sql = 'select goods_id from shopping_cart where user_id = "'.$data['user_id'].'" and goods_id = "'.$data['goods_id'].'"';
        $this->db->query($sql);
        if ($this->db->affected_rows() == 0) {
            $sql = 'insert into shopping_cart (goods_id, user_id, number) values ("'.$data['goods_id'].'", "'.$data['user_id'].'", 1)';
            $this->db->query($sql);
        }else {
            $sql = 'select `number` from shopping_cart where goods_id = "'.$data['goods_id'].'" and user_id = "'.$data['user_id'].'"';
            $result = $this->db->query($sql);
            $number = $result->row()->number;
            $number++;
            $sql = 'update shopping_cart set number = ' . $number. ' where goods_id = "'.$data['goods_id'].'" and user_id = "'.$data['user_id'].'"';
            $this->db->query($sql);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else {
            return true;
        }
    }

    public function show_cart($user_id) {
        $sql = 'select sc.goods_id, sc.number, price, `name` from shopping_cart as sc inner join goods as g on sc.goods_id = g.goods_id where user_id = "'.$user_id.'"';
        $result = $this->db->query($sql);
        $data['result1'] = $result->result();
        $sql = 'select sc.goods_id, sc.number, price, `name` from shopping_cart as sc inner join goods_delete as g on sc.goods_id = g.goods_id where user_id = "'.$user_id.'"';
        $result = $this->db->query($sql);
        $data['result2'] = $result->result();
        return $data;
    }

    public function change_num($goods_id, $user_id, $num){
        $sql = 'update shopping_cart set number = ' . $num . ' where goods_id = "'.$goods_id.'" and user_id = "'.$user_id.'"';
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }
}