<?php
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
    public function create_task(){
        $url = $this->api_url . 'create_task';
        $body = array(
            'customer_email'=> 'john@example.com',
            'order_id'=> '654321',
            'customer_username'=> 'John Doe',
            'customer_phone'=> '+919999999999',
            'customer_address'=> 'Powai Lake, Powai, Mumbai, Maharashtra, India',
            'latitude'=> '28.5494489',
            'longitude'=> '77.2001368',
            'job_description'=> 'Beauty services',
            'job_pickup_datetime'=> '2020-11-28 12:15:00',
            'job_delivery_datetime'=> '2020-11-28 12:15:00',
            'has_pickup'=> '0',
            'has_delivery'=> '0',
            'layout_type'=> '2',
            'tracking_link'=> 1,
            'timezone'=> '-330',
            'custom_field_template'=> 'Template_1',
            'api_key'=> $this->api_key,
            'team_id'=> '',
            'auto_assignment'=> '0',
            'fleet_id'=> '',
            'ref_images'=> [
              'http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png',
              'http=>//tookanapp.com/wp-content/uploads/2015/11/logo_dark.png'
            ],
            'notify'=> 1,
            'tags'=> '',
            'geofence'=> 1
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
            wp_send_json(array(
                "success" => true,
                "message" => $response['body'],
                'key' => $this->api_key,
                'body' => $body
            ));
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
            wp_send_json(array(
                "success" => false,
                "message" => $response->get_error_message()
            ), 400);
        } else {
            wp_send_json(array(
                "success" => true,
                "message" => $response['body'],
                'key' => $this->api_key,
                'body' => $body
            ));
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
