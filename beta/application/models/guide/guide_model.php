<?php

class Guide_model extends CI_Model {

    public function __construct() {
        $this->ASD = $this->load->database('odbcASD', TRUE);
    }

    public function get_enabled_category_list() {
        $this->db->select('*')->from('guide_category')->order_by('sr', 'asc')->where("enable_posts", 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_category_list() {

        $this->db->select('*')->from('guide_category')->order_by('sr', 'asc');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_category_details($sr) {


        $sql = "SELECT * FROM guide_category WHERE sr = ? ";
        $query=$this->db->query($sql, array($sr)); 
        
        return $query->first_row('array');
    }

    public function insert_new_category($data) {
        $this->db->trans_start();
        $this->db->insert('guide_category', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_guide_category($sr, $data) {
        $this->db->trans_start();
        $this->db->where('sr', $sr);
        $this->db->update('guide_category', $data);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_all_game_guides() {
        $this->db->select('*')->from('game_guides')->order_by('verified asc,date desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_game_guides_by_category($guide_link) {  


        $sql = "SELECT guide_title,guide_link FROM game_guides WHERE category_id = ? and verified = ? ";
        $query=$this->db->query($sql, array($guide_link,1)); 

        return $query->result_array();
    }

    public function get_game_guide_details($guide_link) {

        $sql = "SELECT * FROM game_guides WHERE guide_link = ? ";
        $query=$this->db->query($sql, array($guide_link)); 

        return $query->first_row('array');
    }

    public function get_game_guide_details_with_category($guide_link) {


        $sql = "SELECT * FROM game_guides,guide_category WHERE game_guides.guide_link = ? and guide_category.sr=game_guides.category_id ";
        $query=$this->db->query($sql, array($guide_link)); 

        return $query->first_row('array');

    }

    public function get_all_game_guides_where($where = array()) {

         

        $this->db->select('*')->from('game_guides')->order_by('verified asc,date desc')->where($where);
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function update_game_guide($guide_link, $data) {
        $this->db->trans_start();
        $this->db->where('sr', $guide_link);
        $this->db->update('game_guides', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update_game_guide_where($where = array(), $data = array()) {
        $this->db->trans_start();
        $this->db->where($where);
        $this->db->update('game_guides', $data);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function insert_new_game_guide($data) {
        $this->db->trans_start();
        $this->db->insert('game_guides', $data);
       if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_player_guide_count() {
        $username = $this->session->userdata('username');
        $query = $this->db->query("SELECT count(*) as count FROM game_guides WHERE username='$username' and DATE(date)=DATE(NOW())");
        return $query->first_row('array');
    }

    public function delete_game_guide($link) {
        $this->db->where('guide_link', $link);
        $this->db->delete('game_guides'); 
    }

    public function get_side_menu() {
        $query = $this->db->query("select * from guide_category ,game_guides where guide_category.sr=game_guides.category_id and verified=1");
        return $query->result_array();
    }

}
