<?php

require(APPPATH . 'libraries/REST_Controller.php');

class Game_guide extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('guide/guide_model');
       
    }

    public function getCategoryList_post() {
        check_page_access(true, 'BAN');

        $data = $this->guide_model->get_all_category_list();

        $output = array('data' => '');
        foreach ($data as $item) {
            $enabled = ($item['enable_posts']) ? "<a href='#' title='Posting is allowed'> <i class='small mdi-action-done'></i></a>" : "<a href='#' title='Posting is not allowed'> <i class='mdi-content-clear small'></i></a>";
            $arguments = array($item['sr'], rtrim($item['category_name']), $enabled, "<a href='#' class='open-edit-category' id='$item[sr]'> <i class='mdi-image-edit small'></i></a>");
            $output['data'][] = $arguments;
        }

        $this->response($output);
    }

    public function getGameGuideList_post() {
        check_page_access(true, 'BAN');

        $data = $this->guide_model->get_all_game_guides();

        $output = array('data' => '');
        foreach ($data as $item) {
            $enabled = ($item['verified']) ? "<a href='#' title='verified' class='change_status' id='$item[sr]' data-verified='1'> <i class='mdi-action-done small'></i></a>" : "<a href='#' title='Not Verified' class='change_status' id='$item[sr]' data-verified='0'> <i class='mdi-content-clear small'></i></a>";
            $arguments = array($item['sr'], rtrim($item['username']), rtrim($item['playername']), $item['guide_title'], substr($item['guide_body'], 0, 30) . '...', "<a href='#'><i class='mdi-action-aspect-ratio small view-guide' id='$item[guide_link]' title='Click to view the preview'></i></a>", $enabled, "<a href='#' class='open-game-guide' id='$item[guide_link]'> <i class='mdi-image-edit '></i></a>|<a href='#' class='alert-delete-game-guide' id='$item[guide_link]'> <i class='mdi-action-delete '></i></a>");
            $output['data'][] = $arguments;
        }

        $this->response($output);
    }

    public function getPlayerGameGuideList_post() {
        check_page_access(true);

        $data = $this->guide_model->get_all_game_guides_where(array('username' => $this->session->userdata('username')));

        $output = array('data' => '');
        foreach ($data as $item) {
            $enabled = ($item['verified']) ? "<a href='#' title='verified'> <i class='mdi-action-done small'></i></a>" : "<a href='#' title='Not Verified'> <i class='mdi-content-clear small'></i></a>";
            $arguments = array($item['sr'], rtrim($item['playername']), $item['guide_title'], substr($item['guide_body'], 0, 30) . '...', "<a href='#'><i class='mdi-action-aspect-ratio small view-guide' id='$item[guide_link]' title='Click to view the preview'></i></a>",$enabled, "<a href='" . site_url('writer/edit') . "/$item[guide_link]' class='open-game-guide' id='$item[guide_link]'> <i class='mdi-image-edit small'></i></a>");
            $output['data'][] = $arguments;
        }

        $this->response($output);
    }

    public function getGameGuideDetails_post() {
        check_page_access(true, 'BAN');
        $link = $this->post('link', true);
        $link = clean_input("/[^a-zA-Z0-9-+]/", "", $link);
        $data = $this->guide_model->get_game_guide_details($link);
        $this->response($data);
    }
    public function deleteGameGuide_post() {
        check_page_access(true, 'BAN');
        $link = $this->post('link', true);
        $link = clean_input("/[^a-zA-Z0-9-+]/", "", $link);
        $data = $this->guide_model->delete_game_guide($link);
        create_admin_log('Deleted game guide');
        $this->response("Guide has been successfully deleted");
    }

    public function getPlayerGameGuideDetails_post() {
        check_page_access(true);
        $link = $this->post('link', true);
        $link = clean_input("/[^a-zA-Z0-9-+]/", "", $link);
        $data = $this->guide_model->get_game_guide_details($link);
        $user = $this->session->userdata('username');
        if ($data['username'] == $user) {
            $this->response($data);
        } else
            $this->response(array());
    }

    public function getCategoryDetails_post() {
        check_page_access(true, 'BAN');
        $sr = $this->post('sr', true);
        $link = clean_input("/[^0-9]/", "", $link);
        $data = $this->guide_model->get_category_details($sr);
        $this->response($data);
    }

    public function createGuideCategory_post() {
        check_page_access(true, 'BAN');
        $data['category_name'] = $this->post('category_name', true);
        $data['category_name'] = clean_input("/[^a-zA-Z\s]/", "", $data['category_name']);
        $data['enable_posts'] = ($this->post('enable_posts', true)) ? "1" : "0";
        $data['category_link'] = url_title($data['category_name'], 'dash', TRUE);
       
        create_admin_log( "Added new game guide Category ->$data[category_name] .!!");
         
        $this->guide_model->insert_new_category($data);
        $this->response("Category has been successfully created");
    }

    public function updateeGuideCategory_post() {
        check_page_access(true, 'BAN');
        $sr = $this->post('sr', true);
        $data['category_name'] = $this->post('category_name', true);
        $data['category_name'] = clean_input("/[^a-zA-Z\s]/", "", $data['category_name']);
        $data['enable_posts'] = ($this->post('enable_posts', true)) ? "1" : "0";
        $data['category_link'] = url_title($data['category_name'], 'dash', TRUE);
      
        create_admin_log("Updated game guide Category.!!");
        
        $this->guide_model->update_guide_category($sr, $data);
        $this->response("Category has been successfully updated");
    }

    public function updateGameGuide_post() {
        $this->load->model('players/players_model');
        check_page_access(true, 'BAN');
        $sr = $this->post('sr', true);
        $data['guide_title'] = $this->post('guide_title', true);
        $data['category_id'] = $this->post('category_id', true);
        $data['guide_body'] = urldecode($this->post('guide_body'));
        $data['guide_link'] = url_title($data['guide_title'], 'dash', TRUE);
        $data['verified'] = $this->post('verified', true);
        $this->guide_model->update_game_guide($sr, $data);
      
        create_admin_log( "Updated game guide <a href='" . site_url('ingameguide') . "/$data[guide_link]'>here</a>.!!");
        
        //print_r($data);
        $this->response($sr);
    }
    public function updateGameGuideVisibleStatus_post() {
        $this->load->model('players/players_model');
        check_page_access(true, 'BAN');
        $sr = $this->post('sr', true);
        $verified=($this->post('verified', true)==1)?'1':"0";
        $data['verified'] = $verified;
        $this->guide_model->update_game_guide($sr, $data);
      
        create_admin_log( "Updated game guide visible status.!!");
        
        //print_r($data);
        $this->response("Game Guide Status Updated Successfully");
    }

}
