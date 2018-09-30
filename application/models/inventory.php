<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inventory extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function show_inventory() {

        $sql = 'select * from goods as g inner join inventory as i on g.goods_id = i.goods_id';
        $result1 = $this->db->query($sql);
        $data['result1'] = $result1->result();
        $sql = 'select * from goods_delete as g inner join inventory as i on g.goods_id = i.goods_id';
        $result2 = $this->db->query($sql);
        $data['result2'] = $result2->result();
        return $data;
    }

    public function add_inventory($data) {
        $sql = 'insert into inventory (goods_id, inventory) values ("'. $data['goods_id'] . '", ' . $data['inventory'] .')';
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_inventory($goods_id, $inventory) {
        $sql = 'update inventory set inventory = ' . $inventory. ' where goods_id = "'.$goods_id.'"';
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }
}
