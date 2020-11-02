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
     * Handle ZCRM Webhook
     *
     * @return void
     */
    public function handle_zcrm_notifications( $request ){
        
        $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
        $filename= $DOCUMENT_ROOT. '/wp-content/plugins/READTHIS.json';
		$post_data = $request->get_body_params();
		// $data = 
		$f = fopen($filename, 'w');
		fwrite($f, json_encode($post_data));
		fclose($f);
		// $post_data = $_POST['form_data'];
		// $post_data['post_type'] = 'wpqform';
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