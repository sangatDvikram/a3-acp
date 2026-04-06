<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Pk extends REST_Controller 
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
  function reportfake_post()
  {
  	
  	 

  		$id=$this->post('id');
        $grade=$this->post('grade');
        $data=array();
        if($grade=='BAN')
        {
        $this->admin_model->make_pk_fake($id);
        $data['result']=array('message'=>"Success this is FAKE now Die Killer Die !!! HA HA HA",'error'=>'Yes');
        }
        else
        {
            $data['result']=array('message'=>"Die You Hacker",'error'=>'Failed');
        }
       // $data = array('returned: '. $this->get('id'));
        $this->response($data['result']);
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