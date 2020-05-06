<?php

namespace PixerexElements\Admin\Settings;

use PixerexElements\Helper_Functions;

if( ! defined( 'ABSPATH' ) ) exit;

class Maps {
    
    public static $pr_maps_keys = [ 'pixerex-map-api', 'pixerex-map-disable-api', 'pixerex-map-cluster', 'pixerex-map-locale' ];
    
    private $pr_maps_default_settings;
    
    private $pr_maps_settings;
    
    private $pr_maps_get_settings;
    
    public function __construct() {
        
        add_action( 'admin_menu', array ( $this,'create_maps_menu' ), 100 );
        
        add_action( 'wp_ajax_pr_maps_save_settings', array( $this, 'pr_save_maps_settings' ) );
        
    }
    
    public function create_maps_menu() {
        
        add_submenu_page(
            'pixerex-elements',
            '',
            __('Google Maps', 'pixerex-elements'),
            'manage_options',
            'pixerex-elements-maps',
            [ $this, 'pr_maps_page' ]
        );
        
    }
    
    public function pr_maps_page() {
        
        $js_info = array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'pr-maps' ),
		);
        
        wp_localize_script( 'pr-admin-js', 'settings', $js_info );
        
        $this->pr_maps_default_settings = $this->get_default_keys();
       
        $this->pr_maps_get_settings = $this->get_enabled_keys();
       
        $pr_maps_new_settings = array_diff_key( $this->pr_maps_default_settings, $this->pr_maps_get_settings );
        
        if( ! empty( $pr_maps_new_settings ) ) {
            $pr_maps_updated_settings = array_merge( $this->pr_maps_get_settings, $pr_maps_new_settings );
            update_option( 'pr_maps_save_settings', $pr_maps_updated_settings );
        }
        
        $this->pr_maps_get_settings = get_option( 'pr_maps_save_settings', $this->pr_maps_default_settings );
        
        $settings = $this->pr_maps_get_settings;
        
        $locales = Helper_Functions::get_google_languages();
        
        ?>
        <div class="wrap">
           <div class="response-wrap"></div>
           <form action="" method="POST" id="pr-maps" name="pr-maps">
           <div class="pr-header-wrapper">
              <div class="pr-title-left">
                  <h1 class="pr-title-main"><?php echo Helper_Functions::name(); ?></h1>
              </div>
           </div>
           <div class="pr-settings-tabs">
              <div id="pr-maps-api" class="pr-maps-tab">
                 <div class="pr-row">
                    <table class="pr-maps-table">
                       <tr>
                          <p class="pr-maps-api-notice">
                             <?php echo esc_html( Helper_Functions::get_prefix() ) . __(' Maps Element requires Google API key to be entered below. If you don’t have one, click ', 'pixerex-elements'); ?><a href="https://premiumaddons.com/docs/getting-your-api-key-for-google-reviews/" target="_blank"><?php echo __('here', 'pixerex-elements'); ?></a><?php echo __(' to get your  key.', 'pixerex-elements'); ?>
                          </p>
                       </tr>
                       <tr>
                          <td>
                             <h4 class="pr-api-title"><?php echo __('Google Maps API Key:', 'pixerex-elements'); ?></h4>
                          </td>
                          <td>
                              <input name="pixerex-map-api" id="pixerex-map-api" type="text" placeholder="API Key" value="<?php echo esc_attr( $settings['pixerex-map-api'] ); ?>">
                          </td>
                       </tr>
                       <tr>
                          <td>
                             <h4 class="pr-api-disable-title"><?php echo __('Google Maps Localization Language:', 'pixerex-elements'); ?></h4>
                          </td>
                          <td>
                              <select name="pixerex-map-locale" id="pixerex-map-locale" class="placeholder placeholder-active">
                                    <option value=""><?php _e( 'Default', 'pixerex-elements' ); ?></option>
                                <?php foreach ( $locales as $key => $value ) { ?>
                                    <?php
                                    $selected = '';
                                    if ( $key === $settings['pixerex-map-locale'] ) {
                                        $selected = 'selected="selected" ';
                                    }
                                    ?>
                                    <option value="<?php echo esc_attr( $key ); ?>" <?php echo $selected; ?>><?php echo esc_attr( $value ); ?></option>
                                    <?php } ?>
                                </select>
                          </td>
                       </tr>
                       <tr>
                          <td>
                             <h4 class="pr-api-disable-title"><?php echo __('Load Maps API JS File:','pixerex-elements'); ?></h4>
                          </td>
                          <td>
                              <input name="pixerex-map-disable-api" id="pixerex-map-disable-api" type="checkbox" <?php checked(1, $settings['pixerex-map-disable-api'], true) ?>><span><?php echo __('This will load API JS file if it\'s not loaded by another theme or plugin', 'pixerex-elements'); ?></span>
                          </td>
                       </tr>
                       <tr>
                          <td>
                             <h4 class="pr-api-disable-title"><?php echo __('Load Markers Clustering JS File:','pixerex-elements'); ?></h4>
                          </td>
                          <td>
                              <input name="pixerex-map-cluster" id="pixerex-map-cluster" type="checkbox" <?php checked(1, $settings['pixerex-map-cluster'], true) ?>><span><?php echo __('This will load the JS file for markers clusters', 'pixerex-elements'); ?></span>
                          </td>
                       </tr>
                    </table>
                    <input type="submit" value="<?php echo __('Save Settings', 'pixerex-elements'); ?>" class="button pr-btn pr-save-button">
                 </div>
              </div>
           </div>
           </form>
        </div>
    <?php }
    
    public static function get_default_keys() {
        
        $default_keys = array_fill_keys( self::$pr_maps_keys, true );
        
        return $default_keys;
    }
    
    public static function get_enabled_keys() {
        
        $enabled_keys = get_option( 'pr_maps_save_settings', self::get_default_keys() );
        
        return $enabled_keys;
    }
    
    public function pr_save_maps_settings() {
        
        check_ajax_referer('pr-maps', 'security');

        if( isset( $_POST['fields'] ) ) {
            parse_str( $_POST['fields'], $settings );
        } else {
            return;
        }
        
        $this->pr_maps_settings = array(
            'pixerex-map-api'           => sanitize_text_field( $settings['pixerex-map-api'] ),
            'pixerex-map-disable-api'   => intval( $settings['pixerex-map-disable-api'] ? 1 : 0 ),
            'pixerex-map-cluster'       => intval( $settings['pixerex-map-cluster'] ? 1 : 0 ),
            'pixerex-map-locale'        => sanitize_text_field( $settings['pixerex-map-locale'] )
        );
        
        update_option( 'pr_maps_save_settings', $this->pr_maps_settings );
        
        return true;
    }
}