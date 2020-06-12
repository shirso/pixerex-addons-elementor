<?php
/*
Plugin Name: Pixerex Elements Framework 2
Description: Addons Plugin Includes 14+ widgets for Elementor Page Builder.
Plugin URI: https://themeforest.net/user/style-themes/portfolio
Version: 2.0.0
Author: Pixerex
Plugin URI: https://themeforest.net/user/style-themes/portfolio
Text Domain: pixerex-elements
Domain Path: /languages
*/
if ( ! defined('ABSPATH') ) exit; // No access of directly access

// Define Constants
define('PIXEREX_ELEMENTS_VERSION', '2.0.0');
define('PIXEREX_ELEMENTS_URL', plugins_url( '/', __FILE__ ) );
define('PIXEREX_ELEMENTS_PATH', plugin_dir_path( __FILE__ ) );
define('PIXEREX_ELEMENTS_FILE', __FILE__);
define('PIXEREX_ELEMENTS_BASENAME', plugin_basename( PIXEREX_ELEMENTS_FILE ) );

if( ! class_exists('Pixerex_Elements_Framework') ) {
    
    /*
    * Intialize and Sets up the plugin
    */
    class Pixerex_Elements_Framework {
        
        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance = null;
        
        /**
         * Sets up needed actions/filters for the plug-in to initialize.
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function __construct() {
            
            add_action( 'plugins_loaded', array( $this, 'pixerex_elements_elementor_setup' ) );
            
            add_action( 'elementor/init', array( $this, 'elementor_init' ) );
            
            add_action( 'init', array( $this, 'init' ), -999 );
            
            register_activation_hook( PIXEREX_ELEMENTS_FILE, array( $this, 'set_transient' ) );
            
        }
        
        /**
         * Installs translation text domain and checks if Elementor is installed
         * 
         * @since 1.0.0
         * @access public
         * 
         * @return void
         */
        public function pixerex_elements_elementor_setup() {
            
            $this->load_domain();
            
            $this->init_files(); 
        }
        
        
        /**
         * Require initial necessary files
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function init_files() {
            
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/class-helper-functions.php' );
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/class-trait-helper-functions.php' );
            require_once ( PIXEREX_ELEMENTS_PATH . 'admin/settings/modules-setting.php' );
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/elementor-helper.php' );
            
            if ( is_admin() ) {
                
                require_once ( PIXEREX_ELEMENTS_PATH . 'admin/includes/dep/admin-helper.php');
                require_once ( PIXEREX_ELEMENTS_PATH . 'includes/plugin.php');
                
            }
    
        }
        
        /**
         * Load plugin translated strings using text domain
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function load_domain() {
            
            load_plugin_textdomain( 'pixerex-elements' );
            
        }
        
        /**
         * Elementor Init
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function elementor_init() {
            
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/compatibility/class-pixerex_elements_wpml.php' );
            
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/class-addons-category.php' );
            
        }
        
        /**
         * Load required file for addons integration
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return void
         */
        public function init_addons() {
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/class-addons-integration.php' );
        }
        
        /**
         * Load the required files for templates integration
         * 
         * @since 3.6.0
         * @access public
         * 
         * @return void
         */
        public function init_templates() {
            //Load templates file
            require_once ( PIXEREX_ELEMENTS_PATH . 'includes/templates/templates.php');
        }
        
        /*
         * Init 
         * 
         * @since 3.4.0
         * @access public
         * 
         * @return void
         */
        public function init() {
            
            $this->init_addons();
            
            if ( PixerexElements\Admin\Settings\Modules_Settings::check_pixerex_templates() )
                $this->init_templates();
            
        }


        /**
         * Creates and returns an instance of the class
         * 
         * @since 2.6.8
         * @access public
         * 
         * @return object
         */
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    
    }
}

if ( ! function_exists( 'pixerex_elements' ) ) {
    
	/**
	 * Returns an instance of the plugin class.
	 * @since  1.0.0
	 * @return object
	 */
	function pixerex_elements() {
		return Pixerex_Elements_Framework::get_instance();
	}
}

pixerex_elements();