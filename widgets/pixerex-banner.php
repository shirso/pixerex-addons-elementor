<?php

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Pixerex_Banner extends Widget_Base {

	protected $templateInstance;

	public function getTemplateInstance() {
		return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
	}

	public function get_name() {
		return 'pixerex-elements-banner';
	}

	public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Banner', 'pixerex-elements') );
	}

	public function get_icon() {
		return 'eicon-banner';
	}
    
	public function get_categories() {
		return [ 'pixerex-elements'];
	}
    
    public function get_style_depends() {
        return [
            'pixerex-elements'
        ];
    }
    
    public function get_script_depends() {
        return ['pixerex-elements-js'];
    }

	// Adding the controls fields for the banner
	// This will controls the animation, colors and background, dimensions etc
	protected function _register_controls() {

		$this->start_controls_section('pixerex_banner_global_settings',
			[
				'label'         => __( 'Image', 'pixerex-elements' )
			]
		);
        
        $this->add_control('pixerex_banner_image',
			[
				'label'			=> __( 'Upload Image', 'pixerex-elements' ),
				'description'	=> __( 'Select an image for the Banner', 'pixerex-elements' ),
				'type'			=> Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
				'default'		=> [
					'url'	=> Utils::get_placeholder_image_src()
				],
				'show_external'	=> true
			]
		);
        
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'          => 'thumbnail',
				'default'       => 'full',
				'separator'     => 'none',
			]
		);
        
        $this->add_control('pixerex_banner_link_url_switch',
            [
                'label'         => __('Link', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );

		$this->add_control('pixerex_banner_image_link_switcher',
			[
				'label'			=> __( 'Custom Link', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Add a custom link to the banner', 'pixerex-elements' ),
                'condition'     => [
                    'pixerex_banner_link_url_switch'    => 'yes',
                ],
			]
		);
        
        $this->add_control('pixerex_banner_image_custom_link',
			[
				'label'			=> __( 'Set custom Link', 'pixerex-elements' ),
				'type'			=> Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'What custom link you want to set to banner?', 'pixerex-elements' ),
				'condition'		=> [
					'pixerex_banner_image_link_switcher' => 'yes',
                    'pixerex_banner_link_url_switch'    => 'yes'
				],
				'show_external' => false
			]
		);

		$this->add_control('pixerex_banner_image_existing_page_link',
			[
				'label'			=> __( 'Existing Page', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT2,
				'condition'		=> [
					'pixerex_banner_image_link_switcher!' => 'yes',
                    'pixerex_banner_link_url_switch'    => 'yes'
				],
                'label_block'   => true,
                'multiple'      => false,
				'options'		=> $this->getTemplateInstance()->get_all_post()
			]
		);
        
        $this->add_control('pixerex_banner_link_title',
			[
				'label'			=> __( 'Link Title', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'pixerex_banner_link_url_switch'    => 'yes'
                ]
			]
		);
        

		$this->add_control('pixerex_banner_image_link_open_new_tab',
			[
				'label'			=> __( 'New Tab', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Choose if you want the link be opened in a new tab or not', 'pixerex-elements' ),
                'condition'     => [
                    'pixerex_banner_link_url_switch'    => 'yes'
                ]
			]
		);

		$this->add_control('pixerex_banner_image_link_add_nofollow',
			[
				'label'			=> __( 'Nofollow Option', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __('if you choose yes, the link will not be counted in search engines', 'pixerex-elements' ),
                'condition'     => [
                    'pixerex_banner_link_url_switch'    => 'yes'
                ]
			]
		);
        
        $this->add_control('pixerex_banner_image_animation',
			[
				'label'			=> __( 'Effect', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'animation1',
				'description'	=> __( 'Choose a hover effect for the banner', 'pixerex-elements' ),
				'options'		=> [
					'animation1'		=> __('Effect 1', 'pixerex-elements'),
					'animation5'		=> __('Effect 2', 'pixerex-elements'),
					'animation13'       => __('Effect 3', 'pixerex-elements'),
					'animation2'		=> __('Effect 4', 'pixerex-elements'),
					'animation4'		=> __('Effect 5', 'pixerex-elements'),
					'animation6'		=> __('Effect 6', 'pixerex-elements')
				]
			]
		);
        
        $this->add_control('pixerex_banner_active',
			[
				'label'			=> __( 'Always Hovered', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Choose if you want the effect to be always triggered', 'pixerex-elements' )
			]
		);
        
        $this->add_control('pixerex_banner_hover_effect',
            [
                'label'         => __('Hover Effect', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'none'          => __('None', 'pixerex-elements'),
                    'zoomin'        => __('Zoom In', 'pixerex-elements'),
                    'zoomout'       => __('Zoom Out', 'pixerex-elements'),
                    'scale'         => __('Scale', 'pixerex-elements'),
                    'grayscale'     => __('Grayscale', 'pixerex-elements'),
                    'blur'          => __('Blur', 'pixerex-elements'),
                    'bright'        => __('Bright', 'pixerex-elements'),
                    'sepia'         => __('Sepia', 'pixerex-elements'),
                ],
                'default'       => 'none',
            ]
        );
        
        $this->add_control('pixerex_banner_height',
			[
				'label'			=> __( 'Height', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
                'options'		=> [
					'default'		=> __('Default', 'pixerex-elements'),
					'custom'		=> __('Custom', 'pixerex-elements')
				],
				'default'		=> 'default',
				'description'	=> __( 'Choose if you want to set a custom height for the banner or keep it as it is', 'pixerex-elements' )
			]
		);
        
		$this->add_responsive_control('pixerex_banner_custom_height',
			[
				'label'			=> __( 'Min Height', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> __( 'Set a minimum height value in pixels', 'pixerex-elements' ),
				'condition'		=> [
					'pixerex_banner_height' => 'custom'
				],
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-banner-ib' => 'height: {{VALUE}}px;'
				]
			]
		);
        
        $this->add_responsive_control('pixerex_banner_img_vertical_align',
			[
				'label'			=> __( 'Vertical Align', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'condition'		=> [
					'pixerex_banner_height' => 'custom'
				],
                'options'		=> [
					'flex-start'	=> __('Top', 'pixerex-elements'),
                    'center'		=> __('Middle', 'pixerex-elements'),
					'flex-end'		=> __('Bottom', 'pixerex-elements'),
                    'inherit'		=> __('Full', 'pixerex-elements')
				],
                'default'       => 'flex-start',
				'selectors'		=> [
					'{{WRAPPER}} .pixerex-banner-img-wrap' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};'
				]
			]
		);
     
		$this->add_control('pixerex_banner_extra_class',
			[
				'label'			=> __( 'Extra Class', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'description'	=> __( 'Add extra class name that will be applied to the banner, and you can use this class for your customizations.', 'pixerex-elements' )
			]
		);

		
		$this->end_controls_section();

		$this->start_controls_section('pixerex_banner_image_section',
  			[
  				'label' => __( 'Content', 'pixerex-elements' )
  			]
  		);
        
        $this->add_control('pixerex_banner_title',
			[
				'label'			=> __( 'Title', 'pixerex-elements' ),
				'placeholder'	=> __( 'Give a title to this banner', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __( 'Pixerex Banner', 'pixerex-elements' ),
				'label_block'	=> false
			]
		);
        
        $this->add_control('pixerex_banner_title_tag',
			[
				'label'			=> __( 'HTML Tag', 'pixerex-elements' ),
				'description'	=> __( 'Select a heading tag for the title. Headings are defined with H1 to H6 tags', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'h3',
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
        
        
        $this->add_control('pixerex_banner_description_hint',
			[
				'label'			=> __( 'Description', 'pixerex-elements' ),
				'type'			=> Controls_Manager::HEADING,
			]
		);
        
        $this->add_control('pixerex_banner_description',
			[
				'label'			=> __( 'Description', 'pixerex-elements' ),
				'description'	=> __( 'Give the description to this banner', 'pixerex-elements' ),
				'type'			=> Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __( 'Pixerex Banner gives you a wide range of styles and options that you will definitely fall in love with', 'pixerex-elements' ),
				'label_block'	=> true
			]
		);
        
        $this->add_control('pixerex_banner_link_switcher',
            [
                'label'         => __('Button', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'pixerex_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );

        
        $this->add_control('pixerex_banner_more_text', 
            [
                'label'         => __('Text','pixerex-elements'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'Click Here',
                'condition'     => [
                    'pixerex_banner_link_switcher'    => 'yes',
                    'pixerex_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_banner_link_selection',
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
                    'pixerex_banner_link_switcher'    => 'yes',
                    'pixerex_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );

        $this->add_control('pixerex_banner_link',
            [
                'label'         => __('Link', 'pixerex-elements'),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://www.google.com/',
                'label_block'   => true,
                'condition'     => [
                    'pixerex_banner_link_selection' => 'url',
                    'pixerex_banner_link_switcher'    => 'yes',
                    'pixerex_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('pixerex_banner_existing_link',
            [
                'label'         => __('Existing Page', 'pixerex-elements'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_post(),
                'multiple'      => false,
                'condition'     => [
                    'pixerex_banner_link_selection'     => 'link',
                    'pixerex_banner_link_switcher'    => 'yes',
                    'pixerex_banner_link_url_switch!'   => 'yes'
                ],
                'label_block'   => true
            ]
        );
        
        
        $this->add_control('pixerex_banner_title_text_align', 
            [
                'label'         => __('Alignment', 'pixerex-elements'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'  => [
                        'title'     => __('Left', 'pixerex-elements'),
                        'icon'      => 'fa fa-align-left'
                    ],
                    'center'  => [
                        'title'     => __('Center', 'pixerex-elements'),
                        'icon'      => 'fa fa-align-center'
                    ],
                    'right'  => [
                        'title'     => __('Right', 'pixerex-elements'),
                        'icon'      => 'fa fa-align-right'
                    ],
                ],
                'default'       => 'left',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner-ib-title, {{WRAPPER}} .pixerex-banner-ib-content, {{WRAPPER}} .pixerex-banner-read-more'   => 'text-align: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_banner_responsive_section',
            [
                'label'         => __('Responsive', 'pixerex-elements'),
            ]
        );
        
        $this->add_control('pixerex_banner_responsive_switcher',
            [
                'label'         => __('Responsive Controls', 'pixerex-elements'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('If the description text is not suiting well on specific screen sizes, you may enable this option which will hide the description text.', 'pixerex-elements')
            ]
        );
        
        $this->add_control('pixerex_banner_min_range', 
            [
                'label'     => __('Minimum Size', 'pixerex-elements'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: minimum size for extra small screens is 1px.','pixerex-elements'),
                'default'   => 1,
                'condition' => [
                    'pixerex_banner_responsive_switcher'    => 'yes'
                ],
            ]
        );

        $this->add_control('pixerex_banner_max_range', 
            [
                'label'     => __('Maximum Size', 'pixerex-elements'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: maximum size for extra small screens is 767px.','pixerex-elements'),
                'default'   => 767,
                'condition' => [
                    'pixerex_banner_responsive_switcher'    => 'yes'
                ],
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_banner_opacity_style',
			[
				'label' 		=> __( 'Image', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_control('pixerex_banner_image_bg_color',
			[
				'label' 		=> __( 'Background Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .pixerex-banner-ib' => 'background: {{VALUE}};'
				]
			]
		);
        
		$this->add_control('pixerex_banner_image_opacity',
			[
				'label' => __( 'Image Opacity', 'pixerex-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
				'range' => [
					'px' => [
		                'min' => 0,
		                'max' => 1,
		                'step' => .1
		            ]
				],
				'selectors' => [
		            '{{WRAPPER}} .pixerex-banner-ib img' => 'opacity: {{SIZE}};'
		        ]
			]
		);

		$this->add_control('pixerex_banner_image_hover_opacity',
			[
				'label' => __( 'Hover Opacity', 'pixerex-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
				'range' => [
					'px' => [
		                'min' => 0,
		                'max' => 1,
		                'step' => .1
		            ]
				],
				'selectors' => [
		            '{{WRAPPER}} .pixerex-banner-ib img.active' => 'opacity: {{SIZE}};'
		        ]
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .pixerex-banner-ib img',
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filter', 'pixerex-elements'),
				'selector'  => '{{WRAPPER}} .pixerex-banner-ib img.active'
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_banner_image_border',
                'selector'      => '{{WRAPPER}} .pixerex-banner-ib'
            ]
        );

		$this->add_responsive_control(
			'pixerex_banner_image_border_radius',
			[
				'label' => __( 'Border Radius', 'pixerex-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'selectors' => [
		            '{{WRAPPER}} .pixerex-banner-ib' => 'border-radius: {{SIZE}}{{UNIT}};'
		        ]
			]
		);
        
        $this->add_control('blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => __( 'Normal', 'elementor' ),
					'multiply'      => 'Multiply',
					'screen'        => 'Screen',
					'overlay'       => 'Overlay',
					'darken'        => 'Darken',
					'lighten'       => 'Lighten',
					'color-dodge'   => 'Color Dodge',
					'saturation'    => 'Saturation',
					'color'         => 'Color',
					'luminosity'    => 'Luminosity',
				],
                'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner-ib' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('pixerex_banner_title_style',
			[
				'label' 		=> __( 'Title', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('pixerex_banner_color_of_title',
			[
				'label' => __( 'Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner-ib-desc .pixerex_banner_title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pixerex_banner_title_typography',
				'selector' => '{{WRAPPER}} .pixerex-banner-ib-desc .pixerex_banner_title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1
			]
		);
        
        $this->add_control('pixerex_banner_style2_title_bg',
			[
				'label'			=> __( 'Background', 'pixerex-elements' ),
				'type'			=> Controls_Manager::COLOR,
				'default'       => '#f2f2f2',
				'description'	=> __( 'Choose a background color for the title', 'pixerex-elements' ),
				'condition'		=> [
					'pixerex_banner_image_animation' => 'animation5'
				],
				'selectors'     => [
				    '{{WRAPPER}} .pixerex-banner-animation5 .pixerex-banner-ib-desc'    => 'background: {{VALUE}};',
			    ]
			]
		);

		$this->add_control('pixerex_banner_style3_title_border',
			[
				'label'			=> __( 'Title Border Color', 'pixerex-elements' ),
				'type'			=> Controls_Manager::COLOR,
				'condition'		=> [
					'pixerex_banner_image_animation' => 'animation13'
				],
				'selectors'     => [
				    '{{WRAPPER}} .pixerex-banner-animation13 .pixerex-banner-ib-title::after'    => 'background: {{VALUE}};',
			    ]
			]
		);

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','pixerex-elements'),
                'name'              => 'pixerex_banner_title_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-banner-ib-desc .pixerex_banner_title'
            ]
        );
        
        $this->add_responsive_control('pixerex_banner_title_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner-ib-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section('pixerex_banner_styles_of_content',
			[
				'label' 		=> __( 'Description', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('pixerex_banner_color_of_content',
			[
				'label' => __( 'Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner .pixerex_banner_content' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_banner_content_typhography',
				'selector'      => '{{WRAPPER}} .pixerex-banner .pixerex_banner_content',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control('pixerex_banner_scaled_border_color',
			[
				'label' => __( 'Inner Border Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'condition'		=> [
					'pixerex_banner_image_animation' => ['animation4', 'animation6']
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner-animation4 .pixerex-banner-ib-desc::after, {{WRAPPER}} .pixerex-banner-animation4 .pixerex-banner-ib-desc::before, {{WRAPPER}} .pixerex-banner-animation6 .pixerex-banner-ib-desc::before' => 'border-color: {{VALUE}};'
				],
			]
		);

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','pixerex-elements'),
                'name'              => 'pixerex_banner_description_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-banner .pixerex_banner_content',
            ]
        );
        
        $this->add_responsive_control('pixerex_banner_desc_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner-ib-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_banner_styles_of_button',
			[
				'label' 		=> __( 'Button', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_banner_link_switcher'   => 'yes',
                    'pixerex_banner_link_url_switch!'   => 'yes'
                ]
			]
		);

		$this->add_control('pixerex_banner_color_of_button',
			[
				'label' => __( 'Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner .pixerex-banner-link' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control('pixerex_banner_hover_color_of_button',
			[
				'label' => __( 'Hover Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner .pixerex-banner-link:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'pixerex_banner_button_typhography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_3,
				'selector'      => '{{WRAPPER}} .pixerex-banner-link',
			]
		);
        
        $this->add_control('pixerex_banner_backcolor_of_button',
			[
				'label' => __( 'Background Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner .pixerex-banner-link' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control('pixerex_banner_hover_backcolor_of_button',
			[
				'label' => __( 'Hover Background Color', 'pixerex-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pixerex-banner .pixerex-banner-link:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_banner_button_border',
                'selector'      => '{{WRAPPER}} .pixerex-banner .pixerex-banner-link'
            ]
        );
        
        $this->add_control('pixerex_banner_button_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner-link' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow','pixerex-elements'),
                'name'              => 'pixerex_banner_button_shadow',
                'selector'          => '{{WRAPPER}} .pixerex-banner .pixerex-banner-link',
            ]
        );
        
        $this->add_responsive_control('pixerex_banner_button_margin',
            [
                'label'         => __('Margin', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('pixerex_banner_button_padding',
            [
                'label'         => __('Padding', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section('pixerex_banner_container_style',
			[
				'label' 		=> __( 'Container', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_banner_border',
                'selector'      => '{{WRAPPER}} .pixerex-banner'
            ]
        );
        
        $this->add_control('pixerex_banner_border_radius',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .pixerex-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'pixerex_banner_shadow',
                'selector'      => '{{WRAPPER}} .pixerex-banner',
            ]
        );
        
        $this->end_controls_section();

	}


	protected function render() {
        
			$settings 	= $this->get_settings_for_display();
            
            $this->add_inline_editing_attributes('pixerex_banner_title');
            $this->add_render_attribute('pixerex_banner_title', 'class', array(
                'pixerex-banner-ib-title',
                'pixerex_banner_title'
            ));
            
            $this->add_inline_editing_attributes('pixerex_banner_description', 'advanced');

			$title_tag 	= $settings[ 'pixerex_banner_title_tag' ];
			$title 		= $settings[ 'pixerex_banner_title' ];
			$full_title = '<div class="pixerex-banner-title-wrap"><'. $title_tag . ' ' . $this->get_render_attribute_string('pixerex_banner_title') .'>' .$title. '</'.$title_tag.'></div>';

			$link = 'yes' == $settings['pixerex_banner_image_link_switcher'] ? $settings['pixerex_banner_image_custom_link']['url'] : get_permalink( $settings['pixerex_banner_image_existing_page_link'] );

			$link_title = $settings['pixerex_banner_link_url_switch'] === 'yes' ? $settings['pixerex_banner_link_title'] : '';
            
			$open_new_tab = $settings['pixerex_banner_image_link_open_new_tab'] == 'yes' ? ' target="_blank"' : '';
            $nofollow_link = $settings['pixerex_banner_image_link_add_nofollow'] == 'yes' ? ' rel="nofollow"' : '';
			$full_link = '<a class="pixerex-banner-ib-link" href="'. $link .'" title="'. $link_title .'"'. $open_new_tab . $nofollow_link . '></a>';
			$animation_class = 'pixerex-banner-' . $settings['pixerex_banner_image_animation'];
            $hover_class = ' ' . $settings['pixerex_banner_hover_effect'];
			$extra_class = ! empty( $settings['pixerex_banner_extra_class'] ) ? ' '. $settings['pixerex_banner_extra_class'] : '';
			$active = $settings['pixerex_banner_active'] == 'yes' ? ' active' : '';
			$full_class = $animation_class.$hover_class.$extra_class.$active;
            $min_size = $settings['pixerex_banner_min_range'] .'px';
            $max_size = $settings['pixerex_banner_max_range'] .'px';


            $banner_url = 'url' == $settings['pixerex_banner_link_selection'] ? $settings['pixerex_banner_link']['url'] : get_permalink($settings['pixerex_banner_existing_link']);
            
            $image_html = '';
            if ( ! empty( $settings['pixerex_banner_image']['url'] ) ) {
                
                $this->add_render_attribute( 'image', 'src', $settings['pixerex_banner_image']['url'] );
                $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['pixerex_banner_image'] ) );
                
                $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['pixerex_banner_image'] ) );

                $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'pixerex_banner_image' );
                
            }
            
        ?>
            <div class="pixerex-banner" id="pixerex-banner-<?php echo esc_attr($this->get_id()); ?>">
				<div class="pixerex-banner-ib <?php echo $full_class; ?> pixerex-banner-min-height">
					<?php if( ! empty(  $settings['pixerex_banner_image']['url'] ) ) : ?>
                        <?php if( $settings['pixerex_banner_height'] == 'custom' ) : ?>
                            <div class="pixerex-banner-img-wrap">
                        <?php endif;
                            echo $image_html;
                        if( $settings['pixerex_banner_height'] == 'custom' ): ?>
                            </div>
                        <?php endif;
					endif; ?>
					<div class="pixerex-banner-ib-desc">
						<?php echo $full_title;
                        if( ! empty( $settings['pixerex_banner_description'] ) ) : ?>
                            <div class="pixerex-banner-ib-content pixerex_banner_content">
                                <div <?php echo $this->get_render_attribute_string('pixerex_banner_description'); ?>><?php echo $settings[ 'pixerex_banner_description' ]; ?></div>
                            </div>
                        <?php endif;
                    if( 'yes' == $settings['pixerex_banner_link_switcher'] && !empty( $settings['pixerex_banner_more_text'] ) ) : ?>
                        
                            <div class ="pixerex-banner-read-more">
                                <a class = "pixerex-banner-link" <?php if( !empty( $banner_url ) ) : ?> href="<?php echo esc_url( $banner_url ); ?>"<?php endif;?><?php if( !empty( $settings['pixerex_banner_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if( !empty($settings['pixerex_banner_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>><?php echo esc_html( $settings['pixerex_banner_more_text'] ); ?></a>
                            </div>
                        
                    <?php endif; ?>
					</div>
					<?php 
						if( $settings['pixerex_banner_link_url_switch'] == 'yes' && ( ! empty( $settings['pixerex_banner_image_custom_link']['url'] ) || !empty( $settings['pixerex_banner_image_existing_page_link'] ) ) ) {
							echo $full_link;
						}
					 ?>
				</div>
                <?php if($settings['pixerex_banner_responsive_switcher'] == 'yes' ) : ?>
                <style>
                    @media( min-width: <?php echo $min_size; ?> ) and (max-width:<?php echo $max_size; ?> ) {
                    #pixerex-banner-<?php echo esc_attr( $this->get_id() ); ?> .pixerex-banner-ib-content {
                        display: none;
                        }  
                    }
                </style>
                <?php endif; ?>
			</div>
		<?php
	}

	protected function _content_template() {
        ?>
        <#

            view.addRenderAttribute( 'banner', 'id', 'pixerex-banner-' + view.getID() );
            view.addRenderAttribute( 'banner', 'class', 'pixerex-banner' );
            
            var active = 'yes' === settings.pixerex_banner_active ? 'active' : '';
            
            view.addRenderAttribute( 'banner_inner', 'class', [
                'pixerex-banner-ib',
                'pixerex-banner-min-height',
                'pixerex-banner-' + settings.pixerex_banner_image_animation,
                settings.pixerex_banner_hover_effect,
                settings.pixerex_banner_extra_class,
                active
            ] );
            
            var titleTag = settings.pixerex_banner_title_tag,
                title    = settings.pixerex_banner_title;
                
            view.addRenderAttribute( 'pixerex_banner_title', 'class', [
                'pixerex-banner-ib-title',
                'pixerex_banner_title'
            ] );
            
            view.addInlineEditingAttributes( 'pixerex_banner_title' );
            
            var description = settings.pixerex_banner_description;
            
            view.addInlineEditingAttributes( 'description', 'advanced' );
            
            var linkSwitcher = settings.pixerex_banner_link_switcher,
                readMore     = settings.pixerex_banner_more_text,
                bannerUrl    = 'url' === settings.pixerex_banner_link_selection ? settings.pixerex_banner_link.url : settings.pixerex_banner_existing_link;
                
            var bannerLink = 'yes' === settings.pixerex_banner_image_link_switcher ? settings.pixerex_banner_image_custom_link.url : settings.pixerex_banner_image_existing_page_link,
                linkTitle = 'yes' === settings.pixerex_banner_link_url_switch ? settings.pixerex_banner_link_title : '';
                
            var minSize = settings.pixerex_banner_min_range + 'px',
                maxSize = settings.pixerex_banner_max_range + 'px';
                
            var imageHtml = '';
            if ( settings.pixerex_banner_image.url ) {
                var image = {
                    id: settings.pixerex_banner_image.id,
                    url: settings.pixerex_banner_image.url,
                    size: settings.thumbnail_size,
                    dimension: settings.thumbnail_custom_dimension,
                    model: view.getEditModel()
                };

                var image_url = elementor.imagesManager.getImageUrl( image );

                imageHtml = '<img src="' + image_url + '"/>';

            }
        #>
        
            <div {{{ view.getRenderAttributeString( 'banner' ) }}}>
				<div {{{ view.getRenderAttributeString( 'banner_inner' ) }}}>
					<# if( '' !== settings.pixerex_banner_image.url ) { #>
                        <# if( 'custom' === settings.pixerex_banner_height ) { #>
                            <div class="pixerex-banner-img-wrap">
                        <# } #>
                            {{{imageHtml}}}
                        <# if( 'custom' === settings.pixerex_banner_height ) { #>
                            </div>
                        <# } #>
                    <# } #>
					<div class="pixerex-banner-ib-desc">
                        <# if( '' !== title ) { #>
                            <div class="pixerex-banner-title-wrap">
                                <{{{titleTag}}} {{{ view.getRenderAttributeString('pixerex_banner_title') }}}>{{{ title }}}</{{{titleTag}}}>
                            </div>
                        <# } #>
                        <# if( '' !== description ) { #>
                            <div class="pixerex-banner-ib-content pixerex_banner_content">
                                <div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ description }}}</div>
                            </div>
                        <# } #>
                    <# if( 'yes' === linkSwitcher && '' !== readMore ) { #>
                        <div class ="pixerex-banner-read-more">
                            <a class = "pixerex-banner-link" href="{{ bannerUrl }}">{{{ readMore }}}</a>
                        </div>
                    <# } #>
					</div>
					<# if( 'yes' === settings.pixerex_banner_link_url_switch  && ( '' !== settings.pixerex_banner_image_custom_link.url || '' !== settings.pixerex_banner_image_existing_page_link ) ) { #>
							<a class="pixerex-banner-ib-link" href="{{ bannerLink }}" title="{{ linkTitle }}"></a>
                    <# } #>
				</div>
                <# if( 'yes' === settings.pixerex_banner_responsive_switcher ) { #>
                <style>
                    @media( min-width: {{minSize}} ) and ( max-width: {{maxSize}} ) {
                        #pixerex-banner-{{ view.getID() }} .pixerex-banner-ib-content {
                            display: none;
                        }  
                    }
                </style>
                <# } #>
            </div>
        
        
        <?php
	}
}