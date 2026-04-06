<?php

class Game_model extends CI_Model {

    public function __construct() {
        $this->ASD = $this->load->database('odbcASD', TRUE);
    }

    public function get_shout_list($start = 0, $rows = 200) {
        if ($start > 0) {

            $sql = "Select * from log_web_shouts where sr > ? order by date desc limit ?";

            $query = $this->db->query($sql, array($start, $rows));
        } else {
            $sql = "Select * from log_web_shouts order by date desc limit ?";

            $query = $this->db->query($sql, array($rows));
        }



        return $query->result_array();
    }

    public function send_game_shout($player = "Chika", $shout_text = "Hello I am using web shouts!!") {

        $data = array(
            'username' => $this->session->userdata('username'),
            'charname' => trim($player),
            'type' => 'Web',
            'message' => $shout_text,
            'shown_status' => 0,
            'ip' => $this->session->userdata('ip_address')
        );

        $this->db->trans_start();
        $this->db->insert('log_web_shouts', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_from_char($to) {
        $sql = "SELECT Distinct(from_character) as Name FROM `log_game_wisper` WHERE to_character = ? order by date desc";

        $query = $this->db->query($sql, array($to));

        return $query->result_array();
    }

    public function get_to_char($to) {
        $sql = "SELECT Distinct(to_character) as Name FROM `log_game_wisper` WHERE from_character = ? order by date desc";

        $query = $this->db->query($sql, array($to));

        return $query->result_array();
    }

    public function get_char_chat_list($to) {

        // $sql = "select distinct `to_character` as Chat from ( select * from ( SELECT `to_character`,`date` FROM log_game_wisper WHERE from_character = ? UNION SELECT `from_character` , `date` FROM log_game_wisper WHERE to_character = ? ) temp ORDER BY date desc ) temp";

        $sql = "Select characters.name as from_character,log_game_wisper.message as message ,log_game_wisper.date as chat_date,log_game_wisper.sr from (select distinct `to_character` as name from ( select * from ( SELECT `to_character`,`date` FROM log_game_wisper WHERE from_character = ? UNION SELECT `from_character` , `date` FROM log_game_wisper WHERE to_character = ? ) temp ORDER BY date desc ) temp ) characters , (select * from log_game_wisper where from_character=? or to_character=? order by date desc) log_game_wisper where (characters.name=log_game_wisper.to_character or characters.name=log_game_wisper.from_character ) group by characters.name order by log_game_wisper.date desc";

        $query = $this->db->query($sql, array($to, $to, $to, $to));

        return $query->result_array();
    }

    public function get_char_chat_list_like($to, $like) {

        // $sql = "select distinct `to_character` as Chat from ( select * from ( SELECT `to_character`,`date` FROM log_game_wisper WHERE from_character = ? UNION SELECT `from_character` , `date` FROM log_game_wisper WHERE to_character = ? ) temp ORDER BY date desc ) temp";

        $sql = "Select characters.name as from_character,log_game_wisper.message as message ,log_game_wisper.date as chat_date,log_game_wisper.sr from (select distinct `to_character` as name from ( select * from ( SELECT `to_character`,`date` FROM log_game_wisper WHERE from_character = ? UNION SELECT `from_character` , `date` FROM log_game_wisper WHERE to_character = ? ) temp ORDER BY date desc ) temp ) characters , (select * from log_game_wisper where from_character=? or to_character=? order by date desc) log_game_wisper where (characters.name=log_game_wisper.to_character or characters.name=log_game_wisper.from_character ) group by characters.name having characters.name like '%$like%' order by log_game_wisper.date desc";

        $query = $this->db->query($sql, array($to, $to, $to, $to));

        return $query->result_array();
    }

    public function get_last_chat($to, $like, $last) {

        $sql = "Select * from log_game_wisper where from_character = ? and to_character=? and sr>$last ";

        $query = $this->db->query($sql, array($like, $to));

        return $query->result_array();
    }

    public function make_all_seen($char, $with) {

        $sql = "UPDATE log_game_wisper SET seen=1 where (from_character = ? and to_character=?) or (from_character = ? and to_character=? )";

        $query = $this->db->query($sql, array($char, $with, $with, $char));
    }

    public function get_char_chat_with($char, $with) {
        $sql = "Select * from log_game_wisper where (from_character = ? and to_character=?) or (from_character = ? and to_character=? ) ORDER BY date desc Limit 15";

        $query = $this->db->query($sql, array($char, $with, $with, $char));

        return $query->result_array();
    }

    public function get_char_chat_with_using_limits($char, $with, $start) {
        $sql = "Select * from log_game_wisper where ((from_character = ? and to_character=?) or (from_character = ? and to_character=? ) )and sr < $start ORDER BY date desc Limit 15 ";

        $query = $this->db->query($sql, array($char, $with, $with, $char));

        return $query->result_array();
    }

    public function get_unseen_count($from, $to) {
        $sql = "Select count(sr) as unseen from log_game_wisper where from_character=? and to_character=? and seen=0";
        $query = $this->db->query($sql, array($from, $to));
        return $query->first_row('array');
    }

    public function send_chat_message($to_account, $to_character, $message) {
        $data = array(
            'from_account' => $this->session->userdata('username'),
            'from_character' => $this->session->userdata('chatcharacter'),
            'to_account' => $to_account,
            'to_character' => $to_character,
            'message' => $message,
            'type' => 'Web',
            'seen' => '0'
        );

        $this->db->trans_start();
        $this->db->insert('log_game_wisper', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function get_count_of_log($type) {
        $sql = "SELECT Count(*) as count FROM `log_game_item` WHERE action_type='$type'";
        $query = $this->db->query($sql);
        $result = $query->first_row('array');
        return $result['count'];
    }

    public function get_list_of_log($type) {
        $sql = "SELECT *,game.item_code as code FROM `log_game_item` as game , list_items as items WHERE items.item_code=game.item_code and game.action_type='$type' order by game.date desc limit 100 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function generate_list_of_log($type, $search, $start, $last) {
        $serching = "AND ( game.item_code like '%$search%' or game.item_unique like '%$search%' or game.actor_name like '%$search%' or game.actor_account like '%$search%' or game.actor_ip_address like '%$search%' or game.receiver_ip_address like '%$search%' or game.receiver_account like '%$search%'  or game.receiver_name like '%$search%' or game.item_option like '%$search%' )";
        $sql = "SELECT *,game.item_code as code FROM `log_game_item` as game , list_items as items WHERE items.item_code=game.item_code and game.action_type='$type' $serching order by game.date desc limit $start,$last ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_count_of_all_log() {
        $sql = "SELECT Count(*) as count FROM `log_game_item`";
        $query = $this->db->query($sql);
        $result = $query->first_row('array');
        return $result['count'];
    }

    public function get_list_of_all_log() {
        $sql = "SELECT *,game.item_code as code FROM `log_game_item` as game , list_items as items WHERE items.item_code=game.item_code order by game.date desc limit 100 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_count_of_tracking_log($ic, $iu, $account, $character) {
        $and = array();
        if ($ic != '') {
            $and[] = "item_code like '%$ic%'";
        }
        if ($iu != '') {
            $and[] = "item_unique like '%$iu%'";
        }
        if ($account != '') {
            $and[] = "actor_account like '%$account%'";
            $and[] = "receiver_account like '%$account%'";
        }
        if ($character != '') {
            $and[] = "actor_name like '%$character%'";
            $and[] = "receiver_name like '%$character%'";
        }
        $condition = join(" or ", $and);
        $sql = "SELECT Count(*) as count FROM `log_game_item` where ($condition)";
        $query = $this->db->query($sql);
        $result = $query->first_row('array');
        return $result['count'];
    }

    public function get_list_of_tracking_log($ic, $iu, $account, $character) {

        $and = array();
        if ($ic != '') {
            $and[] = "game.item_code like '%$ic%'";
        }
        if ($iu != '') {
            $and[] = "game.item_unique like '%$iu%'";
        }
        if ($account != '') {
            $and[] = "game.actor_account like '%$account%'";
            $and[] = "game.receiver_account like '%$account%'";
        }
        if ($character != '') {
            $and[] = "game.actor_name like '%$character%'";
            $and[] = "game.receiver_name like '%$character%'";
        }
        $condition = join(" or ", $and);

        $sql = "SELECT *,game.item_code as code FROM `log_game_item` as game , list_items as items WHERE items.item_code=game.item_code and ($condition) order by game.date desc limit 100 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function generate_list_of_tracking_log($ic, $iu, $account, $character, $search, $start, $last) {

        $and = array();
        if ($ic != '') {
            $and[] = "game.item_code like '%$ic%'";
        }
        if ($iu != '') {
            $and[] = "game.item_unique like '%$iu%'";
        }
        if ($account != '') {
            $and[] = "game.actor_account like '%$account%'";
            $and[] = "game.receiver_account like '%$account%'";
        }
        if ($character != '') {
            $and[] = "game.actor_name like '%$character%'";
            $and[] = "game.receiver_name like '%$character%'";
        }
        $condition = join(" or ", $and);

        $condition="AND ( $condition )";
        $serching = "";
        if($search!=''){
        $serching = "AND ( game.item_code like '%$search%' or game.item_unique like '%$search%' or game.actor_name like '%$search%' or game.actor_account like '%$search%' or game.actor_ip_address like '%$search%' or game.receiver_ip_address like '%$search%' or game.receiver_account like '%$search%'  or game.receiver_name like '%$search%' or game.item_option like '%$search%' )";
    }
        $sql = "SELECT *,game.item_code as code FROM `log_game_item` as game , list_items as items WHERE items.item_code=game.item_code $condition $serching order by game.date desc limit $start,$last ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
