<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://samiscoding.com
 * @since      1.0.0
 *
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/admin
 * @author     Samer Alotaibi <sam@samiscoding.com>
 */
class Adept_Drivers_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->ad_set_user_roles();
		$this->run_all();

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/adept-drivers-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/adept-drivers-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Prep User Roles and Caps.
	 *
	 * @since    1.0.0
	 */
	private function ad_set_user_roles(){

		/**
		 * These functions remove default user roles
		 */
		remove_role( 'subscriber' );
		remove_role( 'editor' );
		remove_role( 'contributor' );
		remove_role( 'author' );
		remove_role( 'shop_manager' );
		// remove_role( 'customer' );

		/**
		 * These functions add new user roles
		 */
		add_role( 'instructor' , __( 'Instructor', 'adept-drivers' ),
			array()
		 );
		add_role( 'student' , __( 'Student', 'adept-drivers' ),
			array()
		);
	}

	/**
	 * Function to run all admin hooks
	 * 
	 * @since 1.0.0
	 */
	public function run_all(){
		require_once plugin_dir_path( __FILE__ ) . '/class-adept-drivers-pages.php';
		$pages = new Adept_Drivers_Pages();
		require_once plugin_dir_path( __FILE__  ) . '../includes/class-adept-drivers-tokaan.php';
		$ad_tookan = new Adept_Drivers_Tookan;
		$ad_tookan->run_all();
		$pages->run_all();
	}


}
