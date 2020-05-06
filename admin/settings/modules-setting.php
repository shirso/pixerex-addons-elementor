<?php

namespace PixerexElements\Admin\Settings;

use PixerexElements\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class Modules_Settings {
    
    protected $page_slug = 'pixerex-elements';

    public static $pr_elements_keys = ['pixerex-portfolio','pixerex-banner', 'pixerex-blog','pixerex-carousel', 'pixerex-countdown','pixerex-counter','pixerex-dual-header','pixerex-maps','pixerex-modalbox','pixerex-progressbar','pixerex-pricing-table','pixerex-button','pixerex-contactform', 'pixerex-image-button', 'pixerex-grid','pixerex-image-scroll', 'pixerex-templates', 'pixerex-duplicator'];
    
    private $pr_default_settings;
    
    private $pr_settings;
    
    private $pr_get_settings;
   
    public function __construct() {
        
        add_action( 'admin_menu', array( $this,'pr_admin_menu') );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'pr_admin_page_scripts' ) );
        
        add_action( 'wp_ajax_pr_save_admin_addons_settings', array( $this, 'pr_save_settings' ) );
        
    }

    public function pr_admin_page_scripts () {
        
        wp_enqueue_style( 'pr_admin_icon', PIXEREX_ELEMENTS_URL .'admin/assets/fonts/style.css' );
        
        $suffix = is_rtl() ? '-rtl' : '';
        
        $current_screen = get_current_screen();
        
        if( strpos( $current_screen->id , $this->page_slug ) !== false ) {
            
            wp_enqueue_style(
                'pr-admin-css',
                PIXEREX_ELEMENTS_URL.'admin/assets/css/admin' . $suffix . '.css'
            );
            
            wp_enqueue_style(
                'pr-sweetalert-style',
                PIXEREX_ELEMENTS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.css'
            );
            
            wp_enqueue_script(
                'pr-admin-js',
                PIXEREX_ELEMENTS_URL .'admin/assets/js/admin.js',
                array('jquery'),
                PIXEREX_ELEMENTS_VERSION,
                true
            );
            
            wp_enqueue_script(
                'pr-admin-dialog',
                PIXEREX_ELEMENTS_URL . 'admin/assets/js/dialog/dialog.js',
                array('jquery-ui-position'),
                PIXEREX_ELEMENTS_VERSION,
                true
            );
            
            wp_enqueue_script(
                'pr-sweetalert-core',
                PIXEREX_ELEMENTS_URL . 'admin/assets/js/sweetalert2/core.js',
                array('jquery'),
                PIXEREX_ELEMENTS_VERSION,
                true
            );
            
			wp_enqueue_script(
                'pr-sweetalert',
                PIXEREX_ELEMENTS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.js',
                array( 'jquery', 'pr-sweetalert-core' ),
                PIXEREX_ELEMENTS_VERSION,
                true
            );
            
        }
    }

    public function pr_admin_menu() {
        
        $plugin_name = 'Pixerex Elements';
        
        add_menu_page(
            $plugin_name,
            $plugin_name,
            'manage_options',
            'pixerex-elements',
            array( $this , 'pr_admin_page' ),
            '' ,
            100
        );
    }

    public function pr_admin_page() {
        
        $theme_slug = Helper_Functions::get_installed_theme();
        
        $js_info = array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'pr-elements' ),
            'theme'     => $theme_slug
		);

		wp_localize_script( 'pr-admin-js', 'settings', $js_info );
        
        $this->pr_default_settings = $this->get_default_keys();
       
        $this->pr_get_settings = $this->get_enabled_keys();
       
        $pr_new_settings = array_diff_key( $this->pr_default_settings, $this->pr_get_settings );
       
        if( ! empty( $pr_new_settings ) ) {
            $pr_updated_settings = array_merge( $this->pr_get_settings, $pr_new_settings );
            update_option( 'pr_save_settings', $pr_updated_settings );
        }
        $this->pr_get_settings = get_option( 'pr_save_settings', $this->pr_default_settings );
        
        $prefix = Helper_Functions::get_prefix();
        
	?>
	<div class="wrap">
        <div class="response-wrap"></div>
        <form action="" method="POST" id="pr-settings" name="pr-settings">
            <div class="pr-header-wrapper">
                <div class="pr-title-left">
                    <h1 class="pr-title-main"><?php echo Helper_Functions::name(); ?></h1>
                </div>
            </div>
            <div class="pr-settings-tabs">
                <div id="pr-modules" class="pr-settings-tab">
                    <div>
                        <br>
                        <input type="checkbox" class="pr-checkbox" checked="checked">
                        <label>Enable/Disable All</label>
                    </div>
                    <table class="pr-elements-table">
                        <tbody>
                        <tr>

                            <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Dynamic Portfolio', 'pixerex-elements') ); ?></th>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" id="pixerex-portfolio" name="pixerex-portfolio" <?php checked(1, $this->pr_get_settings['pixerex-portfolio'], true) ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Banner', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-banner" name="pixerex-banner" <?php checked(1, $this->pr_get_settings['pixerex-banner'], true) ?>>
                                        <span class="slider round"></span>
                                </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Blog', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-blog" name="pixerex-blog" <?php checked(1, $this->pr_get_settings['pixerex-blog'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Button', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-button" name="pixerex-button" <?php checked(1, $this->pr_get_settings['pixerex-button'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Carousel', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-carousel" name="pixerex-carousel" <?php checked(1, $this->pr_get_settings['pixerex-carousel'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Contact Form7', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-contactform" name="pixerex-contactform" <?php checked(1, $this->pr_get_settings['pixerex-contactform'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Countdown', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-countdown" name="pixerex-countdown" <?php checked(1, $this->pr_get_settings['pixerex-countdown'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Counter', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-counter" name="pixerex-counter" <?php checked(1, $this->pr_get_settings['pixerex-counter'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Dual Heading', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-dual-header" name="pixerex-dual-header" <?php checked(1, $this->pr_get_settings['pixerex-dual-header'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Media Grid', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-grid" name="pixerex-grid" <?php checked(1, $this->pr_get_settings['pixerex-grid'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Button', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-image-button" name="pixerex-image-button" <?php checked(1, $this->pr_get_settings['pixerex-image-button'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Scroll', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-image-scroll" name="pixerex-image-scroll" <?php checked(1, $this->pr_get_settings['pixerex-image-scroll'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Maps', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-maps" name="pixerex-maps" <?php checked(1, $this->pr_get_settings['pixerex-maps'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Modal Box', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-modalbox" name="pixerex-modalbox" <?php checked(1, $this->pr_get_settings['pixerex-modalbox'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Progress Bar', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-progressbar" name="pixerex-progressbar" <?php checked(1, $this->pr_get_settings['pixerex-progressbar'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Pricing Table', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-pricing-table" name="pixerex-pricing-table" <?php checked(1, $this->pr_get_settings['pixerex-pricing-table'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Duplicator', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-duplicator" name="pixerex-duplicator" <?php checked(1, $this->pr_get_settings['pixerex-duplicator'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Templates', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pixerex-templates" name="pixerex-templates" <?php checked(1, $this->pr_get_settings['pixerex-templates'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="<?php echo __('Save Settings', 'pixerex-elements'); ?>" class="button pr-btn pr-save-button">
                    
                </div>
            </div>
            </form>
        </div>
	<?php
}

    public static function get_default_keys() {
        
        $default_keys = array_fill_keys( self::$pr_elements_keys, true );
        
        return $default_keys;
    }
    
    public static function get_enabled_keys() {
        
        $enabled_keys = get_option( 'pr_save_settings', self::get_default_keys() );
        
        return $enabled_keys;
    }
    
    /*
     * Check If Pixerex Templates is enabled
     * 
     * @since 3.6.0
     * @access public
     * 
     * @return boolean
     */
    public static function check_pixerex_templates() {
        
        $settings = self::get_enabled_keys();
        
        if( ! isset( $settings['pixerex-templates'] ) )
            return true;

        $is_enabled = $settings['pixerex-templates'];
        
        return $is_enabled;
    }
    
    /*
     * Check If Pixerex Duplicator is enabled
     * 
     * @since 3.9.7
     * @access public
     * 
     * @return boolean
     */
    public static function check_pixerex_duplicator() {
        
        $settings = self::get_enabled_keys();
        
        if( ! isset( $settings['pixerex-duplicator'] ) )
            return true;

        $is_enabled = $settings['pixerex-duplicator'];
        
        return $is_enabled;
    }

    public function pr_save_settings() {
        
        check_ajax_referer( 'pr-elements', 'security' );

        if( isset( $_POST['fields'] ) ) {
            parse_str( $_POST['fields'], $settings );
        } else {
            return;
        }

        $this->pr_settings = array(
            'pixerex-portfolio'            => intval( $settings['pixerex-portfolio'] ? 1 : 0 ),
            'pixerex-banner'            => intval( $settings['pixerex-banner'] ? 1 : 0 ),
            'pixerex-blog'              => intval( $settings['pixerex-blog'] ? 1 : 0 ),
            'pixerex-carousel'          => intval( $settings['pixerex-carousel'] ? 1 : 0 ),
            'pixerex-countdown'         => intval( $settings['pixerex-countdown'] ? 1 : 0 ),
            'pixerex-counter'           => intval( $settings['pixerex-counter'] ? 1 : 0 ),
            'pixerex-dual-header'       => intval( $settings['pixerex-dual-header'] ? 1 : 0 ),
            'pixerex-maps'              => intval( $settings['pixerex-maps'] ? 1 : 0 ),
            'pixerex-modalbox' 			=> intval( $settings['pixerex-modalbox'] ? 1 : 0 ),
            'pixerex-progressbar' 		=> intval( $settings['pixerex-progressbar'] ? 1 : 0 ),
            'pixerex-pricing-table'     => intval( $settings['pixerex-pricing-table'] ? 1 : 0 ),
            'pixerex-button'            => intval( $settings['pixerex-button'] ? 1 : 0 ),
            'pixerex-contactform'       => intval( $settings['pixerex-contactform'] ? 1 : 0 ),
            'pixerex-image-button'      => intval( $settings['pixerex-image-button'] ? 1 : 0 ),
            'pixerex-grid'              => intval( $settings['pixerex-grid'] ? 1 : 0 ),
            'pixerex-image-scroll'      => intval( $settings['pixerex-image-scroll'] ? 1 : 0 ),
            'pixerex-templates'         => intval( $settings['pixerex-templates'] ? 1 : 0 ),
            'pixerex-duplicator'        => intval( $settings['pixerex-duplicator'] ? 1 : 0 ),
        );

        update_option( 'pr_save_settings', $this->pr_settings );

        return true;
    }
}