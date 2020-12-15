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

        add_action('acf/include_field_types', [$this, 'include_field_types'], 5);
        add_action('acf/include_location_rules', [$this, 'include_location_rules'], 5);
    }

    function include_field_types(){
        include_once('fields/class-acf-field-repeater.php');
    }
    
    function include_location_rules() {
        include_once('options-page/class-acf-location-options-page.php');
    }
}

new WUC_ACF_Addons();
