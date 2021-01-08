<?php
require plugin_dir_path( __DIR__ ) . '/vendor/autoload.php';

/**
 * Class for Tookan API Handler
 * 
 * @package Adept_Drivers
 * @subpackage Adept_Drivers/includes
 * @author Samer Alotaibi <sam@samiscoding.com>
 */

 class Adept_Drivers_Instructors{

    /**
     * DB instance
     * 
     * @access private
     */
    private $db;

    /**
     * Logger
     * 
     * @access private
     */
    private $logger;

    /**
     * The list of keys to display
     * 
     * @access public
     */
    public $Mustache;


    public function __construct(){
        global $wpdb;
        $this->db = $wpdb;
        $this->logger = new Adept_Drivers_Logger('INSTRUCTORS');
        $this->Mustache = new Mustache_Engine(array(
            'entity_flags' => ENT_QUOTES,
            'loader' => new Mustache_Loader_FilesystemLoader(plugin_dir_path( __DIR__ ).'/admin/templates')
        ));
    }

    /**
     * Insert Instructor into DB if not exist
     * 
     * @param Array $data Instructor's Data
     * 
     * @return Bool
     */
    public function insert_update_instructor( $data ){
        $tablename = $this->db->prefix . 'ad_instructors';
        $instructor_id = $data['instructor_id'];
        $find_sql = "SELECT id FROM $tablename WHERE instructor_id = $instructor_id";
        $agent_exist = $this->db->get_row($find_sql, 'ARRAY_A');
        if($agent_exist){
            $op = $this->db->update($tablename, $data, array('instructor_id' => $instructor_id));
        }else{
            $op = $this->db->insert($tablename, $data);
        }

        return !$op ? false : true;
    }

    /**
     * Get All Instructors
     * 
     * @return Array $instructors
     */
    public function get_all_instructors(){
        $tablename = $this->db->prefix . 'ad_instructors';

        $sql = "SELECT * FROM $tablename";

        $instructors = $this->db->get_results($sql, 'ARRAY_A');

        return $instructors;
    }

    /**
     * Get Agent By ID
     * 
     * @param Int $agent_id
     * 
     * @return Array $agent
     */
    public function get_agent_details( $agent_id ){
        $agent_id = intval($agent_id);
        $tablename = $this->db->prefix . 'ad_instructors';

        $sql = "SELECT * FROM $tablename WHERE instructor_id = $agent_id";

        $agent = $this->db->get_row($sql, 'ARRAY_A');

        return $agent;
    }

    /**
     * Get nearest Agent
     * 
     * @param Array $coordinates
     * 
     * @return Int $agent_id
     */
    public function get_nearest_instructor( $coordinates ){
        $min = 1000;
        $agents = $this->get_all_instructors();
        foreach ($agents as $key => $agent) {
            $distance = $this->get_distance($coordinates['lat'], $coordinates['long'], $agent['latitude'], $agent['longitude'] );
            $this->logger->Log_Information(array('distance' => $distance, 'coords' => $coordinates, '$agent' => $agent), __FUNCTION__);
            if($distance < $min){
                $min = $distance;
                $agent_id = $agent['instructor_id'];
            }

        }
        // if($agent_id)
        return $agent_id ?? false;
    }

    /**
     * Get Bookings for instructor
     * 
     * @param Int $ID instructor id
     * 
     * @return mix Array or False
     */

    public function get_instructor_bookings( $ID ){
        $tablename = $this->db->prefix . 'ad_bookings';
        $ID = intval($ID);
        $sql = "SELECT * FROM $tablename WHERE instructor = $ID";
        $bookings = $this->db->get_results($sql, 'ARRAY_A');
        return $bookings ? $bookings : false;
    }

    /**
     * Count Instructor Bookings
     * 
     * @param Int $ID agent id
     * 
     * @return Int $count
     */
    public function count_agent_bookings( $ID ){
        $tablename = $this->db->prefix . 'ad_bookings';
        $ID = intval($ID);
        $sql = "SELECT count(*) FROM $tablename WHERE instructor = $ID";
        $this->logger->Log_information($ID, __FUNCTION__ . ' SQL');
        $count = $this->db->get_var($sql);
        $this->logger->Log_Information($count, __FUNCTION__);
        return $count;
    }

    /**
     * Helper function to get distance
     * 
     * @param Float $latitude1
     * @param Float $longitude1
     * @param Float $latitude2
     * @param Float $longitude2
     * 
     * @return Int $d distance in KM
     */
    public function get_distance($latitude1, $longitude1, $latitude2, $longitude2) {  
        $earth_radius = 6371;
      
        $dLat = deg2rad($latitude2 - $latitude1);  
        $dLon = deg2rad($longitude2 - $longitude1);  
      
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  
      
        return $d;  
    }

    /**
     * Render Instructors Page
     */
    public function render_page(){
        $agents = array();
        foreach ($this->get_all_instructors() as $key => $agent) {
            $agent['count'] = $this->count_agent_bookings($agent['instructor_id']);
            $agent['bookings'] = $agent['count'] > 0 ? $this->get_instructor_bookings($agent['instructor_id']) : false;
            $aget['has_bookings'] = $agent['count'] > 0 ? true : false;
            $agent['name'] = $this->get_agent_details($agent['instructor_id'])['inst_name'];
            $agents[] = $agent;
        }
        $this->logger->Log_Information($agents, __FUNCTION__);
        $tpl = $this->Mustache->loadTemplate('instructors-table');
		echo $tpl->render(array('agents' => $agents));
    }
 }