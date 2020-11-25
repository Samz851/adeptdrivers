<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://samiscoding.com
 * @since      1.0.0
 *
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/public
 * @author     Samer Alotaibi <sam@samiscoding.com>
 */
class Adept_Drivers_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Adept_Drivers_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Adept_Drivers_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/adept-drivers-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Adept_Drivers_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Adept_Drivers_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/adept-drivers-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Override Woocommerce templates
	 * 
	 * @since 1.0.0
	 */
	function ad_override_wc_template( $template, $template_name, $template_path ) {
		global $woocommerce;
		$_template = $template;
		if ( ! $template_path ) 
		   $template_path = $woocommerce->template_url;
	
		$plugin_path  = plugin_dir_path( __FILE__ )  . '../template/woocommerce/';
	
	   // Look within passed path within the theme - this is priority
	   $template = locate_template(
	   array(
		 $template_path . $template_name,
		 $template_name
	   )
	  );
	
	  if( ! $template && file_exists( $plugin_path . $template_name ) )
	   $template = $plugin_path . $template_name;
	
	  if ( ! $template )
	   $template = $_template;
   
	  return $template;
	}
	   
	/**
	* Redirect user to register/login before checkout
	*
	*@since 1.0.0
	*/
	function ad_redirect_pre_checkout() {
		if ( ! function_exists( 'wc' ) ) return;
		$redirect_page_id = url_to_postid('checkout/login-register');
		if ( ! is_user_logged_in() && is_checkout() ) {
			wp_safe_redirect( get_permalink( $redirect_page_id ) );
			die;
		} elseif ( is_user_logged_in() && is_page( $redirect_page_id ) ) {
			wp_safe_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
			die;
		}
	}

	/**
	 * Callback for Booking Dashboard page
	 * 
	 * @since 1.0.0
	 */
	function booking_page_cb(){
		//:: TODO Render page
		echo 'This is booking page';
	}

}
