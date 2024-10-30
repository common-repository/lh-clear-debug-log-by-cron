<?php
/**
 * Plugin Name: LH Clear Debug Log by Cron
 * Plugin URI: https://lhero.org/portfolio/lh-clear-debug-log-by-cron/
 * Description: Handle redirects and much more in a flexible wordpress way
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com/
 * Version: 1.01
 * Text Domain: lh_del_dlog_cron
 * License: GPLv2 or later
 * Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('LH_Clear_debug_log_by_cron_plugin')) {
    

class LH_Clear_debug_log_by_cron_plugin {
    
private static $instance;
 
    static function return_plugin_namespace(){
    
        return 'lh_del_dlog_cron';
    
    }

    static function plugin_name(){
        
        return 'LH Delete Debug Log by Cron';
   
    }

    static function setup_crons(){
        
        wp_clear_scheduled_hook( self::return_plugin_namespace().'_ongoing' ); 
        wp_schedule_event( time() + wp_rand( 0, 30 ), 'hourly', self::return_plugin_namespace().'_ongoing' );
    
    }


    static function remove_crons(){
        
        wp_clear_scheduled_hook( self::return_plugin_namespace().'_ongoing' ); 
    
    }

    static function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(plugin_basename( __FILE__ ).' - '.print_r($log, true));
            } else {
                error_log(plugin_basename( __FILE__ ).' - '.$log);
            }
        }
    }

    static function get_debug_file_path(){
        
         if ( in_array( strtolower( (string) WP_DEBUG_LOG ), array( 'true', '1' ), true ) ) {
                $log_path = WP_CONTENT_DIR . '/debug.log';
            } elseif ( is_string( WP_DEBUG_LOG ) ) {
                $log_path = WP_DEBUG_LOG;
            } else {
                $log_path = false;
            }
            
            return $log_path;
        
    }

    public function run_processes(){
        
        
        if ($file_path = self::get_debug_file_path()){
            
            $size = filesize($file_path);
            
            //by default clear the log if it is larger than 1MB.
            $size_threshold = apply_filters(self::return_plugin_namespace().'_size_threshold', 1048576);
            
            if ($size > $size_threshold){
                
                unlink( $file_path );
                
                self::write_log(self::plugin_name().' file size is '.$size.' bytes which is bigger than the threshold of '.$size_threshold.' bytes  and therefore has been deleted');
                wp_clear_scheduled_hook( self::return_plugin_namespace().'_single_event'); 
                wp_schedule_single_event(time() + wp_rand( 120, 240 ), self::return_plugin_namespace().'_single_event');
            
            
            } else {
                
                //self::write_log(self::plugin_name().' file size is smaller and is '.$size); 
                
            }
            
            
        }
        
        
        
    }

    public function plugin_init(){
        
        //add tasks to the ongoing cron and one off job
        add_action( self::return_plugin_namespace().'_ongoing', array($this,'run_processes'));
        add_action( self::return_plugin_namespace().'_single_event', array($this,'run_processes'));
        
        
    }
	


            
    /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            
            self::$instance = new self();
            
        }
 
        return self::$instance;
    }
    
    
    static function on_activate($network_wide) {
        
        if ( is_multisite() && $network_wide ) { 

            $args = array('number' => 500, 'fields' => 'ids');
        
            $sites = get_sites($args);
            
            foreach ($sites as $blog_id) {

                switch_to_blog($blog_id);
                self::setup_crons();
	            restore_current_blog();
	            
            } 
            
            
        } else {

            self::setup_crons();
           
        }
	    
	}
	
    static function on_deactivate($network_wide) {
        
        if ( is_multisite() && $network_wide ) { 
    
                $args = array('number' => 500, 'fields' => 'ids');
            
                $sites = get_sites($args);
        foreach ($sites as $blog_id) {
    
                switch_to_blog($blog_id);
                self::remove_crons();
                restore_current_blog();
            } 
    
        } else {
    
                self::remove_crons();
               
        }
        
    }

    
    
    /**
	* Constructor
	*/
	public function __construct() {
	    
    	//run our hooks on plugins loaded to as we may need checks       
        add_action( 'plugins_loaded', array($this,'plugin_init'));
	    
	}
    
    
}

$lh_clear_debug_log_by_cron_instance = LH_Clear_debug_log_by_cron_plugin::get_instance();
register_activation_hook(__FILE__, array('LH_Clear_debug_log_by_cron_plugin', 'on_activate'));
register_deactivation_hook( __FILE__, array('LH_Clear_debug_log_by_cron_plugin','on_deactivate') );



}

?>