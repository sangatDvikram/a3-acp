<?php

require(APPPATH . 'libraries/REST_Controller.php');

class Admin extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
    }

    function searchchar_post() {
        $id = $this->post('char', true);
        if (isset($id)) {
            $data['result'] = $this->admin_model->search_character($id);

            $output['query'] = 'Unit';
            foreach ($data['result'] as $value) {
                $output['suggestions'][] = rtrim($value['c_id']);
            }
            $this->response($output);
        } else {


            $this->response(array());
        }
    }

    function characters_get() {
        $id = $this->get('query', true);
        if (isset($id) && $this->session->userdata('logged_in') && $this->session->userdata('grade') == 'BAN') {
            $data['result'] = $this->admin_model->search_character($id);

            $output['query'] = 'Unit';
            foreach ($data['result'] as $value) {
                $output['suggestions'][] = array("value" => rtrim($value['c_id']));
            }
            $this->response($output);
        } else {


            $this->response(array());
        }
    }

    function charactersinfo_post() {
        check_page_access(true, 'BAN');
        $id = $this->post('code', true);
        if (isset($id)) {
            $data['result'] = $this->admin_model->search_character_with_account_details($id);
            foreach ($data['result'] as $value) {
                $output = array(
                    "value" => rtrim($value['character']),
                    'account' => rtrim($value['account']),
                    'status' => rtrim($value['status']),
                    'msg' => rtrim($value['msg'])
                );
            }
            $this->response($output);
        } else {


            $this->response(array());
        }
    }

    function charactersInventoryInfo_post() {
        $id = $this->post('character', true);
        if (isset($id) && $this->session->userdata('logged_in') && $this->session->userdata('grade') == 'BAN') {
            $character_details = $this->admin_model->getCharacterDetails($id);
            $character_inventory = get_mbody_part('INVEN', $character_details['m_body']);
            $character_inventory_items = get_all_inventory_items($character_inventory);
            $character_wear_items = get_wear_item(get_mbody_part('WEAR', $character_details['m_body']));
            $item = "";
            $i = 0;
            foreach ($character_inventory_items as $inventory_item) {
                $item_info = get_item_options($inventory_item);
                $data = item_option_format($item_info);
                $item.='<a href="' . site_url('guides/items') . '?item=' . $item_info['link'] . '">' . "<img src='" . $item_info['image'] . "' class='responsive-img tooltipped player-item' height='64' width='32' data-position='bottom' data-delay='50' data-tooltip='$item_info[item_name]' style='cursor:pointer' data-info='$data[data]'></a>&ensp;";
                $i++;
                if ($i % 6 == 0)
                    $item.="<br>";
            }
            $output_data['item'] = ($item);
            $item = "";
            $i = 0;
            foreach ($character_wear_items as $wear_item) {
                $item_info = get_item_options($wear_item);
                $data = item_option_format($item_info);
                $item.='<a href="' . site_url('guides/items') . '?item=' . $item_info['link'] . '">' . "<img src='" . $item_info['image'] . "' class='responsive-img tooltipped wear-item' height='64' width='32'  data-position='bottom' data-delay='50' data-tooltip='$item_info[item_name]' style='cursor:pointer' data-info='$data[data]'></a>&ensp;";
                $i++;
                if ($i % 3 == 0)
                    $item.="<br>";
            }
            $output_data['wear'] = ($item);
            $this->response($output_data);
        } else {


            $this->response(array());
        }
    }

    function charactersinfonew_get() {
        $id = $this->get('query', true);
        if (isset($id) && $this->session->userdata('logged_in') && $this->session->userdata('grade') == 'BAN') {
            $data['result'] = $this->admin_model->search_character_with_account_details($id);

            $output['query'] = 'Unit';
            foreach ($data['result'] as $value) {
                $output['suggestions'][] = array("value" => rtrim($value['character']), 'account' => rtrim($value['account']), 'status' => rtrim($value['status']));
            }
            $this->response($output);
        } else {


            $this->response(array());
        }
    }

    function searchaccount_get() {
        check_page_access(true, 'BAN');
        $id = $this->get('query', true);
        if (isset($id)) {
            $data['result'] = $this->admin_model->search_account($id);

            $output['query'] = 'Unit';
            foreach ($data['result'] as $value) {
                $output['suggestions'][] = array("value" => rtrim($value['c_id']));
            }
            $this->response($output);
        } else {


            $this->response(array());
        }
    }

    function registerd_accounts_post() {
        check_page_access(true, 'BAN');
        $id = $this->post('char', true);
        $start = $this->post('start', true);
        $limit = $this->post('limit', true);
        $data['result'] = $this->admin_model->getAccountDetails($id);
        $i = 1;
        $output = array();
        $output['recordsTotal'] = count($data['result']);
        $output['recordsFiltered'] = count($data['result']);
        foreach ($data['result'] as $result) {
            $arguments = array($i, $result['c_id'], $result['name'], $result['c_headerb'], $result['c_headera'], $result['word'], $result['d_cdate'], $result['verified'], $result['regip'],
                "<a href='/Admin/ViewAccount/$result[c_id]/' title='View Account Info.'>[VIEW]</a> | <a href='/Admin/EditAccount/$result[c_id]/' title='Edit Account Information'>[EDIT]</a>");
            $output['data'][] = $arguments;
            $i++;
        }

        $this->response($output);
    }

    function getAdminActionLog_post() {
        check_page_access(true, 'BAN');
        $this->load->model('log_model');
        $admin_actions = $this->log_model->admin_action_log();

        $data = "";

        $data.=' <table class="responsive-table">
                <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                ';

        foreach ($admin_actions as $actions) {
            $data.= "<tr><td>$actions[sr]</td><td>$actions[username]</td><td class='red-text text-darken-2'><b>$actions[action]</b></td><td>$actions[date]</tr>";
        }

        $data.='  </tbody>
            </table>';

        $output['data'] = $data;
        $this->response($output);
    }

    function getPlayerActionLog_post() {
        check_page_access(true, 'BAN');
        $this->load->model('log_model');
        $player_actions = $this->log_model->player_action_log();

        $data = "";

        $data.='<table class="responsive-table">
                <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Username</th>
                    <th>IP</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                ';
        foreach ($player_actions as $actions) {
            $data.= "<tr><td>$actions[sr]</td><td>$actions[username]</td><td>$actions[ip]</td><td class='red-text text-darken-2'><b>$actions[action]</b></td><td>$actions[date]</tr>";
        }

        $data.=' </tbody>
            </table>';

        $output['data'] = $data;
        $this->response($output);
    }
    function getSiteVisitors_post() {
        check_page_access(true, 'BAN');
        $this->load->model('log_model');
        $visitors = $this->log_model->visitors();

        $data = "";
        $data.='<table class="responsive-table">
                <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Ip</th>
                    <th>Username</th>
                    <th>Current Page</th>
                    <th>Type</th>
                    <th>Last Activity</th>
                </tr>
                </thead>
                <tbody>';
                $i=0;
                foreach($visitors as $logs)
                {
                    $data.= "<tr><td>$i</td><td>$logs[ip_address]</td><td>$logs[username]</td><td style='width:30%'>".str_replace(base_url(),"",$logs['current_url'])."</td><td>$logs[type]</td><td>".date('D jS  F Y h:i:s A',$logs['last_activity'])."</td></tr>";
                    $i++;
                }
                
               $data.=' </tbody>
            </table>';

        $output['data'] = $data;
        $this->response($output);
    }

}
