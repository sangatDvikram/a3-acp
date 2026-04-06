<?php

class data_model extends CI_Model {

    public function __construct() {
        $this->ASD = $this->load->database('odbcASD', TRUE);
    }

    public function map_list($data = "*", $type = 'code') {

        $this->db->select($data)->from('list_maps');
        $query = $this->db->get();
        return $query->result_array('array');
    }

    public function item_total_count() {

        $query = $this->db->query('SELECT count(*) as total FROM list_items');

        return $query->first_row('array');
    }

    public function item_list($search = null, $start = 0, $end = 10) {
        if (isset($search)) {
            $this->db->like('item_code', $search);
            $this->db->or_like('item_name', $search);
            $this->db->or_like('item_info', $search);
            $this->db->or_like('item_class', $search);
            $this->db->or_like('item_type', $search);
        }

        $this->db->select("*")->from('list_items')->limit($end, $start);
        $query = $this->db->get();
        return $query->result_array('array');
    }

    public function get_item_details_with_sr($sr) {
        $this->db->where('sr_no', $sr);
        $this->db->select('*')->from('list_items')->limit(12);
        $query = $this->db->get();
        return $query->first_row('array');
    }

    public function update_item_info($sr, $data) {
        $this->db->trans_start();
        $this->db->where('sr_no', $sr);
        $this->db->update('list_items', $data);
        $this->db->trans_complete();
        return true;
    }

    public function monster_list($code = null, $type = 'code') {
        $query = $this->db->query("SELECT mon.monster_name,mon.link,mon.monster_code,mon.monster_info,mon.monster_type,mon.monster_image,map.map_name,map.map_code FROM `list_monsters` as mon , list_monster_map as mm , list_maps as map WHERE mm.monster_code=mon.monster_code and map.map_code=mm.map_code ORDER BY map.map_code asc");

        return $query->result_array('array');
    }

    public function rebirth_list() {
        $this->db->select('*')->from('list_rebirth');
        $query = $this->db->get();

        $i = 0;

        $output = array();

        foreach ($query->result_array() as $rebirth) {
            //get items
            $output[$i] = $rebirth;
            if ($rebirth['Rb_reward'] != '-') {
                $reward = explode(';', $rebirth['Rb_reward']);
                $reward = item_info($reward[0]);
                $output[$i]['reward'] = $reward[0];
            }

            if ($rebirth['Item_req_count'] > 0) {

                $items = explode(',', $rebirth['Item_req']);

                foreach ($items as $value) {
                    $items_info = item_info($value);
                    $output[$i]['items'][] = $items_info[0];
                }
            }
            $i++;
        }

        return $output;
    }

}
