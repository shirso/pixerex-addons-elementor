<?php

namespace PixerexElements;

if( ! defined( 'ABSPATH' ) ) exit();

class Pixerex_Addons_Category {
    
    private static $instance = null;
    
    public function __construct() {
        $this->create_pixerex_category();
    }
    
    /*
     * Create pixerex Addons Category
     * 
     * Adds category `pixerex Addons` in the editor panel.
     * 
     * @access public
     * 
     */
    public function create_pixerex_category() {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'pixerex-elements',
            array(
                'title' => Helper_Functions::get_category()
            ),
        1);
    }
    /**
     * Creates and returns an instance of the class
     * 
     * @since  2.6.8
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
    

if ( ! function_exists( 'pixerex_addons_category' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 * @since  2.6.8
	 * @return object
	 */
	function pixerex_addons_category() {
		return Pixerex_Addons_Category::get_instance();
	}
}
pixerex_addons_category();