<?php

class Eshop_model extends CI_Model {

    public function __construct() {
        $this->ASD = $this->load->database('odbcASD', TRUE);
    }

    public function generate_eshop_menu() {


        $sql = "SELECT distinct type as item_type FROM `list_eshop_items` group by type";


        $query = $this->db->query($sql);

        $item_type = $query->result_array();
        $menu = array();
        $i = 0;
        foreach ($item_type as $type) {
            $sql = "SELECT distinct class as item_class,count(class) as count FROM `list_eshop_items` WHERE type='$type[item_type]' group by type,class";
            $query = $this->db->query($sql);
            $item_class = $query->result_array();
            $menu[$i]['item_type'] = $type['item_type'];
            $menu[$i]['class'] = ($item_class);
            $i++;
        }
        return $menu;
    }

    public function get_category_list($category) {

        $where = "class='" . $category . "'";

        $sql = "SELECT * FROM `list_eshop_items` WHERE $where ORDER BY premium_coins_price";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function search_item($name) {

        $where = "name like '%$name%'";

        $sql = "SELECT name as item_name,sr_no as item_code FROM `list_eshop_items` WHERE $where ORDER BY item_name";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function search_item_by_name($name) {

        $where = "name like '%$name%'";

        $sql = "SELECT * FROM `list_eshop_items` WHERE $where ORDER BY premium_coins_price";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function get_item_info($sr_no) {

        $where = "sr_no = '$sr_no'";

        $sql = "SELECT * FROM `list_eshop_items` WHERE $where ORDER BY premium_coins_price LIMIT 1";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function get_top_eshop_items() {

        $sql = "select *  , (eshop_coins_buys+premium_coins_buys) as sold from list_eshop_items order by sold desc LIMIT 32";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function get_account_coins_info() {
        $username = $this->session->userdata('username');
        $statement = "SELECT pcoins,coins,gold,reward FROM account WHERE c_id = '$username'";
        $query = $this->ASD->query($statement);
        $result = $query->first_row('array');

        return $result;
    }

    public function make_payment($data) {
        $this->db->trans_start();

        $statement = "UPDATE account SET $data[transaction_type] = ? WHERE c_id= ? ";
        $this->ASD->query($statement, array($data['new_coins'], $data['account']));

        $statement = "UPDATE list_eshop_items SET $data[transaction_column] = $data[transaction_column]+1 , uniqueid=uniqueid+1 WHERE sr_no='$data[sr_no]'";
        $this->db->query($statement);

        $statement = "INSERT INTO log_eshop_transaction(transaction_id,item_sr_no,account_id,character_name,item_id,item_amount,transaction_type,old_balance,new_balance,ip) VALUES( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )";
        $this->db->query($statement, array($data['transaction_id'], $data['sr_no'], $data['account'], $data['character'], $data['item_id'], $data['amount'], $data['transaction_type'], $data['old_coins'], $data['new_coins'], $data['session_ip']));


        $statement = "INSERT INTO log_eshop_items(transaction_id,item_id,first_part,second_part,unique_part,slot_part) VALUES( ? , ? , ? , ? , ? , ?  )";
        $this->db->query($statement, array($data['transaction_id'], $data['item_id'], $data['first_part'], $data['second_part'], $data['unique_part'], $data['slot_part']));

        $statement = "UPDATE charac0 SET m_body = ? WHERE c_id= ? ";
        $this->ASD->query($statement, array($data['m_body'], $data['character']));


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function get_list_of_transaction() {
        $sql = "SELECT * FROM `log_eshop_transaction` as transactions , list_eshop_items as eshop,log_eshop_items as item WHERE transactions.item_sr_no = eshop.sr_no and transactions.item_id=item.item_id ORDER BY transactions.date desc Limit 10 ";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_ip_from_log($curr_ip)
    {
        $sql = "Select ip from log_eshop_transaction as transactions where transactions.ip = '" . $curr_ip . "'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_count_of_transaction() {
        $sql = "SELECT * FROM `log_eshop_transaction` as transactions , list_eshop_items as eshop,log_eshop_items as item WHERE transactions.item_sr_no = eshop.sr_no and transactions.item_id=item.item_id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    
    public function generate_list_of_transaction($search,$start,$length) {
        $searching="AND ( transactions.character_name like'%$search%' OR transactions.account_id like'%$search%' OR transactions.item_sr_no like'%$search%' OR eshop.name like'%$search%' ) ";
        $sql = "SELECT * FROM `log_eshop_transaction` as transactions , list_eshop_items as eshop,log_eshop_items as item WHERE transactions.item_sr_no = eshop.sr_no and transactions.item_id=item.item_id $searching ORDER BY transactions.date  desc Limit $start,$length ";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
