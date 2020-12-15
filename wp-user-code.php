<?php
/**
 * Plugin Name:       Wordpress User Code
 * Plugin URI:        https://github.com/rbfraphael/wp-user-code
 * Description:       Add custom code to your Wordpress site
 * Version:           1.0.0
 * Author:            RBFraphael
 * Author URI:        https://rbfraphael.com.br/
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if(!defined("ABSPATH")): exit; endif;

/**
 * Plugin constants
 */
define('WUC_PATH', plugin_dir_path(__FILE__));
define('WUC_URL', plugin_dir_url(__FILE__));
define('WUC_VERSION', "1.0.0");

/**
 * Plugin initialization
 * 
 * Enable built-in ACF and initialize configuration
 */
function wuc_init()
{
    if(!function_exists('get_field')){
        wuc_load_acf();
    }

    include_once(WUC_PATH."/includes/acf-addons/acf-addons.php");
    include_once(WUC_PATH."/includes/wuc-fields.php");
}
add_action("after_setup_theme", "wuc_init");

/**
 * Enable built-in ACF
 * 
 * Defines ACF's constants, includes built-in acf.php file and hide "Custom Fields" from Wordpress panel
 */
function wuc_load_acf()
{
    define('MY_ACF_PATH', WUC_PATH."/includes/acf/");
    define('MY_ACF_URL', WUC_URL."/includes/acf/");

    include_once(MY_ACF_PATH."acf.php");

    add_filter("acf/settings/url", "my_acf_settings_url");
    function my_acf_settings_url($url){
        return MY_ACF_URL;
    }

    add_filter("acf/settings/show_admin", "__return_false");
}

/**
 * Options Page
 * 
 * Register options page for plugin settings
 */
function wuc_options_page()
{
    if(function_exists("acf_add_options_sub_page")){
        acf_add_options_sub_page([
            'page_title' => "Additional Code",
            'menu_title' => "Additional Code",
            'menu_slug' => "wp-user-code",
            'icon_url' => "dashicons-media-code",
            'parent_slug' => "options-general.php"
        ]);
    }
}
add_action("acf/init", "wuc_options_page");

/**
 * Head code
 * 
 * Add code to <head> tag using wp_head hook
 */
function wuc_head_code()
{
    $head_code = get_field("wuc_head_code", "options");
    echo "\n".$head_code."\n";
}
add_filter("wp_head", "wuc_head_code");

/**
 * Content code
 * 
 * Add code before and after main content using the_content hook
 */
function wuc_content_code($content)
{
    $before = get_field("wuc_before_content", "options");
    $after = get_field("wuc_after_content", "options");
    return $before."\n".$content."\n".$after;
}
add_filter("the_content", "wuc_content_code");

/**
 * Footer code
 * 
 * Add code to <footer> tag using wp_footer hook
 */
function wuc_footer_code()
{
    $footer_code = get_field("wuc_footer_code", "options");
    echo "\n".$footer_code."\n";
}
add_filter("wp_footer", "wuc_footer_code");
