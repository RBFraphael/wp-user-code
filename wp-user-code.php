<?php
/**
 * Plugin Name:       Wordpress User Code
 * Plugin URI:        https://github.com/rbfraphael/wp-user-code
 * Description:       Add custom code to your Wordpress site
 * Version:           1.0.1
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
define('WUC_VERSION', "1.0.1");

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
    echo "\n<!-- WP User Code - Head Start -->";
    echo "\n".$head_code;
    echo "\n<!-- WP User Code - Head End -->\n";
}
add_filter("wp_head", "wuc_head_code", 1);

/**
 * Content code
 * 
 * Add code before and after main content using the_content hook
 */
function wuc_content_code($content)
{
    $before = get_field("wuc_before_content", "options");
    $before_prefix = "\n<!-- WP User Code - Before Content Start -->";
    $before_sufix = "\n<!-- WP User Code - Before Content End -->\n";

    $after = get_field("wuc_after_content", "options");
    $after_prefix = "\n<!-- WP User Code - After Content Start -->";
    $after_sufix = "\n<!-- WP User Code - After Content End -->\n";

    $before_content = $before_prefix."\n".$before."\n".$before_sufix;
    $after_content = $after_prefix."\n".$after."\n".$after_sufix;

    return $before_content."\n".$content."\n".$after_content;
}
add_filter("the_content", "wuc_content_code", 10);

/**
 * Footer code
 * 
 * Add code to <footer> tag using wp_footer hook
 */
function wuc_footer_code()
{
    $footer_code = get_field("wuc_footer_code", "options");
    echo "\n<!-- WP User Code - Footer Start -->";
    echo "\n".$footer_code;
    echo "\n<!-- WP User Code - Footer End -->\n";
}
add_filter("wp_footer", "wuc_footer_code", 10);

/**
 * Enqueue scripts
 * 
 * Load global and local JavaScript files
 */
function wuc_enqueue_scripts()
{
    while(have_rows("wuc_js_files", "options")){
        the_row();

        $js_id = get_sub_field("js_id", "options");
        $js_file = get_sub_field("js_file", "options");
        $js_head = get_sub_field("load_in_head", "options");

        if(wp_script_is($js_id, "registered")){
            wp_deregister_script($js_id);
        }

        wp_register_script($js_id, $js_file, [], NULL, $js_head ? false : true);
        wp_enqueue_script($js_id);
    }

    while(have_rows("wuc_js_files")){
        the_row();
        
        $js_id = get_sub_field("js_id");
        $js_file = get_sub_field("js_file");
        $js_head = get_sub_field("load_in_head");

        if(wp_script_is($js_id, "registered")){
            wp_deregister_script($js_id);
        }

        wp_register_script($js_id, $js_file, [], NULL, $js_head ? false : true);
        wp_enqueue_script($js_id);
    }
}
add_action("wp_enqueue_scripts", "wuc_enqueue_scripts");

/**
 * Enqueue styles
 * 
 * Load global and local CSS files
 */
function wuc_enqueue_styles()
{
    while(have_rows("wuc_css_files", "options")){
        the_row();

        $css_id = get_sub_field("css_id", "options");
        $css_file = get_sub_field("css_file", "options");

        if(wp_style_is($css_id, "registered")){
            wp_deregister_style($css_id);
        }

        wp_register_style($css_id, $css_file);
        wp_enqueue_style($css_id);
    }

    while(have_rows("wuc_css_files")){
        the_row();

        $css_id = get_sub_field("css_id");
        $css_file = get_sub_field("css_file");

        if(wp_style_is($css_id, "registered")){
            wp_deregister_style($css_id);
        }
        
        wp_register_style($css_id, $css_file);
        wp_enqueue_style($css_id);
    }
}
add_action("wp_enqueue_scripts", "wuc_enqueue_styles");

/**
 * Upload formats
 * 
 * Allow upload of CSS and JS files
 */
function wuc_upload_formats($mime_types)
{
    $mime_types['css'] = "text/css";
    $mime_types['js'] = "application/javascript";
    
    return $mime_types;
}
add_filter("upload_mimes", "wuc_upload_formats");

/**
 * Check file
 * 
 * Check file name and extension on upload
 */
function wuc_check_file_ext($types, $file, $filename, $mimes)
{
    if(strpos($filename, ".css") !== false){
        $types['ext'] = "css";
        $types['type'] = "text/css";
    }

    if(strpos($filename, ".js") !== false){
        $types['ext'] = "js";
        $types['type'] = "application/javascript";
    }

    return $types;
}
add_filter("wp_check_filetype_and_ext", "wuc_check_file_ext", 10, 4);
