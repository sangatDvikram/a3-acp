<?php

if (!function_exists('get_setting')) {

    function get_setting($data) {

        $ci = &get_instance();
        $ci->load->model('settings/settings_model');
        $setting = $ci->settings_model->select_settings_where($data);
        return $setting['value'];
    }

}
if (!function_exists('get_all_setting')) {

    function get_all_setting($data) {

        $ci = &get_instance();
        $ci->load->model('settings/settings_model');
        $setting = $ci->settings_model->select_all_settings_like($data);
        return $setting;
    }

}
if (!function_exists('update_setting')) {

    function update_setting($where,$value) {
        
        $ci = &get_instance();
        $ci->load->model('settings/settings_model');
        $setting = $ci->settings_model->update_settings($where,$value);
        return $setting;
        
    }

}