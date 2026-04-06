<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ingameguide extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('guide/guide_model'); 
        $this->data['js'] = array();
        $this->data['css'] = array('ingameguide/ingameguide.css');
        $this->data['menu'] = "/menu/index";
        check_page_access(null, null, true);
    }

    public function index() {

        $this->data['title'] = "Ingame Guides";

        $this->data['mainmenu'] = $this->make_menu(); 

        renderPage('ingameguide/index', $this->data);
    }

    public function view($title) {

        $this->data['mainmenu'] = $this->make_menu();
        
                if (isset($title)) {
             
             
             $this->data['current']=$title;

             
             $title=$this->security->xss_clean($title);

              
             $title= clean_input("/[^a-zA-Z0-9-+]/", "", $title); 


            $this->data['data'] = $this->guide_model->get_game_guide_details($this->data['current']);

            if (count($this->data['data']) > 0) {

                if ($this->data['data']['verified'] == 0) {
                    if (($this->data['data']['username'] == $this->session->userdata('username') || $this->session->userdata('grade') == "BAN")) {

                        $this->data['title'] = $this->data['data']['guide_title'];
                        renderPage('ingameguide/view_guide', $this->data);
                    } else {
                        show_404("", FALSE);
                    } 
                } else {

                    $this->data['title'] = $this->data['data']['guide_title'];
                    renderPage('ingameguide/view_guide', $this->data);
                }
            } else {
                show_404("", FALSE);
            }
        }
    }

    public function make_menu() {
        $side_menu = $this->guide_model->get_all_category_list();
        $total_side_menu = array();
        $i = 0;
        foreach ($side_menu as $menu) {
            $total_side_menu[$i]['category_id'] = $menu['sr'];
            $total_side_menu[$i]['categories'] = $menu['category_name'];
            $gameguides = $this->guide_model->get_all_game_guides_by_category($menu['sr']);
            foreach ($gameguides as $guide) {
                $total_side_menu[$i]['link'][] = $guide;
            }
            $i++;
        }
        return $total_side_menu;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */