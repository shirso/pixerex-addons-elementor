<?php

namespace PixerexElements\Admin\Settings;

use PixerexElements\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class Modules_Settings {
    
    protected $page_slug = 'pixerex-elements';

    public static $pr_elements_keys = ['pixerex-card','pixerex-image-compare','pixerex-slider','pixerex-image-carousel','pixerex-step-flow','pixerex-infobox','pixerex-services','pixerex-flipbox','pixerex-team','pixerex-team-carousel','pixerex-testimonials-slider','pixerex-dynamic-portfolio','pixerex-dynamic-post-carousel','pixerex-instagram','pixerex-blog'];
    
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
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Card', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-card" name="pixerex-card" <?php checked(1, $this->pr_get_settings['pixerex-card'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Compare', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-image-compare" name="pixerex-image-compare" <?php checked(1, $this->pr_get_settings['pixerex-image-compare'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Slider', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-slider" name="pixerex-slider" <?php checked(1, $this->pr_get_settings['pixerex-slider'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Image Carousel', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-image-carousel" name="pixerex-image-carousel" <?php checked(1, $this->pr_get_settings['pixerex-image-carousel'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Step Flow', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-step-flow" name="pixerex-step-flow" <?php checked(1, $this->pr_get_settings['pixerex-step-flow'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Infobox', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-infobox" name="pixerex-infobox" <?php checked(1, $this->pr_get_settings['pixerex-infobox'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Services', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-services" name="pixerex-services" <?php checked(1, $this->pr_get_settings['pixerex-services'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Flipbox', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-flipbox" name="pixerex-flipbox" <?php checked(1, $this->pr_get_settings['pixerex-flipbox'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Team', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-team" name="pixerex-team" <?php checked(1, $this->pr_get_settings['pixerex-team'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Team Carousel', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-team-carousel" name="pixerex-team-carousel" <?php checked(1, $this->pr_get_settings['pixerex-team-carousel'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Testimonials Slider', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-testimonials-slider" name="pixerex-testimonials-slider" <?php checked(1, $this->pr_get_settings['pixerex-testimonials-slider'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Dynamic Portfolio', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-dynamic-portfolio" name="pixerex-dynamic-portfolio" <?php checked(1, $this->pr_get_settings['pixerex-dynamic-portfolio'], true) ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Post Carousel', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-dynamic-post-carousel" name="pixerex-dynamic-post-carousel" <?php checked(1, $this->pr_get_settings['pixerex-dynamic-post-carousel'], true) ?>>
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
                                <th><?php echo sprintf( '%1$s %2$s', $prefix, __('Instagram Feed', 'pixerex-elements') ); ?></th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="pixerex-instagram" name="pixerex-instagram" <?php checked(1, $this->pr_get_settings['pixerex-instagram'], true) ?>>
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
       // echo 'hey you';
        $this->pr_settings = array(
            'pixerex-card'              => intval( $settings['pixerex-card'] ? 1 : 0 ),
            'pixerex-image-compare'     => intval( $settings['pixerex-image-compare'] ? 1 : 0 ),
            'pixerex-slider'            => intval( $settings['pixerex-slider'] ? 1 : 0 ),
            'pixerex-image-carousel'    => intval( $settings['pixerex-image-carousel'] ? 1 : 0 ),
            'pixerex-step-flow'         => intval( $settings['pixerex-step-flow'] ? 1 : 0 ),
            'pixerex-infobox'           => intval( $settings['pixerex-infobox'] ? 1 : 0 ),
            'pixerex-services'          => intval( $settings['pixerex-services'] ? 1 : 0 ),
            'pixerex-flipbox'           => intval( $settings['pixerex-flipbox'] ? 1 : 0 ),
            'pixerex-team' 			    => intval( $settings['pixerex-team'] ? 1 : 0 ),
            'pixerex-team-carousel' 	=> intval( $settings['pixerex-team-carousel'] ? 1 : 0 ),
            'pixerex-testimonials-slider'=> intval( $settings['pixerex-testimonials-slider'] ? 1 : 0 ),
            'pixerex-dynamic-portfolio'  => intval( $settings['pixerex-dynamic-portfolio'] ? 1 : 0 ),
            'pixerex-dynamic-post-carousel'=> intval( $settings['pixerex-dynamic-post-carousel'] ? 1 : 0 ),
            'pixerex-instagram'            => intval( $settings['pixerex-instagram'] ? 1 : 0 ),
            'pixerex-blog'                 => intval( $settings['pixerex-blog'] ? 1 : 0 ),
        );
        update_option( 'pr_save_settings', $this->pr_settings );

        return true;
    }
}