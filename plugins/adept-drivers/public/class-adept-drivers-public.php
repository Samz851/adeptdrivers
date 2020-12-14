<?php
require plugin_dir_path( __DIR__ ) . '/vendor/autoload.php';
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
	 * Template engine instance.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $Mustache;

	/**
	 * Logger.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private $logger;

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
        $this->logger = new Adept_Drivers_Logger('PUBLIC');
		$this->Mustache = new Mustache_Engine(array(
													'entity_flags' => ENT_QUOTES,
													'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates')
												));

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
		wp_enqueue_style( 'bootstrap-datepicker-css' , plugin_dir_url(__FILE__) . 'css/bootstrap-datepicker.min.css', array(), $this->version, 'all');
		wp_enqueue_style( 'bootstrap-css' , plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		if (is_page('user-account')) {
			// wp_enqueue_style('adept-drivers-css' , plugin_dir_url( __FILE__ ) . 'css/adept-drivers-calendar.css', array(), $this->version, 'all');
		}
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

		// if (is_page('user-account')) {
			wp_enqueue_script('momentsjs' , plugin_dir_url( __FILE__ ) . 'js/lib/moments.js', array(), $this->version, true);
			wp_enqueue_script( 'bootstrap-js-pub' , plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery','momentsjs'), $this->version, true);
			wp_enqueue_script ( 'bootstrap-datepicker-js-pub' , plugin_dir_url(__FILE__) . 'js/bootstrap-datepicker.min.js', array('bootstrap-js-pub'), $this->version, true);
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/adept-drivers-public.js', array( 'bootstrap-datepicker-js-pub' ), $this->version, true );
			wp_localize_script( $this->plugin_name, 'ajaxurl',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

		// }

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
			$_SESSION['redirected_customer'] = true;
			wp_safe_redirect( get_permalink( $redirect_page_id ) . '?action=register_user' );
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
		$student_id = get_current_user_id();
		$bookings = $this->get_student_bookings($student_id);
		$bookings = array_map(function($a){ 
			$a['status'] = $a['status'] == 1 ? 'Pending' : 'Complete';
			$a['cancel'] = $a['status'] == 'Pending' ? true : false;
			return $a;
		}, $bookings);
		$tpl = $this->Mustache->loadTemplate('lessons-booking');
		$this->logger->Log_Information($bookings, __FUNCTION__);
		echo $tpl->render(array(
			'bookings' => $bookings,
			'ID' => $student_id
		));
	}

	/**
	 * Get Student Bookings
	 * 
	 * @param Int $id
	 * 
	 * @return Array $bookings
	 */
	public function get_student_bookings($id){
		//Get Bookings
		$booking_ins = new Adept_Drivers_Public_Booking();

		$bookings = $booking_ins->get_student_bookings($id);

		return $bookings;
	}

}
