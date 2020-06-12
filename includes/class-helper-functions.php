<?php

namespace PixerexElements;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
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
          return true;
		//return self::$script_debug;
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

    /**
     * Check elementor version
     *
     * @param string $version
     * @param string $operator
     * @return bool
     */
    public static function is_elementor_version( $operator = '<', $version = '2.6.0' ) {
        return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
    }

    /**
     * Get a translatable string with allowed html tags.
     *
     * @param string $level Allowed levels are basic and intermediate
     * @return string
     */
    public static function ha_get_allowed_html_desc( $level = 'basic' ) {
        if ( ! in_array( $level, [ 'basic', 'intermediate' ] ) ) {
            $level = 'basic';
        }

        $tags_str = '<' . implode( '>,<', array_keys( self::ha_get_allowed_html_tags( $level ) ) ) . '>';
        return sprintf( __( 'This input field has support for the following HTML tags: %1$s', 'happy-elementor-addons' ), '<code>' . esc_html( $tags_str ) . '</code>' );
    }
    /**
     * Get a list of all the allowed html tags.
     *
     * @param string $level Allowed levels are basic and intermediate
     * @return array
     */
   public static function ha_get_allowed_html_tags( $level = 'basic' ) {
        $allowed_html = [
            'b' => [],
            'i' => [],
            'u' => [],
            'em' => [],
            'br' => [],
            'abbr' => [
                'title' => [],
            ],
            'span' => [
                'class' => [],
            ],
            'strong' => [],
        ];

        if ( $level === 'intermediate' ) {
            $allowed_html['a'] = [
                'href' => [],
                'title' => [],
                'class' => [],
                'id' => [],
            ];
        }

        return $allowed_html;
    }

    /**
     * Strip all the tags except allowed html tags
     *
     * The name is based on inline editing toolbar name
     *
     * @param string $string
     * @return string
     */
    public static function ha_kses_basic( $string = '' ) {
        return wp_kses( $string, self::ha_get_allowed_html_tags( 'basic' ) );
    }
    /**
     * Strip all the tags except allowed html tags
     *
     * The name is based on inline editing toolbar name
     *
     * @param string $string
     * @return string
     */
    public static function ha_kses_intermediate( $string = '' ) {
        return wp_kses( $string, self::ha_get_allowed_html_tags( 'intermediate' ) );
    }
    /**
     * Get elementor instance
     *
     * @return \Elementor\Plugin
     */
    public static function px_elementor() {
        return \Elementor\Plugin::instance();
    }
    public static function get_setting_value( &$settings, $keys ) {
        if ( ! is_array( $keys ) ) {
            $keys = explode( '.', $keys );
        }
        if ( is_array( $settings[ $keys[0] ] ) ) {
            return self::get_setting_value( $settings[ $keys[0] ], array_slice( $keys, 1 ) );
        }
        return $settings[ $keys[0] ];
    }
    Public static function prepare_data_prop_settings( &$settings, $field_map = [] ) {
        $data = [];
        foreach ( $field_map as $key => $data_key ) {
            $setting_value = self::get_setting_value( $settings, $key );
            list( $data_field_key, $data_field_type ) = explode( '.', $data_key );
            $validator = $data_field_type . 'val';

            if ( is_callable( $validator ) ) {
                $val = call_user_func( $validator, $setting_value );
            } else {
                $val = $setting_value;
            }
            $data[ $data_field_key ] = $val;
        }
        return wp_json_encode( $data );
    }
    /**
     * Render icon html with backward compatibility
     *
     * @param array $settings
     * @param string $old_icon_id
     * @param string $new_icon_id
     * @param array $attributes
     */
   public static function render_icon( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
        // Check if its already migrated
        $migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
        // Check if its a new widget without previously selected icon using the old Icon control
        $is_new = empty( $settings[ $old_icon_id ] );

        $attributes['aria-hidden'] = 'true';

        if ( self::is_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
            \Elementor\Icons_Manager::render_icon( $settings[ $new_icon_id ], $attributes );
        } else {
            if ( empty( $attributes['class'] ) ) {
                $attributes['class'] = $settings[ $old_icon_id ];
            } else {
                if ( is_array( $attributes['class'] ) ) {
                    $attributes['class'][] = $settings[ $old_icon_id ];
                } else {
                    $attributes['class'] .= ' ' . $settings[ $old_icon_id ];
                }
            }
            printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
        }
    }


    public static function get_all_post_type_options() {

        $post_types = get_post_types(array('public' => true), 'objects');

        $options = ['' => ''];

        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }

        return  $options;
    }
    public static function get_taxonomies_map() {

        $map = array();

        $taxonomies = self::get_all_taxonomies();

        foreach ($taxonomies as $taxonomy) {
            $map [$taxonomy] = $taxonomy;
        }

        return apply_filters('lae_taxonomies_map', $map);

    }

    public static function get_all_taxonomies() {

        $taxonomies = get_taxonomies(array('public' => true, '_builtin' => false));

        $taxonomies = array_merge(array('category' => 'category', 'post_tag' => 'post_tag'), $taxonomies);

        return $taxonomies;
    }
    public static function get_all_taxonomy_options() {

        $taxonomies = self::get_all_taxonomies();

        $results = array();
        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms(array('taxonomy' => $taxonomy));
            foreach ($terms as $term)
                $results[$term->taxonomy . ':' . $term->slug] = $term->taxonomy . ':' . $term->name;
        }

        return apply_filters('lae_taxonomy_options', $results);
    }
    public static function get_all_types_post(){
        $posts = get_posts( [
            'post_type'      => 'any',
            'post_style'     => 'all_types',
            'post_status'    => 'publish',
            'posts_per_page' => '-1',
        ] );

        if ( !empty( $posts ) ) {
            return wp_list_pluck( $posts, 'post_title', 'ID' );
        }

        return [];

    }
    /**
     * Get all Authors
     *
     * @return array
     */
    public static function get_authors() {
        $users = get_users( [
            'who'                 => 'authors',
            'has_published_posts' => true,
            'fields'              => [
                'ID',
                'display_name',
            ],
        ] );

        if ( !empty( $users ) ) {
            return wp_list_pluck( $users, 'display_name', 'ID' );
        }

        return [];
    }
    /**
     * POst Orderby Options
     *
     * @return array
     */
    public static function get_post_orderby_options() {
        $orderby = array(
            'ID'            => 'Post ID',
            'author'        => 'Post Author',
            'title'         => 'Title',
            'date'          => 'Date',
            'modified'      => 'Last Modified Date',
            'parent'        => 'Parent Id',
            'rand'          => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order'    => 'Menu Order',
        );

        return $orderby;
    }
    public function pixerex_query_controls(){
        $post_types = self::get_all_post_type_options();
        $post_types['by_id'] = __( 'Manual Selection', 'pixerex-elements' );
        $taxonomies = get_taxonomies( [], 'objects' );
        $this->start_controls_section(
            'eael_section_post__filters',
            [
                'label' => __( 'Query', 'pixerex-elements' ),
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label'   => __( 'Source', 'essential-addons-for-elementor-lite' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $post_types,
                'default' => key( $post_types ),
            ]
        );
        $this->add_control(
            'posts_ids',
            [
                'label'       => __( 'Search & Select', 'essential-addons-for-elementor-lite' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => self::get_all_types_post(),
                'label_block' => true,
                'multiple'    => true,
                'condition'   => [
                    'post_type' => 'by_id',
                ],
            ]
        );
        $this->add_control(
            'authors', [
                'label'       => __( 'Author', 'essential-addons-for-elementor-lite' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'default'     => [],
                'options'     => self::get_authors(),
                'condition'   => [
                    'post_type!' => 'by_id',
                ],
            ]
        );
        foreach ( $taxonomies as $taxonomy => $object ) {
            if ( !isset( $object->object_type[0] ) || !in_array( $object->object_type[0], array_keys( $post_types ) ) ) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label'       => $object->label,
                    'type'        => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple'    => true,
                    'object_type' => $taxonomy,
                    'options'     => wp_list_pluck( get_terms( $taxonomy ), 'name', 'term_id' ),
                    'condition'   => [
                        'post_type' => $object->object_type,
                    ],
                ]
            );
        }
        $this->add_control(
            'post__not_in',
            [
                'label'       => __( 'Exclude', 'essential-addons-for-elementor-lite' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => self::get_all_types_post(),
                'label_block' => true,
                'post_type'   => '',
                'multiple'    => true,
                'condition'   => [
                    'post_type!' => 'by_id',
                ],
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label'   => __( 'Posts Per Page', 'essential-addons-for-elementor-lite' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );
        $this->add_control(
            'offset',
            [
                'label'   => __( 'Offset', 'essential-addons-for-elementor-lite' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label'   => __( 'Order By', 'essential-addons-for-elementor-lite' ),
                'type'    => Controls_Manager::SELECT,
                'options' => self::get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __( 'Order', 'essential-addons-for-elementor-lite' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'asc'  => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',

            ]
        );

        $this->end_controls_section();
    }

}