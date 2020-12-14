<?php
if(!defined("ABSPATH")): exit; endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5fd7afee5ffd6',
        'title' => 'User Code',
        'fields' => array(
            array(
                'key' => 'field_5fd7affc122b9',
                'label' => '&lt;head&gt; code',
                'name' => 'wuc_head_code',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => 5,
                'new_lines' => '',
            ),
            array(
                'key' => 'field_5fd7b03f122bb',
                'label' => 'Before content',
                'name' => 'wuc_before_content',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => 5,
                'new_lines' => '',
            ),
            array(
                'key' => 'field_5fd7b053122bc',
                'label' => 'After content',
                'name' => 'wuc_after_content',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => 5,
                'new_lines' => '',
            ),
            array(
                'key' => 'field_5fd7b02a122ba',
                'label' => '&lt;footer&gt; code',
                'name' => 'wuc_footer_code',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => 5,
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'wp-user-code',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
endif;