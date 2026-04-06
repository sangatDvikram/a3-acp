<?php
require(APPPATH.'libraries/REST_Controller.php');

class Guide extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crafting_model');
    }

    public function searchitem_get()
    {
        $name=$this->get('query',true);
        if(isset($name))
        {
            $data=$this->crafting_model->item_details($name,'name');

            $output['query']='Unit';
            foreach ($data as $value)
            {
                 $output['suggestions'][]=array("value"=>rtrim($value['item_name']),"data"=>$value['item_code']);
            }
            $this->response($output);
        }
        else
        {


            $this->response(array());

        }

    }
}