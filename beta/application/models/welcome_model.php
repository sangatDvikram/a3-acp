<?php
class welcome_model extends CI_Model {

    public function __construct()
    {
        $this->ASD=$this->load->database('odbcASD', TRUE);
    }
    public function getAll()
    {
        //$query = $this->ASD->query("select top 20 * from pvplog");
          //  $this->ASD->limit(10);
        /// $query=$this->ASD->get('pvplog',20,0);
      /* $this->ASD->select('TOP 5 *')->from('pvplog')->limit(20, 0); 
        $query=$this->ASD->get();
        return  $query->result_array();*/

        $this->db->select()->from('ci_sessions')->limit(2,0);
        $query=$this->db->get();
        return  $query->result_array();
    }
}