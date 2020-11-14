<?php
require plugin_dir_path( __DIR__ ) . '/vendor/autoload.php';
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\oauth\ZohoOAuth;

/**
 * Class for Zoho CRM API Handler
 * 
 * @package Adept_Drivers
 * @subpackage Adept_Drivers/includes
 * @author Samer Alotaibi <sam@samiscoding.com>
 */
class Adept_Drivers_ZCRM {

    /**
     * Zoho CRM Client ID;
     */
    private $zcrm_id;

    /**
     * Zoho CRM Client Secret
     */
    private $zcrm_secret;

    /**
     * Zoho CRM Redirect URI
     */
    private $zcrm_redirect_uri;

    /**
     * Zoho CRM Redirect URI
     */
    private $zcrm_email;

    /**
     * Zoho Configuration
     */
    private $configuration;

    /**
     * Zoho Client Instance
     */
    private $zinst;

    /**
     * Zoho Temp Token
     */
    private $zcrm_temp_token;

    /**
     * Zoho CRM URI
     */
    private $zcrm_uri = 'https://accounts.zoho.com/oauth/v2/token';

    /**
     * Constructor function
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->run_all();
        $this->api_key = get_option('ad_options')['ad_tookan_api'];
        $this->zcrm_id = get_option('ad_options')['ad_zcrm_cid'];
        $this->zcrm_secret = get_option('ad_options')['ad_zcrm_csecret'];
        $this->zcrm_redirect_uri = get_option('ad_options')['ad_zcrm_redirect_uri'];
        $this->zcrm_email = get_option('ad_options')['ad_zcrm_email'];
        $this->zcrm_temp_token = get_option('ad_options')['ad_zcrm_temp_token'];
        $this->init_zcrm_client();
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

        $response = new WP_REST_Response( array(
            'success' => true,
            'message' => 'You\'ve reached the ZCRM endpoint'
        ) );
        $response->set_status( 200 );
        return $response;
    }

    /**
     * Initialize ZCRM SDK
     * 
     * @since 1.0.0
     */
    private function init_zcrm_client () {
        $this->configuration = array(
            "client_id"=>$this->zcrm_id,
            "client_secret"=> $this->zcrm_secret,
            "redirect_uri"=> $this->zcrm_redirect_uri,
            "currentUserEmail"=> $this->zcrm_email
        );

        if( $this->zcrm_temp_token ){

            $response = wp_remote_post($this->zcrm_uri . '?code=' . $this->zcrm_temp_token . '&redirect_uri=https://adept-drivers.samiscoding.com/crm-redirect&client_id=1000.HQGSJVRJKW06KMK3E0RNG5XRHHL6DW&client_secret=f223703e8ce8f03f7159c0907985ccd306f2f281fe&grant_type=authorization_code');
            if (is_wp_error($response)){
                var_dump($response->get_error_message());
            }else{
                $resp_json = json_decode($response['body'], true);
                if(isset($resp_json['error'])){
                    update_option('ad_zcrm_expired_token', 'expired', true);
                }else{
                    update_option('ad_zcrm_expired_token', 'active', true);
                    update_option('zcrm_access_token', $resp_json['access_token'], true);
                    update_option('zcrm_refresh_token', $resp_json['refresh_token'], true);
                }
                var_dump($response['body']);
            }

            ZCRMRestClient::initialize( $this->configuration );
            $oAuthClient = ZohoOAuth::getClientInstance(); 
            $refreshToken = get_option('zcrm_refresh_token'); 
            $userIdentifier = $this->zcrm_email; 
            $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userIdentifier);
            // ZohoOAuth::initialize( $this->configuration );
            var_dump($oAuthClient);
    
            $this->zinst = ZCRMRestClient::getInstance();

        }

        

        // $oAuthClient = ZohoOAuth::getClientInstance();
        // if($this->zcrm_temp_token){
        //     var_dump($this->zcrm_temp_token);
        //     $oAutToken = $oAuthClient->generateAccessToken( $this->zcrm_temp_token );
        //     // var_dump($oAutToken);
        //     // add_option( 'zcrm_token', $oAutToken, '', 'yes' );
        // }
    }

    /**
     * Push student record to CRM
     * 
     * @param Array $record
     * 
     * @return void
     */
    public function push_student_record( $record ){


        $userdata = array(
            'Email'                     => $record['user_email'],
            'Last_Name'                 => $record['last_name'],
            'First_Name'                => $record['first_name'],
            'Mailing Street'            => $record['billing_address_1'],
            'Mailing_City'              => $record['billing_city'],
            'Mailing Zip'               => $record['billing_postcode'],
            'Mailing State'             => $record['billing_state'],
            'Phone'                     => $record['billing_phone'],
            'G2_Eligibility_Date'       => $record['student_g2el'],
            'Conditions_Eye_Glasses'    => $record['student_cond']
        );
        $moduleIns = $this->zinst->getModuleInstance("Contacts");
        $records = array();
        $record = ZCRMRecord::getInstance("Contacts",null);
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        if($responseIn->getEntityResponses()[0]->getStatus() == 'success'){
            return true;
        }else{
            return false;
        }
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