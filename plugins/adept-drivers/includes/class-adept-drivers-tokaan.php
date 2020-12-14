<?php
require plugin_dir_path( __DIR__ ) . '/vendor/autoload.php';

/**
 * Class for Tookan API Handler
 * 
 * @package Adept_Drivers
 * @subpackage Adept_Drivers/includes
 * @author Samer Alotaibi <sam@samiscoding.com>
 */
class Adept_Drivers_Tookan
{

    /**
     * The User's tookan api key
     *
     * @since 1.0.0
     * @access protected
     * @var string
     */
    protected $api_key;

    /**
     * Loger
     * 
     */
    public $logger;

    /**
     * All possible response codes
     * 
     * @since 1.0.0
     * @access protected
     * @var array
     */
    protected $responses = array (
        200 => 'SUCCESS',
        100 => 'PARAMETER_MISSING',
        101 => 'INVALID_KEY',
        200 => 'ACTION_COMPLETE',
        201 => 'SHOW_ERROR_MESSAGE',
        404 => 'ERROR_IN_EXECUTION'
    );

    /**
     * All Possible tasks status
     * 
     * @since 1.0.0
     * @access protected
     * @var array
     */
    protected $job_status = array(
        0 => 'Assigned',
        1 => 'Started',
        2 => 'Successful',
        3 => 'Failed',
        4 => 'InProgress',
        6 => 'Unassigned',
        7 => 'Accepted',
        8 => 'Decline',
        9 => 'Cancel',
        10 => 'Deleted'

    );

    /**
     * Main API URL
     * 
     * @since 1.0.0
     * @access protected
     * @var string
     */
    protected $api_url = 'https://api.tookanapp.com/v2/';

    /**
     * Constructor function
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->run_all();
        $this->api_key = get_option('ad_options')['ad_tookan_api'];
        $this->logger = new Adept_Drivers_Logger('TOOKAN');
    }

    /**
     * Return API Key
     *
     * @return string API Key
     */
    public function display_key(){
        $this->api_key = get_option('ad_options')['ad_tookan_api'];
        return $this->api_key;
    }

    /**
     * Create Task
     * 
     * @since 1.0.0
     * 
     */
    public function create_task($user, $datetime, $agents){
        $url = $this->api_url . 'create_task';
        $add_string = get_user_meta( $user->ID, 'billing_address_1', true ) . ', ' . get_user_meta( $user->ID, 'billing_city', true ) . ' ' . get_user_meta( $user->ID, 'billing_postcode', true ) . ', ' . get_user_meta( $user->ID, 'billing_state', true ) . ' Canada';
        $body = array(
            'customer_email' => $user->email,
            'customer_username' => $user->display_name,
            'customer_phone' => get_user_meta( $user->ID, 'billing_phone', true ),
            'customer_address'=> $add_string,
            'job_description'=> 'Lesson',
            'job_pickup_datetime'=> $datetime,
            'job_delivery_datetime'=> $datetime,
            'has_pickup'=> '0',
            'has_delivery'=> '0',
            'layout_type'=> '2',
            'tracking_link'=> 1,
            'timezone'=> '-330',
            'api_key'=> $this->api_key,
            'team_id'=> '',
            'auto_assignment'=> '0',
            'fleet_id'=> $agents[0],
            'ref_images'=> [
                'http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png',
                'http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png'
            ],
            'notify'=> 1,
            'tags'=> '',
            'geofence'=> 0
        );
        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );
        $this->logger->Log_Information(gettype($response['body']['data']), 'Add Task Response--TYPE');
        $this->logger->Log_Information($response['body']['data'], 'Add Task Response');
        if ( is_wp_error( $response )  ) {
            return array(
                "success" => false,
                "message" => $response
            );
        } else {
            $response_body = json_decode($response['body'], true);
            if(empty($response_body['data'])){
                return array(
                    "success" => false,
                    "message" => $response['message']
                );
            }else{
                return array(
                    "success" => true,
                    'agent_id' => $agents[0],
                    'job_id' => $response_body['data']['job_id']
                );
            }

        }

    }

    /**
     * Get All Agents Available
     * 
     * @since 1.0.0
     */
    public function get_all_agents(){
        $url = $this->api_url . 'get_all_fleets';
        $body = array(
            'api_key'=> $this->api_key,
            'status'=> 0,
            'fleet_type'=> 1
        );

        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );
        if ( is_wp_error( $response ) ) {
            wp_send_json(array(
                "success" => false,
                "message" => $response->get_error_message()
            ), 400);
        } else {
            //Save agents in DB
            $instructor = new Adept_Drivers_Instructors();

            $response_body = json_decode($response['body'], true);
            foreach ($response_body['data'] as $agent) {
                $this->logger->Log_Information($agent, __FUNCTION__);
                $instructor->insert_update_instructor(array(
                    'instructor_id' => $agent['fleet_id'],
                    'inst_name' => $agent['name'],
                    'latitude' => $agent['latitude'],
                    'longitude' => $agent['longitude']
                ));
            }
            wp_send_json(array(
                "success" => true,
                "message" => $response['body'],
                'key' => $this->api_key,
                'body' => $body
            ));
        }


    }

    /**
     * Assing task to agent
     * 
     * @since 1.0.0
     */
    public function assign_task_to_agent($agentID = 0, $taskID = 0){
        $url = $this->api_url . 'assign_task';
        $taskID = 154551638;
        $agentID = 581960;
        $teamID = 354771;

        $body = array(
            'api_key'=> $this->api_key,
            'job_id'=> $taskID,
            'fleet_id'=> $agentID,
            'team_id'=> $teamID,
            'job_status'=> 6
        );

        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );
        if ( is_wp_error( $response ) ) {
            $this->logger->Log_Error($response, 'TOOKAN-ERROR');
        } else {
            $this->logger->Log_Information($response, 'TOOKAN-INFO');
        }
    }

    /**
     * Get Agents near customer
     * 
     * @since 1.0.0
     * 
     * @param INT $customer_id
     * 
     * @return Array agents
     */
    public function get_agents_near_customer( $customer_id = '' ){
        $url = $this->api_url . 'get_fleets_near_customer';

        $body = array(
            'api_key'=> $this->api_key,
            'customer_id'=> empty($customer_id) ? 28598175 : $customer_id,
            'radius_in_metres'=> 50000
        );

        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );


        if ( is_wp_error( $response ) ) {
            $this->logger->Log_Error($response['body'], 'Agent by proximity');
            return false;
        } else {
            
            $response_arr = json_decode( $response['body'], true);
            $this->logger->Log_Information($response_arr, 'Agent by promixity');
            $this->logger->Log_Information(array_keys($response_arr['data'][0]), 'Type of data');

            return $response_arr['data'][0]['fleet_id'];
        }
    }

    /**
     * Add Student as a customer
     * 
     * @since 1.0.0
     * 
     * @param Array $customer
     * 
     * @return mix customer ID | false
     */
    public function add_customer( $customer ){
        $url = $this->api_url . 'customer/add';

        $body = array(
            'api_key'=> $this->api_key,
            'user_type'=> 0,
            'name'=> $customer['name'],
            'phone' => $customer['phone'],
            'email' => $customer['email'],
            'address' => $customer['address'],
            'latitude' => $customer['latitude'],
            'longitude' => $customer['longitude']
        );

        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );


        if ( is_wp_error( $response ) ) {
            $this->logger->Log_Error($response['body'], 'Adding Customer');
            return false;
        } else {
            // wp_send_json(array(
            //     "success" => true,
            //     "message" => $response['body']
            // ));
            $this->logger->Log_Information($response['body'], 'Adding Customer');
            $this->logger->Log_Type(json_encode($response['body']), 'Adding Customer');

            return json_decode($response['body'], true);
        }
    }

    /**
     * Get Agent Data
     * 
     * @param Int $agentID
     * 
     * @return Array $agent
     */
    public function get_agent_details( $agentID ){
        $url = $this->api_url . 'view_fleet_profile';

        $body = array(
            'api_key'=> $this->api_key,
            'fleed_id' => $agentID

        );
        $this->logger->Log_Information($body, __FUNCTION__);
        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );


        if ( is_wp_error( $response ) ) {
            $this->logger->Log_Error($response['body'], __FUNCTION__);
            return false;
        } else {
            // wp_send_json(array(
            //     "success" => true,
            //     "message" => $response['body']
            // ));
            $this->logger->Log_Information($response['body'], __FUNCTION__);
            $this->logger->Log_Type(json_encode($response['body']), __FUNCTION__);

            return json_decode($response['body'], true);
        }
    }


    /**
     * Ajax to display key
     *
     * @return void
     */
    public function ajax_ad_display_key(){
        wp_send_json(array(
            "success"=> true,
            'message' => $this->display_key(),
        ), 200);
    }

    /**
     * Delete Task
     * 
     * @param Int $job_id
     * 
     * @return Bool
     */
    public function delete_task( $job_id ){
        $url = $this->api_url . 'delete_task';

        $body = array(
            'api_key'=> $this->api_key,
            'job_id' => $job_id

        );
        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type'=> 'application/json'),
            'body'        => json_encode($body),
            'cookies'     => array()
            )
        );


        if ( is_wp_error( $response ) ) {
            return false;
        } else {
            return true;
        }
    }

    /**
	 * Function to run all admin hooks
	 * 
	 * @since 1.0.0
	 */
	public function run_all(){
        add_action( 'wp_ajax_ad_get_tookan_key', array($this, 'ajax_ad_display_key'));
        add_action( 'wp_ajax_ad_create_tookan_task', array($this, 'create_task'));
        add_action( 'wp_ajax_ad_get_agents', array($this, 'get_all_agents'));
        add_action ( 'wp_ajax_ad_assign_task_to_agent', array($this, 'assign_task_to_agent'));
	}
    
}
