<?php
class admin_model extends CI_Model {

    public function __construct()
    {
        $this->ASD=$this->load->database('odbcASD', TRUE);
    }
    public function get_pk_details($id)
    {
        $this->ASD->select('*')->from('pvplog')->where('sr_no',$id); 
        $query=$this->ASD->get();
        return $query->first_row('array');

    }
     public function get_player_pk_stats($id)
    {
        $this->ASD->select('*')->from('Pkstats')->where('pname',$id); 
        $query=$this->ASD->get();
        return $query->first_row('array');

    }
    public function make_pk_fake($id)
    {
       /*
            GET PK Details
       */
       
        

        $report_details=$this->get_pk_details($id);
        if($report_details['fake']==0)
        {
        
        // 1. Killer Details Update

        $this->ASD->trans_start();

        $killer=$this->get_player_pk_stats($report_details['killer']);
        $data = array(
               'fake' => $killer['fake']+1,
               'rp' => $killer['rp'] - 1,
               
            );

        $this->ASD->where('pname', $report_details['killer']);
        $this->ASD->update('Pkstats', $data,FALSE); 

        // 2. Victim Details Update

        $victim=$this->get_player_pk_stats($report_details['victim']);
        $data = array( 'rp' => $victim['rp']+1 ,'deaths'=>$victim['deaths']-1);
        $this->ASD->where('pname', $report_details['victim']);
        $this->ASD->update('Pkstats', $data,FALSE); 

        // 3. PK Details Update


        $data=array('fake'=>1);
        $this->ASD->where('sr_no', $id);
        $this->ASD->update('pvplog', $data,FALSE); 

        // 4. Delete From MYSQL

        $this->db->where('report_sr', $id);
        $this->db->delete('report_pk'); 


        $this->ASD->trans_complete();
        }
        return $report_details;
        
    }
     public function reject_pk_fake($id)
    {
       /*
            GET PK Details
       */
       
        

        $report_details=$this->get_pk_details($id);
        if($report_details['fake']==0)
        {
        
        // 1. Killer Details Update

        $this->ASD->trans_start();

        $data=array('fake'=>2);
        $this->ASD->where('sr_no', $id);
        $this->ASD->update('pvplog', $data,FALSE); 

        // 4. Delete From MYSQL

        $this->db->where('report_sr', $id);
        $this->db->delete('report_pk'); 


        $this->ASD->trans_complete();

        }
        return $report_details;
        
    }
    public function search_character($id,$rows=100)
    {
        $this->ASD->select("Top $rows c_id")->from('charac0')->like('c_id', $id)->order_by('c_id','asc') ;
        $query=$this->ASD->get();
        return $query->result_array('array');
        
    }
    public function search_account($id)
    {
        $this->ASD->select('Top 100 c_id')->from('account')->like('c_id', $id); ;
        $query=$this->ASD->get();
        return $query->result_array('array');
        
    }
    public function search_character_with_account_details($id)   
    {
        /*$this->ASD->like('charac0.c_id',$id);  
        $this->ASD->select("charac0.c_id as character,account.c_id as account,account.c_status as status")->from('charac0')->join('account','account.c_id=charac0.c_sheadera');*/
        $query=$this->ASD->query("Select charac0.c_id as character,account.c_id as account,account.c_status as status,account.msg  from charac0,account where  account.c_id=charac0.c_sheadera and charac0.c_id = '$id'");
        
        return $query->result_array();
    }
    public function getPlayerDetails($id)
    {
        $this->ASD->select('c_id')->from('account')->like('c_id', $id); ;
        $query=$this->ASD->get();
        return $query->result_array('array');

    }
    public function getCharacterDetails($id)
    {
        $this->ASD->select('*')->from('charac0')->where('c_id', $id); ;
        $query=$this->ASD->get();
        return $query->first_row('array');

    }
    public function UpadateCharacterDetails($where,$data)
    {
        $this->ASD->trans_start();
        $this->ASD->where('c_id',$where);
        $query=$this->ASD->update('charac0',$data);
        $this->ASD->trans_complete();


    }
    public function update_character_ban_status($where,$data)
    {
        $this->ASD->trans_start();
        $this->ASD->where('c_id',$where);
        $query=$this->ASD->update('account',$data);
        
        $this->ASD->trans_complete();

        return true;
    }


    public function getAccountDetails($id=null)
    {
        if(isset($id)&&$id!='')
        {
            $this->ASD->like('account.c_id',$id);
        }
        $this->ASD->select('Top 100 *')->from('account')->join('AccountInfo',  'account.c_id = AccountInfo.account')->order_by('account.d_cdate','desc');
        $query=$this->ASD->get();
        return $query->result_array('array');

    }
}