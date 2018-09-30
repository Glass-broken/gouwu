<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_book($data) {
        $this->db->trans_start();
        $sql = 'insert into goods (goods_id, `name`, price, get_date, `type`) values ("' . $data['goods_id'] . '","' . $data['name'] .'",' . $data['price'] . ', now(), "b" );';
        $this->db->query($sql);
        $sql = 'insert into book (goods_id, author, pub_house, pub_time, `type`) values ("'. $data['goods_id'] . '","'. $data['author'] . '", "'. $data['pub_house'] .'", "'. $data['pub_time'] .'", "'. $data['type'] .'");';
        $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        else {
            return true;
        }
    }

    public function add_phone($data) {
        $this->db->trans_start();
        $sql = 'insert into goods (goods_id, `name`, price, get_date, `type`) values ("'. $data['goods_id'] . '","' . $data['model'] .'",' . $data['price'] . ', now(), "p" );';
        $this->db->query($sql);
        $sql = 'insert into phone values ("'. $data['goods_id'] .'", "'. $data['brand'] . '", "' .$data['model']. '", "'. $data['s_size'] . '", "'. $data['cpu'] . '", "'. $data['ram'] . '", "'. $data['rom'] . '", "'. $data['description'] . '")';
        $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        else {
            return true;
        }
    }

    public function add_computer($data) {
        $this->db->trans_start();
        $sql = 'insert into goods (goods_id, `name`, price, get_date, `type`) values ("'. $data['goods_id'] . '","' . $data['model'] .'",' . $data['price'] . ', now(), "c" );';
        $this->db->query($sql);
        $sql = 'insert into computer values ("'. $data['goods_id'] .'", "'. $data['brand'] . '", "' .$data['model']. '", "'. $data['s_size'] . '", "'. $data['cpu'] . '", "'. $data['ram'] . '", "'. $data['disk_capacity'] . '", "'. $data['description'] . '", "' .$data['gpu']. '")';
        $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        else {
            return true;
        }
    }

    public function readd($goods_id) {
        $this->db->trans_start();
        $sql = 'select * from goods_delete where goods_id = "'.$goods_id.'"';
        $result = $this->db->query($sql);
        $type = $result->row()->type;
        $name = $result->row()->name;
        $price = $result->row()->price;
        $sql = 'insert into goods values ("'.$goods_id.'", now(), "'.$type.'", "'.$name.'", '.$price.')';
        $this->db->query($sql);
        if ($type == 'b') {
            $sql = 'select * from book_deleted where goods_id = "'.$goods_id.'"';
            $result = $this->db->query($sql);
            $row = $result->row();
            $sql = 'insert into book values ("'.$goods_id.'", "'.$row->author.'", "'.$row->pub_house.'", "'.$row->pub_time.'", "'.$row->type.'")';
            $this->db->query($sql);
            $sql = 'delete from book_deleted where goods_id = "'.$goods_id.'"';
            $this->db->query($sql);
        }else if($type == 'p') {
            $sql = 'select * from phone_deleted where goods_id = "' . $goods_id .'"';
            $result = $this->db->query($sql);
            $row = $result->row();
            $sql = 'insert into phone (goods_id, brand, model, screen_size, cpu, ram, rom, description) values ("'.$goods_id.'", "'.$row->brand.'", "'.$row->model.'", "'.$row->screen_size.'", "'.$row->cpu.'", "'.$row->ram.'", "'.$row->rom.'", "'.$row->description.'")';
            $this->db->query($sql);
            $sql = 'delete from phone_deleted where goods_id = "' .$goods_id . '"';
            $this->db->query($sql);
        }else if($type == 'c') {
            $sql = 'select * from computer_deleted where goods_id = "' . $goods_id .'"';
            $result = $this->db->query($sql);
            $row = $result->row();
            $sql = 'insert into computer (goods_id, brand, model, screen_size, cpu, memory, disk_capacity, description, gpu) values ("'.$goods_id.'", "'.$row->brand.'", "'.$row->model.'", "'.$row->screen_size.'", "'.$row->cpu.'", "'.$row->memory.'", "'.$row->disk_capacity.'", "'.$row->description.'", "'.$row->gpu.'")';
            $this->db->query($sql);
            $sql = 'delete from computer_deleted where goods_id = "' .$goods_id . '"';
            $this->db->query($sql);
        }
        $sql = 'delete from goods_delete where goods_id = "' .$goods_id.'"';
        $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }else{
            return true;
        }
    }

//    public function show_goods($goods_id) {
//        $sql = 'select * from goods where goods_id = "'.$goods_id.'"';
//        $result = $this->db->query($sql);
//        return $result->result();
//    }

    public function show_goods() {
        $sql = 'select * from goods';
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function show_goods_by_id($goods_id) {
        $sql = 'select * from goods where goods_id = "'.$goods_id.'"';
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function show_goods_deleted() {
        $sql = 'select gd.goods_id, name, type, get_date, price, inventory, deleted_time from goods_delete as gd left join inventory as i on gd.goods_id = i.goods_id';
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function delete_goods($goods_id) {
        $this->db->trans_start();
        $sql = 'select * from goods where goods_id = "' . $goods_id . '"';
        $result = $this->db->query($sql);
        $name = $result->row()->name;
        $price = $result->row()->price;
        $type = $result->row()->type;
        $get_date = $result->row()->get_date;

        $sql = 'insert into goods_delete (goods_id, name, type, price, get_date, deleted_time) values ("'.$goods_id.'", "'.$name.'", "'.$type.'", '.$price.', "'.$get_date.'", now())';
        $this->db->query($sql);
        if ($type == 'b') {
            $sql = 'select * from book where goods_id = "' . $goods_id .'"';
            $result = $this->db->query($sql);
            $row = $result->row();
            $sql = 'insert into book_deleted (goods_id, author, pub_house, pub_time, type) values ("'.$goods_id.'", "'.$row->author.'", "'.$row->pub_house.'", '.$row->pub_time.', "'.$row->type.'")';
            $this->db->query($sql);
            $sql = 'delete from book where goods_id = "' .$goods_id . '"';
            $this->db->query($sql);
        }else if($type == 'p') {
            $sql = 'select * from phone where goods_id = "' . $goods_id .'"';
            $result = $this->db->query($sql);
            $row = $result->row();
            $sql = 'insert into phone_deleted (goods_id, brand, model, screen_size, cpu, ram, rom, description) values ("'.$goods_id.'", "'.$row->brand.'", "'.$row->model.'", "'.$row->screen_size.'", "'.$row->cpu.'", "'.$row->ram.'", "'.$row->rom.'", "'.$row->description.'")';
            $this->db->query($sql);
            $sql = 'delete from phone where goods_id = "' .$goods_id . '"';
            $this->db->query($sql);
        }else if($type == 'c') {
            $sql = 'select * from computer where goods_id = "' . $goods_id .'"';
            $result = $this->db->query($sql);
            $row = $result->row();
            $sql = 'insert into computer_deleted (goods_id, brand, model, screen_size, cpu, memory, disk_capacity, description, gpu) values ("'.$goods_id.'", "'.$row->brand.'", "'.$row->model.'", "'.$row->screen_size.'", "'.$row->cpu.'", "'.$row->memory.'", "'.$row->disk_capacity.'", "'.$row->description.'", "'.$row->gpu.'")';
            $this->db->query($sql);
            $sql = 'delete from computer where goods_id = "' .$goods_id . '"';
            $this->db->query($sql);
        }
        $sql = 'delete from goods where goods_id = "' .$goods_id.'"';
        $this->db->query($sql);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }else{
            return true;
        }

    }

     public function goods_number() {
        $sql = 'select count(*) as num from goods';
        $result = $this->db->query($sql);
        return $result->row();
     }

     public function show_goods_limit($start, $end) {
        $sql = 'select * from goods limit ' . $start .', ' . $end;
        $result = $this->db->query($sql);
        return $result->result();
     }

     public function search_by_id($id, $start, $limit) {
        $sql = 'select *  from goods where goods_id like "%'.$id.'%" limit '.$start.','.$limit;
        $result = $this->db->query($sql)->result();
        return $result;
     }

    public function search_by_name($name, $start, $limit) {
        $sql = 'select *  from goods where `name` like "%'.$name.'%" limit '.$start.','.$limit;
        $result = $this->db->query($sql)->result();
        return $result;
    }
}