<?php

namespace PixerexElements\Admin\Includes;

use PixerexElements\Admin\Settings\Modules_Settings;
use PixerexElements\Helper_Functions;

if ( ! defined( 'ABSPATH' ) ) exit;

class Admin_Helper {
    
    const DUPLICATE_ACTION = 'pa_duplicator';
    
    protected $page_slug = 'pixerex-elements';
    
	private static $instance = null;
    
    public static $current_screen = null;
    
    /**
    * Constructor for the class
    */
    public function __construct() {
        
        add_action( 'current_screen', array( $this, 'get_current_screen' ) );
        
        if( ! Modules_Settings::check_pixerex_duplicator() )
            return;
        
        add_action( 'admin_action_' . self::DUPLICATE_ACTION, array( $this, 'duplicate_post' ) );
        add_filter( 'post_row_actions', array( $this, 'add_duplicator_actions' ), 10, 2 );
        add_filter( 'page_row_actions', array( $this, 'add_duplicator_actions' ), 10, 2 );
        
    }
    
    /**
     * Add Duplicator Actions
     * 
     * Add duplicator action links to posts/pages
     *
     * @access public
     * @since 3.9.7
     * 
     * @param array $actions
     * @param \WP_Post $post
     * @return array
     */
    public function add_duplicator_actions( $actions, $post ) {
        
        if ( current_user_can( 'edit_posts' ) && post_type_supports( $post->post_type, 'elementor' ) ) {
            
            $actions[ self::DUPLICATE_ACTION ] = sprintf(
                '<a href="%1$s" title="%2$s"><span class="screen-reader-text">%2$s</span>%3$s</a>',
                esc_url( self::get_duplicate_url( $post->ID ) ),
                sprintf( esc_attr__( 'Duplicate - %s', 'pixerex-elements' ), esc_attr( $post->post_title ) ),
                __( 'PA Duplicate', 'pixerex-elements' )
            );
            
        }

        return $actions;
    }
    
    /**
     * Get duplicate url
     * 
     * @access public
     * @since 3.9.7
     *
     * @param $post_id
     * @return string
     */
    public static function get_duplicate_url( $post_id ) {
        return wp_nonce_url(
            add_query_arg(
                [
                    'action' => self::DUPLICATE_ACTION,
                    'post_id' => $post_id
                ],
                admin_url( 'admin.php' )
            ),
            self::DUPLICATE_ACTION
        );
    }
    
    /**
     * Duplicate required post/page
     * 
     * @access public
     * @since 3.9.7
     *
     * @return void
     */
    public function duplicate_post() {
        
        if ( ! current_user_can( 'edit_posts' ) )
            return;
        
        $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
        $post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;
        

        if ( ! wp_verify_nonce( $nonce, self::DUPLICATE_ACTION ) )
            return;
        
        if ( is_null( $post = get_post( $post_id ) ) )
            return;
        
        $post = sanitize_post( $post, 'db' );
        
        $duplicated_post_id = self::insert_post( $post );
        
        $redirect = add_query_arg( array (
            'post_type' => $post->post_type
            ),
            admin_url( 'edit.php' ) 
        );

        if ( ! is_wp_error( $duplicated_post_id ) ) {
            
            self::duplicate_post_taxonomies( $post, $duplicated_post_id );
            self::duplicate_post_meta_data( $post, $duplicated_post_id );

        }

        wp_safe_redirect( $redirect );
        die();
    }
    
    /**
     * Duplicate required post/page
     * 
     * @access public
     * @since 3.9.7
     *
     * @return void
     */
    protected static function insert_post( $post ) {
        $current_user = wp_get_current_user();
        
        $post_meta = get_post_meta( $post->ID );
        
        $duplicated_post_args = [
            'post_status'    => 'draft',
            'post_type'      => $post->post_type,
            'post_parent'    => $post->post_parent,
            'post_content'   => $post->post_content,
            'menu_order'     => $post->menu_order,
            'ping_status'    => $post->ping_status,
            'post_excerpt'   => $post->post_excerpt,
            'post_password'  => $post->post_password,
            'comment_status' => $post->comment_status,
            'to_ping'        => $post->to_ping,
            'post_author'    => $current_user->ID,
            'post_title'     => sprintf( __( 'Duplicated: %s - [#%d]', 'pixerex-elements' ), $post->post_title,
                $post->ID )
        ];
        
        if( isset( $post_meta['_elementor_edit_mode'][0] ) ) {
            
            $data = [
                'meta_input'  => array(
                    '_elementor_edit_mode'     => $post_meta['_elementor_edit_mode'][0],
                    '_elementor_template_type' => $post_meta['_elementor_template_type'][0],
                )
            ];
            
            $duplicated_post_args = array_merge( $duplicated_post_args, $data );
            
        }

        return wp_insert_post( $duplicated_post_args );
    }
    
    /**
     * Add post taxonomies to the cloned version
     *
     * @access public
     * @since 3.9.7
     * 
     * @param $post
     * @param $id
     */
    public static function duplicate_post_taxonomies( $post, $id ) {
        
        $taxonomies = get_object_taxonomies( $post->post_type );
        
        if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $terms = wp_get_object_terms( $post->ID, $taxonomy, [ 'fields' => 'slugs' ] );
                wp_set_object_terms( $id, $terms, $taxonomy, false );
            }
        }
    }
    
    /**
     * Add post meta data to the cloned version
     * 
     * @access public
     * @since 3.9.7
     *
     * @param $post
     * @param $id
     */
    public static function duplicate_post_meta_data( $post, $id ) {
        
        global $wpdb;

        $meta = $wpdb->get_results(
            $wpdb->prepare( "SELECT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id = %d", $post->ID )
        );

        if ( ! empty( $meta ) && is_array( $meta ) ) {
            
            $query = "INSERT INTO {$wpdb->postmeta} ( post_id, meta_key, meta_value ) VALUES ";
            
            $_records = [];
            
            foreach ( $meta as $meta_info ) {
                $_value = wp_slash( $meta_info->meta_value );
                $_records[] = "( $id, '{$meta_info->meta_key}', '{$_value}' )";
            }
            
            $query .= implode( ', ', $_records ) . ';';
            $wpdb->query( $query  );
        }
        
    }

    /**
     * Gets current screen slug
     * 
     * @since 3.3.8
     * @access public
     * 
     * @return string current screen slug
     */
    public static function get_current_screen() {
        
        self::$current_screen = get_current_screen()->id;
        
        return isset( self::$current_screen ) ? self::$current_screen : false;
        
    }
    
    public static function get_instance() {
        if( self::$instance == null ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
       
}

if( ! function_exists('get_admin_helper_instance') ) {
    /**
	 * Returns an instance of the plugin class.
     * 
	 * @since  3.3.8
     * 
	 * @return object
	 */
    function get_admin_helper_instance() {
        return Admin_Helper::get_instance();
    }
}

get_admin_helper_instance();