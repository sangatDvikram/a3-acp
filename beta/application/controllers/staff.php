<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class staff extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
    public function index()
    {
        $data['title']="The Staff";
        $data['js']=array('staff.js');
        $data['menu'] = "/menu/index";
        renderPage('staff/index',$data);
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */