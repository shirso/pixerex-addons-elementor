<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Embed;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

if( ! defined( 'ABSPATH' ) ) exit;

class Pixerex_Grid extends Widget_Base {
    
    public function get_name() {
        return 'pixerex-img-gallery';
    }
    
    public function getTemplateInstance() {
		return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
	}
    
    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Media Grid', 'pixerex-elements') );
	}
    
    public function get_icon() {
        return 'pa-grid-icon';
    }
    
    public function get_style_depends() {
        return [
            'pa-prettyphoto',
            'pixerex-elements'
        ];
    }
    
    public function get_script_depends() {
        return [
            'prettyPhoto-js',
            'isotope-js',
            'pixerex-elements-js'
        ];
    }
    
    public function is_reload_preview_required() {
        return true;
    }
    
    public function get_categories() {
        return ['pixerex-elements'];
    }

    public function get_keywords() {
        return ['layout', 'gallery', 'images', 'videos', 'portfolio', 'visual', 'masonry'];
    }
    
    protected function _register_controls() {
        
        $this->start_controls_section('pixerex_gallery_general',
            [
                'label'             => __('Layout','pixerex-elements'),
                
            ]);
        
        $this->add_control('pixerex_gallery_img_size_select',
                [
                    'label'             => __('Grid Layout', 'pixerex-elements'),
                    'type'              => Controls_Manager::SELECT,
                    'options'           => [
                        'fitRows'  => __('Even', 'pixerex-elements'),
                        'masonry'  => __('Masonry', 'pixerex-elements'),
                        'metro'    => __('Metro', 'pixerex-elements'), 
                   ],
                    'default'           => 'fitRows',
                    ]
                );
        
        $this->add_responsive_control('pemium_gallery_even_img_height',
			[ 
 				'label'             => __( 'Minimum Height', 'pixerex-elements' ),
				'label_block'       => true,
                'size_units'        => ['px', 'em', 'vh'],
				'type'              => Controls_Manager::SLIDER,
                'range'             => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 500,
                    ],
                    'em'    => [
                        'min'   => 1, 
                        'max'   => 50,
                    ],
                ],
                'render_type'       => 'template',
                'condition'         => [
                    'pixerex_gallery_img_size_select'   => 'fitRows'
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-gallery-item .pr-gallery-image' => 'min-height: {{SIZE}}{{UNIT}}'
                ]
			]
		);

        $this->add_control('pixerex_gallery_images_fit',
            [
                'label'             => __('Images Fit', 'pixerex-elements'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'fill'   => __('Fill', 'pixerex-elements'),
                    'cover'  => __('Cover', 'pixerex-elements'),
               ],
                'default'           => 'fill',
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-gallery-item .pr-gallery-image'  => 'object-fit: {{VALUE}}'
                ],
                'condition'         => [
                    'pixerex_gallery_img_size_select'   =>  [ 'metro', 'fitRows' ]
                ]
            ]
        );
        
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'             => 'thumbnail', // Actually its `image_size`.
				'default'          => 'full',
                'condition'        => [
                    'pixerex_gallery_img_size_select'   => 'fitRows'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_gallery_column_number',
			[
  				'label'            => __( 'Columns', 'pixerex-elements' ),
				'label_block'      => true,
				'type'             => Controls_Manager::SELECT,				
				'desktop_default'  => '50%',
				'tablet_default'   => '100%',
				'mobile_default'   => '100%',
				'options'          => [
					'100%'      => __( '1 Column', 'pixerex-elements' ),
					'50%'       => __( '2 Columns', 'pixerex-elements' ),
					'33.330%'   => __( '3 Columns', 'pixerex-elements' ),
					'25%'       => __( '4 Columns', 'pixerex-elements' ),
					'20%'       => __( '5 Columns', 'pixerex-elements' ),
					'16.66%'    => __( '6 Columns', 'pixerex-elements' ),
                    '8.33%'     => __( '12 Columns', 'pixerex-elements' ),
				],
                'condition'        => [
                    'pixerex_gallery_img_size_select!'  => 'metro'
                ],
				'selectors'         => [
					'{{WRAPPER}} .pixerex-img-gallery-masonry div.pixerex-gallery-item, {{WRAPPER}} .pixerex-img-gallery-fitRows div.pixerex-gallery-item' => 'width: {{VALUE}};',
				],
				'render_type'       => 'template'
			]
		);
        
        $this->add_control( 'pixerex_gallery_load_more', 
            [
                'label'             => __( 'Load More Button', 'pixerex-elements' ),
                'description'       => __('Requires number of images larger than 6', 'pixerex-elements'),
                'type'              => Controls_Manager::SWITCHER
            ]
        );
        
        $this->add_control( 'pixerex_gallery_load_more_text', 
            [
                'label'             => __( 'Button Text', 'pixerex-elements' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => __('Load More', 'pixerex-elements'),
                'dynamic'           => [ 'active' => true ],
                'condition'         => [
                    'pixerex_gallery_load_more'    => 'yes'
                ]
            ]
        );
        
        $this->add_control( 'pixerex_gallery_load_minimum',
            [
                'label'             => __('Minimum Number of Images', 'pixerex-elements'),
                'type'              => Controls_Manager::NUMBER,
                'description'       => __('Set the minimum number of images before showing load more button', 'pixerex-elements'),
                'default'           => 6,
                'condition'         => [
                    'pixerex_gallery_load_more'    => 'yes'
                ]
            ]
        );
        
        $this->add_control( 'pixerex_gallery_load_click_number',
            [
                'label'             => __('Images to Show', 'pixerex-elements'),
                'type'              => Controls_Manager::NUMBER,
                'description'       => __('Set the minimum number of images to show with each click', 'pixerex-elements'),
                'default'           => 6,
                'condition' => [
                    'pixerex_gallery_load_more'    => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_gallery_load_more_align',
            [
                'label'             => __( 'Button Alignment', 'pixerex-elements' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
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
                'default'           => 'center',
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-gallery-load-more' => 'text-align: {{VALUE}};',
                ],
                'condition'         => [
                    'pixerex_gallery_load_more'    => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_cats',
            [
                'label'             => __('Categories','pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_gallery_filter',
            [
                'label'             => __( 'Filter Tabs', 'pixerex-elements' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes'
            ]
        );
        
        $condition = array( 'pixerex_gallery_filter' => 'yes' );
        
        $this->add_control( 'pixerex_gallery_first_cat_switcher', 
            [
                'label'             => __( 'First Category', 'pixerex-elements' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'condition'         => $condition
            ]
        );
        
        $this->add_control( 'pixerex_gallery_first_cat_label', 
            [
                'label'             => __( 'First Category Label', 'pixerex-elements' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => __('All', 'pixerex-elements'),
                'dynamic'           => [ 'active' => true ],
                'condition' => array_merge( [
                    'pixerex_gallery_first_cat_switcher'    => 'yes'
                ], $condition )
            ]
        );
        
        $repeater = new REPEATER();
        
        $repeater->add_control( 'pixerex_gallery_img_cat', 
            [
                'label'             => __( 'Category', 'pixerex-elements' ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
            ]
        );
        
        $repeater->add_control( 'pixerex_gallery_img_cat_rotation',
            [
                'label'             => __('Rotation Degrees', 'pixerex-elements'),
                'type'              => Controls_Manager::NUMBER,
                'description'       => __('Set rotation value in degrees', 'pixerex-elements'),
                'min'               => -180,
                'max'               => 180,
                'selectors'         => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'transform: rotate({{VALUE}}deg);'
                ],
            ]
        );
        
        $this->add_control('pixerex_gallery_cats_content',
           [
               'label'              => __( 'Categories', 'pixerex-elements' ),
               'type'               => Controls_Manager::REPEATER,
               'default'            => [
                   [
                       'pixerex_gallery_img_cat'   => 'Category 1',
                   ],
                   [
                       'pixerex_gallery_img_cat'   => 'Category 2',
                   ],
               ],
               'fields'             => array_values( $repeater->get_controls() ) ,
               'title_field'        => '{{{ pixerex_gallery_img_cat }}}',
               'condition'          => $condition
           ]
       );
        
        $this->add_control('pixerex_gallery_active_cat',
            [
                'label'             => __('Active Category Index', 'pixerex-elements'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => 1,
                'min'               => 0,
                'condition'         => $condition
                
            ]
        );
            
        $this->add_control('active_cat_notice',
			[
				'raw'             => __( 'Please note categories are zero indexed, so to set if you need the first category to be active, you need to set the value to 0', 'pixerex-elements' ),
                'type'            => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);  
        
        $this->add_control('pixerex_gallery_shuffle',
            [
                'label'         => __( 'Shuffle Images on Filter Click', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => array_merge( [
                    'pixerex_gallery_filter'    => 'yes'
                ], $condition )
            ]
        );
    
        $this->add_responsive_control('pixerex_gallery_filters_align',
            [
                'label'             => __( 'Alignment', 'pixerex-elements' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'flex-start'      => [
                        'title'=> __( 'Left', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'pixerex-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'           => 'center',
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-img-gallery-filter' => 'justify-content: {{VALUE}}'
                ],
                'condition'         => $condition
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_content',
            [
                'label'     => __('Images/Videos','pixerex-elements'),
            ]);
        
        $img_repeater = new REPEATER();
        
        $img_repeater->add_control('pixerex_gallery_img', 
            [
                'label' => __( 'Upload Image', 'pixerex-elements' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src(),
                ],
            ]);
        
        $img_repeater->add_responsive_control('pixerex_gallery_image_cell',
			[
  				'label'                 => __( 'Width', 'pixerex-elements' ),
                'description'           => __('Works only when layout set to \'Metro\'', 'pixerex-elements'),
				'label_block'           => true,
                'default'               => [
                    'unit'  => 'px',
                    'size'  => 4
                ],
				'type'                  => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 12,
                    ],
                ],
				'render_type' => 'template'
			]
		);
        
        $img_repeater->add_responsive_control('pixerex_gallery_image_vcell',
			[
  				'label'                 => __( 'Height', 'pixerex-elements' ),
                'description'           => __('Works only when layout set to \'Metro\'', 'pixerex-elements'),
				'label_block'           => true,
				'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'unit'  => 'px',
                    'size'  => 4
                ],
                'range'         => [
                    'px'    => [
                        'min'   => 1, 
                        'max'   => 12,
                    ],
                ],
				'render_type' => 'template'
			]
		);
        
        $img_repeater->add_control('pixerex_gallery_video',
            [
                'label'         => __( 'Video', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true'
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_video_type',
            [
                'label'         => __( 'Type', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'youtube'       => __('YouTube', 'pixerex-elements'),
                    'vimeo'         => __('Vimeo', 'pixerex-elements'),
                    'hosted'        => __('Self Hosted', 'pixerex-elements'),
                ],
                'label_block'   => true,
                'default'       => 'youtube',
                'condition'     => [
                    'pixerex_gallery_video' => 'true',
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_video_url',
            [
                'label'         => __( 'Video URL', 'pixerex-elements' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'dynamic'       => [ 
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'condition'     => [
                    'pixerex_gallery_video'         => 'true',
                    'pixerex_gallery_video_type!'   => 'hosted'
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_video_self',
            [
                'label'         => __('Select Video', 'pixerex-elements'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY,
                    ],
                ],
                'media_type' => 'video',
                'condition'     => [
                    'pixerex_gallery_video'     => 'true',
                    'pixerex_gallery_video_type'=> 'hosted'
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_video_self_url',
            [
                'label'         => __('Remote Video URL', 'pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active' => true,
                ],
                'label_block'   => true,
                'condition'     => [
                    'pixerex_gallery_video'     => 'true',
                    'pixerex_gallery_video_type'=> 'hosted'
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_video_controls',
            [
                'label'         => __( 'Controls', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'     => [
                    'pixerex_gallery_video'     => 'true',
                    'pixerex_gallery_video_type!'=> 'vimeo'
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_video_mute',
            [
                'label'         => __( 'Mute', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'pixerex_gallery_video'     => 'true'
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_img_name', 
            [
                'label' => __( 'Title', 'pixerex-elements' ),
                'type' => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
            ]);
        
        $img_repeater->add_control('pixerex_gallery_img_desc', 
            [
                'label' => __( 'Description', 'pixerex-elements' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic'       => [ 'active' => true ],
                'label_block' => true,
            ]);
        
        $img_repeater->add_control('pixerex_gallery_img_category', 
            [
                'label' => __( 'Category', 'pixerex-elements' ),
                'type' => Controls_Manager::TEXT,
                'description'=> __('To assign for multiple categories, separate by a comma \',\'','pixerex-elements'),
                'dynamic'       => [ 'active' => true ],
            ]);
        
        $img_repeater->add_control('pixerex_gallery_img_link_type', 
            [
                'label'         => __('Link Type', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', 'pixerex-elements'),
                    'link'  => __('Existing Page', 'pixerex-elements'),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_gallery_video!'     => 'true',
                ]
            ]);
        
        $img_repeater->add_control('pixerex_gallery_img_link', 
            [
                'label'         => __('Link', 'pixerex-elements'),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'placeholder'   => 'https://www.google.com/',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_gallery_img_link_type' => 'url',
                    'pixerex_gallery_video!'        => 'true',
                ]
            ]);
        
        $img_repeater->add_control('pixerex_gallery_img_existing', 
            [
                'label'         => __('Existing Page', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'condition'     => [
                    'pixerex_gallery_img_link_type'=> 'link',
                ],
                'multiple'      => false,
                'separator'     => 'after',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_gallery_img_link_type' => 'link',
                    'pixerex_gallery_video!'        => 'true',
                ]
            ]);
        
        $img_repeater->add_control('pixerex_gallery_link_whole',
            [
                'label'         => __( 'Whole Image Link', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_gallery_video!'         => 'true',
                ]
            ]
        );
        
        $img_repeater->add_control('pixerex_gallery_lightbox_whole',
            [
                'label'         => __( 'Whole Image Lightbox', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_gallery_video!'         => 'true',
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_img_content',
           [
               'label' => __( 'Images', 'pixerex-elements' ),
               'type' => Controls_Manager::REPEATER,
               'default' => [
                   [
                       'pixerex_gallery_img_name'   => 'Image #1',
                       'pixerex_gallery_img_category'   => 'Category 1'
                   ],
                   [
                       'pixerex_gallery_img_name'   => 'Image #2',
                       'pixerex_gallery_img_category' => 'Category 2'
                   ],
               ],
               'fields' => array_values( $img_repeater->get_controls() ),
               'title_field'   => '{{{ "" !== pixerex_gallery_img_name ? pixerex_gallery_img_name : "Image" }}}' . ' - {{{ "" !== pixerex_gallery_img_category ? pixerex_gallery_img_category : "No Categories" }}}',
           ]
       );
        
        $this->add_control('pixerex_gallery_shuffle_onload',
            [
                'label'         => __( 'Shuffle Images on Page Load', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control('pixerex_gallery_yt_thumbnail_size',
            [
                'label'     => __( 'Youtube Videos Thumbnail Size', 'pixerex-elements' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'maxresdefault' => __( 'Maximum Resolution', 'pixerex-elements' ),
                    'hqdefault'     => __( 'High Quality', 'pixerex-elements' ),
                    'mqdefault'     => __( 'Medium Quality', 'pixerex-elements' ),
                    'sddefault'     => __( 'Standard Quality', 'pixerex-elements' ),
                ],
                'default'   => 'maxresdefault',
                'label_block'=> true
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_grid_settings',
            [
                'label'     => __('Display Options','pixerex-elements'),
                
            ]);
        
        $this->add_responsive_control('pixerex_gallery_gap',
            [
                'label'         => __('Image Gap', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', "em"],
                'range'         => [
                    'px'    => [
                        'min'   => 0, 
                        'max'   => 200,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-item' => 'padding: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_img_style',
            [
                'label'         => __('Skin', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'description'   => __('Choose a layout style for the gallery','pixerex-elements'),
                'options'       => [
                    'default'           => __('Style 1', 'pixerex-elements'),
                    'style1'            => __('Style 2', 'pixerex-elements'),
                    'style2'            => __('Style 3', 'pixerex-elements'),
                    'style3'            => __('Style 4', 'pixerex-elements'),
                ],
                'default'       => 'default',
                'separator'     => 'before',
                'label_block'   => true
            ]
        );
        
        $this->add_control('pixerex_grid_style_notice', 
            [
                'raw'               => __('Style 4 works only with Even / Masonry Layout', 'pixerex-elements'),
                'type'              => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'         => [
                    'pixerex_gallery_img_style'         => 'style3',
                    'pixerex_gallery_img_size_select'   => 'metro'
                ]
            ] 
        );
        
        $this->add_responsive_control('pixerex_gallery_style1_border_border',
            [
                'label'         => __('Height', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 700,
                    ]
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pr-gallery-img.style1 .pixerex-gallery-caption' => 'bottom: {{SIZE}}px;',
                ],
                'condition'     => [
                    'pixerex_gallery_img_style' => 'style1'
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_img_effect',
            [
                'label'         => __('Hover Effect', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'description'   => __('Choose a hover effect for the image','pixerex-elements'),
                'options'       => [
                    'none'          => __('None', 'pixerex-elements'),
                    'zoomin'        => __('Zoom In', 'pixerex-elements'),
                    'zoomout'       => __('Zoom Out', 'pixerex-elements'),
                    'scale'         => __('Scale', 'pixerex-elements'),
                    'gray'          => __('Grayscale', 'pixerex-elements'),
                    'blur'          => __('Blur', 'pixerex-elements'),
                    'bright'        => __('Bright', 'pixerex-elements'),
                    'sepia'         => __('Sepia', 'pixerex-elements'),
                    'trans'         => __('Translate', 'pixerex-elements'),
                ],
                'default'       => 'zoomin',
                'label_block'   => true,
                'separator'     => 'after'
            ]
        );
        
        $this->add_control('pixerex_gallery_links_icon',
		  	[
		     	'label'         => __( 'Links Icon', 'pixerex-elements' ),
		     	'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'library'       => 'fa-solid',
                    'value'         => 'fas fa-link',
                ]
		  	]
		);

        $this->add_control('pixerex_gallery_videos_heading',
    		[
				'label'			=> __( 'Videos', 'pixerex-elements' ),
				'type'			=> Controls_Manager::HEADING,
                'separator'     => 'before'
			]
		);
        
        $this->add_control('pixerex_gallery_video_icon',
            [
                'label'         => __( 'Always Show Play Icon', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'     => [
                    'pixerex_gallery_img_style!' => 'style2'
                ],
                
            ]
        );
        
        $this->add_control('pixerex_gallery_videos_icon',
		  	[
		     	'label'         => __( 'Videos Play Icon', 'pixerex-elements' ),
		     	'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'library'       => 'fa-solid',
                    'value'         => 'fas fa-play',
                ]
		  	]
		);
        
        $this->add_control('pixerex_gallery_rtl_mode',
            [
                'label'         => __( 'RTL Mode', 'pixerex-elements' ),
                'description'   => __('This option moves the origin of the grid to the right side. Useful for RTL direction sites', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'separator'     => 'before'
            ]
        );
        
        $this->add_responsive_control('pixerex_gallery_content_align',
                [
                    'label'         => __( 'Content Alignment', 'pixerex-elements' ),
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
                    'default'       => 'center',
                    'separator'     => 'before',
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-gallery-caption' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_lightbox_section',
            [
                'label'         => __('Lightbox', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_gallery_light_box',
            [
                'label'         => __( 'Lightbox', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );
        
        $this->add_control('pixerex_gallery_lightbox_type',
			[
				'label'             => __( 'Lightbox Style', 'pixerex-elements' ),
				'type'              => Controls_Manager::SELECT,
				'default'           => 'default',
				'options'           => [
					'default'   => __( 'PrettyPhoto', 'pixerex-elements' ),
					'yes'       => __( 'Elementor', 'pixerex-elements' ),
					'no'        => __( 'Other Lightbox Plugin', 'pixerex-elements' ),
				],
				'condition'         => [
					'pixerex_gallery_light_box' => 'yes',
				],
			]
		);
        
        $this->add_control('pixerex_gallery_lightbox_doc',
			[
				'raw'             => __( 'Please note Elementor lightbox style is always applied on videos.', 'pixerex-elements' ),
                'type'            => Controls_Manager::RAW_HTML,
                'content_classes' => 'editor-pa-doc',
			]
		);
        
        $this->add_control('pixerex_gallery_lightbox_theme',
            [
                'label'             => __('Lightbox Theme', 'pixerex-elements'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'pp_default'        => __('Default', 'pixerex-elements'),
                    'light_rounded'     => __('Light Rounded', 'pixerex-elements'),
                    'dark_rounded'      => __('Dark Rounded', 'pixerex-elements'),
                    'light_square'      => __('Light Square', 'pixerex-elements'),
                    'dark_square'       => __('Dark Square', 'pixerex-elements'),
                    'facebook'          => __('Facebook', 'pixerex-elements'),
                ],
                'default'           => 'pp_default',
                'condition'     => [
                    'pixerex_gallery_light_box'     => 'yes',
                    'pixerex_gallery_lightbox_type' => 'default'
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_overlay_gallery',
            [
                'label'         => __( 'Overlay Gallery Images', 'pixerex-elements' ),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_gallery_light_box'     => 'yes',
                    'pixerex_gallery_lightbox_type' => 'default'
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_lightbox_icon',
		  	[
		     	'label'         => __( 'Lightbox Icon', 'pixerex-elements' ),
		     	'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'library'       => 'fa-solid',
                    'value'         => 'fas fa-search',
                ],
                'condition'     => [
                    'pixerex_gallery_light_box'     => 'yes'
                ]
		  	]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_responsive_section',
            [
                'label'         => __('Responsive', 'pixerex-elements'),
            ]);
        
        $this->add_control('pixerex_gallery_responsive_switcher',
            [
                'label'         => __('Responsive Controls', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('If the content text is not suiting well on specific screen sizes, you may enable this option which will hide the description text.', 'pixerex-elements')
            ]);
        
        $this->add_control('pixerex_gallery_min_range', 
            [
                'label'     => __('Minimum Size', 'pixerex-elements'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: minimum size for extra small screens is 1px.','pixerex-elements'),
                'default'   => 1,
                'condition' => [
                    'pixerex_gallery_responsive_switcher'    => 'yes'
                ],
            ]);

        $this->add_control('pixerex_gallery_max_range', 
            [
                'label'     => __('Maximum Size', 'pixerex-elements'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: maximum size for extra small screens is 767px.','pixerex-elements'),
                'default'   => 767,
                'condition' => [
                    'pixerex_gallery_responsive_switcher'    => 'yes'
                ],
            ]);

		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_general_style',
            [
                'label'     => __('General','pixerex-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_gallery_general_background',
                    'types'             => [ 'classic', 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-img-gallery',
                ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'pixerex_gallery_general_border',
                    'selector'          => '{{WRAPPER}} .pixerex-img-gallery',
                    ]
                );
        
        $this->add_control('pixerex_gallery_general_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-img-gallery' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'pixerex_gallery_general_box_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-img-gallery',
            ]
            );
        
        $this->add_responsive_control('pixerex_gallery_general_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-img-gallery' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->add_responsive_control('pixerex_gallery_general_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-img-gallery' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_img_style_section',
            [
                'label'     => __('Image','pixerex-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);
        
        $this->add_control('pixerex_gallery_icons_style_overlay',
            [
                'label'         => __('Hover Overlay Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pr-gallery-img:not(.style2):hover .pr-gallery-icons-wrapper, {{WRAPPER}} .pr-gallery-img .pr-gallery-icons-caption-container, {{WRAPPER}} .pr-gallery-img:hover .pr-gallery-icons-caption-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'pixerex_gallery_img_border',
                'selector'          => '{{WRAPPER}} .pr-gallery-img-container',
            ]
        );
        
        $this->add_control('pixerex_gallery_img_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-img-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'             => __('Shadow','pixerex-elements'),
                'name'              => 'pixerex_gallery_img_box_shadow',
                'selector'          => '{{WRAPPER}} .pr-gallery-img-container',
                'condition'         => [
                    'pixerex_gallery_img_style!' => 'style1'
                ]
            ]
            );
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .pr-gallery-img-container img',
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
                'label' => __('Hover CSS Filters', 'pixerex-elements'),
				'name' => 'hover_css_filters',
				'selector' => '{{WRAPPER}} .pixerex-gallery-item:hover img',
			]
		);
        
        $this->add_responsive_control('pixerex_gallery_img_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-img-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->add_responsive_control('pixerex_gallery_img_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-img-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_content_style',
            [
                'label'     => __('Title / Description','pixerex-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);
        
        $this->add_control('pixerex_gallery_title_heading',
                [
                    'label'         => __('Title', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        $this->add_control('pixerex_gallery_title_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-gallery-img-name, {{WRAPPER}} .pixerex-gallery-img-name a' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pixerex_gallery_title_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-gallery-img-name, {{WRAPPER}} .pixerex-gallery-img-name a',
                    ]
                );
        
        $this->add_control('pixerex_gallery_description_heading',
                [
                    'label'         => __('Description', 'pixerex-elements'),
                    'type'          => Controls_Manager::HEADING,
                    'separator'     => 'before',
                ]
                );
        
        $this->add_control('pixerex_gallery_description_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_3,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-gallery-img-desc, {{WRAPPER}} .pixerex-gallery-img-desc a' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pixerex_gallery_description_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-gallery-img-desc, {{WRAPPER}} .pixerex-gallery-img-desc a',
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pixerex_gallery_content_background',
                    'types'             => [ 'classic', 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pixerex-gallery-caption',
                    'separator'         => 'before',
                ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'pixerex_gallery_content_border',
                    'selector'          => '{{WRAPPER}} .pixerex-gallery-caption',
                    ]
                );
        
        $this->add_control('pixerex_gallery_content_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-gallery-caption' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','pixerex-elements'),
                'name'              => 'pixerex_gallery_content_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-gallery-caption',
            ]
            );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'              => 'pixerex_gallery_content_box_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-gallery-caption',
            ]
            );
        
        $this->add_responsive_control('pixerex_gallery_content_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-gallery-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->add_responsive_control('pixerex_gallery_content_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pixerex-gallery-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_icons_style',
            [
                'label'     => __('Icons','pixerex-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);
        
        $this->add_responsive_control('pixerex_gallery_style1_icons_position',
            [
                'label'         => __('Position', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 300,
                    ]
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pr-gallery-img.style1 .pr-gallery-icons-inner-container,{{WRAPPER}} .pr-gallery-img.default .pr-gallery-icons-inner-container' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'pixerex_gallery_img_style!' => 'style2'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_gallery_icons_size',
            [
                'label'         => __('Size', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em'],
                'range'         => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 50,
                    ]
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .pr-gallery-icons-inner-container i, {{WRAPPER}} .pr-gallery-icons-caption-cell i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .pr-gallery-icons-inner-container svg, {{WRAPPER}} .pr-gallery-icons-caption-cell svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        
        $this->start_controls_tabs('pixerex_gallery_icons_style_tabs');
        
        $this->start_controls_tab('pixerex_gallery_icons_style_normal',
                [
                    'label'         => __('Normal', 'pixerex-elements'),
                ]
                );
        
        $this->add_control('pixerex_gallery_icons_style_color',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image i, {{WRAPPER}} .pr-gallery-img-link i' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_control('pixerex_gallery_icons_style_background',
                [
                    'label'         => __('Background Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image span, {{WRAPPER}} .pr-gallery-img-link span' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_gallery_icons_style_border',
                    'selector'      => '{{WRAPPER}} .pr-gallery-magnific-image span, {{WRAPPER}} .pr-gallery-img-link span',
                ]
                );
        
        $this->add_control('pixerex_gallery_icons_style_border_radius',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image span, {{WRAPPER}} .pr-gallery-img-link span' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Shadow','pixerex-elements'),
                    'name'          => 'pixerex_gallery_icons_style_shadow',
                    'selector'      => '{{WRAPPER}} .pr-gallery-magnific-image span, {{WRAPPER}} .pr-gallery-img-link span',
                ]
                );
        
        $this->add_responsive_control('pixerex_gallery_icons_style_margin',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image span, {{WRAPPER}} .pr-gallery-img-link span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('pixerex_gallery_icons_style_padding',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image span, {{WRAPPER}} .pr-gallery-img-link span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();

        $this->start_controls_tab('pixerex_gallery_icons_style_hover',
        [
            'label'         => __('Hover', 'pixerex-elements'),
        ]
        );
        
        $this->add_control('pixerex_gallery_icons_style_color_hover',
                [
                    'label'         => __('Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image:hover i, {{WRAPPER}} .pr-gallery-img-link:hover i' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_control('pixerex_gallery_icons_style_background_hover',
                [
                    'label'         => __('Background Color', 'pixerex-elements'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image:hover span, {{WRAPPER}} .pr-gallery-img-link:hover span' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_gallery_icons_style_border_hover',
                    'selector'      => '{{WRAPPER}} .pr-gallery-magnific-image:hover span, {{WRAPPER}} .pr-gallery-img-link:hover span',
                ]
                );
        
        $this->add_control('pixerex_gallery_icons_style_border_radius_hover',
                [
                    'label'         => __('Border Radius', 'pixerex-elements'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%' ],                    
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image:hover span, {{WRAPPER}} .pr-gallery-img-link:hover span' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Shadow','pixerex-elements'),
                    'name'          => 'pixerex_gallery_icons_style_shadow_hover',
                    'selector'      => '{{WRAPPER}} {{WRAPPER}} .pr-gallery-magnific-image:hover span, {{WRAPPER}} .pr-gallery-img-link:hover span',
                ]
                );
        
        $this->add_responsive_control('pixerex_gallery_icons_style_margin_hover',
                [
                    'label'         => __('Margin', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image:hover span, {{WRAPPER}} .pr-gallery-img-link:hover span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('pixerex_gallery_icons_style_padding_hover',
                [
                    'label'         => __('Padding', 'pixerex-elements'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-gallery-magnific-image:hover span, {{WRAPPER}} .pr-gallery-img-link:hover span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_filter_style',
            [
                'label'     => __('Filter','pixerex-elements'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pixerex_gallery_filter'    => 'yes'
                ]
            ]);
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pixerex_gallery_filter_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-gallery-cats-container li a.category',
                    ]
                );
        
        $this->start_controls_tabs('pixerex_gallery_filters');

        $this->start_controls_tab('pixerex_gallery_filters_normal',
            [
                'label'         => __('Normal', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_gallery_filter_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-cats-container li a.category span' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_background_color',
           [
               'label'         => __('Background Color', 'pixerex-elements'),
               'type'          => Controls_Manager::COLOR,
               'selectors'     => [
                   '{{WRAPPER}} .pixerex-gallery-cats-container li a.category' => 'background-color: {{VALUE}};',
               ],
           ]
       );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'              => 'pixerex_gallery_filter_border',
                    'selector'          => '{{WRAPPER}} .pixerex-gallery-cats-container li a.category',
                ]
                );

        $this->add_control('pixerex_gallery_filter_border_radius',
                [
                    'label'             => __('Border Radius', 'pixerex-elements'),
                    'type'              => Controls_Manager::SLIDER,
                    'size_units'        => ['px','em','%'],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-gallery-cats-container li a.category'  => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_gallery_filters_hover',
            [
                'label'         => __('Hover', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_gallery_filter_hover_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-cats-container li a:hover span' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_control('pixerex_gallery_background_hover_color',
           [
               'label'         => __('Background Color', 'pixerex-elements'),
               'type'          => Controls_Manager::COLOR,
               'selectors'     => [
                   '{{WRAPPER}} .pixerex-gallery-cats-container li a:hover' => 'background-color: {{VALUE}};',
               ],
           ]
       );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'              => 'pixerex_gallery_filter_border_hover',
                    'selector'          => '{{WRAPPER}} .pixerex-gallery-cats-container li a.category:hover',
                ]
                );

        $this->add_control('pixerex_gallery_filter_border_radius_hover',
                [
                    'label'             => __('Border Radius', 'pixerex-elements'),
                    'type'              => Controls_Manager::SLIDER,
                    'size_units'        => ['px','em','%'],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-gallery-cats-container li a.category:hover'  => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_gallery_filters_active',
            [
                'label'         => __('Active', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_gallery_filter_active_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-cats-container li a.active span' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('pixerex_gallery_background_active_color',
           [
               'label'         => __('Background Color', 'pixerex-elements'),
               'type'          => Controls_Manager::COLOR,
               'selectors'     => [
                   '{{WRAPPER}} .pixerex-gallery-cats-container li a.active' => 'background-color: {{VALUE}};',
               ],
           ]
       );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'              => 'pixerex_gallery_filter_border_active',
                    'selector'          => '{{WRAPPER}} .pixerex-gallery-cats-container li a.active',
                ]
                );

        $this->add_control('pixerex_gallery_filter_border_radius_active',
                [
                    'label'             => __('Border Radius', 'pixerex-elements'),
                    'type'              => Controls_Manager::SLIDER,
                    'size_units'        => ['px','em','%'],
                    'selectors'         => [
                        '{{WRAPPER}} .pixerex-gallery-cats-container li a.active'  => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'name'          => 'pixerex_gallery_filter_shadow',
                    'selector'      => '{{WRAPPER}} .pixerex-gallery-cats-container li a.category',
                ]
                );
        
        $this->add_responsive_control('pixerex_gallery_filter_margin',
                [
                    'label'             => __('Margin', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'             => [
                        '{{WRAPPER}} .pixerex-gallery-cats-container li a.category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control('pixerex_gallery_filter_padding',
                [
                    'label'             => __('Padding', 'pixerex-elements'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                'selectors'             => [
                    '{{WRAPPER}} .pixerex-gallery-cats-container li a.category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_gallery_button_style_settings',
            [
                'label'         => __('Load More Button', 'pixerex-elements'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_gallery_load_more'  => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'pixerex_gallery_button_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn',
            ]
        );

        $this->start_controls_tabs('pixerex_gallery_button_style_tabs');

        $this->start_controls_tab('pixerex_gallery_button_style_normal',
            [
                'label'         => __('Normal', 'pixerex-elements'),
            ]
        );

        $this->add_control('pixerex_gallery_button_color',
            [
                'label'         => __('Text Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn'  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn .pixerex-loader'  => 'border-color: {{VALUE}};',
                    ]
                ]
            );
        
        $this->add_control('pixerex_gallery_button_spin_color',
            [
                'label'         => __('Spinner Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn .pixerex-loader'  => 'border-top-color: {{VALUE}};'
                    ]
                ]
            );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'pixerex_gallery_button_text_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'pixerex_gallery_button_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .pixerex-gallery-load-more-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_gallery_button_border',
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn',
            ]
        );

        $this->add_control('pixerex_gallery_button_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_gallery_button_box_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn',
            ]
        );

        $this->add_responsive_control('pixerex_gallery_button_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('pixerex_gallery_button_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('pixerex_gallery_button_style_hover',
            [
                'label'         => __('Hover', 'pixerex-elements'),
            ]
        );

        $this->add_control('pixerex_gallery_button_hover_color',
            [
                'label'         => __('Text Hover Color', 'pixerex-elements'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover'  => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'pixerex_gallery_button_text_shadow_hover',
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'          => 'pixerex_gallery_button_background_hover',
                'types'         => [ 'classic' , 'gradient' ],
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_gallery_button_border_hover',
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover',
            ]
        );

        $this->add_control('button_border_radius_hover',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em' , '%' ],                    
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_gallery_button_shadow_hover',
                'selector'      => '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover',
            ]
        );

        $this->add_responsive_control('button_margin_hover',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('pixerex_gallery_button_padding_hover',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-load-more-btn:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        
        $this->update_controls();
        
    }
    
    /*
     * Filter Cats
     * 
     * Formats Category to be inserted in class attribute.
     * 
     * @since 2.1.0
     * @access public
     * 
     * @return string category slug
     */
    public function filter_cats( $string ) {
        
		$cat_filtered = mb_strtolower( $string );
        
        if( strpos( $cat_filtered, 'class' ) || strpos( $cat_filtered, 'src' ) ) {
            $cat_filtered = substr( $cat_filtered, strpos( $cat_filtered, '"' ) + 1 );
            $cat_filtered = strtok( $cat_filtered, '"' );
            $cat_filtered = preg_replace( '/[http:.]/', '', $cat_filtered );
            $cat_filtered = str_replace( '/', '', $cat_filtered );
        }

        $cat_filtered = str_replace( ', ', ',', $cat_filtered );
		$cat_filtered = preg_replace( "/[\s_]/", "-", $cat_filtered );
        $cat_filtered = str_replace( ',', ' ', $cat_filtered );
        
		return $cat_filtered;
	}
    
    /*
     * Render Filter Tabs on the frontend
     *
     * @since 2.1.0
     * @access protected
     * 
     * @param string $first Class for the first category
     * @param number $active_index active category index
     */
    protected function render_filter_tabs( $first, $active_index ) {
        
        $settings = $this->get_settings_for_display();
        
        ?>

        <div class="pixerex-img-gallery-filter">
            <ul class="pixerex-gallery-cats-container">
                <?php if( 'yes' == $settings['pixerex_gallery_first_cat_switcher'] ) : ?>
                    <li>
                        <a href="javascript:;" class="category <?php echo $first; ?>" data-filter="*">
                            <span><?php echo $settings['pixerex_gallery_first_cat_label']; ?></span>
                        </a>
                    </li>
                <?php endif; 
                foreach( $settings['pixerex_gallery_cats_content'] as $index => $category ) {
                    if( ! empty( $category['pixerex_gallery_img_cat'] ) ) {
                        $cat_filtered = $this->filter_cats( $category['pixerex_gallery_img_cat'] );

                        $key = 'pixerex_grid_category_' . $index;

                        if( $active_index === $index ) {
                            $this->add_render_attribute( $key, 'class', 'active' );
                        }

                        $this->add_render_attribute( $key,
                            'class', [
                                'category',
                                'elementor-repeater-item-' . $category['_id']
                            ]
                        );
                        
                        $slug = sprintf( '.%s', $cat_filtered );
                        
                        $this->add_render_attribute( $key, 'data-filter', $slug );
                    ?>
                        <li>
                            <a href="javascript:;" <?php echo $this->get_render_attribute_string( $key ); ?>>
                                <span><?php echo $category['pixerex_gallery_img_cat']; ?></span>
                            </a>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>

        <?php
    }
    
    /**
	 * Render Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.1.0
	 * @access protected
	 */
    protected function render() {
        
        $settings       = $this->get_settings_for_display();
        
        $filter         = $settings['pixerex_gallery_filter'];
        
        $skin           = $settings['pixerex_gallery_img_style'];
        
        $layout         = $settings['pixerex_gallery_img_size_select'];
        
        $lightbox       = $settings['pixerex_gallery_light_box'];
        
        $lightbox_type  = $settings['pixerex_gallery_lightbox_type'];
        
        $show_play      = $settings['pixerex_gallery_video_icon'];
        
        if ( 'yes' === $settings['pixerex_gallery_responsive_switcher'] ) {
            $min_size   = $settings['pixerex_gallery_min_range'] . 'px';
            $max_size   = $settings['pixerex_gallery_max_range'] . 'px';
        }
        
        $category = "*";
        
        if ( 'yes' === $filter ) {
            
            if ( ! empty( $settings['pixerex_gallery_active_cat'] ) || 0 === $settings['pixerex_gallery_active_cat'] ) {
                
                if( 'yes' !== $settings['pixerex_gallery_first_cat_switcher'] ) {
                    $active_index           = $settings['pixerex_gallery_active_cat'];
                    $active_category        = $settings['pixerex_gallery_cats_content'][$active_index]['pixerex_gallery_img_cat'];
                    $category               = "." . $this->filter_cats( $active_category );
                    $active_category_index  = $settings['pixerex_gallery_active_cat'];
                    
                } else {
                    $active_category_index  = $settings['pixerex_gallery_active_cat'] - 1;
                }
                
            } else {
                $active_category_index = 'yes' === $settings['pixerex_gallery_first_cat_switcher'] ? -1 : 0;
            }
        
            $is_all_active = ( 0 > $active_category_index ) ? "active" : "";
            
        }
        
        if ( 'original' === $layout ) {
            $layout = 'masonry';
        } else if ( 'one_size' === $layout ) {
            $layout = 'fitRows';
        }
        
        $ltr_mode           = 'yes' === $settings['pixerex_gallery_rtl_mode'] ? false : true;
        
        $shuffle            = 'yes' === $settings['pixerex_gallery_shuffle'] ? true : false;
        
        $shuffle_onload     = 'yes' === $settings['pixerex_gallery_shuffle_onload'] ? 'random' : 'original-order';
        
        $grid_settings  = [
            'img_size'      => $layout,
            'filter'        => $filter,
            'theme'         => $settings['pixerex_gallery_lightbox_theme'],
            'active_cat'    => $category,
            'ltr_mode'      => $ltr_mode,
            'shuffle'       => $shuffle,
            'sort_by'       => $shuffle_onload
        ];
        
        $load_more          = 'yes' === $settings['pixerex_gallery_load_more'] ? true : false;
        
        if( $load_more ) {
            $minimum        = ! empty ( $settings['pixerex_gallery_load_minimum'] ) ? $settings['pixerex_gallery_load_minimum'] : 6;
            $click_number   = ! empty ( $settings['pixerex_gallery_load_click_number'] ) ? $settings['pixerex_gallery_load_click_number'] : 6;
            
            $grid_settings = array_merge( $grid_settings, [
                'load_more'     => $load_more,
                'minimum'       => $minimum,
                'click_images'  => $click_number,
            ]);
        }
        
        if ( 'yes' === $lightbox ) {
            $grid_settings = array_merge( $grid_settings, [
                'light_box'         => $lightbox,
                'lightbox_type'     => $lightbox_type,
                'overlay'           => 'yes' === $settings['pixerex_gallery_overlay_gallery'] ? true : false,
            ]);
        } else {
            $this->add_render_attribute( 'grid', [
                'class'         => [
                        'pixerex-img-gallery-no-lightbox'
                    ]
                ]
            );
        }
        
        $this->add_render_attribute( 'grid', [
                'id'            => 'pixerex-img-gallery-' . esc_attr( $this->get_id() ),
                'class'         => [
                    'pixerex-img-gallery',
                    'pixerex-img-gallery-' . $layout,
                    $settings['pixerex_gallery_img_effect']
                ]
            ]
        );
        
        if ( $show_play ) {
            $this->add_render_attribute( 'grid', [
                    'class'         => [
                        'pixerex-gallery-icon-show'
                    ]
                ]
            );
        }
        
        $this->add_render_attribute( 'container', 'class', [
            'pr-gallery-img-container'
        ]);
        
    ?>

    <div <?php echo $this->get_render_attribute_string( 'grid' ); ?>>
        <?php if( $filter == 'yes' ) :
            $this->render_filter_tabs( $is_all_active, $active_category_index );
        endif; ?>
        
        <div class="pixerex-gallery-container" data-settings='<?php echo wp_json_encode( $grid_settings ); ?>'>
            
            <?php if ( 'metro' === $layout ) : ?>
                <div class="grid-sizer"></div>
            <?php endif;
            
            foreach( $settings['pixerex_gallery_img_content'] as $index => $image  ) :
                
                $key = 'gallery_item_' . $index;
                
                $this->add_render_attribute( $key, [
                        'class' => [
                            'pixerex-gallery-item',
                            'elementor-repeater-item-' . $image['_id'],
                            $this->filter_cats( $image['pixerex_gallery_img_category'] )
                        ]
                    ]
                );
                
                if ( 'metro' === $layout ) {
                    
                    $cells = [
                        'cells'         => $image['pixerex_gallery_image_cell']['size'],
                        'vcells'        => $image['pixerex_gallery_image_vcell']['size'],
                        'cells_tablet'  => $image['pixerex_gallery_image_cell_tablet']['size'],
                        'vcells_tablet' => $image['pixerex_gallery_image_vcell_tablet']['size'],
                        'cells_mobile'  => $image['pixerex_gallery_image_cell_mobile']['size'],
                        'vcells_mobile' => $image['pixerex_gallery_image_vcell_mobile']['size'],
                    ];
                    
                    $this->add_render_attribute( $key, 'data-metro', wp_json_encode( $cells )  );
                }
                
                if( $image['pixerex_gallery_video'] ) {
                    $this->add_render_attribute( $key, 'class', 'pixerex-gallery-video-item'  );
                }
                
            ?>
            <div <?php echo $this->get_render_attribute_string( $key ); ?>>
                <div class="pr-gallery-img <?php echo esc_attr( $skin ); ?>" onclick="">
                    <div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
                        <?php 
                            $video_link = $this->render_grid_item ( $image, $index );
                            
                            $image['video_link'] = $video_link;
                        if( 'style3' === $skin ) : ?>
                            <div class="pr-gallery-icons-wrapper">
                                <div class="pr-gallery-icons-inner-container">
                                    <?php $this->render_icons( $image, $index ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if( 'style2' !== $skin ) :
                        if( 'default' === $skin || 'style1' === $skin ) : ?>
                            <div class="pr-gallery-icons-wrapper">
                                <div class="pr-gallery-icons-inner-container">
                                    <?php $this->render_icons( $image, $index ); ?>
                                </div>
                            </div>
                        <?php 
                        endif;
                        $this->render_image_caption( $image );
                    else: ?>
                        <div class="pr-gallery-icons-caption-container">
                            <div class="pr-gallery-icons-caption-cell">
                                <?php 
                                        $this->render_icons( $image, $index );
                                        $this->render_image_caption( $image );
                                ?>
                            </div>
                        </div>
                    <?php endif;
                    if( $image['pixerex_gallery_video'] ) : ?>
                            </div>
                        </div>
                        <?php continue;
                    endif;
                        if( 'yes' === $image['pixerex_gallery_link_whole'] ) {

                            if( 'url' === $image['pixerex_gallery_img_link_type'] && ! empty( $image['pixerex_gallery_img_link']['url'] ) ) {

                                $icon_link  = $image['pixerex_gallery_img_link']['url'];
                                $external   = $image['pixerex_gallery_img_link']['is_external'] ? 'target="_blank"' : '';
                                $no_follow  = $image['pixerex_gallery_img_link']['nofollow'] ? 'rel="nofollow"' : '';

                            ?>
                                <a class="pr-gallery-whole-link" href="<?php echo esc_attr( $icon_link ); ?>" <?php echo $external; ?><?php echo $no_follow; ?>></a>

                            <?php } elseif( 'link' === $image['pixerex_gallery_img_link_type'] ) {
                                $icon_link = get_permalink( $image['pixerex_gallery_img_existing'] );
                            ?>
                                <a class="pr-gallery-whole-link" href="<?php echo esc_attr( $icon_link ); ?>"></a>
                            <?php }

                        } elseif ( 'yes' === $lightbox ) {

                            if( 'yes' === $image['pixerex_gallery_lightbox_whole'] ) {

                                $lightbox_key   = 'image_lightbox_' . $index;

                                $rel            = sprintf( 'prettyPhoto[pixerex-grid-%s]', $this->get_id() );

                                $this->add_render_attribute( $lightbox_key, [
                                    'class'     => 'pr-gallery-whole-link',
                                    'href'      => $image['pixerex_gallery_img']['url'],
                                ]);

                                if( 'default' !== $lightbox_type ) {
                                    $this->add_render_attribute( $lightbox_key, [
                                        'data-elementor-open-lightbox'      => $lightbox_type,
                                        'data-elementor-lightbox-slideshow' => $this->get_id()
                                    ]);
                                } else {
                                    $this->add_render_attribute( $lightbox_key, [
                                        'data-rel'  => $rel
                                    ]);
                                }

                                ?>

                                <a <?php echo $this->get_render_attribute_string( $lightbox_key ); ?>></a>

                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ( 'yes' === $settings['pixerex_gallery_load_more'] ) : ?>
            <div class="pixerex-gallery-load-more pixerex-gallery-btn-hidden">
                <button class="pixerex-gallery-load-more-btn">
                    <span><?php echo $settings['pixerex_gallery_load_more_text']; ?></span>
                    <div class="pixerex-loader"></div>
                </button>
            </div>
        <?php endif; ?>
        
    </div>
    
    <?php if( 'yes' === $settings['pixerex_gallery_responsive_switcher'] ) : ?>
        <style>
            @media( min-width: <?php echo $min_size; ?> ) and ( max-width:<?php echo $max_size; ?> ) {
                #pixerex-img-gallery-<?php echo esc_attr( $this->get_id() ); ?> .pixerex-gallery-caption {
                    display: none;
                }  
            }
        </style>
    <?php endif; ?>
        
    <?php }
    
    /*
     * Render Grid Image
     * 
     * Written in PHP and used to generate the final HTML for image.
     * 
     * @since 3.6.4
     * @access protected
     * 
     * @param array $item grid image repeater item
     * @param number $index item index
     */
    protected function render_grid_item( $item, $index ) {
        
        $settings   = $this->get_settings();
        
        $is_video   = $item['pixerex_gallery_video'];
        
        $alt        = Control_Media::get_image_alt( $item['pixerex_gallery_img'] );
        
        $key        = 'image_' . $index;
        
        if ( ! $is_video ) {
            if ( $settings['pixerex_gallery_img_size_select'] == 'fitRows' ) {
                $image_src = $item['pixerex_gallery_img'];
                $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'thumbnail', $settings);

                $image_src = empty( $image_src_size ) ? $image_src['url'] : $image_src_size;
                
            } else {
                $image_src = $item['pixerex_gallery_img']['url'];
            }
        } else {
            
            $image_src  = $item['pixerex_gallery_img']['url'];
            
            $type       = $item['pixerex_gallery_video_type'];
            
            if( 'hosted' !==  $type ) {
                $embed_params   = $this->get_embed_params( $item );
                $link           = Embed::get_embed_url( $item['pixerex_gallery_video_url'], $embed_params );
                
                if( empty( $image_src ) ) {
                    $video_props    = Embed::get_video_properties( $link );
                    $id             = $video_props['video_id'];
                    $type           = $video_props['provider'];
                    $size           = '';
                    if( 'youtube' === $type ) {
                        $size = $settings['pixerex_gallery_yt_thumbnail_size'];
                    }
                    $image_src = Helper_Functions::get_video_thumbnail( $id, $type, $size );
                }
                
            } else {
                $video_params = $this->get_hosted_params( $item );
            }
            
        }
        
        $this->add_render_attribute( $key, [
            'class' => 'pr-gallery-image',
            'src'   => $image_src,
            'alt'   => $alt
        ]);
        
        if ( $is_video ) {
        ?>
            <div class="pixerex-gallery-video-wrap" data-type="<?php echo $item['pixerex_gallery_video_type']; ?>">
                <?php if( 'hosted' !== $item['pixerex_gallery_video_type'] ) : ?>
                    <div class="pixerex-gallery-iframe-wrap" data-src="<?php echo $link; ?>"></div>
                <?php else: 
                    $link = empty( $item['pixerex_gallery_video_self_url'] ) ? $item['pixerex_gallery_video_self']['url'] : $item['pixerex_gallery_video_self_url'];
                ?>
                    <video src="<?php echo esc_url( $link ); ?>" <?php echo Utils::render_html_attributes( $video_params ); ?>></video>
                <?php endif; ?>
            </div>
        <?php } ?>
                
        <img <?php echo $this->get_render_attribute_string( $key ); ?>>    
        <?php
         
        return ( isset( $link ) && ! empty ( $link ) ) ? $link : false;
    }
    
    /*
     * Render Icons
     * 
     * Render Lightbox and URL Icons HTML
     * 
     * @since 3.6.4
     * @access protected
     * 
     * @param array $item grid image repeater item
     * @param number $index item index
     */
    protected function render_icons( $item, $index ) {
        
        $settings       = $this->get_settings_for_display();
        
        $lightbox_key   = 'image_lightbox_' . $index;
        
        $link_key       = 'image_link_' . $index;
        
        $href           = $item['pixerex_gallery_img']['url'];
        
        $rel            = sprintf( 'prettyPhoto[pixerex-grid-%s]', $this->get_id() );
        
        $lightbox       = $settings['pixerex_gallery_light_box'];
        
        $lightbox_type  = $settings['pixerex_gallery_lightbox_type'];
        
        $is_video       = $item['pixerex_gallery_video'];
        
        $id             = $this->get_id();
        
        if ( $is_video ) {
            
            $type = $item['pixerex_gallery_video_type'];
            
            $this->add_render_attribute( $lightbox_key, [
                'class'     => [
                    'pr-gallery-lightbox-wrap',
                    'pr-gallery-video-icon'
                ]
            ]);
            
            if( 'yes' === $lightbox ) {
                
                $lightbox_options = [
                    'type' => 'video',
                    'videoType' => $item['pixerex_gallery_video_type'],
                    'url' => $item['video_link'],
                    'modalOptions' => [
                        'id' => 'elementor-lightbox-' . $this->get_id(),
                        'videoAspectRatio' => '169',
                    ],
                ];
                
                if( 'hosted' === $type ) {
                    $lightbox_options['videoParams'] = $this->get_hosted_params( $item );
                }
                
                $this->add_render_attribute( $lightbox_key, [
                    'data-elementor-open-lightbox' => 'yes',
                    'data-elementor-lightbox' => wp_json_encode( $lightbox_options ),
                ] );
                
                
            }
            
        ?>
            <div <?php echo $this->get_render_attribute_string( $lightbox_key ); ?>>
                <a class="pr-gallery-magnific-image pr-gallery-video-icon">
                    <span>
                        <?php Icons_Manager::render_icon( $settings['pixerex_gallery_videos_icon'], [ 'aria-hidden' => 'true' ] );
                            ?>
                    </span>
                </a>
            </div>
        
        <?php
            return; 
        }
        
        if( 'yes' === $lightbox ) {
            
            if( 'yes' !== $item['pixerex_gallery_lightbox_whole'] ) {
                
                $this->add_render_attribute( $lightbox_key, [
                    'class'     => 'pr-gallery-magnific-image',
                    'href'      => $href,
                ]);

                if( 'default' !== $lightbox_type ) {
                    $this->add_render_attribute( $lightbox_key, [
                        'data-elementor-open-lightbox'      => $lightbox_type,
                        'data-elementor-lightbox-slideshow' => $id
                    ]);
                } else {
                    $this->add_render_attribute( $lightbox_key, [
                        'data-rel'  => $rel
                    ]);
                    
                }

                ?> 
                    <a <?php echo $this->get_render_attribute_string( $lightbox_key ); ?>>
                        <span>
                            <?php Icons_Manager::render_icon( $settings['pixerex_gallery_lightbox_icon'], [ 'aria-hidden' => 'true' ] );
                            ?>
                        </span>
                    </a>
            <?php
            }
        }
        

        if( ! empty( $item['pixerex_gallery_img_link']['url'] ) || ! empty ( $item['pixerex_gallery_img_existing'] ) ) {
            
            if( 'yes' !== $item['pixerex_gallery_link_whole'] ) {
                
                $icon_link = '';
                
                $this->add_render_attribute( $link_key, [
                    'class'     => 'pr-gallery-img-link',
                ]);

                if( 'url' === $item['pixerex_gallery_img_link_type'] && ! empty( $item['pixerex_gallery_img_link']['url'] ) ) {

                    $icon_link  = $item['pixerex_gallery_img_link']['url'];

                    $external   = $item['pixerex_gallery_img_link']['is_external'] ? '_blank' : '';

                    $no_follow  = $item['pixerex_gallery_img_link']['nofollow'] ? 'nofollow' : '';

                    $this->add_render_attribute( $link_key, [
                        'href'      => $icon_link,
                        'target'    => $external,
                        'rel'       => $no_follow
                    ]);

                } elseif( 'link' === $item['pixerex_gallery_img_link_type'] && ! empty( $item['pixerex_gallery_img_existing'] ) ) {

                    $icon_link = get_permalink( $item['pixerex_gallery_img_existing'] );

                    $this->add_render_attribute( $link_key, [
                        'href'      => $icon_link
                    ]);

                } 

                if ( ! empty ( $icon_link ) ) {
                ?>
                    <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                        <span>
                            <?php Icons_Manager::render_icon( $settings['pixerex_gallery_links_icon'], [ 'aria-hidden' => 'true' ] );
                            ?>
                        </span>
                    </a>
                <?php
                }
            }
        }
    }
    
    /*
     * Render Image Caption
     * 
     * Written in PHP to render the final HTML for image title and description
     * 
     * @since 3.6.4
     * @access proteced
     * 
     * @param array $item grid image repeater item
     */
    protected function render_image_caption( $item ) {
        
        $title          = $item['pixerex_gallery_img_name'];
        
        $description    = $item['pixerex_gallery_img_desc'];
            
        if( ! empty( $title ) || ! empty( $description ) ) : ?>
            <div class="pixerex-gallery-caption">
                
                <?php if( ! empty( $title ) ) : ?>
                    <span class="pixerex-gallery-img-name"><?php echo $title; ?></span>
                <?php endif;
                    
                if( ! empty( $description ) ) : ?>
                    <p class="pixerex-gallery-img-desc"><?php echo $description; ?></p>
                <?php endif; ?>
                    
            </div>
        <?php endif; 
    }
    
    /*
     * Get Hosted Videos Parameters
     * 
     * @since 3.7.0
     * @access private
     * 
     * @param array $item grid image repeater item
     */
    private function get_hosted_params( $item ) {
        
		$video_params = [];
        
        if ( $item[ 'pixerex_gallery_video_controls' ] ) {
            $video_params[ 'controls' ] = '';
        }

        if ( $item['pixerex_gallery_video_mute'] ) {
			$video_params['muted'] = 'muted';
		}
        
		return $video_params;
    }
    
    /*
     * Get embeded videos parameters
     * 
     * @since 3.7.0
     * @access private
     * 
     * @param array $item grid image repeater item
     */
    private function get_embed_params( $item ) {
        
		$video_params               = [];
        
        $video_params[ 'controls' ] = $item[ 'pixerex_gallery_video_controls' ] ? '1' : '0';
        
        $key                        = 'youtube' === $item[ 'pixerex_gallery_video_type' ] ? 'mute' : 'muted';
        
        $video_params[ $key ] = $item['pixerex_gallery_video_mute'] ? '1' : '0';
		
		return $video_params;
    }
    
    /*
     * Update Controls
     * 
     * @since 3.8.8
     * @access private
     * 
     * @param array $item grid image repeater item
     */
    private function update_controls() {
		
		$this->update_responsive_control( 'pixerex_gallery_img_border_radius',
			[
                'type'          => Controls_Manager::DIMENSIONS,
                'selectors'     => [
                    '{{WRAPPER}} .pr-gallery-img-container, {{WRAPPER}} .pr-gallery-img:not(.style2) .pr-gallery-icons-wrapper, {{WRAPPER}} .pr-gallery-img.style2 .pr-gallery-icons-caption-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
				
			]
		);
        
        $this->update_responsive_control( 'pixerex_gallery_content_border_radius',
			[
                'type'          => Controls_Manager::DIMENSIONS,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-gallery-caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
				
			]
		);

	}
}