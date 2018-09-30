<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class orders extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_orders_single($data) {
        $this->db->trans_start();
        $sql = 'select `type` from goods where goods_id ="'.$data['goods_id'].'"';
        $result = $this->db->query($sql);
        $type = $result->row()->type;
        $total_price = $data['total_price'];  //订单总价
        $price = $data['price'];  //商品单价
        $pre_price = $total_price;
        $sql = 'select `range`, reduce_money, full_line from sale_promotion where end_time > now()';
        $result = $this->db->query($sql);
        if (!empty($result->row()->range)) {
            if ($type == 'b') {
                foreach ($result->result() as $e) {
                    if ($e['range'] >= 4) {
                        if ($total_price > $e['full_line'] && $total_price > $e['reduce_money']) {
                            $total_price -= $e['reduce_money'];
                        }
                        break;
                    }
                }
            } else if ($type == 'c') {
                foreach ($result->result() as $e) {
                    if (($e['range'] % 2) == 1) {
                        if ($total_price > $e['full_line'] && $total_price > $e['reduce_money']) {
                            $total_price -= $e['reduce_money'];
                        }
                        break;
                    }
                }
            } else if ($type == 'p') {
                foreach ($result->result() as $e) {
                    if ($e['range'] == 2 || $e['range'] == 3 || $e['range'] == 6 || $e['range'] == 7) {
                        if ($total_price > $e['full_line'] && $total_price > $e['reduce_money']) {
                            $total_price -= $e['reduce_money'];
                        }
                        break;
                    }
                }
            }
        }
        $order_id = time()+rand();
        $sql = 'insert into `orders` (order_id, user_id, original_price, actual_price, address_id, create_time) values ("o_'.$order_id.'", "'.$data['user_id'].'", '.$pre_price.', '.$total_price.', '.$data['address_id'].', now())';
        $this->db->query($sql);
        $sql = 'insert into order_info (order_id, goods_id, `number`, price, status) values ("o_'.$order_id.'", "'.$data['goods_id'].'", '.$data['number'].', '.$price.', 0)';
        $this->db->query($sql);
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE) {
            return false;
        }else {
            return true;
        }
    }

    public function buy_orders_multiple($data, $user_id) {
        $this->db->trans_start();
        $b_price = $p_price = $c_price = 0;
        for ($i = 0; $i < count($data['goods_id']); $i++) {
            $sql = 'select `type`, price from goods where goods_id ="'.$data['goods_id'][$i].'"';
            $result = $this->db->query($sql);
            $type = $result->row()->type;
            $price = $result->row()->price * $data['number'][$i];
            $goods_price[$i] = $price;
            if($type == 'b') {
                $b_price += $price;
            }else if($type == 'c')
                $c_price += $price;
            else if($type == 'p')
                $p_price += $price;
        }
        $sql = 'select `range`, reduce_money, full_line from sale_promotion where end_time > now()';
        $result = $this->db->query($sql);
        if (!empty($result->row()->range)) {
            foreach ($result->result() as $e) {
                if ($e['range'] >= 4) {
                    if ($b_price > $e['full_line'] && $b_price > $e['reduce_money']) {
                        $b_price -= $e['reduce_money'];
                    }
                    break;
                }else if (($e['range'] % 2) == 1) {
                    if ($c_price > $e['full_line'] && $c_price > $e['reduce_money']) {
                        $c_price -= $e['reduce_money'];
                    }
                    break;
                }else if ($e['range'] == 2 || $e['range'] == 3 || $e['range'] == 6 || $e['range'] == 7) {
                    if ($p_price > $e['full_line'] && $p_price > $e['reduce_money']) {
                        $p_price -= $e['reduce_money'];
                    }
                    break;
                }
            }
        }
        $pre_price = $data['total_price'];
        $actual_price = $p_price + $b_price + $c_price;
        $order_id = time()+rand();
        $sql = 'insert into `orders` (order_id, user_id, original_price, actual_price, address_id, create_time) values ("o_'.$order_id.'", "'.$user_id.'", '.$pre_price.', '.$actual_price.', '.$data['address_id'].', now())';
        $this->db->query($sql);
        for($i = 0; $i < count($data['goods_id']); $i++) {
            $sql = 'insert into order_info (order_id, goods_id, `number`, price, status) values ("o_' . $order_id . '", "' . $data['goods_id'][$i] . '", ' . $data['number'][$i] . ', ' . $goods_price[$i] . ', 0)';
            $this->db->query($sql);
            $sql = 'delete from shopping_cart where goods_id = "'.$data['goods_id'][$i].'"';
            $this->db->query($sql);
        }
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE) {
            return false;
        }else {
            return true;
        }
    }

    public function show_orders($user_id, $start, $number, $status) {
        $sql = 'select order_id from orders where user_id = "'.$user_id.'" order by create_time desc limit '.$start. ', '.$number;
        $result = $this->db->query($sql)->result();
        $i = 0;
        $flag = 0;
        foreach($result as $e) {
            if(!isset($status)) {
                $sql1 = 'select order_id, original_price, create_time, actual_price from orders where order_id = "' . $e->order_id . '"';
                $data[$i]['order_info'] = $this->db->query($sql1)->result();
                $sql2 = 'select oi.`goods_id`, `number`, `price`, `name`, `status` from order_info as oi inner join (select `name`, goods_id from goods) as g on oi.goods_id = g.goods_id where order_id = "' . $e->order_id . '"';
                $data[$i]['goods_info'] = $this->db->query($sql2)->result();
                $flag = 1;
                $i++;
            }
            else {
                $sql2 = 'select oi.order_id as order_id, oi.`goods_id`, `number`, `price`, `name`, `status` from order_info as oi inner join (select `name`, goods_id from goods) as g on oi.goods_id = g.goods_id where status = ' . $status . ' and order_id = "' . $e->order_id . '"';
                if (!empty($this->db->query($sql2)->result())) {
                    $data[$i]['goods_info'] = $this->db->query($sql2)->result();
                    $sql1 = 'select order_id, original_price, create_time, actual_price from orders where order_id = "' . $e->order_id . '"';
                    $data[$i]['order_info'] = $this->db->query($sql1)->result();
                    $flag = 1;
                    $i++;
                }
            }


        }
        if ($flag) {
            return $data;
        }else {
            return false;
        }
    }

    public function count_orders($user_id, $status) {
        if(empty($status))
            $sql = 'select count(order_id) as count from orders where user_id = "'.$user_id.'"';
        else
            $sql = 'select count(goods_id) as count from order_info where status = '.$status.' and order_id in (select order_id from orders where user_id = "'.$user_id.'")';
        $result = $this->db->query($sql);
        if(!empty($result->row()->count)) {
            return $result->row()->count;
        }else {
            return 0;
        }
    }

    public function change_goods_status( $order_id, $goods_id) {
        $sql = 'update order_info set status = 1 where goods_id = "'.$goods_id.'" and order_id = "'.$order_id.'"';
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }
}
