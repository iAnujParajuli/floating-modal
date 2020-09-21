<?php
/**
 * Plugin Name:       Floating Modal
 * Plugin URI:
 * Description:       Add a modal with delivery information to your website
 * Version:           1.0.0
 * Author:            Anuj Parajuli <anuj.parajuli01@gmail.com>
 */

define('FLM_BASE_DIR', __DIR__ . "/");
define('FLM_BASE_URL', plugin_dir_url( __FILE__ ));
require_once 'class-flm-base-controller.php';
require_once 'helpers.php';


$flmBaseController = new flmBaseController();
add_action( "admin_action_flm_activator_button", array($flmBaseController, 'toggleActivation') );
add_action( "admin_action_flm_save_modal_data", array($flmBaseController, 'saveModalData') );
add_action("activate_floating-modal", function() {
    wp_redirect(admin_url("admin.php?page=floating-modal/admin/index.php"));
});

register_activation_hook( __FILE__, function() {
    add_option("flm_status", 0);
    add_options_page(
        __( 'Floating Modal', 'FLM' ),
        __( 'Floating Modal', 'FLM' ),
        'manage_options',
        'custom-bootstrap-modal.php',
        'custom-bootstrap-modal'
    );
});

add_action("admin_menu", function() {
    add_menu_page(
        'Floating Modal',
        'Floating Modal',
        'manage_options',
        'floating-modal/admin/index.php',
        '',
        'dashicons-pressthis'
    );
});

add_action( 'admin_enqueue_scripts', 'FLM_add_script' );
function FLM_add_script() {
    wp_enqueue_script('dom-script', plugin_dir_url( __FILE__ ) . 'admin/js/cbsm.js#asyncdeferload', null, false, true);
    wp_enqueue_style('dom-style', plugin_dir_url( __FILE__ ) . 'admin/css/flm-style.css');
}

// Async load
function FLM_async_scripts($url)
{
    $newurl = $url;
    if ( strpos( $url, '#asyncdeferload') !== false ) {
        $newurl = str_replace( '#asyncdeferload', '', $url );
        $newurl .= "' async='async" . "' defer='defer";
    } elseif ( strpos( $url, '#asyncload') !== false ) {
        $newurl = str_replace( '#asyncload', '', $url );
        $newurl .= "' async='async";
    }
    return $newurl;
}
add_filter( 'clean_url', 'FLM_async_scripts', 11, 1 );


add_action('wp_footer', 'flm_add_script_wp_footer');
function flm_add_script_wp_footer() {
    if (get_option("flm_status") && get_option("flm_modal_data")) {
        echo "<script> var modalData =" . json_encode(get_option("flm_modal_data")) . ", pageID = " . get_the_ID() . "</script>";
        wp_enqueue_script('modal-script', FLM_BASE_URL . "public/js/modal.js");
        wp_enqueue_style('modal-css', FLM_BASE_URL . "public/css/modal.css");
    }
}

register_deactivation_hook(__FILE__, function() {
    //code
});