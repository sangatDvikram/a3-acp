<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Notification extends REST_Controller 
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('log_model');
    }
  function getCurrentVisitors_post()
  {
  	
        $visitor_counter=$this->log_model->visitor_log();
        $this->log_model->log_visitor();
        $visitors['data']=" Visitor Counter :<br>we have total " . ($visitor_counter['guests'] + $visitor_counter['players']) . " user online ::<br> " . (0 + $visitor_counter['players']) . " registered and " . ($visitor_counter['guests'] + 0) . " guests (based on users active over the past 5 minutes)";
        $this->response($visitors);
        
  }
  function rejectfake_post()
  {
  	
  	 

  		$id=$this->post('id');
        $grade=$this->post('grade');
        $data=array();
        if($grade=='BAN')
        {
        $this->admin_model->reject_pk_fake($id);
        $data['result']=array('message'=>"Killer You Got your ass saved !!",'error'=>'no');
        }
        else
        {
            $data['result']=array('message'=>"Die You Hacker",'error'=>'Failed');
        }
       // $data = array('returned: '. $this->get('id'));
        $this->response($data['result']);
  }

}