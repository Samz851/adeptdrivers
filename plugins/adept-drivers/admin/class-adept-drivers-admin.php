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
			get_role( 'customer' )->capabilities
		);
	}

	/**
	 * Add custom fields to each product
	 * 
	 * @since 1.0.0
	 */
	function ad_wc_product_custom_fields(){
        global $woocommerce, $post;
        echo '<div class="product_custom_field">';

        woocommerce_wp_text_input(
            array(
                'id' => 'in_car_sessions',
                'placeholder' => 'In Car Sessions',
                'label' => __('In Car Sessions', 'adept-drivers'),
				'class' => 'ad-prod-meta',
				'type'  => 'number',
            )
		);
		woocommerce_wp_checkbox( 
			array( 
				'id'            => 'includes_bde', 
				'wrapper_class' => 'ad-prod-meta', 
				'label'         => __('Includes BDE Course', 'adept-adapters' ), 
				'description'   => __( 'Includes a BDE course with this product', 'adept-drivers' ) 
				)
			);
        echo '</div>';
	}
	
	/**
	 * Save custom fields of products
	 * 
	 * @since 1.0.0
	 */
	function ad_wc_product_custom_fields_save( $post_id ){
		$fields = $_POST;
		// $metas = ['lab_report', 'faq', 'why_buy', 'suggested_use', 'ingredients', 'product_facts', 'amount_cbd', 'total_cbd', 'size_volume'];
		// $wysiwyg_keys = ['faq', 'ingredients', 'why_buy'];
		foreach ($fields as $key => $value) {
			if( $key == 'in_car_sessions' || $key == 'includes_bde'){
				update_post_meta($post_id, $key, $value);
			}
		}
	}

	/**
	 * add registration fields
	 * 
	 * @since 1.0.0
	 */
	function ad_extra_register_fields() {?>
		<p class="form-row form-row-wide">
		<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
		<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
		</p>
		<p class="form-row form-row-first">
		<label for="reg_billing_first_name"><?php _e( 'First name', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
		</p>
		<p class="form-row form-row-last">
		<label for="reg_billing_last_name"><?php _e( 'Last name', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
		</p>
		<p class="form-row form-row-wide">
		<label for="student_dob"><?php _e( 'Date of Birth', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="date" class="input-text" name="student_dob" id="student_dob" value="<?php if ( ! empty( $_POST['student_dob'] ) ) esc_attr_e( $_POST['student_dob'] ); ?>" />
		</p>
		<p class="form-row form-row-first">
		<label for="reg_billing_address_1"><?php _e( 'Address', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_address_1" id="reg_billing_address_1" value="<?php if ( ! empty( $_POST['billing_address_1'] ) ) esc_attr_e( $_POST['billing_address_1'] ); ?>" />
		</p>
		<p class="form-row form-row-last">
		<label for="reg_billing_city"><?php _e( 'City', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" />
		</p>
		<p class="form-row form-row-first">
		<label for="reg_billing_postcode"><?php _e( 'Postal Code', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" value="<?php if ( ! empty( $_POST['billing_postcode'] ) ) esc_attr_e( $_POST['billing_address_1'] ); ?>" />
		</p>
		<p class="form-row form-row-last">
		<label for="reg_billing_state"><?php _e( 'Province', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_state" id="reg_billing_state" value="<?php if ( ! empty( $_POST['billing_state'] ) ) esc_attr_e( $_POST['billing_state'] ); ?>" />
		</p>
		<p class="form-row form-row-first">
		<label for="student_license"><?php _e( 'License #', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="student_license" id="student_license" value="<?php if ( ! empty( $_POST['student_license'] ) ) esc_attr_e( $_POST['student_license'] ); ?>" />
		</p>
		<p class="form-row form-row-last">
		<label for="student_lcissue"><?php _e( 'License Issued', 'adept-drivers' ); ?><span class="required">*</span></label>
		<input type="date" class="input-text" name="student_lcissue" id="student_lcissue" value="<?php if ( ! empty( $_POST['student_lcissue'] ) ) esc_attr_e( $_POST['student_lcissue'] ); ?>" />
		</p>
		<div class="clear"></div>
		<?php
	  }
	  
	  /**
	   * Deactivate all newly registered users
	   * 
	   * @param int $user_id
	   * 
	   * @since 1.0.0
	   */
	  function inactive_user_registration( $user_id ){
		if( !empty($_POST) ){
			add_user_meta( $user_id, 'ad_is_active', false, true);
		}
	  }

	  /**
	   * adjust query to skip inactive users
	   * 
	   * @param WP_User_Query $args
	   * 
	   * @since 1.0.0
	   */
	  function skip_inactive_user_query( $args ){
		  $args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'ad_is_active',
                'value'   => true,
			),
			array(
				'key'     => 'ad_is_active',
				'compare' => 'NOT EXISTS'
			)
			
		  );

		  return $args;
	  }

	  /**
	   * Activate users after purchase
	   * 
	   * @param int $order_id
	   * @since 1.0.0
	   */
	  function activate_user_after_purchase( $order_id ){
		$order = wc_get_order( $order_id );
		$user = $order->get_user_id();
		$order->add_order_note( $user );
		$order->add_order_note(__('This is a test note', 'adept-drivers'));
		if( $user ){

			update_user_meta( $user, 'ad_is_active', true);
		}
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
