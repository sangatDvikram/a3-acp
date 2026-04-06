<?php

class Players_model extends CI_Model {

    public function __construct() {
        $this->ASD = $this->load->database('odbcASD', TRUE);
    }

    public function get_top_chatacter_from_account() {
        $this->ASD->where(array(
            'c_sheadera' => $this->session->userdata('username'),
            'c_status' => "A"
        ));
        $this->ASD->select('Top 1 *')->from('charac0')->order_by(" reset desc,rb desc ");
        $query = $this->ASD->get();
        return $query->first_row('array');
    }

    public function get_current_account_characters() {
        $this->ASD->where(array(
            'c_sheadera' => $this->session->userdata('username'),
            'c_status' => "A"
        ));
        $this->ASD->select('*')->from('charac0');
        $query = $this->ASD->get();
        return $query->result_array();
    }

    public function get_current_account_details($id) {
        $this->ASD->select('c_id')->from('account')->where('c_id', $this->session->userdata('username'));
        ;
        $query = $this->ASD->get();
        return $query->result_array('array');
    }

    public function get_account_details($id) {
        $this->ASD->select('*')->from('account')->where('c_id', $id);
        $query = $this->ASD->get();
        return $query->first_row('array');
    }

    public function get_current_character_details($id) {
        $this->ASD->where(array(
            'c_sheadera' => $this->session->userdata('username'),
            'c_id' => $id
        ));
        $this->ASD->select('*')->from('charac0');
        $query = $this->ASD->get();
        return $query->first_row('array');
    }

    public function get_character_details($id) {
        $this->ASD->where(array(
            'c_id' => $id
        ));
        $this->ASD->select('*')->from('charac0');
        $query = $this->ASD->get();
        return $query->first_row('array');
    }
    public function get_perticular_character_details($id) {

       $statement="SELECT c.c_sheadera,c.reset,c.pnline,c.c_id,c.c_sheaderc,a.acc_status,c.rb,c.c_sheaderb,c.Nation,c.d_udate,c.online FROM account as a,charac0 as c,AccountInfo as AI WHERE c.c_sheadera=a.c_id AND c.c_sheadera=AI.account AND a.c_id=AI.account AND c.c_id=?";

        $query = $this->ASD->query($statement,array($id));

        return $query->first_row('array');
    }
     public function get_all_online_players() {

       $statement="SELECT *  FROM charac0 where pnline=1";

        $query = $this->ASD->query($statement,array($id));

        return $query->first_row('array');
    }

    public function update_character_details($id, $data) {
        $this->ASD->trans_start();
        $this->ASD->where('c_id', $id);
        $query = $this->ASD->update('charac0', $data);
        $this->ASD->trans_complete();
    }

    public function update_account_details($id, $data) {
        $this->ASD->trans_start();
        $this->ASD->where('c_id', $id);
        $query = $this->ASD->update('account', $data);
        $this->ASD->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
              log_message('error', 'Some variable did not contain a value.');
        }
    }

}
