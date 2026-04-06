<?php
require(APPPATH.'libraries/REST_Controller.php');

class data extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/data_model');
    }
    function maplist_get()
    {
        $code=$this->get('code',true);
        $this->response($data['result']=array('message'=>"Die You Hacker",'error'=>'Failed'));
    }

}