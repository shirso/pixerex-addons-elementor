<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Blog extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-addon-blog';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Blog', 'pixerex-elements') );
	}

    public function is_reload_preview_required() {
        return true;
    }
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }
    
    public function get_script_depends() {
        return [
            'isotope-js',
            'jquery-slick',
            'pixerex-elements-js'
        ];
    }

    public function get_icon() {
        return 'pa-blog';
    }
    
    public function get_keywords() {
		return [ 'posts', 'grid', 'item', 'loop', 'query', 'portfolio' ];
	}

    public function get_categories() {
        return [ 'pixerex-elements'];
    }

    // Adding the controls fields for the Blog widget
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        
        $this->start_controls_section('general_settings_section',
            [
                'label'         => __('General', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_blog_skin',
            [
                'label'         => __('Skin', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'classic'       => __('Classic', 'pixerex-elements'),
                    'cards'         => __('Cards', 'pixerex-elements'),
                ],
                'default'       => 'classic',
                'label_block'   => true
            ]
        );
        
        $this->add_control('pixerex_blog_grid',
            [
                'label'         => __('Grid', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes'
            ]
        );
        
        $this->add_control('pixerex_blog_layout',
            [
                'label'             => __('Layout', 'pixerex-elements'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'even'      => __('Even', 'pixerex-elements'),
                    'masonry'   => __('Masonry', 'pixerex-elements'),
                ],
                'default'           => 'masonry',
                'condition'         => [
                    'pixerex_blog_grid' => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_columns_number',
            [
                'label'         => __('Number of Columns', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    '100%'  => __('1 Column', 'pixerex-elements'),
                    '50%'   => __('2 Columns', 'pixerex-elements'),
                    '33.33%'=> __('3 Columns', 'pixerex-elements'),
                    '25%'   => __('4 Columns', 'pixerex-elements'),
                ],
                'default'       => '33.33%',
                'render_type'   => 'template',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container'  => 'width: {{VALUE}};'
                ],
            ]
        );
        
        $this->add_control('pixerex_blog_number_of_posts',
            [
                'label'         => __('Posts Per Page', 'pixerex-elements'),
                'description'   => __('Set the number of per page','pixerex-elements'),
                'type'          => Controls_Manager::NUMBER,
                'min'			=> 1,
                'default'		=> 3,
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('section_query_options',
            [
                'label'         => __('Query', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('category_filter_rule',
            [
                'label'       => __( 'Filter By Category Rule', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'category__in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'category__in'     => __( 'Match Categories', 'pixerex-elements' ),
                    'category__not_in' => __( 'Exclude Categories', 'pixerex-elements' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_categories',
            [
                'label'         => __( 'Categories', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT2,
                'description'   => __('Get posts for specific category(s)','pixerex-elements'),
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_post_type_categories(),
            ]
        );
        
        $this->add_control('tags_filter_rule',
            [
                'label'       => __( 'Filter By Tag Rule', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'tag__in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'tag__in'     => __( 'Match Tags', 'pixerex-elements' ),
                    'tag__not_in' => __( 'Exclude Tags', 'pixerex-elements' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_tags',
            [
                'label'         => __( 'Tags', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT2,
                'description'   => __('Get posts for specific tag(s)','pixerex-elements'),
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_post_type_tags(),        
            ]
        );
        
        $this->add_control('author_filter_rule',
            [
                'label'       => __( 'Filter By Author Rule', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'author__in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'author__in'     => __( 'Match Authors', 'pixerex-elements' ),
                    'author__not_in' => __( 'Exclude Authors', 'pixerex-elements' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_users',
            [
                'label'         => __( 'Authors', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT2,
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_post_type_users(),        
            ]
        );
        
        $this->add_control('posts_filter_rule',
            [
                'label'       => __( 'Filter By Post Rule', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'post__not_in',
                'separator'     => 'before',
                'label_block' => true,
                'options'     => [
                    'post__in'     => __( 'Match Post', 'pixerex-elements' ),
                    'post__not_in' => __( 'Exclude Post', 'pixerex-elements' ),
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_posts_exclude',
            [
                'label'         => __( 'Posts', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT2,
                'label_block'   => true,
                'multiple'      => true,
                'options'       => pixerex_blog_posts_list(),        
            ]
        );
        
        $this->add_control('pixerex_blog_offset',
			[
				'label'         => __( 'Offset Count', 'pixerex-elements' ),
                'description'   => __('This option is used to exclude number of initial posts from being display.','pixerex-elements'),
				'type' 			=> Controls_Manager::NUMBER,
                'default' 		=> '0',
				'min' 			=> '0',
			]
		);
        
        $this->add_control('pixerex_blog_order_by',
            [
                'label'         => __( 'Order By', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT,
                'separator'     => 'before',
                'label_block'   => true,
                'options'       => [
                    'none'  => __('None', 'pixerex-elements'),
                    'ID'    => __('ID', 'pixerex-elements'),
                    'author'=> __('Author', 'pixerex-elements'),
                    'title' => __('Title', 'pixerex-elements'),
                    'name'  => __('Name', 'pixerex-elements'),
                    'date'  => __('Date', 'pixerex-elements'),
                    'modified'=> __('Last Modified', 'pixerex-elements'),
                    'rand'  => __('Random', 'pixerex-elements'),
                    'comment_count'=> __('Number of Comments', 'pixerex-elements'),
                ],
                'default'       => 'date'
            ]
        );
        
        $this->add_control('pixerex_blog_order',
            [
                'label'         => __( 'Order', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT,
                'label_block'   => true,
                'options'       => [
                    'DESC'  => __('Descending', 'pixerex-elements'),
                    'ASC'   => __('Ascending', 'pixerex-elements'),
                ],
                'default'       => 'DESC'
            ]
        );
            
        $this->end_controls_section();

        $this->start_controls_section('pixerex_blog_general_settings',
            [
                'label'         => __('Featured Image', 'pixerex-elements'),
            ]
        );
        
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'featured_image',
				'default' => 'full'
			]
		);
        
        // $this->add_control('pixerex_blog_hover_color_effect',
        //     [
        //         'label'         => __('Overlay Effect', 'pixerex-elements'),
        //         'type'          => Controls_Manager::SELECT,
        //         'description'   => __('Choose an overlay color effect','pixerex-elements'),
        //         'options'       => [
        //             'none'     => __('None', 'pixerex-elements'),
        //             'framed'   => __('Framed', 'pixerex-elements'),
        //             'diagonal' => __('Diagonal', 'pixerex-elements'),
        //             'bordered' => __('Bordered', 'pixerex-elements'),
        //             'squares'  => __('Squares', 'pixerex-elements'),
        //         ],
        //         'default'       => 'framed',
        //         'label_block'   => true,
        //         'condition'     => [
        //             'pixerex_blog_skin!' => 'classic'
        //         ]
        //     ]
        // );
        
        $this->add_control('pixerex_blog_hover_image_effect',
            [
                'label'         => __('Hover Effect', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'description'   => __('Choose a hover effect for the image','pixerex-elements'),
                'options'       => [
                    'none'   => __('None', 'pixerex-elements'),
                    'zoomin' => __('Zoom In', 'pixerex-elements'),
                    'zoomout'=> __('Zoom Out', 'pixerex-elements'),
                    'scale'  => __('Scale', 'pixerex-elements'),
                    'gray'   => __('Grayscale', 'pixerex-elements'),
                    'blur'   => __('Blur', 'pixerex-elements'),
                    'bright' => __('Bright', 'pixerex-elements'),
                    'sepia'  => __('Sepia', 'pixerex-elements'),
                    'trans'  => __('Translate', 'pixerex-elements'),
                ],
                'default'       => 'zoomin',
                'label_block'   => true
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_thumb_min_height',
            [
                'label'         => __('Thumbnail Min Height', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 300,
                    ],
                ],
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container img' => 'min-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_thumb_max_height',
            [
                'label'         => __('Thumbnail Max Height', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 300,
                    ],
                ],
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container img' => 'max-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_thumbnail_fit',
            [
                'label'         => __('Thumbnail Fit', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'cover'  => __('Cover', 'pixerex-elements'),
                    'fill'   => __('Fill', 'pixerex-elements'),
                    'contain'=> __('Contain', 'pixerex-elements'),
                ],
                'default'       => 'cover',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-thumbnail-container img' => 'object-fit: {{VALUE}}'
                ],
                'condition'     => [
                    'pixerex_blog_grid' =>  'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_content_settings',
            [
                'label'         => __('Display Options', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_blog_title_tag',
			[
				'label'			=> __( 'Title HTML Tag', 'pixerex-elements' ),
				'description'	=> __( 'Select a heading tag for the post title.', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'h2',
				'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
				'label_block'	=> true,
			]
        );
        
        $this->add_control('pixerex_blog_meta_position',
            [
                'label'         => __('Meta Position', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'above'        => __('Above Title', 'pixerex-elements'),
                    'below'        => __('Below Title', 'pixerex-elements'),
                    'after_cnt'    => __('After Content', 'pixerex-elements'),
                ],
                'default'       => 'below',
                'label_block'   => true
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_posts_columns_spacing',
            [
                'label'         => __('Rows Spacing', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 200,
                    ],
                ],
                'render_type'   => 'template',
                'condition'     => [
                    'pixerex_blog_grid'   => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container' => 'margin-bottom: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_posts_spacing',
            [
                'label'         => __('Columns Spacing', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 200,
                    ],
                ],
                'render_type'   => 'template',
                'condition'     => [
                    'pixerex_blog_grid'   => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_flip_text_align',
            [
                'label'         => __( 'Alignment', 'pixerex-elements' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'left',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_posts_options',
            [
                'label'         => __('Post Options', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_blog_excerpt',
            [
                'label'         => __('Excerpt', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Excerpt is used for article summary with a link to the whole entry. The default except length is 55','pixerex-elements'),
                'default'       => 'yes',
            ]
        );

        $this->add_control('pixerex_blog_excerpt_length',
            [
                'label'         => __('Excerpt Length', 'pixerex-elements'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 55,
                'condition'     => [
                    'pixerex_blog_excerpt'  => 'yes',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_author_meta',
            [
                'label'         => __('Author Meta', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_blog_date_meta',
            [
                'label'         => __('Date Meta', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_blog_categories_meta',
            [
                'label'         => __('Categories Meta', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('pixerex_show_read_more',
            [
                'label'         => __('Read More Button', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Display or hide read more button','pixerex-elements'),
                'default'       => 'yes',
            ]
        );

        $this->add_control('pixerex_posts_read_more_text',
            [
                'label'         => esc_html__('Read More Text', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Read More','pixerex-elements'),
                'condition'     => [
                    'pixerex_show_read_more'  => 'yes',
                ]
            ]
		);
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_advanced_settings',
            [
                'label'         => __('Advanced Settings', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_blog_cat_tabs',
            [
                'label'         => __('Filter Tabs', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel!'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('filter_tabs_type',
            [
                'label'       => __( 'Get Tabs From', 'pixerex-elements' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'categories',
                'label_block' => true,
                'options'     => [
                    'categories'    => __( 'Categories', 'pixerex-elements' ),
                    'tags'          => __( 'Tags', 'pixerex-elements' ),
                ],
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ]
            ]
        );
        
        $this->add_control('filter_tabs_notice', 
            [
                'raw'               => __('Please make sure to select the categories/tags you need to show from Query tab.', 'pixerex-elements'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ]
            ] 
        );
        
        $this->add_control('pixerex_blog_tab_label',
			[
				'label'			=> __( 'First Tab Label', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'default'       => __('All', 'pixerex-elements'),
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_blog_filter_align',
            [
                'label'         => __( 'Alignment', 'pixerex-elements' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'    => [
                        'title' => __( 'Left', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'        => [
                        'title' => __( 'Center', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'      => [
                        'title' => __( 'Right', 'pixerex-elements' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'toggle'        => false,
                'condition'     => [
                    'pixerex_blog_cat_tabs'     => 'yes',
                    'pixerex_blog_carousel!'    => 'yes'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-filter' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('pixerex_blog_new_tab',
            [
                'label'         => __('Links in New Tab', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Enable links to be opened in a new tab','pixerex-elements'),
                'default'       => 'yes',
            ]
        );
 
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_carousel_settings',
            [
                'label'         => __('Carousel', 'pixerex-elements'),
                'condition'     => [
                    'pixerex_blog_grid' => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel',
            [
                'label'         => __('Enable Carousel', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_fade',
            [
                'label'         => __('Fade', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_columns_number' => '100%'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_play',
            [
                'label'         => __('Auto Play', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_autoplay_speed',
			[
				'label'			=> __( 'Autoplay Speed', 'pixerex-elements' ),
				'description'	=> __( 'Autoplay Speed means at which time the next slide should come. Set a value in milliseconds (ms)', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 5000,
				'condition'		=> [
					'pixerex_blog_carousel' => 'yes',
                    'pixerex_blog_carousel_play' => 'yes',
				],
			]
		);
        
        $this->add_control('pixerex_blog_carousel_dots',
            [
                'label'         => __('Navigation Dots', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_blog_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_arrows',
            [
                'label'         => __('Navigation Arrows', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'pixerex_blog_carousel'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_carousel_arrows_pos',
            [
                'label'         => __('Arrows Position', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', "em"],
                'range'         => [
                    'px'    => [
                        'min'       => -100, 
                        'max'       => 100,
                    ],
                    'em'    => [
                        'min'       => -10, 
                        'max'       => 10,
                    ],
                ],
                'condition'		=> [
					'pixerex_blog_carousel'         => 'yes',
                    'pixerex_blog_carousel_arrows'  => 'yes'
				],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap a.carousel-arrow.carousel-next' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pixerex-blog-wrap a.carousel-arrow.carousel-prev' => 'left: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_pagination_section',
            [
                'label'         => __('Pagination', 'pixerex-elements')
            ]
        );
        
        $this->add_control('pixerex_blog_paging',
            [
                'label'         => __('Enable Pagination', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Pagination is the process of dividing the posts into discrete pages','pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_blog_total_posts_number',
            [
                'label'         => __('Total Number of Posts', 'pixerex-elements'),
                'description'   => __('Set the number of posts in all pages','pixerex-elements'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => wp_count_posts()->publish,
                'min'			=> 1,
                'condition'     => [
                    'pixerex_blog_paging'      => 'yes',
                ]
            ]
        );
        
        $this->add_control('pagination_strings',
            [
                'label'         => __('Enable Pagination Next/Prev Strings', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_prev_text',
			[
				'label'			=> __( 'Previous Page String', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'default'       => __('Previous','pixerex-elements'),
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes',
                    'pagination_strings'    => 'yes'
                ]
			]
		);

        $this->add_control('pixerex_blog_next_text',
			[
				'label'			=> __( 'Next Page String', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'default'       => __('Next','pixerex-elements'),
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes',
                    'pagination_strings'    => 'yes'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_blog_pagination_align',
            [
                'label'         => __( 'Alignment', 'pixerex-elements' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors_dictionary'  => [
                    'left'      => 'flex-start',
                    'center'    => 'center',
                    'right'     => 'flex-end',
                ],
                'default'       => 'right',
                'condition'     => [
                    'pixerex_blog_paging'      => 'yes',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container .page-numbers' => 'justify-content: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();

        //STYLE

        $this->start_controls_section('pixerex_blog_box_style_section',
        [
            'label'         => __('Item Box', 'pixerex-elements'),
            'tab'           => Controls_Manager::TAB_STYLE,
        ]
        );
        
        $this->add_control('pixerex_blog_box_background_color',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-container'  => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('prmeium_blog_box_padding',
            [
                'label'         => __('Spacing', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-outer-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('prmeium_blog_inner_box_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pr_post_grid_border',
                'label' => esc_html__( 'Border for post', 'pixerex' ),
                'selector' => '{{WRAPPER}} .pixerex-blog-post-container',
            ]
        );

        $this->add_control('pr_post_grid_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'pixerex' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .pixerex-blog-post-container' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_blog_box_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-blog-post-container',
            ]
        );

        $this->add_control('pr_post_grid_box_shadow_hover_title',
            [
                'label' => __( 'Hover Box Shadow', 'pixerex-elements'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pr_post_grid_box_shadow_hover',
                'label' => esc_html__( 'Hover Box Shadow', 'pixerex-elements'),
                'selector' => '{{WRAPPER}} .pixerex-blog-post-container:hover',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_image_style_section',
            [
                'label'         => __('Image', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('pixerex_blog_overlay_color',
            [
                'label'         => __('Overlay Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-framed-effect, {{WRAPPER}} .pixerex-blog-bordered-effect,{{WRAPPER}} .pixerex-blog-squares-effect:before,{{WRAPPER}} .pixerex-blog-squares-effect:after,{{WRAPPER}} .pixerex-blog-squares-square-container:before,{{WRAPPER}} .pixerex-blog-squares-square-container:after, {{WRAPPER}} .pixerex-blog-format-container:hover, {{WRAPPER}} .pixerex-blog-thumbnail-overlay' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .pixerex-blog-thumbnail-container img',
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_content_style_section',
        [
            'label'         => __('Content Box', 'pixerex-elements'),
            'tab'           => Controls_Manager::TAB_STYLE,
        ]
        
        );
    
    
        $this->add_control('pixerex_blog_content_background_color',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#f5f5f5',
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper'  => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('prmeium_blog_content_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_title_style_section',
            [
                'label'         => __('Title', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_title_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-entry-title a',
            ]
        );
        
        $this->add_control('pixerex_blog_title_color',
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-title a'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_title_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-title:hover a'  => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('pixerex_blog_title_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_meta_style_section',
            [
                'label'         => __('Meta', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_meta_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-entry-meta a',
            ]
        );
        
        $this->add_control('pixerex_blog_meta_color',
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-meta, {{WRAPPER}} .pixerex-blog-entry-meta a'  => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_meta_hover_color',
            [
                'label'         => __('Hover Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-meta a:hover'  => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('pixerex_blog_meta_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-entry-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('pixerex_blog_excerpt_style_section',
        [
            'label'         => __('Excerpt', 'pixerex-elements'),
            'tab'           => Controls_Manager::TAB_STYLE,
        ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'pixerex_blog_excerpt_typo',
                'selector'      => '{{WRAPPER}} .pixerex-blog-post-content',
            ]
        );
        
        $this->add_control('pixerex_blog_excerpt_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content'  => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('pixerex_blog_excerpt_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'pixerex-elements'),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'     => [
					'pixerex_show_read_more'  => 'yes',
					]
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex-elements'),
			)
		);

		$this->add_control(
			'button_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'pixerex-elements'),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => _x( 'Classic', 'Background Control', 'pixerex-elements'),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'pixerex-elements'),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'pixerex-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'pixerex-elements'),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition' => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'pixerex-elements'),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_type',
			array(
				'label'   => _x( 'Type', 'Background Control', 'pixerex-elements'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'linear' => _x( 'Linear', 'Background Control', 'pixerex-elements'),
					'radial' => _x( 'Radial', 'Background Control', 'pixerex-elements'),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'pixerex-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range' => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'linear',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_position',
			array(
				'label'   => _x( 'Position', 'Background Control', 'pixerex-elements'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'center center' => _x( 'Center Center', 'Background Control', 'pixerex-elements'),
					'center left'   => _x( 'Center Left', 'Background Control', 'pixerex-elements'),
					'center right'  => _x( 'Center Right', 'Background Control', 'pixerex-elements'),
					'top center'    => _x( 'Top Center', 'Background Control', 'pixerex-elements'),
					'top left'      => _x( 'Top Left', 'Background Control', 'pixerex-elements'),
					'top right'     => _x( 'Top Right', 'Background Control', 'pixerex-elements'),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'pixerex-elements'),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'pixerex-elements'),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'pixerex-elements'),
				),
				'default' => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'radial',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label' => esc_html__( 'Text Color', 'pixerex-elements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-readmore-btn',
			)
		);

		$this->add_control(
			'button_text_decor',
			array(
				'label'   => esc_html__( 'Text Decoration', 'pixerex-elements'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'pixerex-elements'),
					'underline' => esc_html__( 'Underline', 'pixerex-elements'),
				),
				'default' => 'none',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pixerex-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pixerex-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'pixerex-elements'),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pr-readmore-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pr-readmore-btn',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex-elements'),
			)
		);

		$this->add_control(
			'button_hover_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'pixerex-elements'),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => _x( 'Classic', 'Background Control', 'pixerex-elements'),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'pixerex-elements'),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'pixerex-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'pixerex-elements'),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition' => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'pixerex-elements'),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_type',
			array(
				'label'   => _x( 'Type', 'Background Control', 'pixerex-elements'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'linear' => _x( 'Linear', 'Background Control', 'pixerex-elements'),
					'radial' => _x( 'Radial', 'Background Control', 'pixerex-elements'),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'pixerex-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range' => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'linear',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_position',
			array(
				'label'   => _x( 'Position', 'Background Control', 'pixerex-elements'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'center center' => _x( 'Center Center', 'Background Control', 'pixerex-elements'),
					'center left'   => _x( 'Center Left', 'Background Control', 'pixerex-elements'),
					'center right'  => _x( 'Center Right', 'Background Control', 'pixerex-elements'),
					'top center'    => _x( 'Top Center', 'Background Control', 'pixerex-elements'),
					'top left'      => _x( 'Top Left', 'Background Control', 'pixerex-elements'),
					'top right'     => _x( 'Top Right', 'Background Control', 'pixerex-elements'),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'pixerex-elements'),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'pixerex-elements'),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'pixerex-elements'),
				),
				'default' => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'radial',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label' => esc_html__( 'Text Color', 'pixerex-elements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'button_hover_typography',
				'label' => esc_html__( 'Typography', 'pixerex-elements'),
				'selector' => '{{WRAPPER}} .pr-readmore-btn:hover',
			)
		);

		$this->add_control(
			'button_hover_text_decor',
			array(
				'label'   => esc_html__( 'Text Decoration', 'pixerex-elements'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'pixerex-elements'),
					'underline' => esc_html__( 'Underline', 'pixerex-elements'),
				),
				'default' => 'none',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pixerex-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pixerex-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'pixerex-elements'),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pr-readmore-btn:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .pr-readmore-btn:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_pagination_Style',
            [
                'label'         => __('Pagination', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_paging'   => 'yes',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'pixerex_blog_pagination_typo',
                'selector'          => '{{WRAPPER}} .pixerex-blog-pagination-container li > .page-numbers',
            ]
        );
        
        $this->start_controls_tabs('pixerex_blog_pagination_colors');
        
        $this->start_controls_tab('pixerex_blog_pagination_nomral',
            [
                'label'         => __('Normal', 'pixerex-elements'),
                
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_color', 
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_back_color', 
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_blog_pagination_hover',
            [
                'label'         => __('Hover', 'pixerex-elements'),
                
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_hover_color', 
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers:hover' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_back_hover_color', 
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_blog_pagination_active',
            [
                'label'         => __('Active', 'pixerex-elements'),
                
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_active_color', 
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li span.current' => 'color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_control('prmeium_blog_pagination_back_active_color', 
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li span.current' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_blog_border',
                'separator'     => 'before',
                'selector'      => '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers',
            ]
        );
        
        $this->add_control('pixerex_blog_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_responsive_control('prmeium_blog_pagination_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('prmeium_blog_pagination_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-pagination-container li .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('carousel_dots_style',
            [
                'label'         => __('Carousel Dots', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_carousel'         => 'yes',
                    'pixerex_blog_carousel_dots'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('carousel_dot_navigation_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} ul.slick-dots li' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control('carousel_dot_navigation_active_color',
			[
				'label' 		=> __( 'Active Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} ul.slick-dots li.slick-active' => 'color: {{VALUE}}'
				]
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('carousel_arrows_style',
            [
                'label'         => __('Carousel Arrows', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_blog_carousel'         => 'yes',
                    'pixerex_blog_carousel_arrows'  => 'yes'
                ]
            ]
        );
        
        $this->add_control('arrow_color',
            [
                'label'         => __('Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control('pixerex_blog_carousel_arrow_size',
            [
                'label'         => __('Size', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_arrow_background',
            [
                'label'         => __('Background Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_blog_carousel_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control('pixerex_blog_carousel_arrow_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-blog-wrap .slick-arrow' => 'padding: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_blog_filter_style',
            [
                'label'     => __('Filter','pixerex-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pixerex_blog_cat_tabs'    => 'yes'
                ]
            ]);
        
        $this->add_control('pixerex_blog_filter_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-blog-cats-container li a.category span' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_control('pixerex_blog_filter_active_color',
                [
                    'label'         => __('Active Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-blog-cats-container li a.active span' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pixerex_blog_filter_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-blog-cats-container li a.category',
                    ]
                );
        
        $this->add_control('pixerex_blog_background_color',
           [
               'label'         => __('Background Color', 'pixerex-elements'),
               'type'          => Controls_Manager::COLOR,
               'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
               'selectors'     => [
                   '{{WRAPPER}} .pixerex-blog-cats-container li a.category' => 'background-color: {{VALUE}};',
               ],
           ]
       );
        
        $this->add_control('pixerex_blog_background_active_color',
           [
               'label'         => __('Active Background Color', 'pixerex-elements'),
               'type'          => Controls_Manager::COLOR,
               'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
               'selectors'     => [
                   '{{WRAPPER}} .pixerex-blog-cats-container li a.active' => 'background-color: {{VALUE}};',
               ],
           ]
       );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'              => 'pixerex_blog_filter_border',
                    'selector'          => '{{WRAPPER}} .pixerex-blog-cats-container li a.category',
                ]
                );

        $this->add_control('pixerex_blog_filter_border_radius',
                [
                    'label'             => __('Border Radius', 'pixerex-elements'),
                    'type'              => Controls_Manager::SLIDER,
                    'size_units'        => ['px','em','%'],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-blog-cats-container li a.category'  => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'name'          => 'pixerex_blog_filter_shadow',
                    'selector'      => '{{WRAPPER}} .pixerex-blog-cats-container li a.category',
                ]
                );
        
        $this->add_responsive_control('pixerex_blog_filter_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'             => [
                        '{{WRAPPER}} .pixerex-blog-cats-container li a.category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control('pixerex_blog_filter_padding',
                [
                    'label'             => __('Padding', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                'selectors'             => [
                    '{{WRAPPER}} .pixerex-blog-cats-container li a.category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
       
    }
    
    /*
     * Renders post content
     * 
     * @since 3.0.5
     * @access protected
     */
    protected function get_post_content() {
        
        $settings = $this->get_settings();
        
        if ( 'yes' !== $settings['pixerex_blog_excerpt'] ) {
            return;
        }
        
    ?>
        <div class="pixerex-blog-post-content">
            <?php
                echo pixerex_blog_get_excerpt_by_id( $settings['pixerex_blog_excerpt_length'] );
            ?>
        </div>
    <?php
    }
    
    /*
     * Get Post Thumbnail
     * 
     * 
     * Renders HTML markup for post thumbnail
     * 
     * @since 3.0.5
     * @access protected
     * 
     * @param $target string link target
     */
    protected function get_post_thumbnail( $target ) {
        
        $settings = $this->get_settings_for_display();
        
        $skin = $settings['pixerex_blog_skin'];
        
        $settings['featured_image']      = [
			'id' => get_post_thumbnail_id(),
		];
        
        $thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'featured_image' );
        
        if( empty( $thumbnail_html ) )
            return; ?>

        <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>">
            <?php echo $thumbnail_html;?>
        </a>
        
        <?php
    }
    /*
     * Renders post skin
     * 
     * @since 3.0.5
     * @access protected
     */
    protected function get_post_layout() {
        
        $settings = $this->get_settings();
        
        $image_effect = $settings['pixerex_blog_hover_image_effect'];
        
        $post_effect = $settings['pixerex_blog_hover_color_effect'];
        
        if( $settings['pixerex_blog_new_tab'] == 'yes' ) {
            $target = '_blank';
        } else {
            $target = '_self';
        }

        $meta_position = $settings['pixerex_blog_meta_position'];
        
        $skin = $settings['pixerex_blog_skin'];
        
        $post_id = get_the_ID();
        
        $key = 'post_' . $post_id;
        
        $tax_key = sprintf( '%s_tax', $key );
        
        $wrap_key = sprintf( '%s_wrap', $key );
        
        $content_key = sprintf( '%s_content', $key );
        
        $this->add_render_attribute( $tax_key, 'class', 'pixerex-blog-post-outer-container' );
        
        $this->add_render_attribute( $wrap_key, 'class', [ 
            'pixerex-blog-post-container',
            'pixerex-blog-skin-' . $skin,
        ] );
        
        $thumb = ( ! has_post_thumbnail() ) ? 'empty-thumb' : '';
        
        if ( 'yes' === $settings['pixerex_blog_cat_tabs'] && 'yes' !== $settings['pixerex_blog_carousel'] ) {
            
            $filter_rule = $settings['filter_tabs_type'];
            
            $taxonomies = 'categories' === $filter_rule ? get_the_category( $post_id ) : get_the_tags( $post_id );
            
            if( ! empty( $taxonomies ) ) {
                foreach( $taxonomies as $index => $taxonomy ) {
                
                    $taxonomy_key = 'categories' === $filter_rule ? $taxonomy->cat_name : $taxonomy->name;

                    $attr_key = str_replace( ' ', '-', $taxonomy_key );

                    $this->add_render_attribute( $tax_key, 'class', strtolower( $attr_key ) );
                }
            }
            
            
        }
        
        $this->add_render_attribute( $content_key, 'class', [ 
            'pixerex-blog-content-wrapper',
            $thumb,
        ] );
        
    ?>
        <div <?php echo $this->get_render_attribute_string( $tax_key ); ?>>
            <div <?php echo $this->get_render_attribute_string( $wrap_key ); ?>>
                <div class="pixerex-blog-thumb-effect-wrapper">
                    <div class="pixerex-blog-thumbnail-container <?php echo 'pixerex-blog-' . $image_effect . '-effect';?>">
                        <?php $this->get_post_thumbnail( $target ); ?>
                    </div>
                    <div class="pixerex-blog-thumbnail-overlay">
                        <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>">
                        </a>
                    </div>
                </div>
                <?php if( 'cards' === $skin ) : ?>
                    <div class="pixerex-blog-author-thumbnail">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 128, '', get_the_author_meta( 'display_name' ) ); ?>
                    </div>
                <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
                    <div class="pixerex-blog-inner-container">
                        <div class="pixerex-blog-format-container">
                            <a class="pixerex-blog-format-link" href="<?php the_permalink(); ?>" title="<?php if( get_post_format() === ' ') : echo 'standard' ; else : echo get_post_format();  endif; ?>" target="<?php echo esc_attr( $target ); ?>"></a>
                        </div>
                        <div class="pixerex-blog-entry-container">
                            <?php
                                if ( 'above' == $meta_position ) {
                                    $this->get_post_meta( $target );
                                }

                                $this->get_post_title( $target );

                                if ( 'below' == $meta_position ) {
                                    $this->get_post_meta( $target );
                                }
                            ?>

                        </div>
                    </div>

                    <?php
                        $this->get_post_content();

                        if ( 'after_cnt' == $meta_position ) {
                            $this->get_post_meta( $target );
                        }
                    ?>

                    <?php if( $settings['pixerex_show_read_more'] === 'yes' ) : ?>
                        <div class="pr-readmore-warp">
                            <a href="<?php echo get_permalink(); ?>" class="btn btn-primary elementor-button elementor-size-md pr-readmore-btn" title="<?php the_title(); ?>"><?php echo $settings['pixerex_posts_read_more_text']; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php }
    
    /*
     * Render post title
     * 
     * @since 3.4.4
     * @access protected
     */
    protected function get_post_title( $link_target ) {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute( 'title', 'class', 'pixerex-blog-entry-title' );
        
    ?>
        
        <<?php echo $settings['pixerex_blog_title_tag'] . ' ' . $this->get_render_attribute_string('title'); ?>>
            <a href="<?php the_permalink(); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                <?php the_title(); ?>
            </a>
        </<?php echo $settings['pixerex_blog_title_tag']; ?>>
        
    <?php   
    }
    
    /*
     * Get Post Meta
     * 
     * @since 3.4.4
     * @access protected
     */
    protected function get_post_meta( $link_target ) {
        
        $settings = $this->get_settings();
        
        $date_format = get_option('date_format');
        
    ?>
        <div class="pixerex-blog-entry-meta">
            <?php if( $settings['pixerex_blog_author_meta'] === 'yes' ) : ?>
                <span class="pixerex-blog-post-author pixerex-blog-meta-data"><?php the_author_posts_link();?></span>
            <?php endif; ?>
            <?php if( $settings['pixerex_blog_date_meta'] === 'yes' ) : ?>
                <span class="pixerex-blog-post-time pixerex-blog-meta-data"><a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($link_target); ?>"><?php the_time($date_format); ?></a></span>
            <?php endif; ?>
            <?php if( $settings['pixerex_blog_categories_meta'] === 'yes' ) : ?>
                <span class="pixerex-blog-post-categories pixerex-blog-meta-data"><?php the_category(', '); ?></span>
            <?php endif; ?>
        </div>
        
        
    <?php
    }
    
    /*
     * Get Filter Tabs Markup
     * 
     * @since 3.11.2
     * @access protected
     */
    protected function get_filter_tabs_markup() {
        
        $settings = $this->get_settings();
        
        $filter_rule = $settings['filter_tabs_type'];
        
        $filters = 'categories' === $filter_rule ? $settings['pixerex_blog_categories'] : $settings['pixerex_blog_tags'];
        
        if( empty( $filters ) )
            return;
        
        ?>
        <div class="pixerex-blog-filter">
            <ul class="pixerex-blog-cats-container">
                <?php if( ! empty( $settings['pixerex_blog_tab_label'] ) ) : ?>
                    <li>
                        <a href="javascript:;" class="category active" data-filter="*">
                            <span><?php echo esc_html( $settings['pixerex_blog_tab_label'] ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php foreach( $filters as $index => $filter ) {
                        $key = 'blog_category_' . $index;

                        if( 'categories' === $filter_rule ) {
                            $name = get_cat_name( $filter );
                        } else {
                            $tag = get_tag( $filter );
                            
                            $name = ucfirst( $tag->name );
                        }
                        
                        $name_filter = str_replace(' ', '-', $name );
                        $name_lower = strtolower( $name_filter );

                        $this->add_render_attribute( $key,
                            'class', [
                                'category'
                            ]
                        );

                        if( empty( $settings['pixerex_blog_tab_label'] ) && 0 === $index ) {
                            $this->add_render_attribute( $key,
                                'class', [
                                    'active'
                                ]
                            );
                        }
                    ?>
                        <li>
                            <a href="javascript:;" <?php echo $this->get_render_attribute_string( $key ); ?> data-filter=".<?php echo esc_attr( $name_lower ); ?>">
                                <span><?php echo $name; ?></span>
                            </a>
                        </li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }

    protected function render() {
        
        if ( get_query_var('paged') ) { 
            $paged = get_query_var('paged');
        } elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');             
        } else {
            $paged = 1;
        }
        
        $settings = $this->get_settings();

        $offset = ! empty( $settings['pixerex_blog_offset'] ) ? $settings['pixerex_blog_offset'] : 0;
        
        $post_per_page = ! empty( $settings['pixerex_blog_number_of_posts'] ) ? $settings['pixerex_blog_number_of_posts'] : 3;
        
        $new_offset = $offset + ( ( $paged - 1 ) * $post_per_page );
        
        $post_args = pixerex_blog_get_post_settings( $settings );

        $posts = pixerex_blog_get_post_data( $post_args, $paged , $new_offset );
        
        switch( $settings['pixerex_blog_columns_number'] ) {
            case '100%' :
                $col_number = 'col-1';
                break;
            case '50%' :
                $col_number = 'col-2';
                break;
            case '33.33%' :
                $col_number = 'col-3';
                break;
            case '25%' :
                $col_number = 'col-4';
                break;
        }
        
        $posts_number = intval ( 100 / substr( $settings['pixerex_blog_columns_number'], 0, strpos( $settings['pixerex_blog_columns_number'], '%') ) );
        
        $carousel = 'yes' == $settings['pixerex_blog_carousel'] ? true : false; 
        
        $this->add_render_attribute('blog', 'class', [
            'pixerex-blog-wrap',
            'pixerex-blog-' . $settings['pixerex_blog_layout'],
            'pixerex-blog-' . $col_number
            ]
        );

        $this->add_render_attribute('blog', 'data-layout', $settings['pixerex_blog_layout'] );
        
        if ( $carousel ) {
            
            $play   = 'yes' == $settings['pixerex_blog_carousel_play'] ? true : false;
            $fade   = 'yes' == $settings['pixerex_blog_carousel_fade'] ? 'true' : 'false';
            $arrows = 'yes' == $settings['pixerex_blog_carousel_arrows'] ? 'true' : 'false';
            $grid   = 'yes' == $settings['pixerex_blog_grid'] ? 'true' : 'false';
            
            $speed  = ! empty( $settings['pixerex_blog_carousel_autoplay_speed'] ) ? $settings['pixerex_blog_carousel_autoplay_speed'] : 5000;
            $dots   = 'yes' == $settings['pixerex_blog_carousel_dots'] ? 'true' : 'false';
        
            $this->add_render_attribute('blog', 'data-carousel', $carousel );
            
            $this->add_render_attribute('blog', 'data-grid', $grid );
            
            $this->add_render_attribute('blog', 'data-fade', $fade );

            $this->add_render_attribute('blog', 'data-play', $play );

            $this->add_render_attribute('blog', 'data-speed', $speed );

            $this->add_render_attribute('blog', 'data-col', $posts_number );
            
            $this->add_render_attribute('blog', 'data-arrows', $arrows );
            
            $this->add_render_attribute('blog', 'data-dots', $dots );
            
        }
        
    ?>
    <div class="pixerex-blog">
        <?php if ( 'yes' === $settings['pixerex_blog_cat_tabs'] && 'yes' !== $settings['pixerex_blog_carousel'] ) : ?>
            <?php $this->get_filter_tabs_markup(); ?>
        <?php endif; ?>
        <div <?php echo $this->get_render_attribute_string('blog'); ?>>

            <?php

            if( count( $posts ) ) {
                global $post;
                foreach( $posts as $post ) {
                    setup_postdata( $post );
                    $this->get_post_layout();
                }
            ?>
        </div>
    </div>
    <?php if ( $settings['pixerex_blog_paging'] === 'yes' ) : ?>
        <div class="pixerex-blog-pagination-container">
            <?php 
            $count_posts = wp_count_posts();
            $published_posts = $count_posts->publish;
            
            $total_posts = ! empty ( $settings['pixerex_blog_total_posts_number'] ) ? $settings['pixerex_blog_total_posts_number'] : $published_posts;
            
            if( $total_posts > $published_posts )
                $total_posts = $published_posts;
            
            $page_tot = ceil( ( $total_posts - $offset ) / $settings['pixerex_blog_number_of_posts'] );
            
            if ( $page_tot > 1 ) {
                $big        = 999999999;
                echo paginate_links( 
                    array(
                        'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ),
                        'format'    => '?paged=%#%',
                        'current'   => max( 1, $paged ),
                        'total'     => $page_tot,
                        'prev_next' => 'yes' === $settings['pagination_strings'] ? true : false,
                        'prev_text' => sprintf( "&lsaquo; %s", $settings['pixerex_blog_prev_text'] ),
                        'next_text' => sprintf( "%s &rsaquo;", $settings['pixerex_blog_next_text'] ),
                        'end_size'  => 1,
                        'mid_size'  => 2,
                        'type'      => 'list'
                    ));
                }
            ?>
        </div>
    <?php endif;
        wp_reset_postdata();   
        }
    }
}
