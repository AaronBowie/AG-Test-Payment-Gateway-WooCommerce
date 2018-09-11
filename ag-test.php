<?php
# @Author: Aaron Bowie
# @Date:   Monday, September 10th 2018, 3:06:30 pm
# @Email:  support@weareag.co.uk
# @Filename: ag-test.php
# @Last modified by:   Aaron Bowie
# @Last modified time: Tuesday, September 11th 2018, 2:53:44 pm

/*
Plugin Name: AG Test WooCommerce Gateway
Plugin URI: https://www.weareag.co.uk/
Description: Extends WooCommerce By Adding A Test Payment Gateway.
Version: 0.1
Author: Aaron Bowie, We are AG
Author URI: https://www.weareag.co.uk/
WC requires at least: 3.0.0
WC tested up to: 3.4.4
*/


defined( 'ABSPATH' ) or die( "No script kiddies please!" );


function atg_fs()
{
    global  $atg_fs ;
    if ( !isset( $atg_fs ) ) {
        // Include Freemius SDK.
        require_once dirname( __FILE__ ) . '/inc/freemius/start.php';
        $atg_fs = fs_dynamic_init( array(
            'id'               => '2583',
            'slug'             => 'ag-test-gateway',
            'type'             => 'plugin',
            'public_key'       => 'pk_ec90d8275ebc550dd734cb9e71843',
            'is_premium'       => false,
            'has_addons'       => false,
            'has_paid_plans'   => false,
            'is_org_compliant' => false,
            'menu'             => array(
                'slug'       => 'AG_plugins',
                'first-path' => 'admin.php?page=AG_plugins',
                'support'    => false,
                'parent'     => array(
                'slug' => 'AG_plugins',
            ),
        ),
            'is_live'          => true,
        ) );
    }
    return $atg_fs;
}
// Init Freemius.
atg_fs();
// Signal that SDK was initiated.
do_action( 'atg_fs_loaded' );




// Include Gateway Class and register Payment Gateway with WooCommerce
add_action( 'plugins_loaded', 'ag_test_init', 0 );
function ag_test_init(){

  if ( !class_exists( 'WC_Payment_Gateway' ) ) {
      return;
  }

  include_once 'test-class.php';

  // Show gateway to user/admin
  function add_test_gateway( $methods ) {
  	$show_visitors = false;
  	if ($settings = get_option('woocommerce_ag_test_gateway_settings')) {
  		if (isset($settings['enabled_non_admin']) && $settings['enabled_non_admin'] == 'yes') {
  			$show_visitors = true;
  		}
  	}
  	if (current_user_can('administrator') || WP_DEBUG || $show_visitors) {
  		$methods[] = 'ag_test_gateway';
  	}
  	return $methods;
  }
  add_filter('woocommerce_payment_gateways', 'add_test_gateway' );

  // Load image for FS
  function test_custom_icon() {
      return dirname( __FILE__ ) . '/plugin-icon.png';
  }
  atg_fs()->add_filter( 'plugin_icon', 'test_custom_icon' );

}



/*-----------------------------------------------------------------------------------*/
/*	Licence management section
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ag_plugin' ) ) {
    add_action( 'admin_menu', 'ag_plugin' );
    function ag_plugin()
    {
        add_menu_page(
            'AG License Activation Menu',
            'AG Plugins',
            'manage_options',
            'AG_plugins',
            'AG_plugins',
            'dashicons-admin-network'
        );
    }
}
if ( !function_exists( 'AG_plugins' ) ) {
    function AG_plugins()
    {
        ?>
		<div class="wrap about-wrap">
			<h1>AG Plugins</h1>
			<div class="about-text">Thank you for becoming part of the AG family!</div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active">Tips & Support</a>
			</h2>

			<div class="changelog">
				<h3>Activating the plugin</h3>
				<div class="feature-section col two-col">
					<div class="last-feature">
						<h4>Why activate?</h4>
						<p>You must activate the plugin to get the latest updates for the plugin</p>
					</div>
				</div>
				<hr />
			</div>
		</div>

		<style>
			.about-wrap .ag-badge {
				position: absolute;
				right: 0;
				top: 0;
			}
			.about-wrap {
				font-size: 15px;
				margin: 25px 40px 0 20px;
				max-width: 1050px;
				position: relative;
			}
			.about-wrap img {
				width:100%;
				height: 210px;
			}
			.thickbox strong {
				text-align: center;
				display: block;
				width: 100%
			}
			.agimg {
				width: 48%;
				float:left;
				padding:8px;
			}
		</style> <?php
    }
}
