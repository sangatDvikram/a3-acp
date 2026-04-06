<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Guides extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crafting_model');
        $this->data['js'] = array('jquery.autocomplete.min.js', 'guide.js');
        $this->data['css'] = array('guide.css');
        $this->data['menu'] = "/menu/index";
        check_page_access(null, null, true);
    }

    public function index() {
        $this->data['crafting_menu'] = $this->crafting_model->guide_generate_crafting_menu();
        $this->data['title'] = "All a3ultimate ingame stuffs guides";
        $this->data['item_data'] = $this->crafting_model->item_details();
        $this->data['request_type'] = 'randome';
        renderPage('guide/items', $this->data);
    }

    public function items() {

        $this->data['crafting_menu'] = $this->crafting_model->guide_generate_crafting_menu();
        $this->data['title'] = "A3ultimate items combination and guide";
        $this->data['request_type'] = 'randome';

        $item = $this->input->get('item', TRUE);
        $item_slug = clean_input("/[^a-zA-Z0-9-+\s]/", "", $item);

        $page = $this->input->get('page', TRUE);
        $page_slug = clean_input("/[^0-9]/", "", $page);

        $category = urldecode($this->input->get('category', TRUE));
        $category_slug = clean_input("/[^a-zA-Z0-9-+\s]/", "", $category);
        if ($item != $item_slug || $category != $category_slug || $page != $page_slug || $page_slug > 99) {
            show_404(urldecode($_SERVER["REQUEST_URI"]));
        }
        if ($item_slug != '') {
            $this->data['item_data'] = $this->crafting_model->item_details($item_slug, 'link', false, false, true);
            $this->data['request_type'] = 'item';
        } elseif ($category_slug != '') {
            if (isset($page_slug))
                $page_slug = 12 * ($page_slug - 1);
            $this->data['item_data'] = $this->crafting_model->item_category_details($category_slug, $page_slug);

            $this->data['cat'] = $category_slug;

            $this->data['paging'] = $this->create_pagination(site_url('guides/items') . "?category=" . $category_slug . "", $this->crafting_model->item_category_details_count($category_slug), 12, 5);
        } else {

            $this->data['item_data'] = $this->crafting_model->item_details();
        }
        /* echo '<pre>';
          print_r($this->data);
          echo '</pre>'; */
        renderPage('guide/items', $this->data);
    }

    public function maps() {

        $map = $this->input->get('map', TRUE);
        $monster = $this->input->get('monster', TRUE);
        $map_slug = clean_input("/[^a-zA-Z0-9-+\s]/", "", $map);
        $monster_slug = clean_input("/[^a-zA-Z0-9-+\s]/", "", $monster);

        if ($map != $map_slug || $monster != $monster_slug) {
            show_404(urldecode($_SERVER["REQUEST_URI"]));
        }
        $result = '';
        $type = 'code';
        // If we are deadling with monstes do monsters things
        if ($monster_slug != '') {
            // $monster_slug = $this->input->get('monster', TRUE);
            $type = 'link';
            $result = 'monster';
        }

        // If we are dealing with maps do map things 
        if ($map_slug != '') {
            // $map_slug = $this->input->get('map', TRUE);
            $type = 'name';
            $result = 'map';
        }


        $this->data['map_menu'] = $this->crafting_model->guide_generate_monster_menu();
        $this->data['title'] = "A3ultimate maps information and guide";
        $this->data['info_type'] = $result;
        if ($result == 'map') {
            $this->data['map_info'] = $this->crafting_model->map_monster_list($map_slug, $type);

            if (empty($this->data['map_info'])) {
                show_404(urldecode($_SERVER["REQUEST_URI"]));
            }
        } elseif ($result == 'monster') {
            $this->data['monster_info'] = $this->crafting_model->monster_list($monster_slug, $type, TRUE);
            if (empty($this->data['monster_info'])) {
                show_404(urldecode($_SERVER["REQUEST_URI"]));
            }
        } else {


            $this->data['map_info'] = $this->crafting_model->map_monster_list(rand(1, 3), 'code');
            if (empty($this->data['map_info'])) {
                show_404(urldecode($_SERVER["REQUEST_URI"]));
            }
            $this->data['info_type'] = 'map';
        }
        //$this->data['input']=$map_slug;
        renderPage('guide/maps', $this->data);
    }

    function rebirth() {

        $this->data['title'] = "A3ultimate rebirth information and guide";
        $this->data['rebirth_menu'] = $this->crafting_model->generate_rebirth_menu();

        $rebirth = $this->input->get('rebirth', TRUE);
        $rebirth_slug = clean_input("/[^a-zA-Z0-9-+\s]/", "", $rebirth);

        if ($rebirth != $rebirth_slug) {
            show_404(urldecode($_SERVER["REQUEST_URI"]));
        }


        if ($rebirth_slug != '') {
            $this->data['rebirth_info'] = $this->crafting_model->rebirth_info($rebirth_slug, 'link');
            $this->data['page_type'] = 'Rebirth';
        } else {
            $this->data['rebirth_info'] = $this->crafting_model->rebirth_info();
            $this->data['page_type'] = 'Randome';
        }




        renderPage('guide/rebirth', $this->data);
    }

    function create_pagination($link, $total_pages, $per_page, $link_at_a_time) {
        $this->load->library('pagination');

        $config['base_url'] = $link;
        $config['total_rows'] = $total_pages;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['num_links'] = $link_at_a_time;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination " style="margin: 0 auto;">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '<i class="mdi-av-fast-rewind"  title="First Page"></i>';
        $config['first_tag_open'] = '<li class="waves-effect">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '<i class="mdi-av-fast-forward" title="Last Page"></i>';
        $config['last_tag_open'] = '<li class="waves-effect">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="mdi-navigation-chevron-right" title="Next Page"></i>';
        $config['next_tag_open'] = '<li class="waves-effect">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="mdi-navigation-chevron-left" title="Previous Page"></i>';
        $config['prev_tag_open'] = '<li class="waves-effect">';
        $config['prev_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li class="waves-effect">';

        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active">';

        $config['cur_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */