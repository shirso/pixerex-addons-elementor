<?php
namespace PixerexElements\Traits;
if ( ! defined('ABSPATH') ) exit; // No access of directly access

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use PixerexElements\Helper_Functions;

trait Helper_Trait {

    /**
     * Query Controls
     *
     */
    protected function pixerex_query_controls(){
        $post_types = Helper_Functions::get_all_post_type_options();
        $post_types['by_id'] = __( 'Manual Selection', 'pixerex-elements' );
        $taxonomies = get_taxonomies( [], 'objects' );
        $this->start_controls_section(
            'pixerex_section_post__filters',
            [
                'label' => __( 'Query', 'pixerex-elements' ),
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label'   => __( 'Source', 'pixerex-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $post_types,
                'default' => key( $post_types ),
            ]
        );
        $this->add_control(
            'posts_ids',
            [
                'label'       => __( 'Search & Select', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => Helper_Functions::get_all_types_post(),
                'label_block' => true,
                'multiple'    => true,
                'condition'   => [
                    'post_type' => 'by_id',
                ],
            ]
        );
        $this->add_control(
            'authors', [
                'label'       => __( 'Author', 'pixerex-elements' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'default'     => [],
                'options'     => Helper_Functions::get_authors(),
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
                'label'       => __( 'Exclude', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => Helper_Functions::get_all_types_post(),
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
                'label'   => __( 'Posts Per Page', 'pixerex-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );
        $this->add_control(
            'offset',
            [
                'label'   => __( 'Offset', 'pixerex-elements' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label'   => __( 'Order By', 'pixerex-elements' ),
                'type'    => Controls_Manager::SELECT,
                'options' => Helper_Functions::get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __( 'Order', 'pixerex-elements' ),
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
    /**
     * Layout Controls For Post Block
     *
     */
    protected function pixerex_layout_controls() {
        $this->start_controls_section(
            'pixerex_section_post_timeline_layout',
            [
                'label' => __( 'Layout Settings', 'pixerex-elements' ),
            ]
        );
        if ( 'pixerex-dynamic-portfolio' === $this->get_name() ) {
            $this->add_responsive_control(
                'pixerex_post_grid_columns',
                [
                    'label'              => esc_html__( 'Column', 'pixerex-elements' ),
                    'type'               => Controls_Manager::SELECT,
                    'default'            => 'eael-col-4',
                    'tablet_default'     => 'eael-col-2',
                    'mobile_default'     => 'eael-col-1',
                    'options'            => [
                        'eael-col-1' => esc_html__( '1', 'pixerex-elements' ),
                        'eael-col-2' => esc_html__( '2', 'pixerex-elements' ),
                        'eael-col-3' => esc_html__( '3', 'pixerex-elements' ),
                        'eael-col-4' => esc_html__( '4', 'pixerex-elements' ),
                        'eael-col-5' => esc_html__( '5', 'pixerex-elements' ),
                        'eael-col-6' => esc_html__( '6', 'pixerex-elements' ),
                    ],
                    'prefix_class'       => 'elementor-grid%s-',
                    'frontend_available' => true,
                ]
            );
            $this->add_control('pixerex_portfolio_filter',
                [
                    'label'             => __( 'Filter Tabs', 'pixerex-elements' ),
                    'type'              => Controls_Manager::SWITCHER,
                    'default'           => 'yes'
                ]
            );
            $condition = array( 'pixerex_portfolio_filter' => 'yes' );
            $this->add_control( 'pixerex_portfolio_first_cat_switcher',
                [
                    'label'             => __( 'First Category', 'pixerex-elements' ),
                    'type'              => Controls_Manager::SWITCHER,
                    'default'           => 'yes',
                    'condition'         => $condition
                ]
            );
            $this->add_control( 'pixerex_portfolio_first_cat_label',
                [
                    'label'             => __( 'First Category Label', 'pixerex-elements' ),
                    'type'              => Controls_Manager::TEXT,
                    'default'           => __('All', 'pixerex-elements'),
                    'dynamic'           => [ 'active' => true ],
                    'condition' => array_merge( [
                        'pixerex_portfolio_first_cat_switcher'    => 'yes'
                    ], $condition )
                ]
            );
            $this->add_control('pixerex_portfolio_active_cat',
                [
                    'label'             => __('Active Category Index', 'pixerex-elements'),
                    'type'              => Controls_Manager::NUMBER,
                    'default'           => 1,
                    'min'               => 0,
                    'condition'         => $condition

                ]
            );
            $this->add_control(
                'layout_mode',
                [
                    'label'   => esc_html__( 'Layout', 'pixerex-elements' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'masonry',
                    'options' => [
                        'grid'    => esc_html__( 'Grid', 'pixerex-elements' ),
                        'masonry' => esc_html__( 'Masonry', 'pixerex-elements' ),
                    ],
                ]
            );

        }




    }
    public function pixerex_get_query_args( $settings = [] ) {
        $settings = wp_parse_args( $settings, [
            'post_type'      => 'post',
            'posts_ids'      => [],
            'orderby'        => 'date',
            'order'          => 'desc',
            'posts_per_page' => 3,
            'offset'         => 0,
            'post__not_in'   => [],
        ] );

        $args = [
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish',
            'posts_per_page'      => $settings['posts_per_page'],
            'offset'              => $settings['offset'],
        ];

        if ( 'by_id' === $settings['post_type'] ) {
            $args['post_type'] = 'any';
            $args['post__in'] = empty( $settings['posts_ids'] ) ? [0] : $settings['posts_ids'];
        } else {
            $args['post_type'] = $settings['post_type'];

            if ( $args['post_type'] !== 'page' ) {
                $args['tax_query'] = [];
                $taxonomies = get_object_taxonomies( $settings['post_type'], 'objects' );

                foreach ( $taxonomies as $object ) {
                    $setting_key = $object->name . '_ids';

                    if ( !empty( $settings[$setting_key] ) ) {
                        $args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field'    => 'term_id',
                            'terms'    => $settings[$setting_key],
                        ];
                    }
                }

                if ( !empty( $args['tax_query'] ) ) {
                    $args['tax_query']['relation'] = 'AND';
                }
            }
        }

        if ( !empty( $settings['authors'] ) ) {
            $args['author__in'] = $settings['authors'];
        }

        if ( !empty( $settings['post__not_in'] ) ) {
            $args['post__not_in'] = $settings['post__not_in'];
        }

        return $args;
    }
    public function pixerex_get_categories($settings){
        $cats=false;
        if ( 'by_id' !== $settings['post_type'] && $settings['post_type'] !== 'page' ) {
            $taxonomies = get_object_taxonomies( $settings['post_type'], 'objects' );
            //print_r($taxonomies);
            foreach ( $taxonomies as $tax=>$object ) {
                $setting_key = $object->name . '_ids';
                $cats=$settings[$setting_key];
                if(empty($cats)){
                    $cats=array_keys(wp_list_pluck( get_terms( $tax ), 'name', 'term_id' ));
                }
            }
        }
        return $cats;
    }
}