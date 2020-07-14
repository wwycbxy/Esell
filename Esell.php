<?php
/*
Plugin Name: Esell
Plugin URI: https://wordpress.org/plugins/esell/
Description: This is a global supply chain plug-in
Version: 1.0.6
Author: Mr.Bai
Author URI: https://profiles.wordpress.org/wwyc/
License: GPLv2 or later
Text Domain: Esell
*/
/*  Copyright 2020  Mr.Bai  (email : 1051204179.@qq.com)
    This is software developed for a special customer. No modification is allowed without the permission of the original author.
*/


/**初始化的一些操作,填写appid等信息
 * Class dealbaoInit
 */

add_action('plugins_loaded', 'plugin_languages_init');
define( 'DEALBAO_VERSION', '1.0.0' );
define( 'DEALBAO_MINIMUM_WP_VERSION', '4.0' );
define( 'DEALBAO_PLUGIN_DIR', plugin_dir_path( __FILE__));//盘符地址
define( 'DEALBAO_DIR_URL', plugin_dir_url( __FILE__));//域名地址
//require_once(DEALBAO_PLUGIN_DIR.'/includes/CommonFunc.php');
set_time_limit(0);
register_activation_hook( __FILE__, 'dealbao_woocommerce_install' );
add_action('woocommerce_checkout_process', 'wh_getCartItemBeforePayment');

function dealbao_woocommerce_install(){
//    wp_die('asdsadas');
    if (!class_exists('Woocommerce')) {
        wp_die( __('Woocommerce is not enabled','dealbao'));
    }
}

//监听订单
function wh_getCartItemBeforePayment()
{
    require_once(DEALBAO_PLUGIN_DIR.'/includes/dealbaoOrder/dealbaoOrder.class.php');
}


// 多语言
function plugin_languages_init(){
    load_plugin_textdomain( 'dealbao', false, basename( dirname( __FILE__ ) ) . '/language/' );
}

require_once(DEALBAO_PLUGIN_DIR.'/includes/init.class.php');
is_admin() &&  $Init = new Init();




