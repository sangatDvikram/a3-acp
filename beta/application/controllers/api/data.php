<?php

require(APPPATH . 'libraries/REST_Controller.php');

class data extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/data_model');

        check_page_access(true, 'BAN');
    }

    function maplist_post() {
        //$code=$this->get('code',true);
        $data = $this->data_model->map_list();

        $output = array();
        foreach ($data as $item) {
            $arguments = array($item['map_code'], rtrim($item['map_name']), $item['map_info'], $item['map_image'], $item['map_type'], "<a href='#'> <i class='mdi-image-edit'></i></a>");
            $output['data'][] = $arguments;
        }

        $this->response($output);
    }

    function itemlist_post() {
        $output = array();
        $total = $this->data_model->item_total_count();
        $output['recordsTotal'] = $total['total'];
        //$code=$this->get('code',true);
        $start = $this->post('start', TRUE);
        $start = clean_input("/[^0-9]/", "", $start);

        $length = $this->post('length', TRUE);
        $length = clean_input("/[^0-9]/", "", $length);

        $search = $this->post('search', TRUE);
        // $search = clean_input("/[^a-zA-Z0-9]/", "", $search);

        $data = $this->data_model->item_list(clean_input("/[^a-zA-Z0-9]/", "", $search['value']), $start, $length);


        $output['recordsFiltered'] = count($data);

        foreach ($data as $item) {
            $arguments = array($item['item_code'], rtrim($item['item_name']), $item['item_type'], $item['item_class'], "<a href='" . site_url('guides/items') . "?item=$item[link]'><img src='$item[image]'></a>", substr($item['item_info'], 0, 20) . "..", "<a href='#' class='open-item-edit-model ' id='$item[sr_no]'> <i class='mdi-image-edit small'></i></a>");
            $output['data'][] = $arguments;
        }


        $this->response($output);
    }

    function getItemDetails_post() {
        $code = $this->post('sr', true);
        $code = clean_input("/[^0-9]/", "", $code);

        $data = $this->data_model->get_item_details_with_sr($code);

        $this->response($data);
    }

    function updateItemDetails_post() {
        $sr = $this->post('sr_no', true);
        $data['item_code'] = $this->post('item_code', true);
        $data['item_code'] = clean_input("/[^0-9]/", "", $data['item_code']);
        $data['item_name'] = $this->post('item_name', true);
        $data['item_name'] = clean_input("/[^a-zA-Z0-9]/", "", $data['item_name']);
        $data['item_info'] = $this->post('item_info', true);
        $data['item_info'] = clean_input('/[A-Za-z0-9_.?"]/', "", $data['item_info']);
        $data['image'] = $this->post('image', true);
        $data['image'] = clean_input("/[A-Za-z0-9_:/.?=#%]/", "", $data['image']);
        $data['item_type'] = $this->post('item_type', true);
        $data['item_type'] = clean_input("/[^a-zA-Z]/", "", $data['item_type']);
        $data['item_class'] = $this->post('item_class', true);
        $data['item_class'] = clean_input("/[^a-zA-Z]/", "", $data['item_class']);

        $this->data_model->update_item_info($sr, $data);

        $this->response("$data[item_name] Information Updated Successfully");
    }

    function monsterlist_post() {
        //$code=$this->get('code',true);
        $data = $this->data_model->monster_list();

        $output = array();
        foreach ($data as $item) {
            $arguments = array($item['monster_code'], rtrim($item['monster_name']), $item['map_name'], "<a href='" . site_url('guides/maps') . "?monster=$item[link]'><img src='/allitems/monsters/$item[monster_code].jpg'></a>", $item['monster_info'], $item['monster_type'], "<a href='#'> <i class='mdi-image-edit small'></i></a>");
            $output['data'][] = $arguments;
        }


        $this->response($output);
    }

    function rebirthlist_post() {
        //$code=$this->get('code',true);
        $data = $this->data_model->rebirth_list();

        $output = array();
        foreach ($data as $rebirth) {


            $items = $rebirth['Item_req'];
            $reward = $rebirth['Rb_reward'];
            if (isset($rebirth['items'])) {
                $items = "";
                foreach ($rebirth['items'] as $item) {
                    $items.= '<a href="' . site_url('guides/items') . '?item=' . $item['link'] . '"> <img src="' . $item['image'] . '" alt="" class=" responsive-img tooltipped left" data-href="" data-position="bottom" data-delay="50" data-tooltip="' . $item['item_name'] . '" style="min-height:60px"></a> ';
                }
            }
            if (isset($rebirth['reward'])) {
                $reward = '<a href="' . site_url('guides/items') . '?item=' . $rebirth['reward']['link'] . '"><img src="' . $rebirth['reward']['image'] . '" alt="" class=" responsive-img tooltipped left" data-position="bottom" data-delay="50" data-tooltip="' . $rebirth['reward']['item_name'] . '" style="min-height:60px"> </a>';
            }
            $coins = "Coins req : $rebirth[Coin_req]<br> Gold req : $rebirth[Gold_req]<br> OP req : $rebirth[Gold_req]";

            $arguments = array($rebirth['Rb'], rtrim($rebirth['rb_name']), $rebirth['Level_req'], number_format($rebirth['Wz_req']), $items, $rebirth['Item_info'], $rebirth['Quest_info'], $reward, $coins, $rebirth['reset_stats'], "<a href='#'> <i class='mdi-image-edit'></i></a>");
            $output['data'][] = $arguments;
        }


        $this->response($output);
    }

}
