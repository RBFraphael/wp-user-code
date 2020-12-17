<?php
if(!defined("ABSPATH")): exit; endif;

if( function_exists('acf_add_local_field_group') ):

    $data = file_get_contents(dirname(__FILE__)."/fields.json");
    $data = json_decode($data, true);

    foreach($data as $field_group){
        acf_add_local_field_group($field_group);
    }
    
endif;