<?php
require plugin_dir_path( __DIR__ ) . 'vendor/autoload.php';

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Adept_Drivers
 * @subpackage Adept_Drivers/public/partials
 * @author     Samer Alotaibi <sam@samiscoding.com>
 */

 class Adept_Drivers_Students {

    /**
     * Holds all students primary data
     * 
     * @access private
     */
    private $students_core = array();

    /**
     * Hold students data to display
     * 
     * @access private
     */
    private $students;

    /**
     * The list of keys to display
     * 
     * @access public
     */
    public $student_keys;

    /**
     * The list of keys to display
     * 
     * @access public
     */
    public $Mustache;

    /**
     * Logger
     * 
     * @access public
     */
    public $logger;

    /**
     * Single Student Data
     * 
     * @access private
     */
    private $student;

    /**
     * Logger
     * 
     * @access public
     */
    public $data_keys = array(
        'ID' => 'ID',
        'name' => 'display_name',
        'email' => 'user_email',
        'LMSID' => 'lmsid',
        'License' => 'student_license',
        'Status' => 'ad_is_active',
        'TookanID' => 'ad_student_tookan_id'
    );

    /**
     * DB
     * 
     * @access private
     */
    private $db;

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct(){
        global $wpdb;
        $this->db = $wpdb;

        $this->Mustache = new Mustache_Engine(array(
            'entity_flags' => ENT_QUOTES,
            'loader' => new Mustache_Loader_FilesystemLoader(plugin_dir_path( __DIR__ ).'/admin/templates')
        ));
        
        $this->logger = new Adept_Drivers_Logger('STUDENTS');
        $this->get_all_students();

    }

    /**
     * populate all students
     * 
     * @return Mix Bookings | false
     */
    private function get_all_students(){
        $args = array(
            'role'    => 'student',
            'orderby' => 'user_nicename',
            'order'   => 'ASC'
        );

        $users_obj = get_users($args);
        foreach($users_obj as $s){
            $student = array(
                'ID' => $s->ID,
                'name' => $s->display_name,
                'email' => $s->user_email
            );
            array_push($this->students_core, $student);
        }

        foreach ($this->students_core as $s){
            $student = array();
            $student['ID'] = $s['ID'];
            $student['name'] = $s['name'];
            $student['email'] = $s['email'];
            // $student['wpnonce'] = wp_create_nonce();
            /**
             * Get student data
             */
            $all_metas = array_map( function( $a ){ return $a[0]; }, get_user_meta( $student['ID'] ) );
            foreach($all_metas as $k => $v){
                $search_result = array_search($k, $this->data_keys);
                if ($search_result !== false){
                    $student[$search_result] = $v;
                }
            }
            $this->students[] = $student;

        }

        // global $wpbd;

        // /**
        //  * Get All Students IDS
        //  */
        // $table_name = $wpdb->prefix . ADEPT_DRIVERS_DBTABLE;
		// $sql = "SELECT * FROM $table_name WHERE student_id = $this->userID";
        // $bookings = $wpdb->get_row($sql, "ARRAY_A");
        
        // return empty($bookings) ? false : $bookings;     
    }

    /**
     * return all students
     * 
     * @return Array $students
     */
    public function get_students(){
        return $this->students;
    }

    /**
     * return all students keys
     * 
     * @return Array $keys
     */
    public function get_students_keys(){
        return array_keys($this->data_keys);
    }

    /**
     * Render Students Page
     * 
     * @return string
     */
    public function render_students_page(){
        $render_obj = array();
        $render_obj['students_keys'] = $this->get_students_keys();
        $render_obj['students'] = $this->get_students();
        $render_obj['wpnonce'] = wp_create_nonce();
        $tpl = $this->Mustache->loadTemplate('students-table');
		echo $tpl->render($render_obj);
    }

    /**
     * Get single student data
     * 
     * @param $id student ID
     * 
     * @return Array student data
     */

     public function get_student_data(){
        // $this->logger->Log_Information($wpbd, 'Students-DBObj');

        $id = $_REQUEST['student_id'];
        //Get Meta
        $all_metas = array_map( function( $a ){ return $a[0]; }, get_user_meta( $id ) );

        //Save student
        $this->student = $all_metas;
        //Get Bookings
        $booking_ins = new Adept_Drivers_Public_Booking();

        $bookings = $booking_ins->get_student_bookings($id);

        $data = array(
            'data' => $all_metas,
            'bookings' => $bookings
        );
        wp_send_json(array(
            "success" => true,
            "data" => $data
        )); 

     }

     /**
      * Add booking for student, AJAX
      *
      *@param Int $studentID
      *@param TimeDate $bookingDate
      *
      *@return Bool
      */
      public function add_student_booking(){
          $student_id = $_REQUEST['student_id'];
          $bookingDate = $_REQUEST['booking_date'];

          $booking_ins = new Adept_Drivers_Public_Booking();
          $booking_conf = $booking_ins->add_student_bookings( $bookingDate, $student_id );

          if($booking_conf['success'] == true){
              //Save student booking
              $bookingdata = array(
                  'student_id' => $student_id,
                  'tookan_id' => get_user_meta( $student_id, 'ad_student_tookan_id', true ),
                  'booking_date' => $bookingDate,
                  'agent_id' => $booking_conf['agent_id'],
                  'job_id' => $booking_conf['job_id']
              );
              $insert = $booking_ins->save_student_booking($bookingdata, $student_id);
              if($insert){
                wp_send_json(array(
                    "success" => true,
                    "message" => "Booking Confirmed and Saved!",
                    "booking" => $bookingdata,
                    "bookingid" => $insert
                ));
              }else{
                wp_send_json(array(
                    "success" => true,
                    "message" => "Booking Confirmed But failed to save!"
                ));
              }

          }else{
              wp_send_json(array(
                  "success" => false,
                  "message" => $booking_conf['message']
              ));
          }

      }

      /**
       * Ajax delete bookings
       * 
       * @return Bool
       */
      public function ad_delete_student_booking(){
          $booking_id = $_REQUEST['booking_id'];
          $student_id = $_REQUEST['student_id'];
          $booking_ins = new Adept_Drivers_Public_Booking();
          $delete = $booking_ins->delete_booking($booking_id, $student_id);
          if($delete){
            wp_send_json(array(
                "success" => true,
                "message" => "Booking deleted!",
            ));
          }else{
            wp_send_json(array(
                "success" => false,
                "message" => "Failed to cancel booking"
            ));
          }
      }

      /**
       * Update user student
       * 
       * @param Array $student_data
       * 
       * @return Bool
       */
      public function update_user_student( $student_data ){
        $core_data = array('ID', 'user_login', 'user_nicename', 'user_email', 'display_name', 'first_name', 'last_name', 'user_registered', 'show_admin_bar_front', 'role');
        $student_core = array();
        $student_metas = array();
        if(is_array($student_data)){
            foreach ($student_data as $key => $value) {
                if(in_array($key, $core_data)){
                    $student_core[$key] = $value;
                }else{
                    $student_metas[$key] = $value;
                }
            }
            $update = wp_update_user($student_core);
            if(is_wp_error($update)){
                return false;
            }else{

                /**
                 * Check if new product added
                 */
                $student_product = $student_metas['student_product'];
                unset($student_metas['student_product']);
                $product = get_page_by_title( $student_product, OBJECT, 'product' );

                $student_products = get_user_meta( $update, 'student_products', true );
                if($student_products){
                    if(!in_array($product->ID, $student_products)){
                        $student_products[] = $product->ID;
                        update_user_meta( $update, 'student_products', $student_products );
                    }

                }else{
                    add_user_meta( $update, 'student_products', array($product->ID), true );
                }
                foreach ($student_metas as $key => $value) {
                    update_user_meta( $update, $key, $value );
                }

                return true;
            }



        }else{
            return false;
        }

      }

      /**
       * Insert new user student
       * 
       * @param Array $student_data
       * 
       * @return Bool
       */
      public function create_user_student( $student_data ){
        $this->logger->Log_Information($student_data, __FUNCTION__);
        $student_core = array();
        $student_metas = array();

        $core_data = array('ID', 'user_pass', 'user_login', 'user_nicename', 'user_email', 'display_name', 'first_name', 'last_name', 'user_registered', 'show_admin_bar_front', 'role');
        $pass = wp_generate_password( 12, true );

        $add_string = $student_data['billing_address_1'] . ', ' . $student_data['billing_city'] . ' ' . $student_data['billing_postal'] . ', ' . $student_data['billing_state'] . ' Canada';

        /**
         * Get user coordinates
         */
        $geocoder = new Adept_Drivers_Geocoding($add_string);
        $coordinates = $geocoder->geocode();

        if(is_array($student_data)){
            $student_product = $student_data['student_product'];
            unset($student_data['student_product']);
            $this->logger->Log_Information($student_product, 'student_product');
            foreach ($student_data as $key => $value) {
                if(in_array($key, $core_data)){
                    $student_core[$key] = $value;
                }else{
                    $student_metas[$key] = $value;
                }
            }
            //Set new user password
            $update = wp_insert_user($student_core);
            
            if(is_wp_error($update)){
                return false;
            }else{
                foreach ($student_metas as $key => $value) {
                    add_user_meta( $update, $key, $value );
                }
                /**
                 * Add Product to user
                 */
                $product = get_page_by_title( $student_product, OBJECT, 'product' );

                add_user_meta( $update, 'student_products', array($product->ID), true);
                add_user_meta( $update, 'coordinates', array('lat' => $coordinates[0], 'long' => $coordinates[1]), true);

                add_user_meta( $update, 'ad_is_active', true, true);

                // Register customer in tookan
                $TOKAAN = new Adept_Drivers_Tookan();
                $customer = $TOKAAN->add_customer(array(
                    'name' => $student_core['display_name'], 
                    'phone' => $student_metas['billing_phone'], 
                    'email' => $student_core['user_email'], 
                    'address' => $add_string, 
                    'latitude' => $coordinates[0], 
                    'longitude' => $coordinates[1]));

                if($customer['data']['customer_id']){
                    add_user_meta( $update, 'ad_student_tookan_id', $customer['data']['customer_id'], true);
                    $agentID = array();
                    // Get agents near this customer
                    $agent = $TOKAAN->get_agents_near_customer( $customer['data']['customer_id'] );
                    if($agent) {
                        array_push($agentID, $agent[0]['fleet_id']);
                    }else{
                        //Search locally
                        $instructor_ins = new Adept_Drivers_Instructors();
                        $agent_id = $instructor_ins->get_nearest_instructor(array('lat' => $coordinates[0], 'long' => $coordinates[1]));
                        $this->logger->Log_Information($agent_id, 'Locally Get Close Agent');
                        if($agent_id) array_push($agentID, $agent_id);
                    }
                    add_user_meta( $update, 'ad_student_instructor', $agentID, true);
                }
                /**
                 * Prep user for LMS activation
                */
                $user = array(                
                    "username" => $student_core['user_nicename'],
                    "password" => $student_core['user_pass'],
                    "firstname" => $student_core['first_name'],
                    "lastname" => $student_core['last_name'],
                    "email" => $student_core['user_email'],
                    "phone1" => $student_metas['billing_phone'],     
                );

                /**
                 * Signup new user into LMS
                 */
                $LMS = new Adept_Drivers_LMS();
                $proccessed = $LMS->process_user($user);
                if($proccessed){
                    add_user_meta($update, 'lmsid', $proccessed['lmsid'], true);
                }

                return true;
            }



        }else{
            return false;
        }


      }

    /**
     * Get Student Dashboard Object
     * 
     * @param Int $id student ID
     * 
     * @return Array $student
     */
    public function get_student_dashboard_obj( $id ){
        $student_data = array();
        $student_metas = array_map(function( $a ){ return $a[0]; }, get_user_meta( $id ));
        
        //Get student grade
        $LMS = new Adept_Drivers_LMS();
        $student_grades = $LMS->get_student_progress($student_metas['lmsid']);

        //Get Car Sessions
        $product_id = maybe_unserialize($student_metas['student_products']);
        $car_sessions_total = get_post_meta($product_id[0], 'in_car_sessions', true);
        $bookings = new Adept_Drivers_Public_Booking();
        $total_bookings = count($bookings->get_student_bookings($id));

        $student_data = $student_metas;
        $student_data['has_LMS'] = get_post_meta($product_id[0], 'includes_bde', true);
        $student_data['student_progress'] = $student_grades['grades'][0]['grade'];
        $student_data['lessons_total'] = $car_sessions_total;
        $student_data['total_bookings'] = $total_bookings;
        $student_data['remaining_booking'] = $car_sessions_total - $total_bookings;
        $student_data['product_name'] = get_page_by_title( $product_id, OBJECT, 'product' );
        $this->logger->Log_Information($student_data, __FUNCTION__);
        return $student_data;

    }


     /**
      * Run all class hooks and ajax
      */
      public function run_all(){
        add_action ( 'wp_ajax_ad_get_student_details', array($this, 'get_student_data'));
        add_action ( 'wp_ajax_ad_add_student_booking', array($this, 'add_student_booking'));
        add_action( 'wp_ajax_ad_delete_student_booking', array($this, 'ad_delete_student_booking') );
      }
 }