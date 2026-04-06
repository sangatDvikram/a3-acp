<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eshop extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eshop/eshop_model');
        $this->data['js'] = array("history/jquery.history.js");
        $this->data['css'] = array();
        $this->data['menu'] = "/menu/index";
        
        $this->load->library('encrypt');
    }

    public function index() {
        check_page_access(true, null, true);
        $this->data['title'] = "Eshop";

        array_push($this->data['js'], "masonry.pkgd.min.js", "jquery.autocomplete.min.js", "eshop/eshop.js");
        array_push($this->data['css'], "eshop/eshop.css");

        $this->data['eshop_side_menu'] = $this->eshop_model->generate_eshop_menu();

        //$this->data['top_eshop_items']= $this->eshop_model->get_top_eshop_items();

        renderPage("eshop/index", $this->data);
    }

    public function buy() {
        check_page_access(true, null, true);
        $encoded = $this->input->get('item', TRUE);
        $encoded = str_replace(' ', '+', $encoded);
        $encoded = clean_input("/[^a-zA-Z0-9+\/=\s\s+]/", '', $encoded);

        array_push($this->data['js'], "eshop/buy-eshop.js");

        $sr_no = (int) $this->encrypt->decode($encoded);
        if (is_integer($sr_no) && $sr_no > 0) {

            $data = $this->eshop_model->get_item_info($sr_no);

            $this->data['item_data'] = $data[0];

            $this->data['title'] = $this->data['item_data']['name'] . " - Eshop";

            $items = $this->data['item_data']['itemid'] . ";" . $this->data['item_data']['typeid'] . ";" . $this->data['item_data']['uniqueid'];
            $this->data['item_info'] = get_item_options($items);
            $this->data['item_options'] = item_option_format($this->data['item_info']);
            $this->data['append_manual_sctript_to_footer'] = "var item='$encoded';";
            renderPage("eshop/buy", $this->data);
        } else {
            show_404(current_url());
        }
    }

    public function info() {
   
         $this->load->view("email_templates/eshop_item_bought_information", $this->data);
    }
    public function success() {
   
         $this->load->view("email_templates/eshop_item_bought_successfull", $this->data);
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */