<?php

class crafting_model extends CI_Model {

    public function __construct() {
        
    }

    public function guide_generate_crafting_menu() {

        $this->db->select('item_type')->from('list_items')->not_like('item_class ', 'quest')->group_by('item_type');


        $query = $this->db->get();
        $item_type = $query->result_array();
        $menu = array();
        $i = 0;
        foreach ($item_type as $type) {
            $this->db->select('item_class,count(item_class) as count')->from('list_items')->where('item_type', $type['item_type'])->not_like('item_class ', 'quest')->group_by('item_type,item_class');
            $query = $this->db->get();
            $item_class = $query->result_array();
            $menu[$i]['item_type'] = $type['item_type'];
            $menu[$i]['class'] = ($item_class);
            $i++;
        }
        return $menu;
    }

    public function guide_generate_monster_menu() {
        //SELECT map.map_name,mm.map_code,count(mm.monster_code)as count FROM list_monster_map as mm ,list_maps as map where mm.map_code=map.map_code group by mm.`map_code`


        $query = $this->db->query('SELECT map.map_name,map.link,mm.map_code,count(mm.monster_code)as count FROM list_monster_map as mm ,list_maps as map where mm.map_code=map.map_code group by mm.map_code order by map.map_name ');


        $map_details = $query->result_array();
        return $map_details;
    }

    public function map_monster_list($map_name = 'Temoz', $type = 'name') {


        if ($type == 'name')
            $this->db->like('list_maps.link', $map_name);
        else
            $this->db->like('list_maps.map_code', $map_name);


        $this->db->select('*')->from('list_maps')->join('list_monster_map', 'list_maps.map_code=list_monster_map.map_code');
        $query = $this->db->get();
        $map_info = $query->first_row('array');

        $this->db->select('*')->from('list_monster_map')->where('list_monster_map.map_code', $map_info['map_code'])->join('list_monsters', 'list_monsters.monster_code=list_monster_map.monster_code')->order_by('list_monsters.monster_code', 'asc')->group_by('list_monsters.monster_code');

        $monster_info = $this->db->get();
        $output[0] = $map_info;
        $output[0]['monster'] = $monster_info->result_array();

        return $output;
    }

    public function monster_list($monster = null, $type = 'name', $items = false, $row_limit = 12) {
        $monster_name = $monster;
        $limit = $row_limit;
        $monster_info = array();
        $condition = "";
        if (isset($monster_name) && $monster_name != '') {
            if ($type == 'name')
                $condition = "and mon.monster_name like '%$monster_name%'";
            elseif ($type == 'link')
                $condition = "and mon.link='$monster_name'";
            else
                $condition = "and mon.monster_code like '%$monster_name%'";
        }

        //$this->db->select('*')->from('list_monsters')->limit($limit)->group_by('monster');

        $query = $this->db->query("SELECT mon.monster_name,mon.link,mon.monster_code,mon.monster_info,mon.monster_image,map.map_name,map.map_code FROM `list_monsters` as mon , list_monster_map as mm , list_maps as map WHERE mm.monster_code=mon.monster_code and map.map_code=mm.map_code " . $condition . " limit " . $row_limit);
        //To get list of all items as well.
        if ($items) {
            $monsters = $query->first_row('array');
            $this->db->select('*')->from('list_monster_droprate')->where('monster_code', $monsters['monster_code'])->join('list_items', 'list_items.item_code=list_monster_droprate.item_code');
            $items = $this->db->get();
            $monster_info[0] = $monsters;
            $monster_info[0]['items'] = $items->result_array();
        } else {
            $monster_info = $query->result_array();
        }


        return $monster_info;
    }

    public function create_monster_map_item_link() {
        $query = $this->db->get('list_items');
        $maps = $query->result_array();
        foreach ($maps as $value) {

            $slug = url_title($value['item_name'], 'dash', TRUE);
            $this->db->where('item_code', $value['item_code']);
            $this->db->update('list_items', array('link' => $slug));
        }
    }

    public function item_details($item_name = null, $type = "name", $monster = false, $crafting = false, $options = false, $rows = 12) {
        //Check what do you need 1. Specific item or 2 Randome items
        //1. Plain Item information
        if (isset($item_name) && $item_name != '') {
            if ($type == 'name')
                $this->db->like('item_name', $item_name);
            elseif ($type == 'link')
                $this->db->where('link', $item_name);
            elseif ($type == 'code')
                $this->db->where('item_code', $item_name);
        }
        if ($item_name == null) {
            $this->db->order_by('RAND()');

            $this->db->not_like('item_type', 'skill');

            $this->db->not_like('item_class', 'quest');

            $this->db->not_like('item_type', 'quest');
        }

        $this->db->select('*')->from('list_items')->limit($rows);
        $query = $this->db->get();
        $item_info = $query->result_array();
        if(count($item_info)==0)
            {
            
        $this->db->select('*')->from('list_items')->limit($rows)->where('item_code',0);
        $query = $this->db->get();
        $item_info = $query->result_array();
            
            }
        // For monster list under this item
        $first_item = $query->first_row('array');
       $output[0] = $first_item;
        if ($monster) {
            $query = $this->db->query(
                    "
            SELECT mon.monster_name,mon.link,mon.monster_code,mon.monster_info,mon.monster_image,map.map_name,map.map_code FROM `list_monsters` as mon , list_monster_map as mm , list_maps as map ,list_monster_droprate as drops,list_items as item WHERE mm.monster_code=mon.monster_code and map.map_code=mm.map_code and item.item_code='$first_item[item_code]' and drops.item_code=item.item_code and drops.monster_code=mon.monster_code group by mon.monster_code
            "
            );
            $output[0]['monsters'] = $query->result_array();
        }


        if ($crafting) {
            $this->db->select('*')->from('list_items')->join('list_crafting', 'list_crafting.result=list_items.item_code')->where('item_code', $first_item['item_code']);
            $query = $this->db->get();
            $output[0]['crafting'] = $query->result_array();
        }
        if ($options) {
            $this->db->select('*')->from('list_items')->join('list_item_options', 'list_item_options.item_code=list_items.item_code')->where('list_items.item_code', $first_item['item_code']);
            $query = $this->db->get();
            if ($query->num_rows() > 0)
                $output[0]['options'] = $query->result_array();
        }

        if ($monster || $crafting || $options) {
            return $output;
        } else {
            return $item_info;
        }
    }

    public function item_category_details($cat,$start=0,$limit=12) {
        $cat = explode(' ', $cat);
        $count = count($cat);
        if ($count == 1) {
            $this->db->where('item_type', $cat[0]);
        }
        if ($count == 2) {
            $this->db->where('item_class', $cat[0]);
            $this->db->where('item_type', $cat[1]);
        }
        
        $this->db->limit($limit,$start);
        
        $this->db->select('*')->from('list_items')->order_by('item_code', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function item_category_details_count($cat) {
        $cat = explode(' ', $cat);
        $count = count($cat);
        if ($count == 1) {
            $this->db->where('item_type', $cat[0]);
        }
        if ($count == 2) {
            $this->db->where('item_class', $cat[0]);
            $this->db->where('item_type', $cat[1]);
        }
        $this->db->select('*')->from('list_items')->order_by('item_code', 'asc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function generate_rebirth_menu() {
        $this->db->select('rb_name,rb_link')->from('list_rebirth');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function rebirth_info($link = null, $type = 'randome', $limit = 12) {
        if ($type == 'link') {
            $this->db->where('rb_link', $link);
        } else {
            $this->db->order_by('RAND()');
        }


        $this->db->select('*')->from('list_rebirth')->limit($limit);
        $query = $this->db->get();

        if ($type == 'link') {
            $first_rebirth = $query->first_row('array');
            $output[0] = $first_rebirth;

            //get items
            if ($first_rebirth['Rb_reward'] != '-') {
                $reward = explode(';', $first_rebirth['Rb_reward']);
                $reward = $this->item_details($reward[0], 'code');
                $output[0]['reward'] = $reward[0];
            }

            if ($first_rebirth['Item_req_count'] > 0) {

                $items = explode(',', $first_rebirth['Item_req']);

                foreach ($items as $value) {
                    $items_info = $this->item_details($value, 'code');
                    $output[0]['items'][] = $items_info[0];
                }
                return $output;
            } else
                return $output;
        } else
            return $query->result_array();
    }

    public function runonce() {
        $this->db->where('item_code', 0);
        $this->db->not_like('name', 'Aruku');
        $this->db->not_like('name', 'Phibollus');
        $query = $this->db->get('list_item_options');

        foreach ($query->result_array() as $value) {

            $items_info = $this->item_details($value['name'], 'name');
            $data = array('item_code' => $items_info[0]['item_code']);
            $this->db->where('name', $value['name']);
            $this->db->update('list_item_options', $data);
        }
        return $query->result_array();
    }

    public function get_item_details_with_name($item_name) {
        $this->db->like('item_name', $item_name);
        $this->db->select('*')->from('list_items')->limit(12);
        $query = $this->db->get();
        return  $query->result_array();
    }

}
