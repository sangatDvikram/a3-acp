<?php
class access_model extends CI_Model {

    public function __construct()
    {
        $this->ASD=$this->load->database('odbcASD', TRUE);
    }
    public function status_list()
    {
        $this->db->select('*')->from('list_site_access_status')->order_by('status','asc');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function update_status_message($status,$data)
    {
        $this->db->trans_start();
        $this->db->where('status',$status);
        $this->db->update('list_site_access_status',$data);
        $this->db->trans_complete();
        return true;
    }
    public function status_info($status)
    {
        $this->db->select('*')->from('list_site_access_status')->where('status',$status);
        $query=$this->db->get();
        return $query->first_row('array');
    }
}