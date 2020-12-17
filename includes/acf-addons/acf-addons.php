<?php
if(!defined("ABSPATH")): exit; endif;

class WUC_ACF_Addons
{
    function __construct()
    {
        include_once('options-page/options-page.php');

        if(is_admin()){
            include_once('options-page/admin-options-page.php');
        }

        add_action('init', [$this, 'register_assets']);
        add_action('acf/include_field_types', [$this, 'include_field_types'], 5);
        add_action('acf/include_location_rules', [$this, 'include_location_rules'], 5);
        add_action('acf/input/admin_enqueue_scripts', [$this, 'input_admin_enqueue_scripts']);
    }

    function register_assets()
    {
        $url = plugin_dir_url(__FILE__);
		wp_register_script('acf-pro-input', $url.'/assets/js/acf-pro-input.min.js', ['acf-input'], "5.9.1");
		wp_register_style('acf-pro-input', $url.'/assets/css/acf-pro-input.css', ['acf-input'], "5.9.1");
    }
    
    function input_admin_enqueue_scripts()
    {
		wp_enqueue_script('acf-pro-input');
		wp_enqueue_style('acf-pro-input');
    }

    function include_field_types()
    {
        include_once('fields/class-acf-field-repeater.php');
    }
    
    function include_location_rules()
    {
        include_once('options-page/class-acf-location-options-page.php');
    }
}

new WUC_ACF_Addons();
