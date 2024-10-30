<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Bitcoin_Online
 * @author    PaR <pavel.rechberg@gmail.cz>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 PaR
 *
 * @wordpress-plugin
 * Plugin Name:       Bitcoin Online
 * Plugin URI:        
 * Description:       Displays online ticker values for the most popular exchange website MT.GOX
 * Version:           1.1
 * Author:            PaR
 * Author URI:        
 * Text Domain:       bitcoin-online-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


require_once( plugin_dir_path( __FILE__ ) . 'public/bitcoinOnline.class.php' );

register_activation_hook( __FILE__, array( 'BitcoinOnline', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'BitcoinOnline', 'deactivate' ) );
add_action( 'plugins_loaded', array( 'BitcoinOnline', 'get_instance' ) );


if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/bitcoinOnlineAdmin.class.php' );
	add_action( 'plugins_loaded', array( 'BitcoinOnlineAdmin', 'get_instance' ) );

}
