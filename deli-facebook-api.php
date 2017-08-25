<?php
/**
Plugin Name: Deli Facebook API Integration
Description: FB Official PHP SDK v5 
Version: 0.1
Author: delicyus
Author URI: http://delicyus.com
License: GPL2
*/
// see https://benmarshall.me/facebook-php-sdk/#manual
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

class Deli_Facebook_Api_Plugin
{

    public function __construct()
    {

        // Required
        if(!isset($_SESSION)) {
             session_start();
        }

        // Get these from facebook
        $this ->app_id         = "00000000000";
        $this ->client_secret  = "00000000000";
        $this ->access_token   = "00000000000|00000000000"; 
       

        // PHP SDK 
        if(!file_exists(__DIR__.'/Facebook/autoload.php'))
            return false;   
        require_once(  __DIR__ . '/Facebook/autoload.php');



        // Create instance
        $this -> fb = new Facebook\Facebook([
            'app_id'                    => $this ->app_id,
            'app_secret'                => $this ->client_secret,
            'default_graph_version'     => 'v2.10',
            'default_access_token'      => $this ->access_token
        ]);
    }



    // RENDERING RESPONSE

    // EVENTS 
    public function render_fb_events(){
        $UserEvents = $this -> get_fb_events();
        // printing events
        if($UserEvents!=false){
            foreach ($UserEvents as $UserEvent) {
                tt($UserEvent ['name']);
            }
        }   
    }



    // GET DATAS 

    // EVENTS 
    private function get_fb_events(){

        // getting user events
        try {
            $requestUserEvents = $this -> fb->get('/jaystepband/events');
            $UserEvents = $requestUserEvents->getGraphEdge()->asArray();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            //echo 'Graph returned an error: ' . $e->getMessage();
            // session_destroy();
            return false;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return false;
        }
        return $UserEvents;
    }

}
global $Deli_Facebook_Api_Plugin;
$Deli_Facebook_Api_Plugin = new Deli_Facebook_Api_Plugin();
?>