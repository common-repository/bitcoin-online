<?php
/**
 * Bitcoin_Online.
 *
 * @package   Bitcoin_Online
 * @author    PaR <pavel.rechberg@gmail.cz>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 PaR
 */


class BitcoinOnline {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.1.0';

	/**
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'bitcoin-online';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
        
        add_shortcode("btc_online",  array( $this, 'btc_online_sc' ));
        add_shortcode("btc_online_ex",  array( $this, 'btc_online_sc_ex' ));
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
	    wp_register_script('pubnub-js','//cdn.pubnub.com/pubnub.min.js', NULL, NULL, FALSE);
        wp_register_script('jquery-js','//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', NULL, NULL, FALSE);
        wp_register_script('jquery-number-js',plugins_url( 'assets/js/jquery.number.min.js', __FILE__ ), NULL, NULL, FALSE);
        
        wp_enqueue_script('pubnub-js');
        wp_enqueue_script('jquery-js');
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
        wp_enqueue_script('jquery-number-js');
	}
    
    
    public function btc_online_sc($atts){
        extract( shortcode_atts( array(
        		'data_type' => 'last',
                'data_value'=> 'display_short',
                'init_text'=>'loading...'
        	), $atts ) ); 
            
        $idt=$this->getInitialData();
        if($idt) $init_text=$idt;              
            
        return '<span class="btc-online-value" data-type="' . $data_type . '" data-value="' . $data_value . '">' . $init_text . '</span>';        
    }
    
        public function btc_online_sc_ex($atts){
        extract( shortcode_atts( array(
        		'data_exchange' => 'btce',
                'init_text'=>'loading...'
        	), $atts ) ); 
         
        $idt=$this->getInitialData($data_exchange);
        if($idt) $init_text=$idt;  

        return '<span class="btc-online-value_ex" data-exchange="' . $data_exchange . '">' . $init_text . '</span>';        
    }
    
    private function getInitialData($exchange='mtgox'){
      if(empty($this->exchangeInitData)){
        $url='http://s2.bitcoinwisdom.com:8080/ticker?sid=10f05a74&nonce=' . time();
        $response=json_decode(file_get_contents($url),true);
        if($response){
            $this->exchangeInitData['mtgox']=$response['mtgoxbtcusd']['last'];
            $this->exchangeInitData['btce']=$response['btcebtcusd']['last'];
            $this->exchangeInitData['bitstamp']=$response['bitstampbtcusd']['last'];
        }
      }
      if(!empty($this->exchangeInitData[$exchange])) return $this->exchangeInitData[$exchange];
      else return false;  
    }

}
