<?php
require(APPPATH.'libraries/REST_Controller.php');

class maps extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/data_model');
    }
    function maplist_get()
    {
        $code=$this->get('code',true);
        $data=$this->data_model->map_list('map_code,map_link');
        $this->response($data);


    }

}