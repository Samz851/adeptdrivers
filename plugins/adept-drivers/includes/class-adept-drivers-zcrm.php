<?php
/**
 * Class for Zoho CRM API Handler
 * 
 * @package Adept_Drivers
 * @subpackage Adept_Drivers/includes
 * @author Samer Alotaibi <sam@samiscoding.com>
 */
class Adept_Drivers_ZCRM {

    /**
     * Constructor function
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->run_all();
        $this->api_key = get_option('ad_options')['ad_tookan_api'];
    }

    /**
     * Create ZCRM Webhook
     * 
     * @since 1.0.0
     */
    public function zcrm_resapi(){
        register_rest_route( 'adept-drivers/v1', 'noticifcations', array(
            'methods' => 'POST',
            'callback' => [$this, 'handle_zcrm_notifications'],
        ) );
    }

    /**
     * Handle ZCRM Webhook for new contacts
     *
     * @return void
     */
    public function handle_zcrm_notifications( $request ){
        
        // $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
        // $filename= $DOCUMENT_ROOT. '/wp-content/plugins/READTHIS.json';

        /** 
         * The post data fetched raw
         */
        $post_data = $request->get_body_params();

        /**
         * Post data mutated to array
         */
        $post_data = json_decode(json_encode($post_data), true);
        if(is_array($post_data)){
            /**
             * Generate password
             */
            $pass = wp_generate_password( $length = 12, $include_standard_special_chars = false );

            /**
             * Prep userdata
             */
            $userdata = array(
                'user_pass'             => $pass,   //(string) The plain-text user password.
                'user_login'            => explode('@',$post_data['studentemail'])[0],   //(string) The user's login username.
                'user_nicename'         => str_replace('.','_',explode('@',$post_data['studentemail'])[0]),   //(string) The URL-friendly user name.
                'user_email'            => $post_data['studentemail'],   //(string) The user email address.
                'display_name'          => $post_data['studentname'],   //(string) The user's display name. Default is the user's username.
                'first_name'            => explode(' ', $post_data['studentname'])[0],   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
                'last_name'             => explode(' ', $post_data['studentname'])[1],   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
                'user_registered'       => $post_data['studentregistration'],   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
                'show_admin_bar_front'  => 'false',   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
                'role'                  => 'student',   //(string) User's role.
             
            );

            /**
             * Holds core data from zcrm
             */
            $zcrm_core = ['studentemail', 'studentname', 'studentregistration'];

            /**
             * create new user
             * 
             * @return Int|WP_error
             */
            $new_user = wp_insert_user($userdata);

            if(!is_wp_error($new_user)){
               /**
                * Convert address data
                */
                $user_address = array(
                    'student_address_1' => 'billing_address_1',
                    'student_city' => 'billing_city',
                    'studentpostal' => 'billing_postcode',
                    'student_state' => 'billing_state',
                    'student_phone' => 'billing_phone'
                );

                /**
                 * Add user meta -- only if not core
                 */

                 foreach ( $post_data as $key=>$value ){
                     if(!in_array($key, $zcrm_core)){
                         if(array_key_exists($key, $user_address)){
                             add_user_meta( $new_user, $user_address[$key], $value, true);
                         }else{
                            add_user_meta( $new_user, '_' . $key, $value, true );
                         }
                     }
                 }
                 add_user_meta( $new_user, 'ad_is_active', true, true);
            }
        };
		// $data = 
		// $f = fopen($filename, 'w');
		// fwrite($f, json_encode($post_data));
		// fclose($f);
		// // $post_data = $_POST['form_data'];
		// // $post_data['post_type'] = 'wpqform';
        $response = new WP_REST_Response( array(
            'success' => true,
            'message' => 'You\'ve reached the ZCRM endpoint'
        ) );
        $response->set_status( 200 );
        return $response;
    }

    /**
	 * Function to run all admin hooks
	 * 
	 * @since 1.0.0
	 */
	public function run_all(){
        
	}
}
?>