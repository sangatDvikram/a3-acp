<?php
class Payment_model extends CI_Model {

    public function __construct()
    {
        $this->ASD=$this->load->database('odbcASD', TRUE);
    }
    public function check_transaction_id($id) 
    {
        $this->db->select('*')->from('ipn_orders')->where('txn_id',$id);
        $query=$this->db->get();
        return $query->num_fields();
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