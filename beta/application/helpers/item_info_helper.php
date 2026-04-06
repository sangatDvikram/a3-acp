<?php
if ( ! function_exists('item_info')) {

    function item_info($data){

        $ci = &get_instance();
        $ci->load->model('crafting_model');

        $item['item_info']=$ci->crafting_model->item_details($data,'code');
        return $item['item_info'];

    }
}