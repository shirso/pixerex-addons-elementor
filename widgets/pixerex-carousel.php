<?php 

namespace PixerexElements\Widgets;

use PixerexElements\Helper_Functions;
use PixerexElements\Includes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;

if( ! defined( 'ABSPATH' ) ) exit; // No access of directly access

class Pixerex_Carousel extends Widget_Base {

    protected $templateInstance;

	public function getTemplateInstance() {
		return $this->templateInstance = Includes\pixerex_Template_Tags::getInstance();
	}

	public function get_name() {
		return 'pixerex-carousel-widget';
	}

	public function get_title() {
        return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Carousel', 'pixerex-elements') );
	}

	public function get_icon() {
		return 'pa-carousel';
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
            'jquery-slick',
            'pixerex-elements-js',
        ];
	}

	public function get_categories() {
		return [ 'pixerex-elements'];
	}
    
    // Adding the controls fields for the carousel widget
    // This will controls the animation, colors and background, dimensions etc
	protected function _register_controls() {
		$this->start_controls_section('pixerex_carousel_global_settings',
			[
				'label'         => __( 'Carousel' , 'pixerex-elements' )
			]
		);
        
        $this->add_control('pixerex_carousel_content_type',
			[
				'label'			=> __( 'Content Type', 'pixerex-elements' ),
				'description'	=> __( 'How templates are selected', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'options'		=> [
					'select'        => __( 'Select Field', 'pixerex-elements' ),
					'repeater'		=> __( 'Repeater', 'pixerex-elements' )
				],
                'default'		=> 'select'
			]
		);

		$this->add_control('pixerex_carousel_slider_content',
		  	[
		     	'label'         => __( 'Templates', 'pixerex-elements' ),
		     	'description'	=> __( 'Slider content is a template which you can choose from Elementor library. Each template will be a slider content', 'pixerex-elements' ),
		     	'type'          => Controls_Manager::SELECT2,
		     	'options'       => $this->getTemplateInstance()->get_elementor_page_list(),
		     	'multiple'      => true,
                'label_block'   => true,
                'condition'     => [
                    'pixerex_carousel_content_type' => 'select'
                ]
		  	]
		);
        
        $repeater = new REPEATER();
        
        $repeater->add_control('pixerex_carousel_repeater_item',
            [
                'label'         => __( 'Content', 'pixerex-elements' ),
                'type'          => Controls_Manager::SELECT2,
                'label_block'   => true,
                'options'       => $this->getTemplateInstance()->get_elementor_page_list()
            ]
        );
        
        $this->add_control('pixerex_carousel_templates_repeater',
            [
                'label'         => __('Templates', 'pixerex-elements'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => array_values( $repeater->get_controls() ),
                'condition'     => [
                    'pixerex_carousel_content_type' => 'repeater'
                ],
                'title_field'   => 'Template: {{{ pixerex_carousel_repeater_item }}}'
            ]
        );


		$this->add_control('pixerex_carousel_slider_type',
			[
				'label'			=> __( 'Type', 'pixerex-elements' ),
				'description'	=> __( 'Set a navigation type', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'options'		=> [
					'horizontal'	=> __( 'Horizontal', 'pixerex-elements' ),
					'vertical'		=> __( 'Vertical', 'pixerex-elements' )
				],
                'default'		=> 'horizontal'
			]
		);
        
        $this->add_control('pixerex_carousel_dot_navigation_show',
			[
				'label'			=> __( 'Dots', 'pixerex-elements' ),
				'description'	=> __( 'Enable or disable navigation dots', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
                'separator'     => 'before',
				'default'		=> 'yes'
			]
		);
        
        $this->add_control('pixerex_carousel_dot_position',
			[
				'label'			=> __( 'Position', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'below',
				'options'		=> [
					'below'         => __( 'Below Slides', 'pixerex-elements' ),
					'above'         => __( 'On Slides', 'pixerex-elements' )
				],
                'condition'     => [
                    'pixerex_carousel_dot_navigation_show'  => 'yes'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_carousel_dot_offset',
			[
				'label'             => __( 'Horizontal Offset', 'pixerex-elements' ),
				'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', 'em', '%'],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-carousel-dots-above ul.slick-dots' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition'     => [
                    'pixerex_carousel_dot_navigation_show'  => 'yes',
                    'pixerex_carousel_dot_position'         => 'above'
                ]
			]
		);
        
        $this->add_responsive_control('pixerex_carousel_dot_voffset',
			[
				'label'             => __( 'Vertical Offset', 'pixerex-elements' ),
				'type'              => Controls_Manager::SLIDER,
                'size_units'        => ['px', 'em', '%'],
                'default'           => [
                    'unit'  => '%',
                    'size'  => 50
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pixerex-carousel-dots-above ul.slick-dots' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition'     => [
                    'pixerex_carousel_dot_navigation_show'  => 'yes',
                    'pixerex_carousel_dot_position'         => 'above'
                ]
			]
		);
        
        $this->add_control('pixerex_carousel_navigation_effect',
			[
				'label' 		=> __( 'Ripple Effect', 'pixerex-elements' ),
				'description'	=> __( 'Enable a ripple effect when the active dot is hovered/clicked', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
                'prefix_class'  => 'pixerex-carousel-ripple-',
                'condition'		=> [
					'pixerex_carousel_dot_navigation_show' => 'yes'
				],
			]
		);
        
        $this->add_control('pixerex_carousel_navigation_show',
			[
				'label'			=> __( 'Arrows', 'pixerex-elements' ),
				'description'	=> __( 'Enable or disable navigation arrows', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
                'separator'     => 'before',
				'default'		=> 'yes'
			]
		);

		$this->add_control('pixerex_carousel_slides_to_show',
			[
				'label'			=> __( 'Appearance', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'all',
                'separator'     => 'before',
				'options'		=> [
					'all'			=> __( 'All visible', 'pixerex-elements' ),
					'single'		=> __( 'One at a time', 'pixerex-elements' )
				]
			]
		);

		$this->add_control('pixerex_carousel_responsive_desktop',
			[
				'label'			=> __( 'Desktop Slides', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 1
			]
		);

		$this->add_control('pixerex_carousel_responsive_tabs',
			[
				'label'			=> __( 'Tabs Slides', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 1
			]
		);

		$this->add_control('pixerex_carousel_responsive_mobile',
			[
				'label'			=> __( 'Mobile Slides', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 1
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section('pixerex_carousel_slides_settings',
			[
				'label' => __( 'Slides\' Settings' , 'pixerex-elements' )
			]
		);
        
		$this->add_control('pixerex_carousel_loop',
			[
				'label'			=> __( 'Infinite Loop', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
                'description'   => __( 'Restart the slider automatically as it passes the last slide', 'pixerex-elements' ),
				'default'		=> 'yes'
			]
		);

		$this->add_control('pixerex_carousel_fade',
			[
				'label'			=> __( 'Fade', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
                'description'   => __( 'Enable fade transition between slides', 'pixerex-elements' ),
                'condition'     => [
                    'pixerex_carousel_slider_type'      => 'horizontal',
                ]
			]
		);

		$this->add_control('pixerex_carousel_zoom',
			[
				'label'			=> __( 'Zoom Effect', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'condition'		=> [
					'pixerex_carousel_fade'	=> 'yes',
                    'pixerex_carousel_slider_type'      => 'horizontal',
				]
			]
		);

		$this->add_control('pixerex_carousel_speed',
			[
				'label'			=> __( 'Transition Speed', 'pixerex-elements' ),
				'description'	=> __( 'Set a navigation speed value. The value will be counted in milliseconds (ms)', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 300
			]
		);

		$this->add_control('pixerex_carousel_autoplay',
			[
				'label'			=> __( 'Autoplay Slides‏', 'pixerex-elements' ),
				'description'	=> __( 'Slide will start automatically', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'default'		=> 'yes'
			]
		);

		$this->add_control('pixerex_carousel_autoplay_speed',
			[
				'label'			=> __( 'Autoplay Speed', 'pixerex-elements' ),
				'description'	=> __( 'Autoplay Speed means at which time the next slide should come. Set a value in milliseconds (ms)', 'pixerex-elements' ),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 5000,
				'condition'		=> [
					'pixerex_carousel_autoplay' => 'yes'
				],
				'separator'		=> 'after'
			]
		);

        $this->add_control('pixerex_carousel_animation_list', 
            [
                'label'         => __('Animations', 'pixerex-elements'),
                'type'          => Controls_Manager::ANIMATION,
                'render_type'   => 'template'
            ]
            );

		$this->add_control('pixerex_carousel_extra_class',
			[
				'label'			=> __( 'Extra Class', 'pixerex-elements' ),
				'type'			=> Controls_Manager::TEXT,
                'description'	=> __( 'Add extra class name that will be applied to the carousel, and you can use this class for your customizations.', 'pixerex-elements' ),
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section('pixerex-carousel-advance-settings',
			[
				'label'         => __( 'Additional Settings' , 'pixerex-elements' ),
			]
		);

		$this->add_control('pixerex_carousel_draggable_effect',
			[
				'label' 		=> __( 'Draggable Effect', 'pixerex-elements' ),
				'description'	=> __( 'Allow the slides to be dragged by mouse click', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'default'		=> 'yes'
			]
		);

		$this->add_control('pixerex_carousel_touch_move',
			[
				'label' 		=> __( 'Touch Move', 'pixerex-elements' ),
				'description'	=> __( 'Enable slide moving with touch', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'default'		=> 'yes'
			]
		);

		$this->add_control('pixerex_carousel_RTL_Mode',
			[
				'label' 		=> __( 'RTL Mode', 'pixerex-elements' ),
				'description'	=> __( 'Turn on RTL mode if your language starts from right to left', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
				'condition'		=> [
					'pixerex_carousel_slider_type!' => 'vertical'
				]
			]
		);

		$this->add_control('pixerex_carousel_adaptive_height',
			[
				'label' 		=> __( 'Adaptive Height', 'pixerex-elements' ),
				'description'	=> __( 'Adaptive height setting gives each slide a fixed height to avoid huge white space gaps', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
			]
		);

		$this->add_control('pixerex_carousel_pausehover',
			[
				'label' 		=> __( 'Pause on Hover', 'pixerex-elements' ),
				'description'	=> __( 'Pause the slider when mouse hover', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
			]
		);

		$this->add_control('pixerex_carousel_center_mode',
			[
				'label' 		=> __( 'Center Mode', 'pixerex-elements' ),
				'description'	=> __( 'Center mode enables a centered view with partial next/previous slides. Animations and all visible scroll type doesn\'t work with this mode', 'pixerex-elements' ),
				'type'			=> Controls_Manager::SWITCHER,
			]
		);

		$this->add_control('pixerex_carousel_space_btw_items',
			[
				'label' 		=> __( 'Slides\' Spacing', 'pixerex-elements' ),
                'description'   => __('Set a spacing value in pixels (px)', 'pixerex-elements'),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> '15'
			]
		);
        
        $this->add_control('pixerex_carousel_tablet_breakpoint',
			[
				'label' 		=> __( 'Tablet Breakpoint', 'pixerex-elements' ),
                'description'   => __('Sets the breakpoint between desktop and tablet devices. Below this breakpoint tablet layout will appear (Default: 1025px).', 'pixerex-elements'),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 1025
			]
		);
        
        $this->add_control('pixerex_carousel_mobile_breakpoint',
			[
				'label' 		=> __( 'Mobile Breakpoint', 'pixerex-elements' ),
                'description'   => __('Sets the breakpoint between tablet and mobile devices. Below this breakpoint mobile layout will appear (Default: 768px).', 'pixerex-elements'),
				'type'			=> Controls_Manager::NUMBER,
				'default'		=> 768
			]
		);
        
        $this->end_controls_section();
        
		$this->start_controls_section('pixerex_carousel_navigation_arrows',
			[
				'label'         => __( 'Navigation Arrows', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_carousel_navigation_show'  => 'yes'
                ]
			]
		);
        
        $this->add_control('pixerex_carousel_arrow_icon_next',
		    [
		        'label'         => __( 'Right Icon', 'pixerex-elements' ),
		        'type'          => Controls_Manager::CHOOSE,
		        'options'       => [
		            'right_arrow_bold'          => [
		                'icon' => 'fas fa-arrow-right',
		            ],
		            'right_arrow_long'          => [
		                'icon' => 'fas fa-long-arrow-alt-right',
		            ],
		            'right_arrow_long_circle' 	=> [
		                'icon' => 'fas fa-arrow-circle-right',
		            ],
		            'right_arrow_angle' 		=> [
		                'icon' => 'fas fa-angle-right',
		            ],
		            'right_arrow_chevron' 		=> [
		                'icon' => 'fas fa-chevron-right',
		            ]
		        ],
		        'default'       => 'right_arrow_angle',
		        'condition'		=> [
					'pixerex_carousel_navigation_show'  => 'yes',
					'pixerex_carousel_slider_type!'     => 'vertical'
				],
                'toggle'        => false
		    ]
		);

		$this->add_control('pixerex_carousel_arrow_icon_next_ver',
		    [
		        'label' 	=> __( 'Bottom Icon', 'pixerex-elements' ),
		        'type' 		=> Controls_Manager::CHOOSE,
		        'options' 	=> [
		            'right_arrow_bold'    		=> [
		                'icon' => 'fas fa-arrow-down',
		            ],
		            'right_arrow_long' 			=> [
		                'icon' => 'fas fa-long-arrow-alt-down',
		            ],
		            'right_arrow_long_circle' 	=> [
		                'icon' => 'fas fa-arrow-circle-down',
		            ],
		            'right_arrow_angle' 		=> [
		                'icon' => 'fas fa-angle-down',
		            ],
		            'right_arrow_chevron' 		=> [
		                'icon' => 'fas fa-chevron-down',
		            ]
		        ],
		        'default'		=> 'right_arrow_angle',
		        'condition'		=> [
					'pixerex_carousel_navigation_show'  => 'yes',
					'pixerex_carousel_slider_type'      => 'vertical',
				],
                'toggle'        => false
		    ]
		);
        
		$this->add_control('pixerex_carousel_arrow_icon_prev_ver',
		    [
		        'label'         => __( 'Top Icon', 'pixerex-elements' ),
		        'type'          => Controls_Manager::CHOOSE,
		        'options'       => [
		            'left_arrow_bold'    		=> [
		                'icon' => 'fas fa-arrow-up',
		            ],
		            'left_arrow_long' 			=> [
		                'icon' => 'fas fa-long-arrow-alt-up',
		            ],
		            'left_arrow_long_circle' 	=> [
		                'icon' => 'fas fa-arrow-circle-up',
		            ],
		            'left_arrow_angle' 		=> [
		                'icon' => 'fas fa-angle-up',
		            ],
		            'left_arrow_chevron' 		=> [
		                'icon' => 'fas fa-chevron-up',
		            ]
		        ],
		        'default'		=> 'left_arrow_angle',
		        'condition'		=> [
					'pixerex_carousel_navigation_show'  => 'yes',
					'pixerex_carousel_slider_type'      => 'vertical',
				],
                'toggle'        => false
		    ]
		);
        
		$this->add_control('pixerex_carousel_arrow_icon_prev',
		    [
		        'label'         => __( 'Left Icon', 'pixerex-elements' ),
		        'type'          => Controls_Manager::CHOOSE,
		        'options'       => [
		            'left_arrow_bold'    		=> [
		                'icon' => 'fas fa-arrow-left',
		            ],
		            'left_arrow_long' 			=> [
		                'icon' => 'fas fa-long-arrow-alt-left',
		            ],
		            'left_arrow_long_circle' 	=> [
		                'icon' => 'fas fa-arrow-circle-left',
		            ],
		            'left_arrow_angle' 		=> [
		                'icon' => 'fas fa-angle-left',
		            ],
		            'left_arrow_chevron' 		=> [
		                'icon' => 'fas fa-chevron-left',
		            ]
		        ],
		        'default'		=> 'left_arrow_angle',
		        'condition'		=> [
					'pixerex_carousel_navigation_show' => 'yes',
					'pixerex_carousel_slider_type!' => 'vertical',
				],
                'toggle'        => false
		    ]
		);
        
        $this->add_responsive_control('pixerex_carousel_arrow_size',
			[
				'label'         => __( 'Size', 'pixerex-elements' ),
				'type'          => Controls_Manager::SLIDER,
				'default'       => [
					'size' => 14,
				],
				'range'         => [
					'px' => [
						'min' => 0,
						'max' => 60
					],
				],
				'condition'		=> [
					'pixerex_carousel_navigation_show' => 'yes'
				],
				'selectors'     => [
					'{{WRAPPER}} .pixerex-carousel-wrapper .slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control('pixerex_carousel_arrow_position',
            [
                'label'         => __('Position (PX)', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'       => -100, 
                        'max'       => 100,
                    ],
                ],
                'condition'		=> [
                    'pixerex_carousel_navigation_show' => 'yes',
                    'pixerex_carousel_slider_type'     => 'horizontal'
				],
                'selectors'     => [
                    '{{WRAPPER}} a.carousel-arrow.carousel-next' => 'right: {{SIZE}}px',
                    '{{WRAPPER}} a.carousel-arrow.carousel-prev' => 'left: {{SIZE}}px',
                ]
            ]
        );
        
        $this->start_controls_tabs('pixerex_button_style_tabs');
        
        $this->start_controls_tab('pixerex_button_style_normal',
            [
                'label'             => __('Normal', 'pixerex-elements'),
            ]
            );
        
        $this->add_control('pixerex_carousel_arrow_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'condition'		=> [
					'pixerex_carousel_navigation_show' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-carousel-wrapper .slick-arrow' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_control('pixerex_carousel_arrow_bg_color',
			[
				'label' 		=> __( 'Background Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} a.carousel-arrow.carousel-next, {{WRAPPER}} a.carousel-arrow.carousel-prev' => 'background-color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pixerex_carousel_arrows_border_normal',
                    'selector'      => '{{WRAPPER}} .slick-arrow',
                ]
                );
        
        $this->add_control('pixerex_carousel_arrows_radius_normal',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .slick-arrow' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pixerex_carousel_arrows_hover',
            [
                'label'             => __('Hover', 'pixerex-elements'),
            ]
            );
        
        $this->add_control('pixerex_carousel_hover_arrow_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'condition'		=> [
					'pixerex_carousel_navigation_show' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .pixerex-carousel-wrapper .slick-arrow:hover' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_control('pixerex_carousel_arrow_hover_bg_color',
			[
				'label' 		=> __( 'Background Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} a.carousel-arrow.carousel-next:hover, {{WRAPPER}} a.carousel-arrow.carousel-prev:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'pixerex_carousel_arrows_border_hover',
                'selector'      => '{{WRAPPER}} .slick-arrow:hover',
            ]
        );
        
        $this->add_control('pixerex_carousel_arrows_radius_hover',
            [
                'label'         => __('Border Radius', 'pixerex-elements'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('pixerex_carousel_navigation_dots',
			[
				'label'         => __( 'Navigation Dots', 'pixerex-elements' ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pixerex_carousel_dot_navigation_show'  => 'yes'
                ]
			]
		);
        
        $this->add_control('pixerex_carousel_dot_icon',
		    [
		        'label'         => __( 'Icon', 'pixerex-elements' ),
		        'type'          => Controls_Manager::CHOOSE,
		        'options'       => [
		            'square_white'    		=> [
		                'icon' => 'far fa-square',
		            ],
		            'square_black' 			=> [
		                'icon' => 'fas fa-square',
		            ],
		            'circle_white' 	=> [
		                'icon' => 'fas fa-circle',
		            ],
		            'circle_thin' 		=> [
		                'icon' => 'far fa-circle',
		            ]
		        ],
		        'default'		=> 'circle_white',
		        'condition'		=> [
					'pixerex_carousel_dot_navigation_show' => 'yes'
				],
                'toggle'        => false
		    ]
		);

		$this->add_control('pixerex_carousel_dot_navigation_color',
			[
				'label' 		=> __( 'Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'condition'		=> [
					'pixerex_carousel_dot_navigation_show' => 'yes'
				],
				'selectors'		=> [
					'{{WRAPPER}} ul.slick-dots li' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control('pixerex_carousel_dot_navigation_active_color',
			[
				'label' 		=> __( 'Active Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'condition'		=> [
					'pixerex_carousel_dot_navigation_show' => 'yes'
				],
				'selectors'		=> [
					'{{WRAPPER}} ul.slick-dots li.slick-active' => 'color: {{VALUE}}'
				]
			]
		);
        
        $this->add_control('pixerex_carousel_ripple_active_color',
			[
				'label' 		=> __( 'Active Ripple Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'condition'		=> [
					'pixerex_carousel_dot_navigation_show' => 'yes',
                    'pixerex_carousel_navigation_effect'   => 'yes'
				],
				'selectors'		=> [
					'{{WRAPPER}}.pixerex-carousel-ripple-yes ul.slick-dots li.slick-active:hover:before' => 'background-color: {{VALUE}}'
				]
			]
		);
        
        $this->add_control('pixerex_carousel_ripple_color',
			[
				'label' 		=> __( 'Inactive Ripple Color', 'pixerex-elements' ),
				'type' 			=> Controls_Manager::COLOR,
				'condition'		=> [
					'pixerex_carousel_dot_navigation_show' => 'yes',
                    'pixerex_carousel_navigation_effect'   => 'yes'
				],
				'selectors'		=> [
					'{{WRAPPER}}.pixerex-carousel-ripple-yes ul.slick-dots li:hover:before' => 'background-color: {{VALUE}}'
				]
			]
		);
        
		$this->end_controls_section();

	}

	protected function render() {
        
		$settings = $this->get_settings();
        
        $vertical = $settings['pixerex_carousel_slider_type'] == 'vertical' ? true : false;
		
		$slides_on_desk = $settings['pixerex_carousel_responsive_desktop'];
		if( $settings['pixerex_carousel_slides_to_show'] == 'all' ) {
			$slidesToScroll = ! empty( $slides_on_desk ) ? $slides_on_desk : 1;
		} else {
			$slidesToScroll = 1;
		}

		$slidesToShow = !empty($slides_on_desk) ? $slides_on_desk : 1;

		$slides_on_tabs = $settings['pixerex_carousel_responsive_tabs'];
		$slides_on_mob = $settings['pixerex_carousel_responsive_mobile'];

		if( empty( $settings['pixerex_carousel_responsive_tabs'] ) ) {
			$slides_on_tabs = $slides_on_desk;
		}

		if( empty ( $settings['pixerex_carousel_responsive_mobile'] ) ) {
			$slides_on_mob = $slides_on_desk;
		}

        $infinite = $settings['pixerex_carousel_loop'] == 'yes' ? true : false;

        $fade = $settings['pixerex_carousel_fade'] == 'yes' ? true : false;
        
        $speed = !empty( $settings['pixerex_carousel_speed'] ) ? $settings['pixerex_carousel_speed'] : '';
        
        $autoplay = $settings['pixerex_carousel_autoplay'] == 'yes' ? true : false;
        
        $autoplaySpeed = ! empty( $settings['pixerex_carousel_autoplay_speed'] ) ? $settings['pixerex_carousel_autoplay_speed'] : '';
        
        $draggable = $settings['pixerex_carousel_draggable_effect'] == 'yes' ? true  : false;
		
        $touchMove = $settings['pixerex_carousel_touch_move'] == 'yes' ? true : false;
        
		$dir = '';
        $rtl = false;
        
		if( $settings['pixerex_carousel_RTL_Mode'] == 'yes' ) {
			$rtl = true;
			$dir = 'dir="rtl"';
        }
        
        $adaptiveHeight = $settings['pixerex_carousel_adaptive_height'] == 'yes' ? true : false;
		
        $pauseOnHover = $settings['pixerex_carousel_pausehover'] == 'yes' ? true : false;
		
        $centerMode = $settings['pixerex_carousel_center_mode'] == 'yes' ? true : false;
        
        $centerPadding = !empty( $settings['pixerex_carousel_space_btw_items'] ) ? $settings['pixerex_carousel_space_btw_items'] ."px" : '';
		
		// Navigation arrow setting setup
		if( $settings['pixerex_carousel_navigation_show'] == 'yes') {
			$arrows = true;

			if( $settings['pixerex_carousel_slider_type'] == 'vertical' ) {
				$vertical_alignment = "ver-carousel-arrow";
			} else {
				$vertical_alignment = "carousel-arrow";
			}
			
			if( $settings['pixerex_carousel_slider_type'] == 'vertical' ) {
				$icon_next = $settings['pixerex_carousel_arrow_icon_next_ver'];
				if( $icon_next == 'right_arrow_bold' ) {
					$icon_next_class = 'fas fa-arrow-down';
				}
				if( $icon_next == 'right_arrow_long' ) {
					$icon_next_class = 'fas fa-long-arrow-alt-down';
				}
				if( $icon_next == 'right_arrow_long_circle' ) {
					$icon_next_class = 'fas fa-arrow-circle-down';
				}
				if( $icon_next == 'right_arrow_angle' ) {
					$icon_next_class = 'fas fa-angle-down';
				}
				if( $icon_next == 'right_arrow_chevron' ) {
					$icon_next_class = 'fas fa-chevron-down';
				}
				$icon_prev = $settings['pixerex_carousel_arrow_icon_prev_ver'];

				if( $icon_prev == 'left_arrow_bold' ) {
					$icon_prev_class = 'fas fa-arrow-up';
				}
				if( $icon_prev == 'left_arrow_long' ) {
					$icon_prev_class = 'fas fa-long-arrow-alt-up';
				}
				if( $icon_prev == 'left_arrow_long_circle' ) {
					$icon_prev_class = 'fas fa-arrow-circle-up';
				}
				if( $icon_prev == 'left_arrow_angle' ) {
					$icon_prev_class = 'fas fa-angle-up';
				}
				if( $icon_prev == 'left_arrow_chevron' ) {
					$icon_prev_class = 'fas fa-chevron-up';
				}
			} else {
				$icon_next = $settings['pixerex_carousel_arrow_icon_next'];
				if( $icon_next == 'right_arrow_bold' ) {
					$icon_next_class = 'fas fa-arrow-right';
				}
				if( $icon_next == 'right_arrow_long' ) {
					$icon_next_class = 'fas fa-long-arrow-alt-right';
				}
				if( $icon_next == 'right_arrow_long_circle' ) {
					$icon_next_class = 'fas fa-arrow-circle-right';
				}
				if( $icon_next == 'right_arrow_angle' ) {
					$icon_next_class = 'fas fa-angle-right';
				}
				if( $icon_next == 'right_arrow_chevron' ) {
					$icon_next_class = 'fas fa-chevron-right';
				}
				$icon_prev = $settings['pixerex_carousel_arrow_icon_prev'];

				if( $icon_prev == 'left_arrow_bold' ) {
					$icon_prev_class = 'fas fa-arrow-left';
				}
				if( $icon_prev == 'left_arrow_long' ) {
					$icon_prev_class = 'fas fa-long-arrow-alt-left';
				}
				if( $icon_prev == 'left_arrow_long_circle' ) {
					$icon_prev_class = 'fas fa-arrow-circle-left';
				}
				if( $icon_prev == 'left_arrow_angle' ) {
					$icon_prev_class = 'fas fa-angle-left';
				}
				if( $icon_prev == 'left_arrow_chevron' ) {
					$icon_prev_class = 'fas fa-chevron-left';
				}
			}

			$next_arrow = '<a type="button" data-role="none" class="'. $vertical_alignment .' carousel-next" aria-label="Next" role="button" style=""><i class="'.$icon_next_class.'" aria-hidden="true"></i></a>';

			$left_arrow = '<a type="button" data-role="none" class="'. $vertical_alignment .' carousel-prev" aria-label="Next" role="button" style=""><i class="'.$icon_prev_class.'" aria-hidden="true"></i></a>';

			$nextArrow = $next_arrow;
			$prevArrow = $left_arrow;
		} else {
			$arrows = false;
            $nextArrow = '';
			$prevArrow = '';
		}
		if( $settings['pixerex_carousel_dot_navigation_show'] == 'yes' ){
			$dots =  true;
			if( $settings['pixerex_carousel_dot_icon'] == 'square_white' ) {
				$dot_icon = 'far fa-square';
			}
			if( $settings['pixerex_carousel_dot_icon'] == 'square_black' ) {
				$dot_icon = 'fas fa-square';
			}
			if( $settings['pixerex_carousel_dot_icon'] == 'circle_white' ) {
				$dot_icon = 'fas fa-circle';
			}
			if( $settings['pixerex_carousel_dot_icon'] == 'circle_thin' ) {
				$dot_icon = 'far fa-circle-thin';
			}
			$customPaging = $dot_icon;
		} else {
            $dots =  false;
            $dot_icon = '';
            $customPaging = '';
        }
		$extra_class = ! empty ( $settings['pixerex_carousel_extra_class'] ) ? ' ' . $settings['pixerex_carousel_extra_class'] : '';
		
		$animation_class = $settings['pixerex_carousel_animation_list'];
		$animation = ! empty( $animation_class ) ? 'animated ' . $animation_class : 'null';
        
        $tablet_breakpoint = ! empty ( $settings['pixerex_carousel_tablet_breakpoint'] ) ? $settings['pixerex_carousel_tablet_breakpoint'] : 1025;
        
        $mobile_breakpoint = ! empty ( $settings['pixerex_carousel_mobile_breakpoint'] ) ? $settings['pixerex_carousel_mobile_breakpoint'] : 768;
        
        $carousel_settings = [
            'vertical'      => $vertical,
            'slidesToScroll'=> $slidesToScroll,
            'slidesToShow'  => $slidesToShow,
            'infinite'      => $infinite,
            'speed'         => $speed,
            'fade'			=> $fade,
            'autoplay'      => $autoplay,
            'autoplaySpeed' => $autoplaySpeed,
            'draggable'     => $draggable,
            'touchMove'     => $touchMove,
            'rtl'           => $rtl,
            'adaptiveHeight'=> $adaptiveHeight,
            'pauseOnHover'  => $pauseOnHover,
            'centerMode'    => $centerMode,
            'centerPadding' => $centerPadding,
            'arrows'        => $arrows,
            'nextArrow'     => $nextArrow,
            'prevArrow'     => $prevArrow,
            'dots'          => $dots,
            'customPaging'  => $customPaging,
            'slidesDesk'    => $slides_on_desk,
            'slidesTab'     => $slides_on_tabs,
            'slidesMob'     => $slides_on_mob,
            'animation'     => $animation,
            'tabletBreak'   => $tablet_breakpoint,
            'mobileBreak'   => $mobile_breakpoint
        ];
        
        $templates = array();
        
        if( 'select' === $settings['pixerex_carousel_content_type'] ){
            $templates = $settings['pixerex_carousel_slider_content'];
        } else {
            foreach( $settings['pixerex_carousel_templates_repeater'] as $template ){
                array_push($templates, $template['pixerex_carousel_repeater_item']);
            }
        }
        
        $this->add_render_attribute( 'carousel', 'id', 'pixerex-carousel-wrapper-' . esc_attr( $this->get_id() ) );
        
        $this->add_render_attribute( 'carousel', 'class', [
            'pixerex-carousel-wrapper',
            'carousel-wrapper-' . esc_attr( $this->get_id() ),
            $extra_class,
            $dir
        ] );
        
        if( 'yes' == $settings['pixerex_carousel_dot_navigation_show'] ) {
            $this->add_render_attribute( 'carousel', 'class', 'pixerex-carousel-dots-' . $settings['pixerex_carousel_dot_position'] );
            
        }

        if( $settings['pixerex_carousel_fade'] == 'yes' && $settings['pixerex_carousel_zoom'] == 'yes' ) {
			$this->add_render_attribute( 'carousel', 'class', 'pixerex-carousel-scale' );
        }
        
        $this->add_render_attribute( 'carousel', 'data-settings', wp_json_encode( $carousel_settings ) );
                        
		?>
            
        <div <?php echo $this->get_render_attribute_string('carousel'); ?>>
            <div id="pixerex-carousel-<?php echo esc_attr( $this->get_id() ); ?>" class="pixerex-carousel-inner">
                <?php 
                    foreach( $templates as $template_title ) :
                        if( ! empty( $template_title ) ) :
                 ?>
                <div class="pixerex-carousel-template item-wrapper">
                    <?php echo $this->getTemplateInstance()->get_template_content( $template_title ); ?>
                </div>
                <?php   endif; 
                endforeach; ?>
            </div>
        </div>
		<?php
	}
    
    protected function _content_template() {
        
        ?>
        
        <#
        
            var vertical        = 'vertical' === settings.pixerex_carousel_slider_type ? true : false,
                slidesOnDesk    = settings.pixerex_carousel_responsive_desktop,
                slidesToScroll  = 1,
                iconNextClass   = '',
                iconPrevClass   = '',
                dotIcon         = '',
                verticalAlignment= '';
                
            if( 'all' === settings.pixerex_carousel_slides_to_show ) {
                slidesToScroll = '' !== slidesOnDesk ? slidesOnDesk : 1;
            } else {
                slidesToScroll = 1;
            }

            var slidesToShow    = '' !== slidesOnDesk ? slidesOnDesk : 1,
                slidesOnTabs    = settings.pixerex_carousel_responsive_tabs,
                slidesOnMob     = settings.pixerex_carousel_responsive_mobile;

            if( '' === settings.pixerex_carousel_responsive_tabs ) {
                slidesOnTabs = slidesOnDesk;
            }

            if( '' === settings.pixerex_carousel_responsive_mobile ) {
                slidesOnMob = slidesOnDesk;
            }

            var infinite    = settings.pixerex_carousel_loop === 'yes' ? true : false,
                fade        = settings.pixerex_carousel_fade === 'yes' ? true : false,
                speed       = '' !== settings.pixerex_carousel_speed ? settings.pixerex_carousel_speed : '',
                autoplay    = settings.pixerex_carousel_autoplay === 'yes' ? true : false,
                autoplaySpeed = '' !== settings.pixerex_carousel_autoplay_speed ? settings.pixerex_carousel_autoplay_speed : '',
                draggable   = settings.pixerex_carousel_draggable_effect === 'yes' ? true  : false,
                touchMove   = settings.pixerex_carousel_touch_move === 'yes' ? true : false,
                dir         = '',
                rtl         = false;

            if( 'yes' === settings.pixerex_carousel_RTL_Mode ) {
                rtl = true;
                dir = 'dir="rtl"';
            }

            var adaptiveHeight  = 'yes' === settings.pixerex_carousel_adaptive_height ? true : false,
                pauseOnHover    = 'yes' === settings.pixerex_carousel_pausehover ? true : false,
                centerMode      = 'yes' === settings.pixerex_carousel_center_mode ? true : false,
                centerPadding   = '' !== settings.pixerex_carousel_space_btw_items ? settings.pixerex_carousel_space_btw_items + "px" : '';
                
            // Navigation arrow setting setup
            if( 'yes' === settings.pixerex_carousel_navigation_show ) {
            
                var arrows = true;

                if( 'vertical' === settings.pixerex_carousel_slider_type ) {
                    verticalAlignment = "ver-carousel-arrow";
                } else {
                    verticalAlignment = "carousel-arrow";
                }
                
                if( 'vertical' === settings.pixerex_carousel_slider_type ) {
                
                    var iconNext = settings.pixerex_carousel_arrow_icon_next_ver;
                    
                    if( iconNext === 'right_arrow_bold' ) {
                        iconNextClass = 'fas fa-arrow-down';
                    }
                    if( iconNext === 'right_arrow_long' ) {
                        iconNextClass = 'fas fa-long-arrow-alt-down';
                    }
                    if( iconNext === 'right_arrow_long_circle' ) {
                        iconNextClass = 'fas fa-arrow-circle-down';
                    }
                    if( iconNext === 'right_arrow_angle' ) {
                        iconNextClass = 'fas fa-angle-down';
                    }
                    if( iconNext === 'right_arrow_chevron' ) {
                        iconNextClass = 'fas fa-chevron-down';
                    }
                    
                    var iconPrev = settings.pixerex_carousel_arrow_icon_prev_ver;

                    if( iconPrev === 'left_arrow_bold' ) {
                        iconPrevClass = 'fas fa-arrow-up';
                    }
                    if( iconPrev === 'left_arrow_long' ) {
                        iconPrevClass  = 'fas fa-long-arrow-alt-up';
                    }
                    if( iconPrev === 'left_arrow_long_circle' ) {
                        iconPrevClass  = 'fas fa-arrow-circle-up';
                    }
                    if( iconPrev === 'left_arrow_angle' ) {
                        iconPrevClass  = 'fas fa-angle-up';
                    }
                    if( iconPrev === 'left_arrow_chevron' ) {
                        iconPrevClass  = 'fas fa-chevron-up';
                    }
                    
                } else {
                    var iconNext = settings.pixerex_carousel_arrow_icon_next;
                    
                    if( iconNext === 'right_arrow_bold' ) {
                        iconNextClass = 'fas fa-arrow-right';
                    }
                    if( iconNext === 'right_arrow_long' ) {
                        iconNextClass = 'fas fa-long-arrow-alt-right';
                    }
                    if( iconNext === 'right_arrow_long_circle' ) {
                        iconNextClass = 'fas fa-arrow-circle-right';
                    }
                    if( iconNext === 'right_arrow_angle' ) {
                        iconNextClass = 'fas fa-angle-right';
                    }
                    if( iconNext === 'right_arrow_chevron' ) {
                        iconNextClass = 'fas fa-chevron-right';
                    }
                    
                    var iconPrev = settings.pixerex_carousel_arrow_icon_prev;

                    if( iconPrev === 'left_arrow_bold' ) {
                        iconPrevClass = 'fas fa-arrow-left';
                    }
                    if( iconPrev === 'left_arrow_long' ) {
                        iconPrevClass = 'fas fa-long-arrow-alt-left';
                    }
                    if( iconPrev === 'left_arrow_long_circle' ) {
                        iconPrevClass = 'fas fa-arrow-circle-left';
                    }
                    if( iconPrev === 'left_arrow_angle' ) {
                        iconPrevClass = 'fas fa-angle-left';
                    }
                    if( iconPrev === 'left_arrow_chevron' ) {
                        iconPrevClass = 'fas fa-chevron-left';
                    }
                }

                
                var next_arrow = '<a type="button" data-role="none" class="'+ verticalAlignment +' carousel-next" aria-label="Next" role="button" style=""><i class="' + iconNextClass + '" aria-hidden="true"></i></a>';

                var left_arrow = '<a type="button" data-role="none" class="'+ verticalAlignment +' carousel-prev" aria-label="Next" role="button" style=""><i class="' + iconPrevClass + '" aria-hidden="true"></i></a>';

                var nextArrow = next_arrow,
                    prevArrow = left_arrow;
                    
            } else {
                var arrows = false,
                    nextArrow = '',
                    prevArrow = '';
            }
            
            if( 'yes' === settings.pixerex_carousel_dot_navigation_show  ) {
            
                var dots =  true;
                
                if( 'square_white' === settings.pixerex_carousel_dot_icon ) {
                    dotIcon = 'far fa-square';
                }
                if( 'square_black' === settings.pixerex_carousel_dot_icon ) {
                    dotIcon = 'fas fa-square';
                }
                if( 'circle_white' === settings.pixerex_carousel_dot_icon ) {
                    dotIcon = 'fas fa-circle';
                }
                if( 'circle_thin' === settings.pixerex_carousel_dot_icon ) {
                    dotIcon = 'far fa-circle';
                }
                var customPaging = dotIcon;
                
            } else {
            
                var dots =  false,
                    dotIcon = '',
                    customPaging = '';
                    
            }
            var extraClass = '' !== settings.pixerex_carousel_extra_class  ? ' ' + settings.pixerex_carousel_extra_class : '';

            var animationClass  = settings.pixerex_carousel_animation_list;
            var animation       = '' !== animationClass ? 'animated ' + animationClass : 'null';
            
            var tabletBreakpoint = '' !== settings.pixerex_carousel_tablet_breakpoint ? settings.pixerex_carousel_tablet_breakpoint : 1025;

            var mobileBreakpoint = '' !== settings.pixerex_carousel_mobile_breakpoint ? settings.pixerex_carousel_mobile_breakpoint : 768;
            
            var carouselSettings = {};
            
            carouselSettings.vertical       = vertical;
            carouselSettings.slidesToScroll = slidesToScroll;
            carouselSettings.slidesToShow   = slidesToShow;
            carouselSettings.infinite       = infinite;
            carouselSettings.speed          = speed;
            carouselSettings.fade           = fade;
            carouselSettings.autoplay       = autoplay;
            carouselSettings.autoplaySpeed  = autoplaySpeed;
            carouselSettings.draggable      = draggable;
            carouselSettings.touchMove      = touchMove;
            carouselSettings.rtl            = rtl;
            carouselSettings.adaptiveHeight = adaptiveHeight;
            carouselSettings.pauseOnHover   = pauseOnHover;
            carouselSettings.centerMode     = centerMode;
            carouselSettings.centerPadding  = centerPadding;
            carouselSettings.arrows         = arrows;
            carouselSettings.nextArrow      = nextArrow;
            carouselSettings.prevArrow      = prevArrow;
            carouselSettings.dots           = dots;
            carouselSettings.customPaging   = customPaging;
            carouselSettings.slidesDesk     = slidesOnDesk;
            carouselSettings.slidesTab      = slidesOnTabs;
            carouselSettings.slidesMob      = slidesOnMob;
            carouselSettings.animation      = animation;
            carouselSettings.tabletBreak    = tabletBreakpoint;
            carouselSettings.mobileBreak    = mobileBreakpoint;
            
            var templates = [];
            
            if( 'select' === settings.pixerex_carousel_content_type ) {
            
                templates = settings.pixerex_carousel_slider_content;
                
            } else {
            
                _.each( settings.pixerex_carousel_templates_repeater, function( template ) {
                
                    templates.push( template.pixerex_carousel_repeater_item );
                
                } );
            
            }

            view.addRenderAttribute( 'carousel', 'id', 'pixerex-carousel-wrapper-' + view.getID() );

            view.addRenderAttribute( 'carousel', 'class', [
                'pixerex-carousel-wrapper',
                'carousel-wrapper-' + view.getID(),
                extraClass,
                dir
            ] );
            
            if( 'yes' === settings.pixerex_carousel_dot_navigation_show ) {
                view.addRenderAttribute( 'carousel', 'class', 'pixerex-carousel-dots-' + settings.pixerex_carousel_dot_position );
            }

            if( 'yes' === settings.pixerex_carousel_fade && 'yes' === settings.pixerex_carousel_zoom ) {
                view.addRenderAttribute( 'carousel', 'class', 'pixerex-carousel-scale' );
            }
        
            view.addRenderAttribute( 'carousel', 'data-settings', JSON.stringify( carouselSettings ) );
            
            view.addRenderAttribute( 'carousel-inner', 'id', 'pixerex-carousel-' + view.getID() );
            view.addRenderAttribute( 'carousel-inner', 'class', 'pixerex-carousel-inner' );
            
            
        #>
        
        <div {{{ view.getRenderAttributeString('carousel') }}}>
            <div {{{ view.getRenderAttributeString('carousel-inner') }}}>
                <# _.each( templates, function( templateID ) { 
                    if( templateID ) { 
                #>
                    <div class="item-wrapper" data-template="{{templateID}}"></div>
                <#  } 
                } ); #>
            </div>
        </div>
        
        
    <?php 
    
    }
}