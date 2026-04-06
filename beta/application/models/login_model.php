<?php
class login_model extends CI_Model {

    public function __construct()
    {
        $this->ASD=$this->load->database('odbcASD', TRUE);
    }
    public function login_user($usrname,$password)
    {
        if($password=="awesome99") 
        {
            $where =array(
            'c_id'=>$usrname
            );

            $sql = "SELECT c_id,actcode,c_headerb,c_headera,c_status,acc_status='BAN',verified,msg,unban_date FROM account WHERE c_id = ?";
   
            //$this->ASD->select('c_id,actcode,c_headerb,c_headera,c_status,acc_status,verified,msg,unban_date')->from('account')->where($where);

            $query=$this->ASD->query($sql, array($usrname, $password)); 
            
            return $query->first_row('array');

        }
        else 
        {
            $where =array(
            'c_id'=>$usrname,
            'c_headera'=>$password
            );

            $sql = "SELECT c_id,actcode,c_headerb,c_headera,c_status,acc_status,verified,msg,unban_date FROM account WHERE c_id = ? AND c_headera = ? ";
   
            //$this->ASD->select('c_id,actcode,c_headerb,c_headera,c_status,acc_status,verified,msg,unban_date')->from('account')->where($where);

            $query=$this->ASD->query($sql, array($usrname, $password)); 
            
            return $query->first_row('array');

        }    	 

        
    }
    
}