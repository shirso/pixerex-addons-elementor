<?php

namespace PixerexElements;

if( ! defined('ABSPATH') ) exit;

class Helper_Functions {
    
    private static $google_localize = null;
    
    /**
	 * script debug enabled
	 *
	 * @var script_debug
	 */
	private static $script_debug = null;
    
    /**
	 * JS scripts directory
	 *
	 * @var js_dir
	 */
	private static $js_dir = null;
    
    /**
	 * CSS fiels directory
	 *
	 * @var js_dir
	 */
	private static $css_dir = null;

	/**
	 * JS Suffix
	 *
	 * @var js_suffix
	 */
	private static $assets_suffix = null;
    
    /**
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function author() {
        
        return ( isset( $author_free ) && '' != $author_free ) ? $author_free : 'Pixerex';
    }
    
    /**
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function name() {
        
        return ( isset( $name_free ) && '' != $name_free ) ? $name_free : 'Pixerex Elements';
    }
    
    /**
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_category() {
        
        return ( isset( $category ) && '' != $category ) ? $category : __( 'Pixerex Elements', 'pixerex-elements');
        
    }
    
    /**
     * Get White Labeling - Widgets Prefix string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_prefix() {
        
        return ( isset( $prefix ) && '' != $prefix ) ? $prefix : __('Pixerex', 'pixerex-elements');
    }
    
    /**
     * Get White Labeling - Widgets Badge string
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_badge() {
        
        return ( isset( $badge ) && '' != $badge ) ? $badge : 'PR';
    }
    
    /**
     * Get Google Maps localization prefixes
     * 
     * @since 1.0.0
     * @return string
     * 
     */
    public static function get_google_languages() {
        
        if ( null === self::$google_localize ) {

			self::$google_localize = array(
				 'ar' => __( 'Arabic', 'pixerex-elements'),
                'eu' => __( 'Basque', 'pixerex-elements'),
                'bg' => __( 'Bulgarian', 'pixerex-elements'),
                'bn' => __( 'Bengali', 'pixerex-elements'),
                'ca' => __( 'Catalan', 'pixerex-elements'),
                'cs' => __( 'Czech', 'pixerex-elements'),
                'da' => __( 'Danish', 'pixerex-elements'),
                'de' => __( 'German', 'pixerex-elements'),
                'el' => __( 'Greek', 'pixerex-elements'),
                'en' => __( 'English', 'pixerex-elements'),
                'en-AU' => __( 'English (australian)', 'pixerex-elements'),
                'en-GB' => __( 'English (great britain)', 'pixerex-elements'),
                'es' => __( 'Spanish', 'pixerex-elements'),
                'fa' => __( 'Farsi', 'pixerex-elements'),
                'fi' => __( 'Finnish', 'pixerex-elements'),
                'fil' => __( 'Filipino', 'pixerex-elements'),
                'fr' => __( 'French', 'pixerex-elements'),
                'gl' => __( 'Galician', 'pixerex-elements'),
                'gu' => __( 'Gujarati', 'pixerex-elements'),
                'hi' => __( 'Hindi', 'pixerex-elements'),
                'hr' => __( 'Croatian', 'pixerex-elements'),
                'hu' => __( 'Hungarian', 'pixerex-elements'),
                'id' => __( 'Indonesian', 'pixerex-elements'),
                'it' => __( 'Italian', 'pixerex-elements'),
                'iw' => __( 'Hebrew', 'pixerex-elements'),
                'ja' => __( 'Japanese', 'pixerex-elements'),
                'kn' => __( 'Kannada', 'pixerex-elements'),
                'ko' => __( 'Korean', 'pixerex-elements'),
                'lt' => __( 'Lithuanian', 'pixerex-elements'),
                'lv' => __( 'Latvian', 'pixerex-elements'),
                'ml' => __( 'Malayalam', 'pixerex-elements'),
                'mr' => __( 'Marathi', 'pixerex-elements'),
                'nl' => __( 'Dutch', 'pixerex-elements'),
                'no' => __( 'Norwegian', 'pixerex-elements'),
                'pl' => __( 'Polish', 'pixerex-elements'),
                'pt' => __( 'Portuguese', 'pixerex-elements'),
                'pt-BR' => __( 'Portuguese (brazil)', 'pixerex-elements'),
                'pt-PT' => __( 'Portuguese (portugal)', 'pixerex-elements'),
                'ro' => __( 'Romanian', 'pixerex-elements'),
                'ru' => __( 'Russian', 'pixerex-elements'),
                'sk' => __( 'Slovak', 'pixerex-elements'),
                'sl' => __( 'Slovenian', 'pixerex-elements'),
                'sr' => __( 'Serbian', 'pixerex-elements'),
                'sv' => __( 'Swedish', 'pixerex-elements'),
                'tl' => __( 'Tagalog', 'pixerex-elements'),
                'ta' => __( 'Tamil', 'pixerex-elements'),
                'te' => __( 'Telugu', 'pixerex-elements'),
                'th' => __( 'Thai', 'pixerex-elements'),
                'tr' => __( 'Turkish', 'pixerex-elements'),
                'uk' => __( 'Ukrainian', 'pixerex-elements'),
                'vi' => __( 'Vietnamese', 'pixerex-elements'),
                'zh-CN' => __( 'Chinese (simplified)', 'pixerex-elements'),
                'zh-TW' => __( 'Chinese (traditional)', 'pixerex-elements'),
			);
		}

		return self::$google_localize;
        
    }
    
    /**
     * Checks if a plugin is installed
     * 
     * @since 1.0.0
     * @return boolean
     * 
     */
    public static function is_plugin_installed( $plugin_path ) {
        
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        
        $plugins = get_plugins();
        
        return isset( $plugins[ $plugin_path ] );
    }
    
    /**
	 * Check is script debug mode enabled.
	 *
	 * @since 3.11.1
	 *
	 * @return boolean is debug mode enabled
	 */
	public static function is_debug_enabled() {

		if ( null === self::$script_debug ) {

			self::$script_debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		}

		return self::$script_debug;
	}
    
    /**
	 * Get JS scripts directory.
	 *
	 * @since 0.0.1
	 *
	 * @return string JS scripts directory.
	 */
	public static function get_scripts_dir() {

		if ( null === self::$js_dir ) {

			self::$js_dir = self::is_debug_enabled() ? 'js' : 'min-js';
		}

		return self::$js_dir;
	}
    
    /**
	 * Get CSS files directory.
	 *
	 * @since 0.0.1
	 *
	 * @return string CSS files directory.
	 */
	public static function get_styles_dir() {

		if ( null === self::$css_dir ) {

			self::$css_dir = self::is_debug_enabled() ? 'css' : 'min-css';
		}

		return self::$css_dir;
	}

	/**
	 * Get JS scripts suffix.
	 *
	 * @since 0.0.1
	 *
	 * @return string JS scripts suffix.
	 */
	public static function get_assets_suffix() {

		if ( null === self::$assets_suffix ) {

			self::$assets_suffix = self::is_debug_enabled() ? '' : '.min';
		}

		return self::$assets_suffix;
	}
    
    /**
     * Get Installed Theme
     * 
     * Returns the active theme slug
     * 
     * @access public
     * @return string theme slug
     */
    public static function get_installed_theme() {

        $theme = wp_get_theme();

        if( $theme->parent() ) {

            $theme_name = $theme->parent()->get('Name');

        } else {

            $theme_name = $theme->get('Name');

        }

        $theme_name = sanitize_key( $theme_name );

        return $theme_name;
    }
    
    /*
     * Get Vimeo Video Data
     * 
     * Get video data using Vimeo API
     * 
     * @since 3.11.4
     * @access public
     * 
     * @param string $id video ID
     */
    public static function get_vimeo_video_data( $id ) {
        
        $vimeo_data         = wp_remote_get( 'http://www.vimeo.com/api/v2/video/' . intval( $id ) . '.php' );
        
        if ( isset( $vimeo_data['response']['code'] ) && '200' == $vimeo_data['response']['code'] ) {
            $response       = unserialize( $vimeo_data['body'] );
            $thumbnail = isset( $response[0]['thumbnail_large'] ) ? $response[0]['thumbnail_large'] : false;
            
            $data = [
                'src'       => $thumbnail,
                'url'       => $response[0]['user_url'],
                'portrait'  => $response[0]['user_portrait_huge'],
                'title'     => $response[0]['title'],
                'user'      => $response[0]['user_name']
            ];
            
            return $data;
        }
        
        return false;
        
    }
    
    /*
     * Get Video Thumbnail
     * 
     * Get thumbnail URL for embed or self hosted
     * 
     * @since 3.7.0
     * @access public
     * 
     * @param string $id video ID
     * @param string $type embed type
     * @param string $size youtube thumbnail size
     */
    public static function get_video_thumbnail( $id, $type, $size = '' ) {
        
        $thumbnail_src = '';
        
        if ( 'youtube' === $type ) {
            if ( '' === $size ) {
                $size = 'maxresdefault';
            }
            $thumbnail_src = sprintf( 'https://i.ytimg.com/vi/%s/%s.jpg', $id, $size );
        } elseif ( 'vimeo' === $type ) {
           
            $vimeo = self::get_vimeo_video_data( $id );
            
            $thumbnail_src = $vimeo['src'];
                
        } else {
            $thumbnail_src = 'transparent';
        }
        
        return $thumbnail_src;
    }
}