<?php
class log_model extends CI_Model
{

    public function __construct()
    {

    }
    public function visitor_log()
    {
        
        $this->db->where('session_id',$this->session->userdata('session_id'));
        $this->db->select('*')->from('ci_sessions');
        $check=$this->db->get();
        $check=$check->first_row('array');
        if($check['last_activity']>(time()-300)){
            if ($this->session->userdata('logged_in') && ($check['type'] != 'player')) {
                $data = array('type' => 'player', 'active' => 1, 'username' => $this->session->userdata('username'));
                $this->db->where('session_id', $this->session->userdata('session_id'));
                $this->db->update('ci_sessions', $data);
            } elseif ($check['type'] != 'guest' && !$this->session->userdata('logged_in')) {
                $data = array('type' => 'guest', 'active' => 0, 'username' => '-');
                $this->db->where('session_id', $this->session->userdata('session_id'));
                $this->db->update('ci_sessions', $data);
            }
        }
       $query=$this->db->query("Select (select count(*) as Guest from(select COUNT(*) from ci_sessions where type='guest' and last_activity>(last_activity-300) group by ip_address) as guest) as guests, (select count(*) as player from(select COUNT(*) from ci_sessions where type='player' and last_activity>(last_activity-300) group by ip_address) as player) as players");
        return $query->first_row('array');

    }
    public function visitor_counter()
    {

        $query=$this->db->query("select type,count(type) as count from visitor_log where DATE(date)=CURDATE() and active=1 group by type");
        return $query->result_array();
    }
    public function visitors()
    {

        $query=$this->db->query("select * from ci_sessions order by last_activity desc limit 50");
        return $query->result_array();
    }
    public function admin_action_log($row=10)
    {

        $query=$this->db->query("select * from log_admin_action order by date desc limit $row");
        return $query->result_array();
    }
    public function player_action_log($row=10)
    {

        $query=$this->db->query("select * from log_player_action order by date desc limit $row");
        return $query->result_array();
    }
    public function log($table,$data)
    {

        $query=$this->db->insert($table,$data);

    }
    public function log_visitor()
    {
        if ($this->agent->is_browser())
        {
            $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot())
        {
            $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile())
        {
            $agent = $this->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        $data=array(
            'ip'=>$this->session->userdata('ip_address'),
            'browser'=>$agent,
            'platform'=>$this->agent->platform(),
            'username'=>$this->session->userdata('username'),
            'date'=>date('Y-m-d')
        );
        $this->db->where($data);
        $this->db->select('*')->from('visitor_log');
        $query=$this->db->get();
        if ($query->num_rows() > 0)
        {

        }
        else
        {
            $this->db->insert('visitor_log',$data);
        }
    }
}