<?php

class settings_model extends CI_Model {

    public function __construct() {
        $this->ASD = $this->load->database('odbcASD', TRUE);
    }

    public function select_all_settings() {
        $this->db->select('*')->from('web_settings');
        $query = $this->db->get();
        $output = $query->result_array();
        return $output[0];
    }

    public function select_all_settings_like($like) {
        $this->db->like('setting_name', $like);
        $this->db->select('*')->from('web_settings');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function select_settings_where($where) {
        $this->db->where('setting_name', $where);
        $this->db->select('*')->from('web_settings');
        $query = $this->db->get();
        return $query->first_row('array');
    }

    public function update_settings($where,$value) {
        $this->db->trans_start();
        $this->db->where("setting_name",$where);
        $data=array("value"=>$value);
        $this->db->update('list_site_access_status', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_404();
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}
